<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;

class LecturerAssignmentModel extends Model
{
    protected $table = 'lecturer_courses';
    protected $primaryKey = 'id';
    protected $allowedFields = ['lecturer_email', 'course_code', 'admin_user_id', 'created_at'];

    // Function to get courses for the current lecturer
    public function getCoursesForCurrentLecturer(Session $session)
    {
        // Get the lecturer email from the session
        $lecturerEmail = $session->get('lecturer_email');
        
        if ($lecturerEmail) {
            // Query the database to get all the courses for the current lecturer
            return $this->where('lecturer_email', $lecturerEmail)->findAll();
        }
        
        return [];
    }
}
