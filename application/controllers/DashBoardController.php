
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/BaseController.php';
class DashboardController extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('InterestModel');
        $this->load->model('UserModel');
        $this->load->library('pagination');
    }



public function index($page = 1) { // Default to page 1 if no number is passed
    $user_id = $this->session->userdata('user_id');
    $user = $this->UserModel->get_user_by_id($user_id);

    if (!$user_id || !$user) {
        redirect('login'); // Redirect to login
    }

    $gender_to_fetch = ($user->gender_id == 1) ? 2 : 1;


    $config['full_tag_open'] = '<div class="pagination-container">';
$config['full_tag_close'] = '</div>';

$config['first_link'] = 'First';
$config['first_tag_open'] = '<span class="pagination-item first">';
$config['first_tag_close'] = '</span>';

$config['last_link'] = 'Last';
$config['last_tag_open'] = '<span class="pagination-item last">';
$config['last_tag_close'] = '</span>';

$config['next_link'] = '&raquo;';
$config['next_tag_open'] = '<span class="pagination-item next">';
$config['next_tag_close'] = '</span>';

$config['prev_link'] = '&laquo;';
$config['prev_tag_open'] = '<span class="pagination-item prev">';
$config['prev_tag_close'] = '</span>';

$config['cur_tag_open'] = '<span class="pagination-item current">';
$config['cur_tag_close'] = '</span>';

$config['num_tag_open'] = '<span class="pagination-item">';
$config['num_tag_close'] = '</span>';




    // Pagination settings
    $config['base_url'] = base_url('dashboard/index');
    $config['total_rows'] = $this->InterestModel->count_profiles_with_interest_status_by_gender($user_id, $gender_to_fetch);
    $config['per_page'] = 10;
    $config['uri_segment'] = 3;
    $config['use_page_numbers'] = TRUE;

    $this->pagination->initialize($config);

    // Calculate offset
    $offset = ($page - 1) * $config['per_page'];
    $data['profiles'] = $this->InterestModel->get_profiles_with_interest_status_by_gender($user_id, $gender_to_fetch, $config['per_page'], $offset);

    $data['pagination_links'] = $this->pagination->create_links();

    // Load views
    $this->load->view('partials/navbar');
    $this->load->view('layouts/header');
    $this->load->view('dashboard/dashboardView', $data);
    $this->load->view('layouts/footer');
}

    

    public function profile_details($id) {
        // Fetch the profile data from the database using the ID
        $profile = $this->UserModel->get_profile_by_id($id);
    
        // Debugging: print the profile data
        if ($profile) {
            // Pass the profile as an associative array to the view
            $data['profile'] = $profile; // Store the profile data in the $data array
            $this->load->view('profile/profileDetailsView', $data); // Pass $data to the view
        } else {
            echo "Profile not found.";
        }
    
    }
    
    
    


}