<?php

namespace App\Controllers;

use Google\Client;
use Google\Service\Oauth2;
use App\Models\UserModel;
use App\Models\RoleModel;

class GoogleLogin extends BaseController
{
    private $client;

    public function __construct()
    {
        require_once APPPATH . "Libraries/vendor/autoload.php";

        // Initialize Google Client
        $this->client = new Client();
        $this->client->setClientId('421923811217-qeh2d35852gmg2sk9le0r8se2q092b3r.apps.googleusercontent.com');
        $this->client->setClientSecret('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');
        $this->client->setRedirectUri(base_url('googlelogin/callback'));
        $this->client->addScope('email');
        $this->client->addScope('profile');
    }

    public function login()
    {
        // Redirect to Google Auth URL
        $authUrl = $this->client->createAuthUrl();
        return redirect()->to($authUrl);
    }

    public function callback()
    {
        if ($this->request->getVar('code')) {
            // Exchange code for access token
            $token = $this->client->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
            $this->client->setAccessToken($token);

            // Fetch user info
            $googleService = new Oauth2($this->client);
            $userData = $googleService->userinfo->get();

            $email = $userData->email;
            $googleId = $userData->id;

            // Load UserModel
            $userModel = new UserModel();

            // Check if the auth_id (Google ID) exists in the database
            $existingUser = $userModel->where('auth_id', $googleId)->where('auth_provider', 'google')->first();

            if (!$existingUser) {
                // Register new user
                $newUser = [
                    'user_name'     => $userData->name,
                    'email'         => $email,
                    'password'      => null, // No password for Google users
                    'auth_provider' => 'google',
                    'auth_id'       => $googleId, // Store Google ID
                    'role_id'       => 50 //assign default role id for student
                ];

                $userModel->insert($newUser);
                $userId = $userModel->insertID(); // Get the ID of the new user
                $role_id = null;
            } else {
                // User already exists, get their ID
                $userId = $existingUser['user_id'];
                $role_id = $existingUser['role_id'];
            }

            // Log the user in
            session()->set([
                'user_id'      => $userId,
                'email'        => $email,
                'is_logged_in' => true,
                'user_name'    => $userData->name,
                'role_id'      => $role_id
            ]);

            return redirect()->to('/dashboard'); // Redirect to dashboard
        } else {
            return redirect()->to('/login')->with('error', 'Failed to authenticate with Google.');
        }
    }

    public function completeProfile()
    {
        // Check if user session exists
        if (!session()->has('email') && !session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Session expired. Please log in again.');
        }

        // Load roles from the database
        $roleModel = new RoleModel();
        $roles = $roleModel->findAll();

        return view('complete_profile', ['roles' => $roles]);
    }

    public function saveProfile()
    {
        // Load the model
        $userModel = new UserModel();

        // Get the role_id from the POST data
        $role_id = $this->request->getPost('role_id');

        // Check if role_id exists
        if (!$role_id) {
            return redirect()->back()->with('error', 'Please select a role.');
            
        }

        // Get the user's ID from the session
        $user_id = session('user_id');

        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'User session expired. Please log in again.');
        }

        // Update the user's role in the database
        $updated = $userModel->update($user_id, ['role_id' => $role_id]);

        if ($updated) {
            return redirect()->to('/dashboard')->with('success', 'Profile completed successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update profile. Please try again.');
        }
    }
}
