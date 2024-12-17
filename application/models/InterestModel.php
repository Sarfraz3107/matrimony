<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InterestModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Check if an interest exists between two users.
     * 
     * @param int $sender_id The ID of the sender.
     * @param int $receiver_id The ID of the receiver.
     * @return bool True if interest exists, false otherwise.
     */
    public function is_interest_sent($sender_id, $receiver_id) {
        $query = $this->db->get_where('interests', [
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id
        ]);
        return $query->num_rows() > 0;
    }

    /**
     * Send interest to a user.
     * 
     * @param array $data The interest data to insert.
     * @return bool True if the interest is successfully inserted.
     */
    public function send_interest($data) {
        return $this->db->insert('interests', $data);
    }

    public function get_profiles_with_interest_status_by_gender($user_id, $gender) {
        // Select the user data and the interest count using JOIN
        $this->db->select('users.*, 
            IFNULL(COUNT(interests.id), 0) AS interest_sent'); // Use IFNULL to return 0 if no interests
        
        // From the 'users' table
        $this->db->from('users');
        
        // Join with 'interests' table to get the count of interests
        $this->db->join('interests', 'interests.receiver_id = users.id AND interests.sender_id = ' . $user_id, 'left');
        
        // Filter by gender and exclude the logged-in user
        $this->db->where('users.gender_id', $gender);
        $this->db->where('users.id !=', $user_id);
    
        // Group by user ID to count the number of interests
        $this->db->group_by('users.id');
        
        // Execute the query
        $query = $this->db->get();
    
        // Return the result as an array
        return $query->result();
    }
    
    


}
