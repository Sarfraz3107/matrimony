<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/BaseController.php';

class PhotoUploadController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('UserModel');
    }

    public function upload_file($id)
    {

        // Validate user ID
        if (!is_numeric($id)) {
            echo "Invalid user ID.";
            return;
        }

        // Check if file is uploaded
        if (!isset($_FILES['file'])) {
            echo "No file uploaded.";
            return;
        }

        // Configure upload
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size']      = 2048; // 2MB
        $config['file_name']     = 'profile_' . $id . '_' . time();

        $this->load->library('upload', $config);

        // Perform the upload
        if (!$this->upload->do_upload('file')) {
            echo "Upload error: " . $this->upload->display_errors();
            return;
        }

        // Get the file data after upload
        $upload_data = $this->upload->data();
        $file_path = 'uploads/' . $upload_data['file_name'];

        // Update the database with the new image path
        if (!$this->UserModel->updated_user_image($id, $file_path)) {
            echo "Database error: Unable to update image path.";
            return;
        }


        // Retrieve updated user data
        $data['user'] = $this->UserModel->get_user_by_id($id);

        // Check if user data exists
        if (empty($data['user'])) {
            echo "Failed to fetch updated user data.";
            die;
        }

        // Load the view with the updated user data
        $this->load->view('profile/viewProfileView', $data);
    }
}
?>
