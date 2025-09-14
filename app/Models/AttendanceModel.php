<?php

namespace App\Models;

use CodeIgniter\Model;

class AttendanceModel extends Model
{
    protected $table = 'attendance';
    protected $primaryKey = 'attendance_id';
    protected $allowedFields = ['class_id', 'reg_no', 'attended_at'];

    /**
     * Get attendance count per day for a given class.
     *
     * @param int $classId
     * @return array
     */
    public function getAttendanceCountByDate(int $classId): array
    {
        return $this->select('DATE(attended_at) as date, COUNT(*) as total')
            ->where('class_id', $classId)
            ->groupBy('DATE(attended_at)')
            ->orderBy('date', 'ASC')
            ->findAll();
    }

    /**
     * Get attendance details of a specific student.
     *
     * @param string $regNo
     * @return array
     */
    public function getStudentAttendance(string $regNo): array
    {
        return $this->select('attendance.attendance_id, attendance.class_id, attendance.reg_no, attendance.attended_at, classes.subject_code, classes.venue')
            ->join('classes', 'classes.class_id = attendance.class_id')
            ->where('attendance.reg_no', $regNo)
            ->orderBy('attendance.attended_at', 'ASC')
            ->findAll();
    }

    /**
     * Get attendance grouped by subject.
     * If the user is not an admin, it filters attendance based on the user's classes.
     *
     * @param int|null $userId
     * @param bool $isAdmin
     * @return array
     */
    public function getAttendanceBySubject(?int $userId = null, bool $isAdmin = false): array
{
    if (!$isAdmin) {
        log_message('info', 'Fetching attendance for lecturer ID: ' . $userId);

        $query = $this->select('courses.course_name, classes.subject_code,classes.random_code, attendance.class_id, COUNT(attendance.attendance_id) as total')
            ->join('classes', 'classes.class_id = attendance.class_id') // Join classes with attendance
            ->join('courses', 'courses.course_code = classes.subject_code') // Join courses with classes
            ->where('classes.user_id', $userId) // Filter by lecturer ID
            ->groupBy('courses.course_name, classes.subject_code, attendance.class_id') // Group by class_id
            ->orderBy('classes.subject_code', 'ASC')
            ->findAll();

        log_message('info', 'Lecturer Attendance Query Result: ' . json_encode($query)); // Log result

        return $query;
    }
    

    $query = $this->select('courses.course_name, classes.subject_code,classes.random_code, attendance.class_id, COUNT(attendance.attendance_id) as total')
    ->join('classes', 'classes.class_id = attendance.class_id') // Join classes with attendance
    ->join('courses', 'courses.course_code = classes.subject_code') // Join courses with classes
    ->groupBy('courses.course_name, classes.subject_code, attendance.class_id')
    ->orderBy('classes.subject_code', 'ASC')
    ->findAll();

    log_message('info', 'Came to this block: ' . json_encode($query));

    return $query;

    // return $query->groupBy('classes.subject_code, classes.course_name, attendance.class_id')
    //     ->orderBy('classes.subject_code', 'ASC')
    //     ->findAll();
}



}
