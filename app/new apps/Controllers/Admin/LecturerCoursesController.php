<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LecturerAssignmentModel;
use CodeIgniter\HTTP\ResponseInterface;

class LecturerCoursesController extends BaseController
{
    public function index()
    {
        $model = new LecturerAssignmentModel();
        $data['lecturers'] = $model->findAll();
        return view('admin/assign_lecturers', $data);
    }

    public function store()
    {
        $session = session();
        $model = new LecturerAssignmentModel();
        $adminUserId = $session->get('user_id');
        $data = [
            'lecturer_email' => $this->request->getPost('lecturer_email'),
            'course_code'    => $this->request->getPost('course_code'),
            'admin_user_id'  => $adminUserId,
            'created_at'     => date('Y-m-d H:i:s'),
        ];

        $model->save($data);
        return redirect()->to('/admin/assign-lecturers')->with('success', 'Lecturer assigned successfully!');
    }

    public function uploadCSV()
    {
        $session = session();
        $adminUserId = $session->get('user_id'); // Get logged-in user ID from session

        if (!$adminUserId) {
            return redirect()->to('/admin/assign-lecturers')->with('error', 'User not logged in!');
        }

        $file = $this->request->getFile('csv_file');
        log_message('info', 'Uploaded file: ' . $file->getName());
        if ($file->isValid() && !$file->hasMoved()) {
            // Validate the file type (CSV only)
            $allowedMimeTypes = ['text/csv', 'application/vnd.ms-excel'];
            $allowedExtensions = ['csv'];
        
            // Get file details
            $fileMimeType = $file->getMimeType();
            $fileExtension = $file->getExtension();
        
            if (!in_array($fileMimeType, $allowedMimeTypes) || !in_array($fileExtension, $allowedExtensions)) {
                return redirect()->back()->with('error', 'Invalid file type. Only CSV files are allowed.');
            }
        
            // Store the file if valid
            $filepath = WRITEPATH . 'uploads/' . $file->store();

            $file = fopen($filepath, 'r');
            $model = new LecturerAssignmentModel();
            
            // Read and parse the header row
            $header = fgetcsv($file);

            // Log the actual CSV headers to debug
           // log_message('info', 'CSV Header: ' . print_r($header, true));

            if ($header === false || count($header) < 2) {
                return redirect()->to('/admin/assign-lecturers')->with('error', 'Invalid CSV format!');
            }

            // Normalize headers (trim spaces and convert to lowercase)
            $header = array_map('strtolower', array_map('trim', $header));

           // log_message('info', 'Processed CSV Header: ' . print_r($header, true)); // Log the cleaned headers

            $emailIndex = array_search('lecturer email', $header);
            $courseIndex = array_search('course code', $header);

            if ($emailIndex === false || $courseIndex === false) {
                log_message('error', 'CSV headers do not match expected format!');
                return redirect()->to('/admin/assign-lecturers')->with('error', 'CSV headers do not match expected format!');
            }


            $data = [];

           

            while ($row = fgetcsv($file)) {
                // Read values based on detected column positions
                $data[] = [
                    'lecturer_email' => trim($row[$emailIndex]),
                    'course_code'    => trim($row[$courseIndex]),
                    'admin_user_id'  => $adminUserId, // Use session user ID
                ];
                log_message('debug', 'CSV Row: ' . print_r($row, true));
            }

            fclose($file);

            if (!empty($data)) {
                $model->insertBatch($data);
                log_message('info', 'CSV Uploaded by Admin User ID: ' . $adminUserId);
            }

            return redirect()->to('/admin/assign-lecturers')->with('success', 'CSV Uploaded Successfully!');
        }

        return redirect()->to('/admin/assign-lecturers')->with('error', 'Invalid file!');
    }
}
