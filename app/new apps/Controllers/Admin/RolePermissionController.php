<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RolePermissionModel;

class RolePermissionController extends BaseController
{
    public function index()
    {
        $rolePermissionModel = new RolePermissionModel();

        $data['roles'] = $rolePermissionModel->getRoles();
        $data['permissions'] = $rolePermissionModel->getPermissions();
        $data['rolePermissions'] = $rolePermissionModel->getRolePermissions();

        return view('admin/role_permissions', $data);
    }

    public function update()
    {
        $rolePermissionModel = new RolePermissionModel();
        
        // Get all selected permissions from the form
        $selectedPermissions = $this->request->getPost('permissions');

        // Update role permissions in the database
        $rolePermissionModel->updateRolePermissions($selectedPermissions);

        return redirect()->to('/admin/permissions')->with('success', 'Permissions updated successfully.');
    }
}
