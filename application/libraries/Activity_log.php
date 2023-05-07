<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Activity_log
{

    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('activity_log_model');
    }

    public function log_activity($id_user, $discripsi)
    {
        $this->CI->activity_log_model->insert_activity($id_user, $discripsi);
    }
}
