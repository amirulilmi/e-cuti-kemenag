<?php
class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->check_login();
        $this->load->model(['employee_model', 'Department_model']);
        $this->load->model('Dashboard_model');

    }

    private function check_login()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index()
    {
        // Data leave
        $total_leave    = $this->Dashboard_model->count_leave();
        $pending_leave  = $this->Dashboard_model->count_leave_by_status(0);
        $approved_leave = $this->Dashboard_model->count_leave_by_status(4);
        $rejected_leave = $this->Dashboard_model->count_leave_by_status(5);
        $recalled_leave = $this->Dashboard_model->count_leave_by_status(6);
        $cancelled_leave = $this->Dashboard_model->count_leave_by_status(5);

        // Hitung persentase
        $pending_percentage  = $total_leave > 0 ? floor(($pending_leave / $total_leave) * 100) : 0;
        $approved_percentage = $total_leave > 0 ? floor(($approved_leave / $total_leave) * 100) : 0;
        $recalled_percentage = $total_leave > 0 ? floor(($recalled_leave / $total_leave) * 100) : 0;
        $rejected_percentage = $total_leave > 0 ? floor(($rejected_leave / $total_leave) * 100) : 0;
        $cancelled_percentage = $total_leave > 0 ? floor(($cancelled_leave / $total_leave) * 100) : 0;

        // Data department
        $departments  = $this->Dashboard_model->get_departments_with_counts();
        $total_staff  = $this->Dashboard_model->get_total_staff();

        // Data ringkasan
        $total_employee = $this->Dashboard_model->count_employees();
        $total_depart   = $this->Dashboard_model->count_departments();
        $total_types    = $this->Dashboard_model->count_leave_types();

        // Data tabel
        $newest_employees = $this->Dashboard_model->get_newest_employees();
        $recent_leave = $this->Dashboard_model->get_recent_leave();

        // print_r($newest_employees);exit;
    
        $data = [
            'total_leave'          => $total_leave,
            'pending_leave'        => $pending_leave,
            'approved_leave'       => $approved_leave,
            'recalled_leave'       => $recalled_leave,
            'cancelled_leave'       => $cancelled_leave,
            'rejected_leave'       => $rejected_leave,
            'pending_percentage'   => $pending_percentage,
            'approved_percentage'  => $approved_percentage,
            'recalled_percentage'  => $recalled_percentage,
            'rejected_percentage'  => $rejected_percentage,
            'cancelled_percentage'  => $cancelled_percentage,
            'departments'          => $departments,
            'total_staff'          => $total_staff,
            'total_employee'       => $total_employee,
            'total_depart'         => $total_depart,
            'total_types'          => $total_types,
            'newest_employees'     => $newest_employees,
            'recent_leave'         => $recent_leave
        ];

        $data['page_name'] = 'dashboard';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
}