<?php

namespace App\Controllers;

use App\Models\AttendanceModel;
use App\Models\UserModel; 
use CodeIgniter\Controller;

class AttendanceController extends BaseController
{
    public function studentAttendance()
    {
        log_message('debug', 'studentAttendance called');
    
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
        }
    
        // Get user model and fetch the logged-in user's details
        $userModel = new UserModel();
        $user = $userModel->find(session('user_id'));
    
        // If user is not found, redirect to login
        if (!$user) {
            return redirect()->to('/login');
        }
    
        $userEmail = $user['email']; // Fetch the user's email

        // Process the email (first 10 characters and capitalize the 5th character)
        $email = substr($userEmail, 2, 8); // Get the first 10 characters of the email
        $modifiedEmail = $email; // Save the original sliced email as a new variable

        if (strlen($modifiedEmail) >= 3) {
            $modifiedEmail = substr($modifiedEmail, 0, 2) . strtoupper($modifiedEmail[2]) . substr($modifiedEmail, 3); // Capitalize the 3rd character
        }
        
        // Use the modifiedEmail to fetch the filtered attendance records
        $attendanceModel = new AttendanceModel();
        $attendance = $attendanceModel->getStudentAttendance($modifiedEmail);

        // Debugging: Log the attendance result
        log_message('debug', 'Filtered Attendance records: ' . print_r($attendance, true));
    
        return view('student_attendance', [
            'attendance' => $attendance,
            'userEmail' => $userEmail // Pass the email to the view
        ]);
    }
}