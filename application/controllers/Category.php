<?php
class Category extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->check_permission();
        $this->load->model('Category_model');
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
        // Ambil semua department
        $categories = $this->Category_model->get_with_stats();

        $totalrank = array_sum(array_column($categories, 'rank_count'));

        // Kirim Ke view
        $data['totalRank']  = $totalrank;
        $data['categories'] = $categories;

        $data['page_name'] = 'category';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('categories/index', $data);
        $this->load->view('templates/footer');
    }

    public function save()
    {
        $this->form_validation->set_rules('name', 'Category Name', 'required|is_unique[tblcategories.name]');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        $data = [
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description')
        ];

        if ($this->Category_model->insert($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil ditambahkan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Kategori Gagal ditambahkan']);
        }
    }

    public function update()
    {
        $id = $this->input->post('id');

        $this->form_validation->set_rules('name', 'Category Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        $data = [
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description')
        ];

        if ($this->Category_model->update($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil diubah']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Kategori Gagal diubah']);
        }
    }

    public function delete()
    {
        $id = $this->input->post('id');
    
        // Validasi ID
        if (empty($id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'ID kategori tidak ditemukan.'
            ]);
            return;
        }
    
        // Proses hapus data
        $deleted = $this->Category_model->delete($id);
    
        if ($deleted) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Kategori berhasil dihapus.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal menghapus kategori. Data mungkin tidak ditemukan.'
            ]);
        }
    }
    
}