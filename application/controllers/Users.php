<?php

class Users extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    function index()
    {
        $data['user'] = $this->user_model->tampil_data()->result();
        $this->load->view('admin/index', $data);
    }


    public function __construct() {
        parent::__construct();
        $this->load->library('activity_log');
      }
    
      public function some_activity() {
        // melakukan aktivitas
        $id_user = 1; // contoh ID user
        $discripsi = 'Melakukan Login'; // contoh detail aktivitas
        $this->activity_log->log_activity($id_user, $discripsi);
      }
    
    }


    function save_user()
    {

        $id       =   $this->input->post('id_user');
        $discripsi   =   $this->input->post('discripsi');
        $status      =   $this->input->post('status');
        $data       =   array('id_user' => $id, 'discripsi' => $discripsi, 'status' => $status);
        $this->user_model->save_user($data);

        //contoh panggil helper log
        helper_log("login", "user login");
        //silahkan di ganti2 aja kalimatnya

        redirect('admin/index');
    }


    public function save()
    {
        if ($this->ion_auth->logged_in()) {
            $this->form_validation->set_rules(
                'product_name',
                'Nama Produk',
                'trim|required',
                array(
                    'required'      => '%s harus diisi.'
                )
            );
            $this->form_validation->set_rules(
                'description',
                'Diskripsi',
                'trim|required',
                array(
                    'required'      => '%s harus diisi.'
                )
            );

            if ($this->form_validation->run() == FALSE) {
                $data['title'] = "Tambah Produk";
                $data['page_name'] = "product/add";
                $this->load->view('template', $data);
            } else {
                $id = $this->product_model->insert();
                if ($id !== 0) {
                    $this->user_activity_model->insert('users', 'tambah data produk dengan id = ' . $id, '', $id, date("Y-m-d H:i:s"), $this->ion_auth->user()->row()->username);
                }
                redirect('product');
            }
        } else {
            redirect('auth/login');
        }
    }

    public function update()
    {
        if ($this->ion_auth->logged_in()) {
            $post = $this->input->post();
            $this->form_validation->set_rules(
                'product_name',
                'Nama Produk',
                'trim|required',
                array(
                    'required'      => '%s harus diisi.'
                )
            );
            $this->form_validation->set_rules(
                'description',
                'Diskripsi',
                'trim|required',
                array(
                    'required'      => '%s harus diisi.'
                )
            );
            $id = $post["id"];
            $users = $this->product_model->findById($id);
            $data['users'] = $users;

            if ($this->form_validation->run() == FALSE) {
                $data['title'] = "Edit Produk";
                $data['page_name'] = "product/edit";
                $this->load->view('template', $data);
            } else {

                if ($this->product_model->update()) {

                    $users_new = $this->product_model->findById($id);

                    if ($users["product_name"] !== $users_new["product_name"]) {
                        $this->user_activity_model->insert('users', 'update data produk dengan id = ' . $id . ' field = product_name', $users["product_name"], $users_new["product_name"], date("Y-m-d H:i:s"), $this->ion_auth->user()->row()->username);
                    }
                    if ($users["description"] !== $users_new["description"]) {
                        $this->user_activity_model->insert('users', 'update data produk dengan id = ' . $id . ' field = description', $users["description"], $users_new["description"], date("Y-m-d H:i:s"), $this->ion_auth->user()->row()->username);
                    }
                    if ($users["url"] !== $users_new["url"]) {
                        $this->user_activity_model->insert('users', 'update data produk dengan id = ' . $id . ' field = url', $users["url"], $users_new["url"], date("Y-m-d H:i:s"), $this->ion_auth->user()->row()->username);
                    }

                    redirect('product');
                } else {
                    $data['title'] = "Edit Produk";
                    $data['page_name'] = "product/edit";
                    $this->load->view('template', $data);
                }
            }
        } else {
            redirect('auth/login');
        }
    }

    public function delete($id)
    {
        if ($this->ion_auth->logged_in()) {
            if ($this->product_model->delete($id)) {
                $this->user_activity_model->insert('users', 'delete  data produk dengan id = ' . $id, $id, '', date("Y-m-d H:i:s"), $this->ion_auth->user()->row()->username);
            }
            redirect('product');
        } else {
            redirect('auth/login');
        }
    }
}
