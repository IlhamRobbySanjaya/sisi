<?php

class Users extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper('url');
    }

    function index()
    {
        $data['user'] = $this->user_model->tampil_data()->result();
        $this->load->view('admin/index', $data);
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
                    $this->logActivities_model->insert('products', 'tambah data produk dengan id = ' . $id, '', $id, date("Y-m-d H:i:s"), $this->ion_auth->user()->row()->username);
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
            $products = $this->product_model->findById($id);
            $data['products'] = $products;

            if ($this->form_validation->run() == FALSE) {
                $data['title'] = "Edit Produk";
                $data['page_name'] = "product/edit";
                $this->load->view('template', $data);
            } else {

                if ($this->product_model->update()) {

                    $products_new = $this->product_model->findById($id);

                    if ($products["product_name"] !== $products_new["product_name"]) {
                        $this->logActivities_model->insert('products', 'update data produk dengan id = ' . $id . ' field = product_name', $products["product_name"], $products_new["product_name"], date("Y-m-d H:i:s"), $this->ion_auth->user()->row()->username);
                    }
                    if ($products["description"] !== $products_new["description"]) {
                        $this->logActivities_model->insert('products', 'update data produk dengan id = ' . $id . ' field = description', $products["description"], $products_new["description"], date("Y-m-d H:i:s"), $this->ion_auth->user()->row()->username);
                    }
                    if ($products["url"] !== $products_new["url"]) {
                        $this->logActivities_model->insert('products', 'update data produk dengan id = ' . $id . ' field = url', $products["url"], $products_new["url"], date("Y-m-d H:i:s"), $this->ion_auth->user()->row()->username);
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
                $this->logActivities_model->insert('products', 'delete  data produk dengan id = ' . $id, $id, '', date("Y-m-d H:i:s"), $this->ion_auth->user()->row()->username);
            }
            redirect('product');
        } else {
            redirect('auth/login');
        }
    }
}
