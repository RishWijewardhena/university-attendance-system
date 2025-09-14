<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CommentModel;
use App\Models\CsvModel;
use App\Models\CourseModel;
use App\Models\ClassModel;

class CourseController extends Controller
{
    protected $db;
    
    public function __construct()
    {
        // Use dependency injection to get the database connection
        $this->db = \Config\Database::connect();
    }

    /**
     * View course details.
     *
     * This method retrieves course information by joining the classes
     * and courses tables. It then fetches all class sessions (random codes)
     * for that subject and attaches the latest CSV file data (if available).
     */
    public function view($subjectCode)
    {
        $session = session();
        $userId = $session->get('user_id'); // Get the user ID from the session

        // Use Query Builder to get course details
        $course = $this->db->table('classes')
            ->select('courses.course_name, classes.subject_code, classes.user_id')
            ->join('courses', 'classes.subject_code = courses.course_code')
            ->where('classes.subject_code', $subjectCode)
            ->where('classes.user_id', $userId)
            ->get()
            ->getRow();

        if (!$course) {
            return redirect()->to('/dashboard')->with('error', 'Course not found or no class created yet');
        }

        // Retrieve all classes (sessions) for the subject
        $randomCodes = $this->db->table('classes')
            ->select('class_id, random_code, scheduled_time, venue, subject_code')
            ->where('subject_code', $subjectCode)
            ->where('user_id', $userId)
            ->orderBy('scheduled_time', 'ASC')
            ->get()
            ->getResult();

        // Loop through each class to attach CSV details (if any)
        foreach ($randomCodes as $index => $randomCode) {
            $randomCode->week_number = 'Class ' . ($index + 1);

            $csvData = $this->db->table('csv_table')
                ->select('csv_id, file_name, active')
                ->where('class_id', $randomCode->class_id)
                ->orderBy('created_at', 'DESC')
                ->limit(1)
                ->get()
                ->getRow();

            if ($csvData) {
                $randomCode->csv_id   = $csvData->csv_id;
                $randomCode->file_name = $csvData->file_name;
                $randomCode->is_active = ($csvData->active === 'active');
            } else {
                $randomCode->csv_id   = null;
                $randomCode->file_name = null;
                $randomCode->is_active = false;
            }
        }

        return view('course', [
            'course'       => $course,
            'randomCodes'  => $randomCodes,
            'user_name'    => $session->get('user_name'),
            'error'        => $session->getFlashdata('error'),
            'success'      => $session->getFlashdata('success')
        ]);
    }

    /**
     * Upload and process a CSV file.
     *
     * This method handles the CSV file upload, deactivates any previous CSV files,
     * moves the file to the uploads folder, saves its details in the database, and
     * processes its content by inserting comments.
     */
    public function uploadCSV($classId)
    {
        $session = session();
        $userId = $session->get('user_id');
        $csvFile = $this->request->getFile('csv_file');

        if (!$csvFile || !$csvFile->isValid()) {
            return redirect()->back()->with('error', 'Invalid CSV file.');
        }

        $csvModel = new CsvModel();
        $csvModel->deactivatePreviousFiles($classId, $userId);

        $newFileName = $csvFile->getRandomName();
        if (!$csvFile->move(WRITEPATH . 'uploads', $newFileName)) {
            return redirect()->back()->with('error', 'Failed to save the uploaded file.');
        }

        $csvData = [
            'user_id'   => $userId,
            'class_id'  => $classId,
            'file_name' => $newFileName,
            'active'    => 'active'
        ];

        if (!$csvModel->insertCsv($csvData)) {
            return redirect()->back()->with('error', 'Failed to save file details.');
        }

        $csvId    = $csvModel->getInsertID();
        $filePath = WRITEPATH . 'uploads/' . $newFileName;
        $commentModel = new CommentModel();

        try {
            if (($handle = fopen($filePath, 'r')) !== false) {
                // Skip the header row
                fgetcsv($handle);
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    $commentData = [
                        'csv_id'    => $csvId,
                        'reg_no'    => $data[0] ?? null,
                        'user_id'   => $userId,
                        'name'      => $data[1] ?? null,
                        'comment_1' => $data[2] ?? null,
                        'comment_2' => $data[3] ?? null
                    ];
                    $commentModel->insertComment($commentData);
                }
                fclose($handle);
            } else {
                return redirect()->back()->with('error', 'Failed to process CSV file.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while processing the file.');
        }

        return redirect()->back()->with('success', 'CSV file uploaded successfully.');
    }

    /**
     * Delete a CSV file and its associated comments.
     */
    public function deleteCSV($csvId)
    {
        $csvModel = new CsvModel();
        $commentModel = new CommentModel();

        if (!$csvModel->deactivateCsv($csvId)) {
            return redirect()->back()->with('error', 'Failed to deactivate CSV file.');
        }

        $commentModel->deleteCommentsByCsvId($csvId);
        return redirect()->back()->with('success', 'CSV file deleted successfully.');
    }

    /**
     * View class attendance.
     *
     * Retrieves attendance records for a given class (identified by its random code)
     * and displays them along with class details.
     */
    public function viewAttendance($randomCode)
    {
        $attendance = $this->db->table('attendance')
            ->select('reg_no, attended_at')
            ->join('classes', 'attendance.class_id = classes.class_id')
            ->where('classes.random_code', $randomCode)
            ->orderBy('attended_at', 'DESC')
            ->get()
            ->getResult();

        $classDetails = $this->db->table('classes')
            ->select('subject_code, random_code, scheduled_time, venue')
            ->where('random_code', $randomCode)
            ->get()
            ->getRow();

        if (!$classDetails) {
            return redirect()->back()->with('error', 'Invalid class code or attendance data not found.');
        }

        return view('attendance', [
            'attendance'   => $attendance,
            'classDetails' => $classDetails,
            'subject_code' => $classDetails->subject_code
        ]);
    }

    /**
     * Delete a class along with associated CSV files.
     *
     * Note: If you need to delete related comments as well, you can uncomment
     * the deletion for the comment_table.
     */
    public function deleteClass($classId)
    {
        try {
            $this->db->transBegin();

            // Delete associated CSV records
            $this->db->table('csv_table')->where('class_id', $classId)->delete();
            // Uncomment the following line if you also wish to delete related comments:
            // $this->db->table('comment_table')->where('class_id', $classId)->delete();
            // Delete the class record itself
            $this->db->table('classes')->where('class_id', $classId)->delete();

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return redirect()->back()->with('error', 'Failed to delete class.');
            }

            $this->db->transCommit();
            return redirect()->back()->with('success', 'Class deleted successfully.');
        } catch (\Exception $e) {
            $this->db->transRollback();
            return redirect()->back()->with('error', 'An error occurred while deleting the class.');
        }
    }
}
