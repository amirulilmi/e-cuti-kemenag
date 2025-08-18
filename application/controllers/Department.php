<?php
class Department extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->check_permission();
        $this->load->model('Department_model');
    }

    private function check_permission()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        $role = $this->session->userdata('role');
        if (!in_array($role, ['Admin', 'Manager'])) {
            show_error('Access Denied', 403);
        }
    }

    public function index()
    {
        $data['page_name'] = 'Departments';
        // $data['departments'] = $this->department_model->get_with_stats();
        // Ambil semua department
        $departments = $this->Department_model->get_with_stats();

        $totalStaff = array_sum(array_column($departments, 'employee_count'));
        // Hitung total staff untuk progress bar
        // $totalStaff = $this->Department_model->get_total_staff_count();

        // Kirim data ke view
        $data['totalStaff']  = $totalStaff;
        $data['departments'] = $departments;
        // $data['totalStaff'] = $totalStaff;

        $data['page_name'] = 'department';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('departments/index', $data);
        $this->load->view('templates/footer');
    }

    public function save()
    {
        $this->form_validation->set_rules('department_name', 'Department Name', 'required|is_unique[tbldepartments.department_name]');
        $this->form_validation->set_rules('department_desc', 'Description', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        $data = [
            'department_name' => $this->input->post('department_name'),
            'department_desc' => $this->input->post('department_desc')
        ];

        if ($this->Department_model->insert($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Department added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add department']);
        }
    }

    public function update()
    {
        $id = $this->input->post('id');

        $this->form_validation->set_rules('department_name', 'Department Name', 'required');
        $this->form_validation->set_rules('department_desc', 'Description', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        $data = [
            'department_name' => $this->input->post('department_name'),
            'department_desc' => $this->input->post('department_desc')
        ];

        if ($this->Department_model->update($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Department updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update department']);
        }
    }

    public function delete()
    {
        $id = $this->input->post('id');
        $result = $this->Department_model->delete($id);
        echo json_encode($result);
    }
}