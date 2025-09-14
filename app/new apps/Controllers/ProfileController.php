<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use CodeIgniter\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $session = session();
        $userId = $session->get('user_id'); // Get user ID from session

        if (!$userId) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        $userModel = new UserModel();
        $roleModel = new RoleModel();

        // Fetch user details
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to('/login'); // If user not found, redirect
        }

        // Fetch role name using RoleModel
        $role = $roleModel->find($user['role_id']);

        // Add role name to user data
        $user['role_name'] = $role ? $role['role_name'] : 'Unknown';

        return view('profile', ['user' => $user]);
    }
}