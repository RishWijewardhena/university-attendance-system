<?php
namespace App\Models;

use CodeIgniter\Model;

class RolePermissionModel extends Model
{
    protected $table = 'role_permission'; // The table managing role-permission relationships
    protected $allowedFields = ['role_id', 'permission_id'];

    /**
     * Get all roles from the database
     */
    public function getRoles()
    {
        return $this->db->table('roles')->get()->getResultArray();
    }

    /**
     * Get all permissions from the database
     */
    public function getPermissions()
    {
        return $this->db->table('permission')->get()->getResultArray();
    }

    /**
     * Get permissions assigned to each role
     */
    public function getRolePermissions()
    {
        $query = $this->db->table($this->table)
            ->select('role_id, permission_id')
            ->get();

        $rolePermissions = [];
        foreach ($query->getResultArray() as $row) {
            $rolePermissions[$row['role_id']][] = $row['permission_id'];
        }

        return $rolePermissions;
    }

    /**
     * Update role permissions based on form input
     */
    public function updateRolePermissions($selectedPermissions)
    {
        // Clear existing role permissions
        $this->truncate();

        // Insert new role permissions
        if (!empty($selectedPermissions)) {
            foreach ($selectedPermissions as $roleId => $permissionIds) {
                foreach ($permissionIds as $permissionId) {
                    $this->insert([
                        'role_id' => $roleId,
                        'permission_id' => $permissionId
                    ]);
                }
            }
        }
    }
}
