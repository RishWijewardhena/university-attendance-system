<?php
// namespace App\Controllers;

// use CodeIgniter\Controller;
// use App\Models\UserModel;
// use App\Models\RoleModel;

// class DashboardController extends Controller
// {
//     public function index()
//     {
//         if (!session()->get('is_logged_in')) {
//             return redirect()->to('/login')->with('error', 'Please log in first.');
//         }

//         $userModel = new UserModel();
//         $user = $userModel->find(session('user_id'));

//         if (!$user || !$user['role_id']) {
//             return redirect()->to('/googlelogin/completeProfile')->with('error', 'Please complete your profile.');
//         }

//         $session = session();
//         $db = \Config\Database::connect();

//         try {
//             $lecturerEmail = $user['email'];
        
//             log_message('debug', 'Fetching courses for: ' . $lecturerEmail);
        
//             $courses = $db->query("
//                 SELECT courses.course_name, courses.course_code 
//                 FROM lecturer_courses 
//                 JOIN courses ON lecturer_courses.course_code = courses.course_code 
//                 WHERE lecturer_courses.lecturer_email = ?", [$lecturerEmail])
//                 ->getResultArray();
        
//             log_message('info', 'Fetched courses: ' . print_r($courses, true));
//         } catch (\Exception $e) {
//             log_message('error', 'Query error: ' . $e->getMessage());
//         }
//          finally {
//             $db->close(); //  Ensure the database connection is closed
//         }

//         // ✅ Pass data to the dashboard view
//         $createdClassName = $session->getFlashdata('created_class_name');
//         $successMessage = $session->getFlashdata('success');

//         return view('dashboard', [
//             'courses' => $courses, // ✅ Pass courses to the view
//             'successMessage' => $successMessage
//         ]);
//     }

  
    
// }



namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\RoleModel;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
        }

        $userModel = new UserModel();
        $user = $userModel->find(session('user_id'));

        // if (!$user || !$user['role_id']) {
        //     return redirect()->to('/googlelogin/completeProfile')->with('error', 'Please complete your profile.');
        // }

        $db = \Config\Database::connect();

        try {
            if ($user['role_id'] == 50) { // 50 is for students
                $courses = $db->query("SELECT * FROM courses")->getResultArray();
                log_message('debug', 'Student Courses: ' . print_r($courses, true));
            } else {
                $lecturerEmail = $user['email'];
                $courses = $db->query("
                    SELECT courses.course_name, courses.course_code 
                    FROM lecturer_courses 
                    JOIN courses ON lecturer_courses.course_code = courses.course_code 
                    WHERE lecturer_courses.lecturer_email = ?", [$lecturerEmail])
                    ->getResultArray();
                log_message('debug', 'Lecturer Courses: ' . print_r($courses, true));
            }
        } catch (\Exception $e) {
            log_message('error', 'Query error: ' . $e->getMessage());
            $courses = [];
        } finally {
            $db->close();
        }

        return view('dashboard', [
            'courses' => $courses,
            'role_id' => $user['role_id'],
            'successMessage' => session()->getFlashdata('success')
        ]);
    }

}