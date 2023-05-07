<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_activity_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function list()
    {
        $this->db->select('*');
        $this->db->where('active', 1);
        $query = $this->db->get("user_activity");
        return $query;
    }

    function insert($no_activity, $id_user, $discripsi, $status, $menu_id, $delete_mark)
    {
        $data = array(
            'no_activity' => $no_activity,
            'id_user' => $id_user,
            'discripsi' => $discripsi,
            'status' => $status,
            'menu_id' => $menu_id,
            'delete_mark' => $delete_mark,
            'active' => '1',
        );
        $this->db->insert('user_activity', $data);
    }

    public function make_query()
    {
        $query = "
        SELECT * from user_activity
        WHERE active=1
        ";

        return $query;
    }

    public function fetch_data($limit, $start)
    {
        $query = $this->make_query();
        $query .= ' order by  id desc';
        $query .= ' LIMIT ' . $start . ', ' . $limit;
        $data = $this->db->query($query);

        return $data->result();
    }

    public function count_all()
    {
        $query = $this->make_query();
        $data = $this->db->query($query);

        return $data->num_rows();
    }
}
