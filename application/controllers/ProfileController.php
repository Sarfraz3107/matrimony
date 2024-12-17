<?php 

require_once APPPATH . 'core/BaseController.php';
class ProfileController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('UserModel');
    }

    
    public function view() {
        $user_id = $this->session->userdata('user_id');
        
        if (!$user_id) {
            echo 'No user ID in session';  // Debugging line
            redirect('login');
            return;
        }
    
        
        $this->load->model('UserModel');
        $user = $this->UserModel->get_user_by_id($user_id);
        
        if (!$user) {
            echo 'User not found in database';  // Debugging line
            show_error('User not found', 404);
            return;
        }
    
        // Pass user data to the view
        $this->load->view('partials/navbar');
        $this->load->view('profile/viewProfileView.php', ['user' => $user]);
    }
    

    public function edit() {
        $user_id = $this->session->userdata('user_id');
        $user = $this->UserModel->get_user_by_id($user_id);
        $this->load->view('partials/navbar');
        $this->load->view('profile/editProfileView', ['user' => $user]);
    }

    public function update() {
        $user_id = $this->session->userdata('user_id');
        
        // Validate form inputs
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('age', 'Age', 'required|numeric');
        $this->form_validation->set_rules('subscription_type', 'Subscription', 'required');

        if ($this->form_validation->run() === FALSE) {
            // Reload edit view with validation errors
            $this->edit();
        } else {
            // Gather updated data
            $formData = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'age' => $this->input->post('age'),
                'subscription_type' => $this->input->post('subscription_type'),
            ];

            // Hash and update password if provided
            $password = $this->input->post('password');
            if (!empty($password)) {
                $formData['password'] = password_hash($password, PASSWORD_BCRYPT);
            }

            // Update user in database
            $updated = $this->UserModel->update_user($user_id, $formData);

            if ($updated) {
                // Update session data for immediate reflection
                $this->session->set_userdata([
                    'name' => $formData['name'],
                    'subscription_type' => $formData['subscription_type'],
                ]);

                // Redirect to profile page with success message
                $this->session->set_flashdata('success', 'Profile updated successfully.');
               
                redirect('profile');
            } else {
                // Show error message and reload edit view
                $this->session->set_flashdata('error', 'Update failed. Please try again.');
                $this->edit();
            }
        }
    }

    
}
