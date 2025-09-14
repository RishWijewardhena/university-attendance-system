<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user'; // Define the table name
    protected $primaryKey = 'user_id'; // Define the primary key
    protected $allowedFields = [
        'user_name',
        'email',
        'password',
        'auth_provider',
        'otp',
        'otp_expiry',
        'auth_id',
        'role_id',
        'is',
        'status',
    ];
    // Get user by email (method name changed to match the controller)
    public function get_user_by_email($email)
    {
        return $this->where('email', $email)->get()->getRowObject(); // Return the first row as an object
    }

   
    public function getUsers()
    {
        return $this->findAll(); // Fetch all users
    }
    

    // Save OTP to database
    public function save_otp($userId, $otp)
    {
        $expiryTime = date('Y-m-d H:i:s', strtotime('+15 minutes')); // OTP valid for 15 minutes
        return $this->update($userId, [
            'otp' => $otp,
            'otp_expiry' => $expiryTime,
        ]); // Use the model's update method
    }

    // Verify OTP
    public function verifyOtp($otp)
    {
        return $this->where('otp', $otp)
                    ->where('otp_expiry >', date('Y-m-d H:i:s'))
                    ->first(); // Use where clauses and first() to fetch a single record
    }

    // Update password and clear OTP
    public function updatePassword($otp, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        return $this->set([
            'password' => $hashedPassword,
            'otp' => null,
            'otp_expiry' => null,
        ])->where('otp', $otp)
          ->update(); // Use set, where, and update methods
    }

    public function deactivate($userId)
    {

        return $this->update($userId, ['status' => 'inactive']); // Update the user's status to 'inactive'
    }

    public function activate($userId)
    {
        return $this->update($userId, ['status' => 'active']); // Update the user's status to 'active'
    }

}
