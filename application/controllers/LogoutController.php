<?php
class LogoutController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load the session library to manage session data
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        // Destroy all session data
        $this->session->sess_destroy();

        // Redirect to login page after successful logout
        redirect('login');
    }
}
