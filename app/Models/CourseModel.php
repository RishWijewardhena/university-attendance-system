<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    protected $allowedFields = ['course_name', 'course_code'];

    public function getCourses()
    {
        return $this->findAll();
    }

    public function getCourseById($id)
    {
        return $this->where('course_id', $id)->first();
    }
}