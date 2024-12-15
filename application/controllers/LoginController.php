<?php

class LoginController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('UserModel');
    }

    public function index() {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');  // User is logged in, no need to see the login page
        }
        $this->load->view('partials/navbar');
        $this->load->view('loginView');
    }

    public function submit() {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('loginView');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            // Verify email and password from the database
            $user = $this->UserModel->get_user_by_email($email);

            if ($user && password_verify($password, $user['password'])) {
                // Set session data
                $user_data = [
                    'user_id' => $user['id'],
                    'email' => $user['email'],
                    'logged_in' => TRUE,
                    'last_activity' => time(),
                ];
                $this->session->set_userdata($user_data);
                $this->session->sess_regenerate(TRUE);

                // Redirect to dashboard after successful login
                redirect('dashboard');
            } else {
                // Show error if authentication fails
                $this->session->set_flashdata('error', 'Invalid email or password.');
                redirect('login');
            }
        }
    }
}
