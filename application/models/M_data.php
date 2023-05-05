<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_data extends CI_Model
{
    function hapus_data($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }

    function hapus_sub($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
}
