<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Staff extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->model('Rank_model');
        $this->load->model('Leave_model');

        // Cek login dan role
        // if (!$this->session->userdata('slogin') || !$this->session->userdata('srole')) {
        //     redirect('auth/login'); // ganti sesuai route login kamu
        // }

        // $role = $this->session->userdata('srole');
        // if ($role !== 'Manager' && $role !== 'Admin') {
        //     redirect('dashboard'); // ganti sesuai halaman utama
        // }
    }

    public function index($departmentName = null)
    {

        // Ambil dari URL segment atau query string
        if ($departmentName) {
            $departmentName = urldecode($departmentName);
        } elseif ($this->input->get('department')) {
            $departmentName = urldecode($this->input->get('department'));
        }


        $data['departmentFilter'] = $departmentName ?: 'Show all';
        $data['departments'] = $this->Staff_model->get_departments();

        $data['page_name'] = 'staff_list';


        $data['page_name'] = 'staff_list';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('staff/index', $data);
        $this->load->view('templates/footer');
    }


    public function fetch_staff()
    {
        $searchQuery = $this->input->post('searchQuery');
        $departmentFilter = $this->input->post('departmentFilter');

        $department_id = null;
        if (!empty($departmentFilter) && $departmentFilter !== 'Show all') {
            $dept = $this->db->get_where('tbldepartments', ['department_name' => $departmentFilter])->row_array();
            if ($dept) {
                $department_id = $dept['id'];
            }
        }

        $staffList = $this->Staff_model->get_staff($department_id, $searchQuery);

        $output = '';
        foreach ($staffList as $staff) {
            $imgPath = (!empty($staff['image_path']) && file_exists(FCPATH . ltrim($staff['image_path'], '/')))
                ? base_url($staff['image_path'])
                : base_url('uploads/images/default-avatar.jpg');

            $fullName = $staff['first_name'] . ' ' . $staff['last_name'];

            $output .= '
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card user-card" style="position: relative; overflow: hidden;">
                    <div class="card-block">
                        <div class="user-image" style="position: relative;">
                            <img src="' . $imgPath . '" class="img-radius staff-photo" alt="' . htmlspecialchars($fullName) . '" style="width:250px; height:250px; border-radius:5%; display:block; margin:0 auto;">
                            <span style="
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                background: rgba(0, 0, 0, 0.5);
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                gap: 6px;
                                opacity: 0;
                                transition: opacity 0.3s ease;
                                
                            " class="hover-buttons">
                                <a href="' . site_url('staff/profile/' . $staff['emp_id'] . '?view=2') . '" 
                                   class="btn btn-sm btn-primary" data-popup="lightbox">
                                   <i class="icofont icofont-eye-alt"></i>
                                </a>
                                <a href="' . site_url('staff/form/' . $staff['emp_id']) . '" 
                                   class="btn btn-sm btn-warning" data-popup="lightbox">
                                   <i class="icofont icofont-edit"></i>
                                </a>';
            if ($staff['designation'] !== 'Admin') {
                $output .= '
                                <a href="#" class="btn btn-sm btn-danger delete-staff" data-id="' . $staff['emp_id'] . '">
                                    <i class="icofont icofont-ui-delete"></i>
                                </a>';
            }
            $output .= '
                            </span>
                        </div>
                        <h6 style="margin-top: 10px;">' . htmlspecialchars($fullName) . '</h6>
                        <p class="text-muted">' . htmlspecialchars($staff['designation']) . '</p>
                        <p>' . htmlspecialchars($staff['email_id']) . '</p>
                    </div>
                </div>
            </div>
            <script>
                document.querySelectorAll(".user-image").forEach(function(el) {
                    el.addEventListener("mouseenter", function() {
                        el.querySelector(".hover-buttons").style.opacity = "1";
                    });
                    el.addEventListener("mouseleave", function() {
                        el.querySelector(".hover-buttons").style.opacity = "0";
                    });

                    // SweetAlert2 Delete Confirm
                    const deleteButtons = document.querySelectorAll(".delete-staff");
                    deleteButtons.forEach(btn => {
                        btn.addEventListener("click", function(e) {
                            e.preventDefault();
                            let staffId = this.getAttribute("data-id");
                            Swal.fire({
                                title: "Yakin ingin menghapus?",
                                text: "Data staff ini akan dihapus permanen!",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#d33",
                                cancelButtonColor: "#3085d6",
                                confirmButtonText: "Ya, hapus!",
                                cancelButtonText: "Batal"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . site_url('staff/delete/') . '" + staffId;
                                }
                            });
                        });
                    });
                });
            </script>
            ';



        }
        echo $output ?: '<div class="col-12"><p>No staff found.</p></div>';
    }

    public function form($id = null)
    {
        $data['staff'] = null;
        if ($id) {
            $data['staff'] = $this->Staff_model->get_staff_by_id($id);
        }
        $data['departments'] = $this->Staff_model->get_all_departments();
        $data['session_role'] = $this->session->userdata('role');
        $data['ranks'] = $this->Rank_model->get_all();
        // print_r($data);exit;

        $data['page_name'] = 'staff_list';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('staff/create', $data);
        $this->load->view('templates/footer');
    }

    public function save()
    {
        $id = $this->input->post('edit_id');

        // Load library form_validation
        $this->load->library('form_validation');

        // Validasi umum
        $this->form_validation->set_rules('firstname', 'First Name', 'required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required');
        $this->form_validation->set_rules('staff_id', 'Staff ID', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if (empty($id)) {
            // Insert -> staff_id & email harus unik
            $this->form_validation->set_rules(
                'staff_id',
                'Staff ID',
                'required|is_unique[tblemployees.staff_id]',
                [
                    'required' => 'NIP wajib diisi.',
                    'is_unique' => 'NIP sudah digunakan. Silakan pilih yang lain.'
                ]
            );

            $this->form_validation->set_rules(
                'email',
                'Email',
                'required|valid_email|is_unique[tblemployees.email_id]',
                [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique' => 'Email sudah digunakan. Silakan gunakan email lain.'
                ]
            );
        } else {
            // Update -> callback untuk unik selain record saat ini
            $this->form_validation->set_rules('staff_id', 'Staff ID', 'required|callback_check_staff_id[' . $id . ']');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_check_email[' . $id . ']');
        }

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => 'error',
                'message' => validation_errors()
            ]);
            return;
        }

        $data = [
            'first_name' => $this->input->post('firstname'),
            'middle_name' => $this->input->post('middlename'),
            'last_name' => $this->input->post('lastname'),
            'phone_number' => $this->input->post('contact'),
            'designation' => $this->input->post('designation'),
            'gender' => $this->input->post('gender'),
            'department' => $this->input->post('department'),
            'staff_id' => $this->input->post('staff_id'),
            'email_id' => $this->input->post('email'),
            // 'is_supervisor' => $this->input->post('is_supervisor'),
            'role' => $this->input->post('role'),
            'id_ranks' => $this->input->post('id_ranks'),
        ];

        // Upload file jika ada
        if (!empty($_FILES['image_path']['name'])) {
            $config['upload_path'] = './uploads/images/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 5120;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image_path')) {
                $data['image_path'] = 'uploads/images/' . $this->upload->data('file_name');
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => $this->upload->display_errors()
                ]);
                return;
            }
        }

        // Password
        if ($this->input->post('password')) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        }

        if ($id) {
            $this->Staff_model->update_staff($id, $data);
            $response = ['status' => 'success', 'message' => 'Data Pegawai Berhasil di Ubah'];
        } else {
            $this->Staff_model->insert_staff($data);
            $response = ['status' => 'success', 'message' => 'Data Pegawai Berhasil di Tambahkan'];
        }

        echo json_encode($response);
    }

    public function add_n_employee()
    {
        $leave_type_id = $this->input->post('leave_type_id');
        $employee_id = $this->input->post('employee_id');
        $n1 = (int) $this->input->post('n1');
        $n2 = (int) $this->input->post('n2');

        if (!$leave_type_id || !$employee_id) {
            echo json_encode(["status" => "error", "message" => "Data tidak lengkap."]);
            return;
        }

        $record = $this->db->get_where('employee_leave_types', [
            'emp_id' => $employee_id,
            'leave_type_id' => $leave_type_id
        ])->row();

        if ($record) {
            // Validasi jika n1 atau n2 sudah ada
            // Validasi n1 sendiri
            if (!empty($n1) && $record->n1 !== null) {
                echo json_encode([
                    "status" => "warning",
                    "message" => "Kolom N1 sudah ada. Hapus dulu sebelum menambahkan yang baru."
                ]);
                return;
            }

            // Validasi n2 sendiri
            if (!empty($n2) && $record->n2 !== null) {
                echo json_encode([
                    "status" => "warning",
                    "message" => "Kolom N2 sudah ada. Hapus dulu sebelum menambahkan yang baru."
                ]);
                return;
            }

            // Update kolom yang diisi saja
            if (!empty($n1)) {
                $this->db->set('n1', (int)$n1);
                $this->db->set('available_days', 'available_days + ' . (int)$n1, FALSE);
            }
            if (!empty($n2)) {
                $this->db->set('n2', (int)$n2);
                $this->db->set('available_days', 'available_days + ' . (int)$n2, FALSE);
            }
            // Update kolom yang diisi saja
            $this->db->where('emp_id', $employee_id);
            $this->db->where('leave_type_id', $leave_type_id);
            $this->db->update('employee_leave_types');

            echo json_encode(["status" => "success", "message" => "Data berhasil diupdate!"]);
        } else {
            // Insert baru
            $data = [
                'emp_id'        => $employee_id,
                'leave_type_id' => $leave_type_id,
                'n1'            => !empty($n1) ? (int)$n1 : null,
                'n2'            => !empty($n2) ? (int)$n2 : null,
                'available_days'=> ((int)$n1 + (int)$n2)
            ];
            $this->db->insert('employee_leave_types', $data);

            echo json_encode(["status" => "success", "message" => "Data berhasil ditambahkan!"]);
        }
    }

    public function delete_n()
    {
        $leave_type_id = $this->input->post('leave_type_id');
        $emp_id = $this->input->post('emp_id');
        $column = $this->input->post('column'); // n1 atau n2

        if (!$leave_type_id || !$emp_id || !in_array($column, ['n1', 'n2'])) {
            echo json_encode(["status" => "error", "message" => "Data tidak valid."]);
            return;
        }

        // Ambil data existing
        $record = $this->db->get_where('employee_leave_types', [
            'emp_id' => $emp_id,
            'leave_type_id' => $leave_type_id
        ])->row();

        if (!$record) {
            echo json_encode(["status" => "error", "message" => "Data tidak ditemukan."]);
            return;
        }

        $valueToSubtract = (int) $record->$column;

        // Set kolom n1/n2 menjadi NULL dan update available_days
        $this->db->set($column, null);
        $this->db->set('available_days', 'available_days - ' . $valueToSubtract, FALSE);
        $this->db->where('emp_id', $emp_id);
        $this->db->where('leave_type_id', $leave_type_id);
        $this->db->update('employee_leave_types');

        echo json_encode(["status" => "success", "message" => $column . " berhasil dihapus!"]);
    }


    // Callback unik staff_id saat update
    public function check_staff_id($staff_id, $id)
    {
        // print_r($id);exit;
        $this->db->where('staff_id', $staff_id);
        $this->db->where('emp_id !=', $id);
        $exists = $this->db->get('tblemployees')->row();

        if ($exists) {
            $this->form_validation->set_message('check_staff_id', 'Staff ID sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }

    // Callback unik email saat update
    public function check_email($email, $id)
    {
        $this->db->where('email_id', $email);
        $this->db->where('emp_id !=', $id);
        $exists = $this->db->get('tblemployees')->row();

        if ($exists) {
            $this->form_validation->set_message('check_email', 'Email sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }


    public function generate_id()
    {
        $new_id = 'STF-' . rand(1000, 9999);
        echo $new_id;
    }
    public function delete($id = null)
    {
        if (!$id) {
            show_error('ID Staff tidak ditemukan', 404);
        }

        // Optional: Cek apakah staff ada
        $staff = $this->Staff_model->get_staff_by_id($id);
        if (!$staff) {
            show_error('Staff tidak ditemukan', 404);
        }

        // Proses hapus
        $this->Staff_model->delete_staff($id);

        // Kalau mau redirect biasa
        $this->session->set_flashdata('success', 'Staff berhasil dihapus.');
        redirect('staff');
    }

    // 
    // 
    // 

    public function profile($emp_id = null)
    {
        if (!$emp_id) {
            show_404();
        }

        // Get employee data
        $employee = $this->Staff_model->get_employee_by_id($emp_id);
        if (!$employee) {
            show_404();
        }

        // Get supervisor information
        $supervisor = $this->Staff_model->get_supervisor($emp_id);

        // Get assigned leave types
        $assigned_leave_types = $this->Staff_model->get_assigned_leave_types($emp_id);

        // Get all leave types for modal
        $all_leave_types = $this->Staff_model->get_all_leave_types();

        // Get assigned leave types with IDs for checkbox states
        $assigned_leave_types_ids = $this->Staff_model->get_assigned_leave_types_with_ids($emp_id);

        // Get department name
        $department_name = $this->Staff_model->get_department_name($employee['department']);

        // Get potential supervisors
        $potential_supervisors = $this->Staff_model->get_potential_supervisors($emp_id);

        // Prepare data for view
        // $data = array(
        //     'employee' => $employee,
        //     'supervisor' => $supervisor,
        //     'assigned_leave_types' => $assigned_leave_types,
        //     'all_leave_types' => $all_leave_types,
        //     'assigned_leave_types_ids' => $assigned_leave_types_ids,
        //     'department_name' => $department_name,
        //     'potential_supervisors' => $potential_supervisors,
        //     'session_id' => $this->session->userdata('session_id'),
        //     'user_role' => $this->session->userdata('role'),
        //     'page_name' => 'staff_list'
        // );


        // 
        // 
        // MYLEAVE
        $userId = $emp_id;
        $leaveStatusFilter = $this->input->get('leave_status') ?? 'Show all';

        // ambil data dari model
        $leaveData = $this->Leave_model->get_user_leaves($userId);
        $availableDays = $this->Leave_model->get_available_days($userId);
        $assignDays = $this->Leave_model->get_assign_days();


        // print_r($assignDays);exit;
        // kalkulasi summary
        $leaveSummary = [];
        foreach ($leaveData as $leave) {
            $leaveTypeId = $leave['leave_type_id'];
            $requestedDays = $leave['requested_days'];

            // ambil assign_days
            $assign = $assignDays[$leaveTypeId] ?? 0;
           
            // ambil n1 + n2 
            $n1 = $n1Days[$leaveTypeId] ?? 0;
            $n2 = $n2Days[$leaveTypeId] ?? 0;

            // print_r($additional);exit;
            if (!isset($leaveSummary[$leaveTypeId])) {
                $leaveSummary[$leaveTypeId] = [
                    'type' => $leave['leave_type'],
                    'total_awal' => $assignDays[$leaveTypeId] ?? 0,
                    'n1' => $n1,
                    'n2' => $n2,
                    'total' => $assign + $n1 + $n2,     // assign_days + n1 + n2
                    'remaining' => $availableDays[$leaveTypeId] ?? 0,
                    'used' => 0
                ];
            }
            $leaveSummary[$leaveTypeId]['used'] =
                $leaveSummary[$leaveTypeId]['total'] - $leaveSummary[$leaveTypeId]['remaining'];
        }

        // echo '<pre>';
        // print_r($assignDays);
        // echo '</pre>';
        // exit;

        $leaveTypeCount = !empty($leaveSummary) ? '(' . count($leaveSummary) . ')' : '';

        // tentukan nama status
        $statusMap = [
            '0' => 'Pending Admin Approval',
            '1' => 'Rejected by Admin',
            '2' => 'Forwarded to Kepala',
            '3' => 'Rejected by Kepala',
            '4' => 'Approved',
            '5' => 'Cancelled',
            '6' => 'Recalled',
        ];
        $selectedLeaveStatusName = $statusMap[$leaveStatusFilter] ?? 'Show all';

        $data = [
            'leaveSummary' => $leaveSummary,
            'leaveTypeCount' => $leaveTypeCount,
            'selectedLeaveStatusName' => $selectedLeaveStatusName,
            'employee' => $employee,
            'supervisor' => $supervisor,
            'assigned_leave_types' => $assigned_leave_types,
            'all_leave_types' => $all_leave_types,
            'assigned_leave_types_ids' => $assigned_leave_types_ids,
            'department_name' => $department_name,
            'potential_supervisors' => $potential_supervisors,
            'session_id' => $this->session->userdata('session_id'),
            'user_role' => $this->session->userdata('role'),
            'userIdCust' => $userId,
            'page_name' => 'staff_list'
        ];



        // print_r($assigned_leave_types);exit;

        $data['page_name'] = 'staff';
        // Load header and sidebar
        $this->load->view('templates/header');
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('staff/show', $data);
        $this->load->view('leaves/myleave', $data);
        $this->load->view('templates/footer');
    }

    public function staff_functions()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $action = $this->input->post('action');

        switch ($action) {
            case 'assign-leave-types':
                $this->assign_leave_types();
                break;
            case 'assign-supervisor':
                $this->assign_supervisor();
                break;
            default:
                echo json_encode(array('status' => 'error', 'message' => 'Invalid action'));
        }
    }

    private function assign_leave_types()
    {
        $emp_id = $this->input->post('employeeId');
        $leave_types = $this->input->post('leaveTypes');

        // print_r($emp_id);exit;
        if (!$emp_id || !is_array($leave_types)) {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid data'));
            return;
        }

        if ($this->Staff_model->update_employee_leave_types($emp_id, $leave_types)) {
            echo json_encode(array('status' => 'success', 'message' => 'Tipe cuti berhasil di ubah'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal mengubah tipe cuti'));
        }
    }
    private function assign_supervisor()
    {
        $emp_id = $this->input->post('employeeId');
        $supervisor_id = $this->input->post('supervisorId');

        if (!$emp_id || !$supervisor_id) {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid data'));
            return;
        }

        if ($this->Staff_model->assign_supervisor($emp_id, $supervisor_id)) {
            echo json_encode(array('status' => 'success', 'message' => 'Supervisor assigned successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to assign supervisor'));
        }
    }
    public function change_password()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');
        $emp_id = $this->input->post('employee_id');

        // print_r($emp_id);exit;
        // Validation
        if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
            echo json_encode(array('status' => 'error', 'message' => 'Silahkan isi semua kolom.'));
            return;
        }

        if ($new_password !== $confirm_password) {
            echo json_encode(array('status' => 'error', 'message' => 'Kata sandi baru dan konfirmasi kata sandi tidak cocok.'));
            return;
        }

        // Verify old password
        if (!$this->Staff_model->verify_old_password($emp_id, $old_password)) {
            echo json_encode(array('status' => 'error', 'message' => 'Kata sandi lama salah.'));
            return;
        }

        // Change password
        if ($this->Staff_model->change_password($emp_id, $new_password)) {
            echo json_encode(array('status' => 'success', 'message' => 'Password berhasil diubah'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal mengubah kata sandi.'));
        }
    }
}
