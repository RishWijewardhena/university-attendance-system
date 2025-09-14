<?php
namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table = 'role_permission';
    protected $primaryKey = 'id';
    protected $allowedFields = ['role_id', 'permission_id'];

    public function getPermissionsByRole($roleId)
{
    $result = $this->db->table('role_permission')
                       ->select('permission.permission_name')
                       ->join('permission', 'permission.permission_id = role_permission.permission_id', 'inner')
                       ->where('role_permission.role_id', $roleId)
                       ->get()
                       ->getResultArray();


    return $result;
}

}
