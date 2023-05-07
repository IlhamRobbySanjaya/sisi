<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_activity extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("user_activity_model");
    }

    public function index()
    {
        $per_page = 5;

        $config["per_page"] = $per_page;
        $config["base_url"] = base_url() . "product";
        $config["total_rows"] = $this->user_activity_model->count_all();

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();
        $data['log_activities'] = $this->user_activity_model->fetch_data($per_page, $page);

        $data['title'] = "Daftar Aktivitas";
        $data['page_name'] = "log_activities/list";

        $this->load->view('template', $data);
    }
}
