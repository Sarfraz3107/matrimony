<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class BaseController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        // Load navbar only for non-AJAX requests
        // if (!$this->input->is_ajax_request()) {
        //     $this->load->view('partials/navbar');
        // }

        $this->check_login();
    }

    private function check_login() {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    private function validate_session() {
        $current_time = time();
        $last_activity = $this->session->userdata('last_activity');
        $timeout_duration = 100;

        if (!$last_activity || ($current_time - $last_activity > $timeout_duration)) {
            redirect('login');
        }

        $this->session->set_userdata('last_activity', $current_time);
    }
}
