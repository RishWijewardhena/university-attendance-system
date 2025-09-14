<?php
namespace App\Models;

use CodeIgniter\Model;

class CsvModel extends Model
{
    protected $table = 'csv_table';
    protected $primaryKey = 'csv_id';
    protected $allowedFields = ['user_id', 'class_id', 'active', 'created_at', 'file_name'];

    public function deactivatePreviousFiles($classId, $userId)
    {
        $this->where('class_id', $classId)
             ->where('user_id', $userId)
             ->where('active', 'active')
             ->set(['active' => 'inactive'])
             ->update();
    }

    public function insertCsv($data)
    {
        return $this->insert($data);
    }

    // Fetch the last inserted ID after inserting a CSV file
    public function getInsertID()
    {
        return $this->db->insertID();   //This is a CodeIgniter function that retrieves the auto-increment ID of the last inserted row for the current database connection.
    }

    public function deactivateCsv($csvId)
{
    $this->where('csv_id', $csvId)
         ->set(['active' => 'inactive'])
         ->update();

    // Return the number of affected rows
    return $this->db->affectedRows() > 0;
}



    public function getUploadedFilesByClass($classId)
    {
        return $this->where('class_id', $classId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
