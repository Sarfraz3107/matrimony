<?php

require_once APPPATH . 'core/BaseController.php';

class InterestController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
    }

    public function index() {
        // Load the view for interests (the page where users can see and send interests)
        $this->load->view('interest/interestManagement');
    }




    public function send_interest() {
        // Start output buffering

        while (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Type: application/json');
    
        try {
            $sender_id = $this->session->userdata('user_id');
            $receiver_id = $this->input->post('receiver_id');
    
            // Check if interest already exists
            $this->load->model('InterestModel');
            $is_sent = $this->InterestModel->is_interest_sent($sender_id, $receiver_id);
    
            if ($is_sent) {
                http_response_code(400);
                echo json_encode(['status' => 400, 'error' => 'Interest already sent.']);
            } else {
                // Insert the interest into the database
                $data = [
                    'sender_id' => $sender_id,
                    'receiver_id' => $receiver_id,
                    'status' => 'pending'
                ];

                $this->InterestModel->send_interest($data);
    
                http_response_code(200); // Success
        echo json_encode(['status' => 200, 'message' => 'Interest sent successfully.']);
        return;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 500, 'error' => $e->getMessage()]);
        }
    
        // Clean and flush buffer
        // $output = ob_get_clean();
        // echo $output;
    }

    // public function send_interest() {
    //     // Clear previous outputs
    //     while (ob_get_level()) {
    //         ob_end_clean();
    //     }

    //     header('Content-Type: application/json');
    //     echo json_encode(['status' => 200, 'message' => 'Test successful']);
    // }
    

    
    

    // public function load_incoming_interests() {
    //     $user_id = $this->session->userdata('user_id');
        
    //     // Get all pending interests sent to the logged-in user
    //     $interests = $this->db->get_where('interests', ['receiver_id' => $user_id, 'status' => 'pending'])->result();

    //     $this->load->view('partials/navbar');

    //     if ($interests) {
    //         foreach ($interests as $interest) {
    //             $sender = $this->UserModel->get_user_by_id($interest->sender_id);
    //             echo "<div class='interest-item'>
    //                     <p>User " . $sender->name . " has sent you an interest.</p>
    //                     <button class='respond-interest accept' data-interest-id='" . $interest->id . "' data-response='accept'>Accept</button>
    //                     <button class='respond-interest reject' data-interest-id='" . $interest->id . "' data-response='reject'>Reject</button>
    //                     <button class='respond-interest block' data-interest-id='" . $interest->id . "' data-response='block'>Block</button>
    //                   </div>";
    //         }
    //     } else {
    //         echo "<p>No incoming interest requests.</p>";
    //     }
    // }

    public function load_incoming_interests() {
        $user_id = $this->session->userdata('user_id');
        
        // Get all pending interests sent to the logged-in user
        $interests = $this->db->get_where('interests', ['receiver_id' => $user_id, 'status' => 'pending'])->result();
    
        $this->load->view('partials/navbar');
    
        if ($interests) {
            foreach ($interests as $interest) {
                $sender = $this->UserModel->get_user_by_id($interest->sender_id);
                echo "<div class='interest-card'>
                        <h3>User " . $sender->name . " has sent you an interest.</h3>
                        <p>Would you like to respond to their interest?</p>
                        <div class='respond-buttons'>
                            <button class='respond-interest accept' data-interest-id='" . $interest->id . "' data-response='accept'>Accept</button>
                            <button class='respond-interest reject' data-interest-id='" . $interest->id . "' data-response='reject'>Reject</button>
                            <button class='respond-interest block' data-interest-id='" . $interest->id . "' data-response='block'>Block</button>
                        </div>
                      </div>";
            }
        } else {
            echo "<p>No incoming interest requests.</p>";
        }
    }
    


    public function respond_interest($interest_id, $response) {
        $user_id = $this->session->userdata('user_id');
        
        // Fetch the interest request
        $interest = $this->db->get_where('interests', ['id' => $interest_id, 'receiver_id' => $user_id])->row();

        if ($interest) {
            if ($response == 'accept') {
                $this->db->where('id', $interest_id);
                $this->db->update('interests', ['status' => 'accepted']);
            } elseif ($response == 'reject') {
                $this->db->where('id', $interest_id);
                $this->db->update('interests', ['status' => 'rejected']);
            } elseif ($response == 'block') {
                $this->db->where('id', $interest_id);
                $this->db->update('interests', ['status' => 'blocked']);
            }
            echo json_encode(['message' => 'Interest response recorded.']);
        } else {
            echo json_encode(['error' => 'Invalid interest request.']);
        }
    }

}
?>
