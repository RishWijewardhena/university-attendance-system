<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\AttendanceModel; // ✅ Add missing model

class AdminController extends Controller
{
    public function index()
    {
        return view('admin/admin_panel');
    }

    public function users()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();
        return view('admin/users', $data);
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        $roleModel = new RoleModel();
        
        $data['user'] = $userModel->find($id);
        $data['roles'] = $roleModel->findAll();
        
        // Pass any validation errors to the view
        $data['validation'] = \Config\Services::validation();
        
        return view('admin/edit_user', $data);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $currentUser = $userModel->find($id);
        $newEmail = $this->request->getPost('email');

        // Only check for unique email if the email has changed
        if ($currentUser['email'] !== $newEmail) {
            // Check if email already exists for another user
            $existingUser = $userModel->where('email', $newEmail)
                                    ->where('user_id !=', $id)
                                    ->first();

            if ($existingUser) {
                return redirect()->back()
                                ->with('error', 'Email already exists for another user')
                                ->withInput();
            }
        }

        $data = [
            'user_name' => $this->request->getPost('name'),
            'email' => $newEmail,
            'role_id' => $this->request->getPost('role')
        ];

        if ($userModel->update($id, $data)) {
            return redirect()->to('/admin/users')
                            ->with('success', 'User updated successfully');
        } else {
            return redirect()->back()
                            ->with('error', 'Failed to update user')
                            ->withInput();
        }
    }

    public function deactivate_user($id)
    {
        $userModel = new UserModel();
        $userModel->deactivate($id);
        return redirect()->to('/admin/users')->with('success', 'User deactivated successfully');
    }

    public function activate_user($id)
    {
        $userModel = new UserModel();
        $userModel->activate($id);
        return redirect()->to('/admin/users')->with('success', 'User activated successfully');
    }

    public function showProgress()
    {
        return view('admin/progress'); // Load progress page
    }

    public function getAttendanceData()
{
    
    
    $attendanceModel = new AttendanceModel();

    // ✅ Fetch attendance grouped by subject
    $data = $attendanceModel->getAttendanceBySubject(null, true);

   

    if (!$data) {
        return $this->response->setJSON(['message' => 'No attendance data found']);
    }

    // ✅ Group data by subject code
    $groupedData = [];
    foreach ($data as $row) {
        $subjectCode = $row['subject_code'];
        $courseName = $row['course_name'];

        if (!isset($groupedData[$subjectCode])) {
            $groupedData[$subjectCode] = [
                'course_name' => $courseName,
                'classes' => []
            ];
        }

        $groupedData[$subjectCode]['classes'][] = [
            'class_id' => $row['class_id'],
            'total' => $row['total']
        ];
    }

    return $this->response->setJSON(['attendance' => $groupedData]);
}

    
}
