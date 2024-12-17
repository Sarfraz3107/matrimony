

<?php
class SearchModel extends CI_Model {

public function add_user_to_search_table($user_id, $gender, $marital_status) {
    if ($gender == 1) { // Male
        $this->update_gender_row(1, $user_id);
    } elseif ($gender == 2) { // Female
        $this->update_gender_row(2, $user_id);
    }

    // Marital Status check
    if ($marital_status == 1) { // Never Married
        $this->update_marital_status_row(1, $user_id);
    } elseif ($marital_status == 2) { // Married
        $this->update_marital_status_row(2, $user_id);
    } elseif ($marital_status == 3) { // Divorced
        $this->update_marital_status_row(3, $user_id);
    } elseif ($marital_status == 4) { // Separated
        $this->update_marital_status_row(4, $user_id);
    }
}

private function update_gender_row($table_id, $user_id) {
    // Get current gender values from the row
    $this->db->select('gender');
    $this->db->where('table_id', $table_id);
    $query = $this->db->get('search_table');
    $row = $query->row();

    if ($row) {
        // Check if user ID is already in the list
        $current_gender = $row->gender ? json_decode($row->gender) : [];
        if (!in_array($user_id, $current_gender)) {
            // Append user ID to the list
            $current_gender[] = $user_id;
            $this->db->where('table_id', $table_id);
            $this->db->update('search_table', ['gender' => json_encode($current_gender)]);
        }
    } else {
        // If no row exists, create a new one
        $this->db->insert('search_table', [
            'table_id' => $table_id,
            'gender' => json_encode([$user_id]),
            'marital_status' => json_encode([]) // Initial empty marital status
        ]);
    }
}

private function update_marital_status_row($table_id, $user_id) {
    // Get current marital status values from the row
    $this->db->select('marital_status');
    $this->db->where('table_id', $table_id);
    $query = $this->db->get('search_table');
    $row = $query->row();

    if ($row) {
        // Check if user ID is already in the list
        $current_status = $row->marital_status ? json_decode($row->marital_status) : [];
        if (!in_array($user_id, $current_status)) {
            // Append user ID to the list
            $current_status[] = $user_id;
            $this->db->where('table_id', $table_id);
            $this->db->update('search_table', ['marital_status' => json_encode($current_status)]);
        }
    } else {
        // If no row exists, create a new one
        $this->db->insert('search_table', [
            'table_id' => $table_id,
            'gender' => json_encode([]), // Empty gender initially
            'marital_status' => json_encode([$user_id]) // Start with the user ID
        ]);
    }
}





}
