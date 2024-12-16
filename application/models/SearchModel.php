<?php

class SearchModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert_or_update_user($user_id, $gender, $marital_status) {

        // Determine gender_table_id based on gender input (1 for male, 2 for female)
        if ($gender == 1) {
            $gender_table_id = 1; // Male
        } elseif ($gender == 2) {
            $gender_table_id = 2; // Female
        } else {
            $gender_table_id = null;
            log_message('error', 'Invalid gender value passed.');
        }

        if ($gender_table_id !== null) {
            // Check if gender row exists in the table
            $this->db->select('gender, marital_status');
            $this->db->where('table_id', $gender_table_id);
            $query = $this->db->get('search_table');

            if ($query->num_rows() > 0) {
                // Row exists, update the gender array
                $row = $query->row();
                $gender_ids = json_decode($row->gender, true);
                if (!in_array($user_id, $gender_ids)) {
                    $gender_ids[] = $user_id;
                    $this->db->where('table_id', $gender_table_id);
                    $this->db->update('search_table', ['gender' => json_encode($gender_ids)]);
                }
            } else {
                // Row does not exist, insert new row
                $data = [
                    'table_id' => $gender_table_id,
                    'gender' => json_encode([$user_id]),
                    'marital_status' => '[]' // Empty marital_status array initially
                ];
                $this->db->insert('search_table', $data);
            }
        }

        // Now handle marital status
        $this->update_marital_status($user_id, $marital_status);
    }

    private function update_marital_status($user_id, $row_id) {

        // Check if marital status row exists in the table
        $this->db->select('marital_status');
        $this->db->where('table_id', $row_id);
        $query = $this->db->get('search_table');

        if ($query->num_rows() > 0) {
            // Row exists, update marital status array
            $row = $query->row();
            $marital_status_ids = json_decode($row->marital_status, true);
            if (!in_array($user_id, $marital_status_ids)) {
                $marital_status_ids[] = $user_id;
                $this->db->where('table_id', $row_id);
                $this->db->update('search_table', ['marital_status' => json_encode($marital_status_ids)]);
                log_message('debug', 'Marital status IDs updated: ' . print_r($marital_status_ids, true));
            }
        } else {
            // Row does not exist, insert new row for marital status
            log_message('debug', 'No marital status row found. Inserting new row for marital status row_id ' . $row_id);
            $data = [
                'table_id' => $row_id,
                'gender' => null, // Gender is not applicable for marital status rows
                'marital_status' => json_encode([$user_id])
            ];
            $this->db->insert('search_table', $data);
        }
    }
}
