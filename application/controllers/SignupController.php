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
            // Return JSON error messages for validation failures
            // echo json_encode([
            //     'status' => 'error',
            //     'message' => validation_errors()
            // ]);
        } else {
            // Prepare form data
            $formData = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'marital_status' => $this->input->post('marital_status'),
                'on_behalf' => $this->input->post('on_behalf'),
                'age' => $this->input->post('age'),
                'income' => $this->input->post('income'),
                'education' => $this->input->post('education'),
                'gender' => $this->input->post('gender'),
                'property_owner' => $this->input->post('property_owner'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'subscription_type' => 'free'
            ];

            // Attempt to insert the user into the database
            $user_id = $this->UserModel->insert_user($formData);


            if ($user_id) {

                $this->SearchModel->insert_user($user_id, $formData['gender'], $formData['marital_status']);
                // Set session data
                $user_data = [
                    'user_id' => $user_id,
                    'name' => $formData['name'],
                    'logged_in' => TRUE,
                    'last_activity' => time() // Add current timestamp for last activity
                ];

                $this->session->set_userdata($user_data);
                $this->session->sess_regenerate(TRUE); // Regenerate session ID for security

                redirect('dashboard');

                // Return success response
                // echo json_encode([
                //     'status' => 'success',
                //     'redirect' => base_url('dashboard')
                // ]);
            } else {
                // Return error response if insertion fails
                // echo json_encode([
                //     'status' => 'error',
                //     'message' => 'Failed to create user. Please try again later.'
                // ]);
            }
        }
    }
}
