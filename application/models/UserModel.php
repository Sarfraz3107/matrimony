<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

    // Define the table name
    private $table = 'users';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Function to insert user data into the database
    public function insert_user($data) {
        // Insert the user data and return the result
        print_r($data);
        $this->db->insert($this->table, $data);
        return $this->db->insert_id(); // Return the ID of the inserted user
    }

    // Function to validate unique fields (for example, checking if email exists)
    public function check_user_exists($email) {
        $this->db->where('email', $email);
        $query = $this->db->get($this->table);
        return $query->num_rows() > 0; // Return true if email exists
    }

    // Optional: Retrieve a user by their ID or other unique attribute
    public function get_user_by_id($user_id) {
        return $this->db->get_where('users', ['id' => $user_id])->row();
    }


    public function get_user_by_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users'); // Assuming the table name is 'users'
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return null;  // Return null if user not found
    }

    // public function get_profiles_by_gender($gender, $exclude_user_id) {

    //     return $this->db->get_where('users', ['gender' => $gender, 'id !=' => $exclude_user_id])->result();
    // }

    public function update_user_photo($user_id, $photo_path) {
        // Update the photo_path in the users table
        $data = [
            'photo_path' => $photo_path
        ];

        $this->db->where('id', $user_id);
        return $this->db->update($this->table, $data);
    }



}
