<?php 


class ProfileController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('UserModel');
    }

    public function edit() {
        // Get the current user's details
        $user_id = $this->session->userdata('user_id');
        $user = $this->UserModel->get_user_by_id($user_id);
        
        // Load the profile edit view and pass user data
        $this->load->view('profile/edit', ['user' => $user]);
    }

    public function update() {
        $user_id = $this->session->userdata('user_id');
        
        // Form validation
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('age', 'Age', 'required|numeric');
        // Additional validation rules for profile fields

        if ($this->form_validation->run() === FALSE) {
            // Reload profile edit view with validation errors
            $this->edit();
        } else {
            // Get the updated data from the form
            $formData = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'age' => $this->input->post('age'),
                'income' => $this->input->post('income'),
                'education' => $this->input->post('education'),
                'marital_status' => $this->input->post('marital_status'),
                'property_owner' => $this->input->post('property_owner'),
                'profile_picture' => $this->upload_profile_picture(), // Handle profile picture upload
                'subscription_type' => $this->input->post('subscription_type') ?? 'free', // Handle subscription upgrade
            ];

            // Update the user's profile
            $updateStatus = $this->UserModel->update_user($user_id, $formData);

            if ($updateStatus) {
                // Update session data
                $this->session->set_userdata([
                    'name' => $formData['name'],
                    'subscription_type' => $formData['subscription_type']
                ]);
                
                // Redirect to the dashboard or a success page
                redirect('dashboard');
            } else {
                // If update fails, show error
                $this->session->set_flashdata('error', 'Profile update failed.');
                $this->edit();
            }
        }
    }

    // private function upload_profile_picture() {
    //     // Logic for handling profile picture upload
    //     if (!empty($_FILES['profile_picture']['name'])) {
    //         // Handle file upload and return file path
    //     }
    //     return null;
    // }

    public function upload_photo() {
        // User must be logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        // Configuration for file upload
        $config['upload_path'] = './uploads/profile_pictures/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;  // 2 MB max size
        $config['file_name'] = 'profile_' . $this->session->userdata('user_id');  // Unique filename

        $this->upload->initialize($config);

        // If upload is successful
        if ($this->upload->do_upload('profile_photo')) {
            // Get the file data
            $file_data = $this->upload->data();

            // Prepare data for saving into the database
            $photo_path = 'uploads/profile_pictures/' . $file_data['file_name']; // Path to the uploaded photo

            // Update the user record with the photo path
            $user_id = $this->session->userdata('user_id');
            $this->UserModel->update_user_photo($user_id, $photo_path);

            // Redirect to the profile page
            redirect('profile');
        } else {
            // If upload fails, reload the profile page with an error message
            $data['error'] = $this->upload->display_errors();
            $this->load->view('profile_edit', $data);
        }
    }



}


?>
