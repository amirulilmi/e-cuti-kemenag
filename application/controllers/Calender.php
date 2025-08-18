<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calender extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Calender_model');
    }

    public function index()
    {
        $holidays = $this->Calender_model->get_all();
        // $red_dates_list = array_column($holidays, 'holiday_date');
        
            // bentuk array dengan key tanggal dan value deskripsi
        $red_dates = [];
        foreach ($holidays as $h) {
            $red_dates[$h['holiday_date']] = $h['description']; 
        }

        $data['month'] = date('m');
        $data['year'] = date('Y');
        // $data['red_dates_list'] = $red_dates_list;

        $data['red_dates'] = $red_dates;
        $data['holidays'] = $holidays;

        $data['page_name'] = 'calender';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('calender/index', $data);
        $this->load->view('templates/footer');
    }

    public function add_holiday()
    {
        if ($this->input->post()) {
            $data = [
                'holiday_date' => $this->input->post('holiday_date'),
                'description'  => $this->input->post('description'),
            ];
            $this->Calender_model->insert($data);
    
            $id = $this->db->insert_id();
            $data['id'] = $id;
    
            echo json_encode([
                'status' => 'success',
                'message' => 'Tanggal merah berhasil ditambahkan',
                'data' => $data
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak valid']);
        }
    }
    
    public function delete_holiday($id)
    {
        if ($this->Calender_model->delete($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Tanggal merah berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus tanggal merah']);
        }
    }
}
