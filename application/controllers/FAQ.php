<?php
class FAQ extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('FAQ_model');
    }

    public function index()
    {

        $data['faq_list'] = $this->FAQ_model->getAll();


        $data['page_name'] = 'FAQ';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar', $data);
        $this->load->view('FAQ/index', $data);
        $this->load->view('templates/footer');
    }

    public function save()
    {
        $name = $this->input->post('name');
        $description = $this->input->post('description');

        $uploadFile = null;

        // konfigurasi upload
        if (!empty($_FILES['document']['name'])) {
            $config['upload_path'] = './uploads/template/'; // folder simpan file
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size'] = 5000; // 5MB
            $config['encrypt_name'] = TRUE; // rename file supaya unik

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('document')) {
                $uploadData = $this->upload->data();
                $uploadFile = 'uploads/template/'. $uploadData['file_name'];
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => $this->upload->display_errors('', '')
                ]);
                return;
            }
        }

        // print_r(   $uploadFile);exit;

        $data = [
            'name' => $name,
            'description' => $description,
            'document' => $uploadFile
        ];

        $insert = $this->FAQ_model->insert($data);

        if ($insert) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
        }
    }

    /**
     * Update data
     */
    public function update()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $description = $this->input->post('description');

        $data = [
            'name' => $name,
            'description' => $description
        ];

        // cek apakah ada file baru diupload
        if (!empty($_FILES['document']['name'])) {
            $config['upload_path'] = './uploads/template/';
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size'] = 5000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('document')) {
                $uploadData = $this->upload->data();
                // $data['document'] = $uploadData['file_name'];
                $data['document'] = 'uploads/template/'. $uploadData['file_name'];

                print_r($data);exit;
                // hapus file lama (opsional)
                $oldData = $this->FAQ_model->getById($id);
                if ($oldData && !empty($oldData->document) && file_exists('./uploads/template/' . $oldData->document)) {
                    unlink('./uploads/template/' . $oldData->document);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => $this->upload->display_errors('', '')
                ]);
                return;
            }
        }

        $update = $this->FAQ_model->update($id, $data);

        if ($update) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data']);
        }
    }

    /**
     * Delete data
     */
    public function delete()
    {
        $id = $this->input->post('id');

        // ambil data lama
        $oldData = $this->FAQ_model->getById($id);
        if ($oldData && !empty($oldData->document) && file_exists('./uploads/template/' . $oldData->document)) {
            unlink('./uploads/template/' . $oldData->document);
        }

        $delete = $this->FAQ_model->delete($id);

        if ($delete) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data']);
        }
    }
}

