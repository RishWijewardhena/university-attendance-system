<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ClassModel;
use App\Models\CourseModel;
use App\Models\LecturerAssignmentModel;
use App\Models\VenueModel;
use CodeIgniter\Database\Exceptions\DataException;

class CreateClassController extends Controller
{
    protected $classModel;
    protected $courseModel;
    protected $lecturerAssignmentModel;
    protected $db;

    public function __construct()
    {
        $this->classModel = new ClassModel();
        $this->courseModel = new CourseModel();
        $this->lecturerAssignmentModel = new LecturerAssignmentModel();
        $this->db = \Config\Database::connect();
    }

    /**
     * Display the Create Class page with a list of available courses.
     */
    public function index()
    {
        $session = session();
        if (!$session->get('user_id')) {
            return redirect()->to('/login');
        }

        // Get the lecturer email from session
        $lecturerEmail = $session->get('email');

        if (!$lecturerEmail) {
            // If no lecturer email is found in the session, return empty courses
            $courses = [];
        } else {
            // Get the courses assigned to the lecturer
            $courses = $this->lecturerAssignmentModel
                            ->join('courses', 'courses.course_code = lecturer_courses.course_code')
                            ->where('lecturer_email', $lecturerEmail)
                            ->findAll();
            
            log_message('debug', 'Courses: ' . print_r($courses, true));
        }

        // Fetch venues from the venues table
        $venueModel = new VenueModel();
        $venues = $venueModel->findAll();

        return view('create_class', compact('courses', 'venues'));
    }

    /**
     * Handle the form submission for creating a new class.
     */
    public function store()
    {
        $session = session();

        // Validate form inputs
        $validation = \Config\Services::validation();
        $validation->setRules([
            'subject_code' => 'required',
            'scheduled_time' => 'required|valid_date',
            'venue' => 'required|string|max_length[255]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', implode(', ', $validation->getErrors()));
        }

        // Generate a random 3-digit number
        $randomCode = random_int(100, 999);

        // Prepare class data
        $data = [
            'subject_code' => $this->request->getPost('subject_code'),
            'scheduled_time' => $this->request->getPost('scheduled_time'),
            'venue' => $this->request->getPost('venue'),
            'user_id' => $session->get('user_id'),
        ];

        try {
            // Insert the class and get its ID
            $classId = $this->classModel->createClass($data);

            // Generate unique random code
            $fullRandomCode = $classId . $randomCode;
            $this->classModel->updateRandomCode($classId, $fullRandomCode);

            // Fetch the course name using CourseModel
            $course = $this->courseModel->where('course_code', $data['subject_code'])->first();
            $className = $course ? $course['course_name'] : 'Unknown';

            // Set success message
            $session->setFlashdata('created_class_name', $className);
            $session->setFlashdata('success', "Class created successfully! Unique Code: $fullRandomCode");

            return redirect()->to('/dashboard');
        } catch (DataException $e) {
            return redirect()->back()->withInput()->with('error', 'Error creating class: ' . $e->getMessage());
        }
    }
}
