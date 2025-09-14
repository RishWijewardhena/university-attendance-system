<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default Route
$routes->get('/', 'HomeController::index');

// User registration
$routes->get('/register', 'RegisterController::register');
$routes->post('/register', 'RegisterController::processRegister');


// Login and Authentication Routes
$routes->get('/login', 'Auth::index'); // Display login page
$routes->post('/Auth/authenticate', 'Auth::authenticate'); // Handle login
$routes->get('/logout', 'Auth::logout'); // Handle logout
$routes->get('/googlelogin/login', 'GoogleLogin::login');
$routes->get('/googlelogin/callback', 'GoogleLogin::callback');
// $routes->get('/googlelogin/completeProfile', 'GoogleLogin::completeProfile'); // Route to show the profile completion form
$routes->post('/googlelogin/saveProfile', 'GoogleLogin::saveProfile'); // Route to save profile details


// Password Recovery Routes
$routes->get('/auth/forgot_password', 'Auth::forgot_password'); // Forgot Password Form
$routes->post('/auth/process_forgot_password', 'Auth::process_forgot_password'); // Process Forgot Password
$routes->get('/auth/otp_verification_form', 'Auth::otp_verification_form'); // OTP Verification Form
$routes->post('/auth/validate_otp', 'Auth::validate_otp'); // Validate OTP
$routes->get('/auth/reset_password_form', 'Auth::reset_password_form'); // Reset Password Form
$routes->post('/auth/process_reset_password', 'Auth::process_reset_password'); // Process Reset Password


// No Permission Route
$routes->get('no_permission', 'Auth::noPermission');


// Dashboard and Course Management Routes
$routes->get('/dashboard', 'DashboardController::index'); // Dashboard page
//routes->get('/course', 'CourseController::index'); // Courses page
$routes->get('/create-class', 'CreateClassController::index');
$routes->post('/create-class/store', 'CreateClassController::store');
$routes->get('course/(:segment)', 'CourseController::view/$1');
//$routes->post('/upload-csv/(:any)', 'CourseController::uploadCsv/$1');

// Auto Routing
$routes->setAutoRoute(false);

// Course Routes
$routes->get('/course', 'CourseController::index'); // Display create_class form
$routes->post('/course/create', 'CourseController::create'); // Handle class creation form submission

// Explicit route for create_class page
$routes->get('/create_class', 'CourseController::index');


// attendance
//$routes->get('/view-attendance/(:any)', 'AttendanceController::view/$1');
//$routes->get('view-attendance/(:segment)/(:segment)', 'AttendanceController::view/$1/$2');
//$routes->get('/course/(:segment)', 'CourseController::view/$1');
//$routes->get('/attendance/(:segment)', 'AttendanceController::view/$1');

//$routes->get('/course', 'CourseController::index'); // Courses page
$routes->group('course', function ($routes) {
    $routes->get('view-files/(:num)', 'CourseController::viewUploadedFiles/$1'); // View uploaded CSV files for a specific class
    $routes->post('upload-csv/(:num)', 'CourseController::uploadCSV/$1'); // Upload a new CSV file for a specific class
    $routes->get('delete-csv/(:num)', 'CourseController::deleteCSV/$1'); // Delete a specific CSV file (mark as inactive)
    $routes->get('view-attendance/(:any)', 'CourseController::viewAttendance/$1'); //show attendance
    $routes->get('delete-class/(:num)', 'CourseController::deleteClass/$1'); // Delete a specific class
});


// Admin Routes
$routes->group('admin', function ($routes) {
    $routes->get('admin_panel', 'Admin\AdminController::index', ['filter' => 'rolePermission:show_admin_panel']);
    $routes->get('courses', 'Admin\CourseController::index' ,['filter' => 'rolePermission:show_admin_panel']);
    $routes->get('courses/add', 'Admin\CourseController::add');
    $routes->post('courses/create', 'Admin\CourseController::create');
    $routes->get('courses/edit/(:num)', 'Admin\CourseController::edit/$1');
    $routes->post('courses/update/(:num)', 'Admin\CourseController::update/$1');
    $routes->get('courses/delete/(:num)', 'Admin\CourseController::delete/$1');


    //controllers
    $routes->get('users', 'Admin\AdminController::users',['filter' => 'rolePermission:show_admin_panel']); // View Users
    $routes->get('users/edit/(:num)', 'Admin\AdminController::edit/$1'); // Edit User
    $routes->post('users/update/(:num)', 'Admin\AdminController::update/$1'); // Update User
    $routes->get('users/deactivate/(:num)', 'Admin\AdminController::deactivate_user/$1'); // deactivate User
    $routes->get('users/activate/(:num)', 'Admin\AdminController::activate_user/$1'); // activate User
    // view all courses
    // $routes->get('view_all_courses', 'Admin\CourseController::view_courses', ['filter' => 'rolePermission:show_all_courses_details']);
    $routes->get('permissions', 'Admin\RolePermissionController::index', ['filter' => 'rolePermission:manage_permissions']);
    $routes->post('role-permissions/update', 'Admin\RolePermissionController::update', ['filter' => 'rolePermission:manage_permissions']);

    //assign lecturers
    $routes->get('assign-lecturers', 'Admin\LecturerCoursesController::index',['filter'=>'rolePermission:assign_lecturers']);
    $routes->post('assign-lecturers/store', 'Admin\LecturerCoursesController::store');
    $routes->post('assign-lecturers/uploadCSV', 'Admin\LecturerCoursesController::uploadCSV');
   
    //show progress
    $routes->get('progress', 'Admin\AdminController::showProgress'); 
    $routes->get('progress-data', 'Admin\AdminController::getAttendanceData'); 

    
});


// Profile Routes
$routes->get('/profile', 'ProfileController::index'); // Display user profile

//progress
$routes->get('/progress', 'ProgressController::index', ['filter' => 'rolePermission:show_progress']);  

//student attendance
$routes->get('attendance/student', 'AttendanceController::studentAttendance');