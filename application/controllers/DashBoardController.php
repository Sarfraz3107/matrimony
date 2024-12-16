
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/BaseController.php';
class DashboardController extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('InterestModel');
        $this->load->model('userModel');
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

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $user = $this->UserModel->get_user_by_id($user_id);
    
        if (!$user_id || !$user) {
            redirect('login'); // Redirect to login if the user is not logged in
        }
    
        // Determine the gender to fetch based on the user's gender
        $gender_to_fetch = ($user->gender == '1') ? 2 : 1;
    
        // Fetch profiles of the opposite gender with interest status
        $data['profiles'] = $this->InterestModel->get_profiles_with_interest_status_by_gender($user_id, $gender_to_fetch);
    
        // Load views
        $this->load->view('layouts/header');
        $this->load->view('partials/navbar');
        $this->load->view('dashboard/dashboardView', $data);
        $this->load->view('layouts/footer');
    }

    public function profile_details($id) {
        // Fetch the profile data from the database using the ID
        $profile = $this->userModel->get_profile_by_id($id);
    
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