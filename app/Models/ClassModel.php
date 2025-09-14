<?php

namespace App\Models;

use CodeIgniter\Model;

class ClassModel extends Model
{
    protected $table = 'classes';
    protected $primaryKey = 'class_id';
    protected $allowedFields = ['subject_code', 'scheduled_time', 'venue', 'user_id', 'random_code','scheduled_time'];

    /**
     * Create a new class and return the inserted ID.
     */
    public function createClass($data)
    {
        $this->insert($data);
        return $this->insertID();
    }

    /**
     * Update a class with a generated random code.
     */
    public function updateRandomCode($classId, $randomCode)
    {
        return $this->update($classId, ['random_code' => $randomCode]);
    }
}
