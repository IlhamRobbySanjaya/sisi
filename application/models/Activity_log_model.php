<?php
class Activity_log_model extends CI_Model
{

    public function insert_activity($id_user, $discripsi)
    {
        $data = array(
            'id_user' => $id_user,
            'discripsi' => $discripsi
        );
        $this->db->insert('user_activity', $data);
    }
}
