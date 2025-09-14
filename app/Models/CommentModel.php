<?php
namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comment_table';
    protected $primaryKey = 'data_id';
    protected $allowedFields = [
        'csv_id', 'reg_no', 'user_id','name', 'comment_1', 'comment_2'
    ];

    public function insertComment($data)
    {
        return $this->insert($data);
    }
    
    public function deleteCommentsByCsvId($csvId)
    {
        $this->where('csv_id', $csvId)->delete();
    }
}
