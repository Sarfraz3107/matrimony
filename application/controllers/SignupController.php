<?php
class SignupController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['form', 'url']);
        $this->load->library(['form_validation', 'session']);
        $this->load->model('UserModel');
        $this->load->model('SearchModel');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard'); // Redirect to the dashboard if already logged in
        }
        $this->load->view('partials/navbar');
        $this->load->view('signupView');
    }
    
    
    
    public function submit() {
        log_message('debug', 'Form submission started.');
    
        // Set validation rules
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('marital_status', 'Marital Status', 'required');
        $this->form_validation->set_rules('on_behalf', 'On Behalf', 'required');
        $this->form_validation->set_rules('age', 'Age', 'required|integer');
        $this->form_validation->set_rules('income', 'Income', 'required');
        $this->form_validation->set_rules('education', 'Education', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('property_owner', 'Property Owner', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            // Collect validation errors
            $errors = [];
            foreach ($_POST as $key => $value) {
                $errors[$key] = form_error($key);
            }
    
            log_message('error', 'Validation errors: ' . json_encode($errors));
    
            // Return error response
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status' => 'error',
                'errors' => $errors
            ]));
        } else {
            // Collect form data
            $password = $this->input->post('password');
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            $formData = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'marital_status_id' => $this->input->post('marital_status'),  // Updated field name
                'on_behalf_id' => $this->input->post('on_behalf'),  // Updated field name
                'age' => $this->input->post('age'),
                'income' => $this->input->post('income'),
                'education' => $this->input->post('education'),
                'gender_id' => $this->input->post('gender'),  // Updated field name
                'property_owner' => $this->input->post('property_owner'),
                'password' => $hashed_password,
                'subscription_id' => 1 // Automatically assign to free subscription
            ];
            
            
            // Try inserting into database
            $user_id = $this->UserModel->insert_user($formData);
    
            if (!$user_id) {
                log_message('error', 'User insertion failed: ' . json_encode($formData));
                $this->output->set_content_type('application/json')->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'Failed to create user. Please try again later.'
                ]));
                return;
            }
    
            // After inserting the user, update gender and marital status
            $gender = (int) $this->input->post('gender');
            $marital_status = (int) $this->input->post('marital_status');
            $this->SearchModel->add_user_to_search_table($user_id, $gender, $marital_status);
    
            // Set session data and return success response
            $user_data = [
                'user_id' => $user_id,
                'name' => $formData['name'],
                'logged_in' => TRUE,
                'last_activity' => time()
            ];
    
    
            $this->session->set_userdata($user_data);
            $this->session->sess_regenerate(TRUE);
    
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status' => 'success',
                'message' => 'User successfully created.',
                'redirect' => base_url('dashboard')
            ]));
        }
    }
    
    


}