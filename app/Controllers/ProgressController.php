<?php

namespace App\Controllers;

use App\Models\AttendanceModel;
use CodeIgniter\Controller;

class ProgressController extends Controller
{
    public function index()
    {
        if (!hasPermission('show_progress')) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to view progress.');
        }
    
        $userId = session()->get('user_id'); // Get logged-in lecturer's ID
        $isAdmin = hasPermission('admin_access'); // Check if user is admin
    
        $attendanceModel = new AttendanceModel();
        $attendanceData = $attendanceModel->getAttendanceBySubject($userId, $isAdmin);
    
        // Group attendance by course
        $organizedData = [];
        foreach ($attendanceData as $record) {
            $subjectCode = $record['subject_code'];
            $courseName = $record['course_name'];
            $classId = isset($record['class_id']) ? $record['class_id'] : 'Unknown Class';
    
            if (!isset($organizedData[$subjectCode])) {
                $organizedData[$subjectCode] = [
                    'course_name' => $courseName,
                    'subject_code' => $subjectCode,
                    'classes' => []
                ];
            }
    
            // Store class-wise attendance count
            $organizedData[$subjectCode]['classes'][] = [
                'class_id' => "Class " . $classId,
                'random_code' => $record['random_code'],
                'total' => intval($record['total']) // Ensure numeric value
            ];
        }
    
        return view('progress', [
            'attendanceData' => $organizedData,
        ]);
    }
    
}
