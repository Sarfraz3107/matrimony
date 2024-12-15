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
        $this->db->select('users.*, 
            (SELECT COUNT(*) 
             FROM interests 
             WHERE interests.sender_id = ' . $user_id . ' 
               AND interests.receiver_id = users.id) AS interest_sent');
        $this->db->from('users');
        $this->db->where('users.gender', $gender); // Fetch profiles of the specified gender
        $this->db->where('users.id !=', $user_id); // Exclude the logged-in user
        $query = $this->db->get();
        return $query->result();
    }
    


}
