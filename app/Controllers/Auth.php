<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;



class Auth extends BaseController

{

    public function index()
    {
        // Load the login view
        return view('login');
    }
    
    protected $userModel;
    protected $email;

    ////functionn copied from the login controller

    public function authenticate()
{
    // Load the UserModel
    $userModel = new UserModel();

    // Get input data
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    // Find user by email
    $user = $userModel->where('email', $email)->first();

    if ($user) {
        // Verify the hashed password
        if (password_verify($password, $user['password']) && $user['status'] === 'active') {
            // Set session
            $session = session();
            $session->set('user_id', $user['user_id']);
            $session->set('user_name', $user['user_name']);
            $session->set('role_id', $user['role_id']);
            $session->set('email', $user['email']);

            // Redirect to dashboard
            session()->set('is_logged_in', true);

            return redirect()->to('/dashboard');
        } else {

            if ($user['status'] === 'inactive') {
                return redirect()->back()->with('error', 'Your account is inactive. Please contact the administrator.');
            } else {
                return redirect()->back()->with('error', 'Invalid  password.'); //invalid password
            }
            
        }
    } else {
        // User not found
        return redirect()->back()->with('error', 'Invalid email or password.');
    }
}


    public function logout()
    {
        // Destroy session
        $session = session();
        $session->destroy();

        // Redirect to login page
        return redirect()->to('/');

    }


    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->email = \Config\Services::email(); // Initialize the email service
    }
 
    // Forgot Password Form
    public function forgot_password()
    {   
        // Clear any previously set session data
        session()->remove('otp_sent');
        session()->remove('email');
        session()->remove('user_id');
        return view('forgot_password'); // Load the view for the Forgot Password form
    }

    public function process_forgot_password()
    {
        $email = $this->request->getPost('email');
        $user = $this->userModel->get_user_by_email($email);
    
        if ($user) {
            // Check if the user's auth_provider is 'local'
            if ($user->auth_provider === 'local') {
                session()->set('reset_email', $email);
                session()->set('reset_user_id', $user->user_id);
    
                // Generate and save OTP
                $otp = random_int(100000, 999999);
                $this->userModel->save_otp($user->user_id, $otp);
    
                // Send OTP via email
                $this->email->setFrom('rishraveesha19@gmail.com', 'Attendance System');
                $this->email->setTo($email);
                $this->email->setSubject('Password Reset OTP');
                $this->email->setMessage("Your OTP for password reset is: $otp");
    
                if ($this->email->send()) {
                    session()->set('otp_sent', true);
                    return redirect()->to('/auth/otp_verification_form')->with('success', 'OTP sent to your email.'); // Change this line
                } else {
                    return redirect()->to('/auth/forgot_password')->with('error', 'Failed to send email. Try again.');
                }
            } else {
                // If the user's auth_provider is not 'local', deny password reset
                return redirect()->to('/auth/forgot_password')->with('error', 'Password reset is not available for this account.');
            }
        } else {
            return redirect()->to('/auth/forgot_password')->with('error', 'Email not found.');
        }
    }
    
    public function otp_verification_form()
    {
        // Load the view for OTP verification
        return view('otp_verification_form'); //
    }




    public function validate_otp() {
        $otp = $this->request->getPost('otp');
        $user = $this->userModel->verifyOtp($otp);
    
        if ($user) {
            session()->set('reset_user_id', $user['user_id']);
            session()->remove('otp_sent');
            return redirect()->to('/auth/reset_password_form'); // Redirect to the reset password form
        } else {
            return redirect()->to('/auth/otp_verification_form')
                ->with('error', 'Invalid OTP. Please try again.');
        }
    }
    

    

    // Update Password
    public function updatePassword()
    {
        $userId = session()->get('reset_user_id');
        if (!$userId) {
            return redirect()->to('/auth/forgot_password')
                ->with('error', 'Session expired. Please try again.');
        }

        $newPassword = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if ($newPassword !== $confirmPassword) {
            return redirect()->to('/auth/forgot_password_form')
                ->with('error', 'Passwords do not match.');
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT); // Hash the new password

        // Update password in database
        $this->userModel->update($userId, ['password' => $hashedPassword]);

        session()->remove('reset_user_id'); // Clear session

        return redirect()->to('/login')->with('success', 'Password reset successfully.');
    }
// Reset Password Form
public function reset_password_form() {
    if (!session()->has('reset_user_id')) {
        return redirect()->to('/auth/forgot_password')->with('error', 'Session expired. Please try again.');
    }
    return view('reset_password_form'); // This should be correct.
}


 // Handle Password Reset
 public function process_reset_password()
 {
     $userId = session()->get('reset_user_id');
     if (!$userId) {
         return redirect()->to('/auth/forgot_password')->with('error', 'Session expired. Please try again.');
     }

     $newPassword = $this->request->getPost('password');
     $confirmPassword = $this->request->getPost('confirm_password');

     if ($newPassword !== $confirmPassword) {
         return redirect()->to('/auth/reset_password_form')->with('error', 'Passwords do not match.');
     }

     $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

     // Update password in the database
     $this->userModel->update($userId, ['password' => $hashedPassword]);

     session()->remove('reset_user_id'); // Clear session data

     return redirect()->to('/login')->with('success', 'Password reset successfully.');
 }


 //redirect to no access page
 public function noPermission()
 {
     return view('errors/no_permission'); // Load the view for unauthorized access
 }

 
}
