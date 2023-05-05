<?php

class User_model extends CI_Model
{
    function tampil_data()
    {
        return $this->db->get('user');
    }
}


function insert()
{
    $post = $this->input->post();
    $image = $this->uploadImage();
    $data = array(
        'product_name' => $post["product_name"],
        'description' => $post["description"],
        'url' => $image,
        'create_date' => date("Y-m-d H:i:s"),
        'create_by' => $this->ion_auth->user()->row()->username,
        'active' => '1',
    );
    if ($this->db->insert('products', $data)) {
        return $this->db->insert_id();
    } else {
        return 0;
    }
}

function update()
{
    $post = $this->input->post();
    if (!empty($_FILES["image_file"]["name"])) {
        $image = $this->uploadImage();
    } else {
        $image = $post["url_old"];
    }
    $id = $post["id"];

    $data = array(
        'product_name' => $post["product_name"],
        'description' => $post["description"],
        'url' => $image,
        'update_date' => date("Y-m-d H:i:s"),
        'update_by' => $this->ion_auth->user()->row()->username,
        'active' => '1',
    );
    $this->db->where('id', $id);
    return $this->db->update('products', $data);
}

function delete($id)
{
    $data = array(
        'update_date' => date("Y-m-d H:i:s"),
        'update_by' => $this->ion_auth->user()->row()->username,
        'active' => '0',
    );
    $this->db->where('id', $id);
    return $this->db->update('products', $data);
}
