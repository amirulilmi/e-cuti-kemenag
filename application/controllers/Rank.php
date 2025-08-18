<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rank extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Rank_model');
        $this->load->model('Category_model');
    }

    public function index()
    {
        $data['page_name'] = 'rank';
        $data['ranks'] = $this->Rank_model->get_all();
        $data['categories'] = $this->Category_model->get_all(); // ambil semua kategori


        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('ranks/index', $data);
        $this->load->view('templates/footer');

    }

    public function save()
    {
        $data = [
            'name'   => $this->input->post('name'),
            'id_category'  => $this->input->post('id_category'),
            'description'  => $this->input->post('description'),
            'creation_date'=> date('Y-m-d H:i:s')
        ];

        if ($this->Rank_model->insert($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Golongan berhasil ditambahkan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Golongan Gagal ditambahkan']);
        }
    }

    public function update()
    {
        $id = $this->input->post('id');
        // print_r($id);exit;
        $data = [
            'name'  => $this->input->post('name'),
            'id_category' => $this->input->post('id_category'),
            'description' => $this->input->post('description'),
        ];

        if ($this->Rank_model->update($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Golongan berhasil diubah']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Golongan Gagal diubah']);
        }
    }

    public function delete()
    {
        $id = $this->input->post('id');

        if ($this->Rank_model->delete($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Leave type deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete leave type.']);
        }
    }
}
