<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leave_type extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Cek session login
        // if (!$this->session->userdata('slogin') || !$this->session->userdata('srole')) {
        //     redirect('login');
        // }
        // $role = $this->session->userdata('srole');
        // if ($role !== 'Manager' && $role !== 'Admin') {
        //     redirect('dashboard');
        // }

        $this->load->model('Leave_type_model');
    }

    public function index()
    {
        $data['leave_types'] = $this->Leave_type_model->get_all();

        $data['page_name'] = 'leave_type';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar', $data);
        $this->load->view('leave_types/index', $data);
        $this->load->view('templates/footer');
    }

    public function save()
    {

        $data = [
            'leave_type' => $this->input->post('dname'),
            'description' => $this->input->post('description'),
            'assign_days' => $this->input->post('assigned'),
            'status' => $this->input->post('status'),
            'allowsat' => $this->input->post('allowsat'),
            'allowsun' => $this->input->post('allowsun'),
            'creation_date' => date('Y-m-d H:i:s')
        ];
        // print_r($data);exit;

        if ($this->Leave_type_model->insert($data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Insert failed']);
        }
    }

    public function update()
    {
        $id = $this->input->post('id');
        $data = [
            'leave_type' => $this->input->post('dname'),
            'description' => $this->input->post('description'),
            'assign_days' => $this->input->post('assigned'),
            'status' => $this->input->post('status'),
            'allowsat' => $this->input->post('allowsat'),
            'allowsun' => $this->input->post('allowsun'),
        ];

        // print_r($data);exit;

        if ($this->Leave_type_model->update($id, $data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
        }
    }

    public function delete()
    {
        $id = $this->input->post('id');
        if ($this->Leave_type_model->delete($id)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Delete failed']);
        }
    }
}
