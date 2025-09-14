<?php

function hasPermission($permission)
{
    $session = session();
    $roleId = $session->get('role_id');

    // If no role_id in session, deny access
    if (!$roleId) {
        log_message('info', 'No role ID in session.');
        return false;
    }

    //log_message('info', 'Role ID: ' . $roleId);

    // Load the PermissionModel
    $permissionModel = new \App\Models\PermissionModel();

    // Fetch permissions for the role
    $permissions = $permissionModel->getPermissionsByRole($roleId);

    //log_message('info', 'Permissions fetched: ' . print_r($permissions, true));

    // Check if the permission exists
    foreach ($permissions as $perm) {
        if ($perm['permission_name'] === $permission) {
            //log_message('info', 'Permission granted: ' . $permission);
            return true;
        }
    }

    //log_message('info', 'Permission denied for: ' . $permission);
    return false;
}