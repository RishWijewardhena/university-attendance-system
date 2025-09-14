<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RolePermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Ensure the user is logged in
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/login')->with('error', 'You must log in first.');
        }

        // Check if the user has the required permission
        $requiredPermission = $arguments[0] ?? null;

        if ($requiredPermission && !hasPermission($requiredPermission)) {
            return redirect()->to('/no_permission')->with('error', 'Access denied.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do after request
    }
}
