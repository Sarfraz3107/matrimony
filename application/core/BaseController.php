<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class BaseController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        $this->check_login();
    }

    private function check_login() {
        if (!$this->session->userdata('logged_in')) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'error', 'message' => 'Session expired, please login again.']);
                exit;  // Stop further execution
            } else {
                redirect('login');
            }
        }

        $this->validate_session();

    }
    

    private function validate_session() {
        $current_time = time();
        $last_activity = $this->session->userdata('last_activity');
        $timeout_duration = 900;  // 15 minutes timeout
    
        if (!$last_activity || ($current_time - $last_activity > $timeout_duration)) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'error', 'message' => 'Session expired, please login again.']);
                exit;  // Stop further execution
            } else {
                redirect('login');
            }
        }
    
        $this->session->set_userdata('last_activity', $current_time);
    }
    
}
