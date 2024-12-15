
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class SearchModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Insert a new user into the search table based on gender and marital status
    public function insert_user($user_id, $gender = null, $marital_status = null)
    {
        log_message('debug', "User ID: " . $user_id);
        log_message('debug', "Gender: " . $gender);
        log_message('debug', "Marital Status: " . $marital_status);
    
        // Gender Insert/Update
        if ($gender !== null) {
            $gender_id = ($gender == 1) ? 1 : 2;  // Gender 1 for Male, 2 for Female

            // Check if the record for the gender exists
            $this->db->where('id', $gender_id);
            $query = $this->db->get('search');

            if ($query->num_rows() == 0) {
                // Insert a new record if it doesn't exist
                $data = [
                    'id' => $gender_id,
                    'gender' => json_encode([$user_id])
                ];
                if ($this->db->insert('search', $data)) {
                    log_message('debug', 'New gender record inserted');
                } else {
                    log_message('error', 'Failed to insert gender record');
                }
            } else {
                // Update existing record by appending the user ID to the gender field
                $sql = "UPDATE search SET gender = JSON_ARRAY_APPEND(gender, '$', ?) WHERE id = ?";
                $this->db->query($sql, [$user_id, $gender_id]);
                log_message('debug', 'Updated gender record');
            }
        }
    
        // Marital Status Insert/Update
        if ($marital_status !== null) {
            // Check if the record for the marital status exists
            $this->db->where('id', $marital_status);
            $query = $this->db->get('search');
            log_message('debug', "Marital Status query result: " . print_r($query->result_array(), true));

            if ($query->num_rows() == 0) {
                // Insert a new record if it doesn't exist
                $data = [
                    'id' => $marital_status,
                    'marital_status' => json_encode([$user_id])
                ];
                if ($this->db->insert('search', $data)) {
                    log_message('debug', 'New marital status record inserted');
                } else {
                    log_message('error', 'Failed to insert marital status record');
                }
            } else {
                // Update existing record by appending the user ID to the marital_status field
                $sql = "UPDATE search SET marital_status = JSON_ARRAY_APPEND(marital_status, '$', ?) WHERE id = ?";
                $this->db->query($sql, [$user_id, $marital_status]);
                log_message('debug', 'Updated marital status record');
            }
        }
    }
}
