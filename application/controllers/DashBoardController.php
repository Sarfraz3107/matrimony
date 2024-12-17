
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
        // Additional initialization if needed
    }

    // public function index() {
    //     $user_id = $this->session->userdata('user_id');
    //     $user = $this->UserModel->get_user_by_id($user_id);

        

    //     // If the logged-in user is male, show only female profiles
    //     if ($user->gender == '1') {
    //         // Get all female profiles except the current user
    //         $data['profiles'] = $this->UserModel->get_profiles_by_gender(2, $user_id);
    //     } else {
    //         // If the user is female, show all male profiles
    //         $data['profiles'] = $this->UserModel->get_profiles_by_gender(1, $user_id);
    //     }

    //     $this->load->view('layouts/header');
        
    //     $this->load->view('dashboard/dashboardView', $data);
    //     $this->load->view('layouts/footer');
    // }

    // public function index() {
    //     $user_id = $this->session->userdata('user_id');
    //     $user = $this->UserModel->get_user_by_id($user_id);
    
    //     if (!$user_id || !$user) {
    //         redirect('login'); // Redirect to login if the user is not logged in
    //     }
    
    //     // Determine the gender to fetch based on the user's gender
    //     $gender_to_fetch = ($user->gender == '1') ? 2 : 1;
    
    //     // Fetch profiles of the opposite gender with interest status
    //     $data['profiles'] = $this->InterestModel->get_profiles_with_interest_status_by_gender($user_id, $gender_to_fetch);
    
    //     // Load views
    //     $this->load->view('layouts/header');
    //     $this->load->view('partials/navbar');
    //     $this->load->view('dashboard/dashboardView', $data);
    //     $this->load->view('layouts/footer');
    // }

//     public function index() {
//         $user_id = $this->session->userdata('user_id');
//         $user = $this->UserModel->get_user_by_id($user_id);

//         // var_dump($user);
//         // echo $user;
//         // die("something..");
    
//         if (!$user_id || !$user) {
//             redirect('login'); // Redirect to login if the user is not logged in
//         }
    
//         // Determine the gender to fetch based on the user's gender
//         $gender_to_fetch = ($user->gender_id == '1') ? 2 : 1;

//         // var_dump($gender_to_fetch);
//         // echo  $gender_to_fetch;
//         // die("something..");
    
//         // Pagination settings
       
    
//         // Configuring pagination
//         $config['base_url'] = base_url('dashboard/index');


//         // var_dump("hii");
//         // echo "hiii";
//         // die("hii");
//         $config['total_rows'] = $this->InterestModel->count_profiles_with_interest_status_by_gender($user_id, $gender_to_fetch); // Count total profiles for pagination

//         // var_dump("hii");
//         // echo "hiii";
//         // die("hii");

//         $config['per_page'] = 10; // Number of profiles per page
//         $config['uri_segment'] = 3;
//     // Segment in the URL where the page number is passed
//         $config['num_links'] = 2;
    
//         $this->pagination->initialize($config);
    
//         // Get the current page from the URL
//         $page = $this->uri->segment(3, 0);
//         var_dump($page);
//         die('Debug page segment');
        
//         // Fetch profiles with interest status based on pagination
//         $data['profiles'] = $this->InterestModel->get_profiles_with_interest_status_by_gender($user_id, $gender_to_fetch, $config['per_page'], $page);
        
//         // var_dump($data);
//         // print_r($data);
//         // die("something went ..");

//         // Pass pagination links to the view
//         $data['pagination_links'] = $this->pagination->create_links();
    
//         // Load views
//         $this->load->view('layouts/header');
//         $this->load->view('partials/navbar');
//         $this->load->view('dashboard/dashboardView', $data);
//         $this->load->view('layouts/footer');
// }



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
    $this->load->view('layouts/header');
    $this->load->view('partials/navbar');
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