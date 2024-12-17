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




    public function get_profiles_with_interest_status_by_gender($user_id, $gender, $limit, $offset) {
        $this->db->select('users.*, IFNULL(COUNT(interests.id), 0) AS interest_sent');
        $this->db->from('users');
        $this->db->join('interests', 'interests.receiver_id = users.id AND interests.sender_id = ' . $user_id, 'left');
        $this->db->where('users.gender_id', $gender);
        $this->db->where('users.id !=', $user_id);
        $this->db->group_by('users.id');
        $this->db->limit($limit, $offset); // Add limit and offset for pagination
        $query = $this->db->get();
        return $query->result();
    }
    

    public function count_profiles_with_interest_status_by_gender($user_id, $gender) {
        // Count the total number of profiles with the specified interest status and gender
        
        $this->db->select('users.id'); // Select only the user ID for counting
        $this->db->from('users');
        $this->db->join('interests', 'interests.receiver_id = users.id AND interests.sender_id = ' . $user_id, 'left');
        $this->db->where('users.gender_id', $gender);
        $this->db->where('users.id !=', $user_id);
        $this->db->group_by('users.id'); // Group by user ID
    
        // Return the count of profiles
        return $this->db->count_all_results();
    }
    
    


}
