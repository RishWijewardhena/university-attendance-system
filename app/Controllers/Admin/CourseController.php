<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\LecturerCourseModel;

class CourseController extends BaseController
{
    public function index()
    {
        $courseModel = new CourseModel();
        $data['courses'] = $courseModel->getCourses();

        return view('admin/courses', $data);
    }

    public function add()
    {
        return view('admin/add_course');
    }

    public function create()
    {
        $courseModel = new CourseModel();

        $courseModel->save([
            'course_name' => $this->request->getPost('course_name'),
            'course_code' => $this->request->getPost('course_code'),
            'description' => $this->request->getPost('description')
        ]);

        return redirect()->to('/admin/courses')->with('success', 'Course added successfully');
    }

    public function edit($id)
    {
        $courseModel = new CourseModel();
        $data['course'] = $courseModel->getCourseById($id);

        return view('admin/edit_course', $data);
    }

    public function update($id)
    {
        $courseModel = new CourseModel();

        $courseModel->update($id, [
            'course_name' => $this->request->getPost('course_name'),
            'course_code' => $this->request->getPost('course_code'),
        ]);

        return redirect()->to('/admin/courses')->with('success', 'Course updated successfully');
    }

    public function delete($id)
    {
        $courseModel = new CourseModel();
        $courseModel->delete($id);

        return redirect()->to('/admin/courses')->with('success', 'Course deleted successfully');
    }

    public function view_courses()
    {
        // Load the LecturerCourseModel
        $lecturerCourseModel = new LecturerCourseModel();

        // Get all the lecturer_course data
        $data['lecturer_courses'] = $lecturerCourseModel->findAll();

        // Pass the data to the 'course_view' page
        return view('admin/view_all_courses',$data);
    }
}