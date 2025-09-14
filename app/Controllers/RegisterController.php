<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;

class RegisterController extends BaseController
{
    public function register()
    {
        return view('register');
    }

    public function processRegister()
    {
        $validation = \Config\Services::validation();

        // Validate input fields
        $validation->setRules([
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[user.email]|emailCheck',
            'password' => 'required|min_length[6]',
        ]);
        
        

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Get input data
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        // // Check if email domain is valid
        // if (!$this->emailCheck($email)) {
        //     return redirect()->back()->withInput()->with('errors', ['email' => 'Only emails with @cmb.ac.lk are allowed.']);
        // }

        // Save user
        $userModel = new UserModel();
        $userModel->save([
            'user_name' => $name,
            'email'     => $email,
            'password'  => $password,
            'role_id'   => 50 // Assign 'Student' role by default
        ]);

        return redirect()->to('/login')->with('success', 'Registration successful! You can now log in.');
    }

    
}
