<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leave extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Leave_model');
        $this->load->model('Calender_model');
        $this->load->helper(['url', 'form']);
        $this->load->library(['session']);
    }

    public function apply()
    {

        // custom calender
        $holidays = $this->Calender_model->get_all();
    
        $data['holiday_dates'] = array_column($holidays, 'holiday_date');


        $id_leave = $id_leave ?? $this->input->get('id', true) ?? null;
        $leaveData = null;
        if ($id_leave) {
            // Ada ID leave, bisa ambil data dari DB
            $leaveData = $this->Leave_model->get_leave_by_id($id_leave);
            // Lakukan sesuatu dengan $leaveData
        }

        $data['userRole'] = $this->session->userdata('role');
        $data['userDesignation'] = $this->session->userdata('designation');
        $data['leaveData'] = $leaveData;
        $data['availableDays'] = $leaveData;

        // Ambil data karyawan untuk dropdown
        $data['employees'] = $this->Leave_model->get_employees();

        $data['page_name'] = 'apply_leave';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar', $data);
        $this->load->view('leaves/apply', $data);
        $this->load->view('templates/footer');

    }

    public function applyLeave()
    {

        $action = $this->input->post('action');

        if ($action === 'update-leave') {
            $this->_handleUpdateLeave();
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'apply-leave') {
            $empId = $_POST['empId'];
            $leaveType = $_POST['leave_type'];
            $startDate = $_POST['start_date'];
            $endDate = $_POST['end_date'];
            $numberDays = $_POST['number_days'];
            $remarks = $_POST['remarks'];

            // === VALIDASI REQUIRED ===
            $errors = [];

            if (!$empId)
                $errors[] = 'Employee ID is required.';
            if (!$leaveType)
                $errors[] = 'Leave type is required.';
            if (!$startDate)
                $errors[] = 'Start date is required.';
            if (!$endDate)
                $errors[] = 'End date is required.';
            if (!$numberDays)
                $errors[] = 'Number of days is required.';
            if (!$remarks)
                $errors[] = 'Remarks is required.';
            // if (empty($_FILES['sick_file']['name']))
            //     $errors[] = 'Sick file is required.';
            if (empty($_FILES['approve_file']['name']))
                $errors[] = 'Approval file is required.';

            if (!empty($errors)) {
                echo json_encode(['status' => 'error', 'message' => implode(' ', $errors)]);
                exit;
            }

            // Handle file upload
            $sickFilePath = null;
            if (!empty($_FILES['sick_file']['name'])) {
                $uploadDir = FCPATH . 'uploads/document/sick_file/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = basename($_FILES['sick_file']['name']);
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['sick_file']['tmp_name'], $targetPath)) {
                    // simpan ke DB mulai dari "uploads/..."
                    $sickFilePath = 'uploads/document/sick_file/' . $fileName;
                }
            }

            // === Handle approval file ===
            $approveFilePath = null;
            if (!empty($_FILES['approve_file']['name'])) {
                $uploadDir = FCPATH . 'uploads/document/approval_file/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = basename($_FILES['approve_file']['name']);
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['approve_file']['tmp_name'], $targetPath)) {
                    // simpan ke DB mulai dari "uploads/..."
                    $approveFilePath = 'uploads/document/approval_file/' . $fileName;
                }
            }

            // print_r($_FILES['approve_file']['name']);exit;

            // Insert via model
            $result = $this->Leave_model->insertLeave($empId, $leaveType, $startDate, $endDate, $numberDays, $remarks, $sickFilePath, $approveFilePath);

            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Leave applied successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to apply leave.']);
            }
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        }
    }

    private function _handleUpdateLeave()
    {
        try {
            $leave_id = $this->input->post('leave_id');

            if (!$leave_id) {
                echo json_encode(['status' => 'error', 'message' => 'ID leave tidak ditemukan']);
                return;
            }

            // Ambil data leave yang akan diupdate
            $existingLeave = $this->Leave_model->get_leave_by_id($leave_id);
            if (!$existingLeave) {
                echo json_encode(['status' => 'error', 'message' => 'Data leave tidak ditemukan']);
                return;
            }

            // Validasi permission
            if (
                $this->session->userdata('role') !== 'Admin' &&
                $existingLeave['emp_id'] != $this->session->userdata('emp_id')
            ) {
                echo json_encode(['status' => 'error', 'message' => 'Anda tidak memiliki akses untuk mengupdate data ini']);
                return;
            }

            // Validasi status - hanya bisa edit jika status masih pending


            // Validasi input
            $validation = $this->_validateLeaveInput();
            if (!$validation['valid']) {
                echo json_encode(['status' => 'error', 'message' => $validation['message']]);
                return;
            }

            // Prepare data untuk update
            $leaveData = $this->_prepareLeaveData();

            // Handle file upload (optional untuk update)
            $fileUploadResult = $this->_handleFileUpload(true); // true = update mode
            if (!$fileUploadResult['success']) {
                echo json_encode(['status' => 'error', 'message' => $fileUploadResult['message']]);
                return;
            }

            // Merge file data jika ada file baru yang diupload
            if (!empty($fileUploadResult['files'])) {
                $leaveData = array_merge($leaveData, $fileUploadResult['files']);
            }

            // Update ke database
            $result = $this->Leave_model->update_leave($leave_id, $leaveData);

            if ($result) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Data cuti berhasil diperbarui'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Gagal memperbarui data ke database'
                ]);
            }

        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    private function _validateLeaveInput()
    {
        $empId = $this->input->post('empId');
        $leaveType = $this->input->post('leave_type');
        $startDate = $this->input->post('start_date');
        $endDate = $this->input->post('end_date');
        $numberDays = $this->input->post('number_days');

        if (empty($empId)) {
            return ['valid' => false, 'message' => 'Employee ID tidak boleh kosong'];
        }

        if (empty($leaveType)) {
            return ['valid' => false, 'message' => 'Tipe cuti harus dipilih'];
        }

        if (empty($startDate)) {
            return ['valid' => false, 'message' => 'Tanggal mulai harus diisi'];
        }

        if (empty($endDate)) {
            return ['valid' => false, 'message' => 'Tanggal selesai harus diisi'];
        }

        if (empty($numberDays) || $numberDays <= 0) {
            return ['valid' => false, 'message' => 'Jumlah hari tidak valid'];
        }

        // Validasi tanggal
        if (strtotime($startDate) > strtotime($endDate)) {
            return ['valid' => false, 'message' => 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai'];
        }

        return ['valid' => true];
    }

    private function _prepareLeaveData()
    {
        return [
            'empid' => $this->input->post('empId'),
            'leave_type_id' => $this->input->post('leave_type'),
            'from_date' => $this->input->post('start_date'),
            'to_date' => $this->input->post('end_date'),
            'requested_days' => $this->input->post('number_days'),
            'remarks' => $this->input->post('remarks') ?: '',
            'leave_status' => 'Pending',
            'created_date' => date('Y-m-d H:i:s'),
        ];
    }

    private function _handleFileUpload($isUpdate = false)
    {
        $uploadPath = './uploads/leave_files/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        $files = [];
        $uploadErrors = [];

        // Handle sick file
        if (!empty($_FILES['sick_file']['name'])) {
            if ($this->upload->do_upload('sick_file')) {
                $uploadData = $this->upload->data();
                $files['sick_file'] = $uploadData['file_name'];
            } else {
                $uploadErrors[] = 'Sick file: ' . $this->upload->display_errors('', '');
            }
        }

        // Handle approve file
        if (!empty($_FILES['approve_file']['name'])) {
            if ($this->upload->do_upload('approve_file')) {
                $uploadData = $this->upload->data();
                $files['file'] = $uploadData['file_name'];
            } else {
                $uploadErrors[] = 'Approve file: ' . $this->upload->display_errors('', '');
            }
        }

        if (!empty($uploadErrors)) {
            return [
                'success' => false,
                'message' => 'Upload error: ' . implode(', ', $uploadErrors)
            ];
        }

        return [
            'success' => true,
            'files' => $files
        ];
    }
    public function loadLeaveTypes()
    {
        $empId = $this->input->post('empId');
        $leave_types = $this->Leave_model->getLeaveTypesByEmployee($empId); // buat fungsi di model

        // print_r($leave_types);exit;
        $options = '<option value="">-- Pilih Tipe Cuti --</option>';
        foreach ($leave_types as $type) {
            $options .= '<option value="' . $type['id'] . '" 
                            data-allowsat="' . $type['allowsat'] . '" 
                            data-allowsun="' . $type['allowsun'] . '"
                            data-available_days="' . $type['available_days'] . '"
                            >'
                . htmlspecialchars($type['leave_type']) .
                '</option>';
        }

        echo $options;
    }

    // 
    // 
    // MY LEAVE
    public function myLeave()
    {
        $userId = $this->session->userdata('emp_id');
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

            if (!isset($leaveSummary[$leaveTypeId])) {
                $leaveSummary[$leaveTypeId] = [
                    'type' => $leave['leave_type'],
                    'total' => $assignDays[$leaveTypeId] ?? 0,
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
            'selectedLeaveStatusName' => $selectedLeaveStatusName
        ];

        // echo '<pre>';
        // print_r($selectedLeaveStatusName);
        // echo '</pre>';


        $data['page_name'] = 'my_leave';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar', $data);
        $this->load->view('leaves/myleave', $data);
        $this->load->view('templates/footer');

    }

    public function fetchStaff($userIdCust = null)
    {
        $searchQuery = $this->input->post('searchQuery');
        $leaveStatusFilter = $this->input->post('leaveStatusFilter');

        // Gunakan userIdCust jika tidak null, jika null tetap pakai session
        $userId = $userIdCust ?? $this->session->userdata('emp_id');
        // echo '<pre>';
        // print_r($userIdCust);
        // echo '</pre>';
        // exit;
        // Mapping status cuti
        $statusMap = [
            '0' => 'Pending Admin Approval',
            '1' => 'Rejected by Admin',
            '2' => 'Forwarded to Kepala',
            '3' => 'Rejected by Kepala',
            '4' => 'Approved',
            '5' => 'Cancelled',
            '6' => 'Recalled',
        ];

        // Ambil data dari model
        $leaves = $this->Leave_model->getFilteredStaff($searchQuery, $leaveStatusFilter, $userId, $statusMap);

        // Jika tidak ada data
        if (empty($leaves)) {
            echo '<div class="col-sm-12 text-center">
                    <img src="' . base_url('files/assets/images/no_data.png') . '" 
                         class="img-radius" alt="No Data Found" 
                         style="width:200px; height:auto;">
                  </div>';
            return;
        }

        // Ambil mapping leave type (supaya bisa dapat nama cuti)
        $leaveTypes = $this->Leave_model->getLeaveTypes();

        // Loop data cuti
        foreach ($leaves as $leave) {
            $imagePath = empty($leave->image_path) ? base_url('files/assets/images/user-card/img-round1.jpg') : $leave->image_path;

            // Konversi status ke text
            switch ($leave->leave_status) {
                case 0:
                    $leaveStatusText = 'Pending Admin Approval';
                    $badgeClass = 'bg-primary';
                    $iconClass = 'fa fa-hourglass-start';
                    break;
                case 1:
                    $leaveStatusText = 'Rejected by Admin';
                    $badgeClass = 'badge-danger';
                    $iconClass = 'fa fa-ban';
                    break;
                case 2:
                    $leaveStatusText = 'Forwarded to Kepala';
                    $badgeClass = 'bg-success';
                    $iconClass = 'fa fa-check-circle';
                    break;
                case 3:
                    $leaveStatusText = 'Rejected by Kepala';
                    $badgeClass = 'badge-danger';
                    $iconClass = 'fa fa-ban';
                    break;
                case 4:
                    $leaveStatusText = 'Approved';
                    $badgeClass = 'bg-success';
                    $iconClass = 'fa fa-check-circle';
                    break;
                case 5:
                    $leaveStatusText = 'Cancelled';
                    $badgeClass = 'badge-warning';
                    $iconClass = 'fa fa-times-circle';
                    break;
                case 6:
                    $leaveStatusText = 'Recalled';
                    $badgeClass = 'badge-warning';
                    $iconClass = 'fa fa-undo-alt';
                    break;
                default:
                    $leaveStatusText = 'Unknown';
                    $badgeClass = 'badge-warning';
                    $iconClass = 'fa fa-question-circle';
                    break;
            }

            $leaveTypeName = isset($leaveTypes[$leave->leave_type_id]) ? $leaveTypes[$leave->leave_type_id] : 'Unknown';

            $fromDate = date('jS F, Y', strtotime($leave->from_date));
            $toDate = date('jS F, Y', strtotime($leave->to_date));
            $postingDate = date('jS F, Y', strtotime($leave->created_date));

            echo '
            <div class="col-md-15">
                <div class="card">
                    <div class="card-header">
                        <div class="media">
                            <a class="media-left media-middle" href="#">
                                <i class="label ' . $badgeClass . ' ' . $iconClass . ' fa-2x"></i>
                            </a>
                            <div class="media-body media-middle">
                                <div class="company-name">
                                    <p>' . $leaveTypeName . '</p>
                                    <span class="text-muted f-14">Created on ' . $postingDate . '</span>
                                </div>
                                <div class="job-badge">
                                    <label class="label ' . $badgeClass . '">' . $leaveStatusText . '</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <p class="text-muted">Pengajuan cuti ini berlaku untuk periode dari:
                            <strong>' . $fromDate . '</strong> sampai: <strong>' . $toDate . '</strong>
                        </p>
                        <div class="job-meta-data">
                            <i class="icofont icofont-safety"></i>
                            Hari cuti diajukan: ' . $leave->requested_days . '
                        </div>
                        <div class="text-right">
                            <div class="dropdown-secondary dropdown">
                                <button class="btn btn-primary btn-mini dropdown-toggle waves-effect waves-light" 
                                        type="button" id="dropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdown1" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                   <a class="dropdown-item waves-light waves-effect review-btn" href="#" 
                                      data-toggle="modal" data-target="#detailed-leave"
                                      data-submission-date="' . $leave->created_date . '"
                                      data-expiry-date="' . $leave->to_date . '"
                                      data-start-date="' . $leave->from_date . '"
                                      data-leave-reason="' . $leave->remarks . '"
                                      data-leave-remaing="' . $leave->remaining_days . '"
                                      data-leave-staff="' . $leave->staff_name . '"
                                      data-leave-type="' . $leaveTypeName . '"
                                      data-leave-status="' . $leaveStatusText . '"
                                      data-leave-id="' . $leave->id . '"
                                      data-requested-days="' . $leave->requested_days . '"
                                      data-letter-number="' . $leave->letter_number . '" 
                                      data-approval-file="' . $leave->file . '"
                                      data-sick-file="' . $leave->sick_file . '"
                                      >
                                        <span class="point-marker bg-danger"></span>Review
                                   </a>';

                                    // kalau status = 0 tampilkan tombol edit
                                    if ($leave->leave_status == 0) {
                                        echo '<a class="dropdown-item waves-light waves-effect" 
                                                                    href="' . base_url('Leave/apply?id=' . $leave->id . '&edit=1') . '">
                                                                    <span class="point-marker bg-danger"></span>Edit Request
                                                                    </a>';
                                    }

                                    echo '  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }

    // 
    // 
    // ALL LEAVE

    public function all_leaves()
    {
        // $leave_status_filter = $this->input->get('leave_status') ? $this->input->get('leave_status') : 'Show all';
        $leave_status_filter = $this->input->get('leave_status');
        $leave_status_filter = ($leave_status_filter !== null) ? $leave_status_filter : 'Show all';

        // Get selected leave status name
        $selected_leave_status_name = 'Show all';
        if ($leave_status_filter !== 'Show all') {
            $status_names = [
                '0' => 'Pending Admin Approval',
                '1' => 'Rejected by Admin',
                '2' => 'Forwarded to Kepala',
                '3' => 'Rejected by Kepala',
                '4' => 'Approved',
                '5' => 'Cancelled',
                '6' => 'Recalled',
            ];
            $selected_leave_status_name = isset($status_names[$leave_status_filter]) ? $status_names[$leave_status_filter] : 'Show all';

        }

        // Prepare filters for model
        $filters = [
            'user_role' => $this->session->userdata('role'),
            'user_id' => $this->session->userdata('emp_id'),
            'user_department' => $this->session->userdata('department'),
            'is_supervisor' => $this->session->userdata('is_supervisor'),
            'leave_status' => $selected_leave_status_name
        ];

        $statusMap = [
            '0' => 'Pending Admin Approval',
            '1' => 'Rejected by Admin',
            '2' => 'Forwarded to Kepala',
            '3' => 'Rejected by Kepala',
            '4' => 'Approved',
            '5' => 'Cancelled',
            '6' => 'Recalled',
        ];
        // Get leave status counts
        $leave_status_counts = $this->Leave_model->get_leave_status_counts($filters);

        $data = [
            'selected_leave_status_name' => $selected_leave_status_name,
            'leave_status_counts' => $leave_status_counts,
            'leaveStatusMap' => $statusMap,
            'session_user_name' => trim($this->session->userdata('first_name') . ' ' . $this->session->userdata('middle_name') . ' ' . $this->session->userdata('last_name'))
        ];

        // echo '<pre>';
        // print_r($leave_status_counts);
        // echo '</pre>';
        // exit;
        $data['page_name'] = 'all_leave';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar', $data);
        $this->load->view('leaves/allleave', $data);
        $this->load->view('templates/footer');
    }

    public function fetch_leaves()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $search_query = $this->input->post('searchQuery');
        $leave_status_filter = $this->input->post('leaveStatusFilter');


        $filters = [
            'user_role' => $this->session->userdata('role'),
            'user_id' => $this->session->userdata('emp_id'),
            'user_department' => $this->session->userdata('department'),
            'is_supervisor' => $this->session->userdata('is_supervisor'),
            'search_query' => $search_query,
            'leave_status' => ($leave_status_filter !== null) ? $leave_status_filter : 'Show all'
        ];

        $leave_data = $this->Leave_model->get_leave_requests($filters);
        $leave_types = $this->Leave_model->get_leave_types();

        // echo '<pre>';
        // print_r($leave_data);
        // echo '</pre>';
        // exit;
        if (empty($leave_data)) {
            echo '<div class="col-sm-12 text-center">
                    <img src="' . base_url('files/assets/images/no_data.png') . '" 
                         class="img-radius" alt="No Data Found" 
                         style="width:200px; height:auto;">
                  </div>';
            return;
        }
        // echo '<pre>';
        // print_r($leave_data);
        // echo '</pre>';
        // exit;

        echo $this->generate_leave_cards($leave_data, $leave_types);
    }

    private function generate_leave_cards($leave_data, $leave_types)
    {
        if (empty($leave_data)) {
            return '<div class="col-sm-12 text-center">
                        <img src="' . base_url('assets/images/no_data.png') . '" class="img-radius" alt="No Data Found" style="width: 200px; height: auto;">
                    </div>';
        }

        $html = '';
        foreach ($leave_data as $leave) {
            $image_path = empty($leave['image_path']) ? base_url('assets/images/user-card/img-round1.jpg') : base_url($leave['image_path']);

            $status_names = [0 => 'Pending Admin Approval', 1 => 'Rejected by Admin', 2 => 'Forwarded to Kepala', 3 => 'Rejected by Kepala', 4 => 'Approved', 5 => 'Cancelled', 6 => 'Recalled'];
            $leave_status_text = $status_names[$leave['leave_status']];

            $badge_classes = [0 => 'bg-primary', 1 => 'bg-danger', 2 => 'bg-success', 3 => 'badge-danger', 4 => 'bg-success', 5 => 'badge-warning', 6 => 'badge-warning'];
            $badge_class = $badge_classes[$leave['leave_status']];

            $leave_type_name = isset($leave_types[$leave['leave_type_id']]) ? $leave_types[$leave['leave_type_id']] : 'Unknown';

            $from_date = date('jS F, Y', strtotime($leave['from_date']));
            $to_date = date('jS F, Y', strtotime($leave['to_date']));
            $posting_date = date('jS F, Y', strtotime($leave['created_date']));

            $full_name = trim($leave['first_name'] . ' ' . $leave['middle_name'] . ' ' . $leave['last_name']);

            $html .= '<div class="col-md-15">
            <div class="card">
                <div class="card-header"  style="padding-bottom:5px;">
                    <div class="media">
                        <a class="media-left media-middle" href="#">
                            <img class="media-object img-60" src="' . $image_path . '" alt="Employee Image"  style="width:80px; height:80px; object-fit:cover; object-position:top; border-radius:50%;">
                        </a>
                        <div class="media-body media-middle">
                            <div class="company-name">
                                <p>' . $leave['first_name'] . ' ' . $leave['middle_name'] . ' ' . $leave['last_name'] . '</p>
                                <span class="text-muted f-14">Created on ' . $posting_date . '</span>
                            </div>
                            <div class="job-badge">
                                <label class="label ' . $badge_class . '">' . $leave_status_text . '</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-block" >
                    <h6 class="job-card-desc">Tipe Cuti: ' . $leave_type_name . '</h6>
                    <p class="text-muted">Pengajuan cuti ini berlaku untuk periode dari: <strong>' . $from_date . '</strong> sampai: <strong>' . $to_date . '</strong></p>
                    <div class="job-meta-data"><i class="icofont icofont-safety"></i>Jumlah Hari Cuti diajukan: ' . $leave['requested_days'] . '</div>
                    <div class="job-meta-data"><i class="icofont icofont-university"></i>SIsa Jatah Cuti: ' . $leave['available_days'] . '</div>
                    <div class="text-right">
                       <div class="dropdown-secondary dropdown">
                            <button onclick="window.location.href=\'' . base_url('Staff/profile/' . $leave['empid']) . '\'" 
                                    class="btn btn-secondary btn-mini waves-effect waves-light">
                                Histori
                            </button>
                            <button class="btn btn-primary btn-mini waves-effect waves-light review-btn" 
                                type="button" 
                                data-toggle="modal" 
                                data-target="#confirm-mail" 
                                data-submission-date="' . $leave['created_date'] . '" 
                                data-expiry-date="' . $leave['to_date'] . '" 
                                data-start-date="' . $leave['from_date'] . '" 
                                data-leave-reason="' . $leave['remarks'] . '" 
                                data-leave-remaining="' . $leave['available_days'] . '" 
                                data-leave-staff="' . $leave['first_name'] . ' ' . $leave['middle_name'] . ' ' . $leave['last_name'] . '" 
                                data-leave-type="' . $leave_type_name . '" 
                                data-leave-status="' . $leave_status_text . '" 
                                data-leave-id="' . $leave['id'] . '" 
                                data-requested-days="' . $leave['requested_days'] . '"
                                data-letter-number="' . $leave['letter_number'] . '" 
                                data-approval-file="' . $leave['file'] . '"
                                data-sick-file="' . $leave['sick_file'] . '"
                                >
                                Review
                            </button>


                            <!-- end of dropdown menu -->
                        </div>
                    </div></div>
                    </div>
            </div>';
        }

        return $html;
    }

    public function update_leave_status()
    {


        if (!$this->input->is_ajax_request()) {
            show_404();
        }



        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $letter_number = $this->input->post('letterNumber');
        // Get leave details before update
        $leave_data = $this->Leave_model->get_leave_by_id($id);


        // Cek apakah ada file yang diupload
        $approveFilePath = null;
        if (!empty($_FILES['approvalFile']['name'])) {
            $uploadDir = FCPATH . 'uploads/document/approval_file/';

            // pastikan folder ada
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // buat nama file unik biar nggak ketimpa
            $ext = pathinfo($_FILES['approvalFile']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid('approval_') . '.' . $ext;
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['approvalFile']['tmp_name'], $targetPath)) {
                // simpan ke DB mulai dari "uploads/..."
                $approveFilePath = 'uploads/document/approval_file/' . $fileName;
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Gagal mengupload file approval.'
                ]);
                return;
            }
        }



        if (!$leave_data) {
            echo json_encode(['status' => 'error', 'message' => 'Data cuti tidak ditemukan']);
            return;
        }

        $emp_id = $leave_data['empid'];
        $leave_type_id = $leave_data['leave_type_id'];
        $requested_days = $leave_data['requested_days'];
        $current_status = $leave_data['leave_status'];
        $from_date = $leave_data['from_date'];
        $to_date = $leave_data['to_date'];

        // Handle available days updates
        // Jalankan hanya jika status baru berbeda dengan current status
        if ($status != $current_status) {
            if ($status == 6 && $current_status == 4) {
                // Recall leave - restore days
                // echo '<pre>';
                // print_r($leave_type_id);
                // echo '</pre>';
                // exit;
                $remaining_days = $this->calculate_business_days($from_date, $to_date, $leave_type_id);



                $this->Leave_model->update_available_days($emp_id, $leave_type_id, $remaining_days, 'add');
            } elseif ($status == 4) {
                // Approve leave - deduct days
                $this->Leave_model->update_available_days($emp_id, $leave_type_id, $requested_days, 'subtract');
            }
        }

        // Update leave status
        if ($this->Leave_model->update_leave_status($id, $status, $letter_number, $approveFilePath)) {
            // Send notifications for approved or recalled leaves
            if ($status == 4 || $status == 6) {
                $this->send_leave_status_notification($emp_id, $leave_type_id, $from_date, $to_date, $status);
            }
            echo json_encode(['status' => 'success', 'message' => 'Leave status updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update leave status.']);
        }
    }

    public function delete_leave()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id = $this->input->post('id');

        if ($this->Leave_model->delete_leave($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Leave request deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete leave request.']);
        }
    }
















    private function handle_file_upload($file)
    {
        $allowed_extensions = ['pdf', 'jpg', 'jpeg', 'png'];
        $upload_path = FCPATH . 'uploads/sick_files/';

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            return false;
        }

        $new_filename = md5(time() . $file['name']) . '.' . $file_extension;
        $destination = $upload_path . $new_filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $new_filename;
        }

        return false;
    }

    private function calculate_business_days($start_date, $end_date, $leave_type_id)
    {
        // Ambil informasi leave type
        $leave_type = $this->db->get_where('tblleavetype', ['id' => $leave_type_id])->row_array();

        $allow_sat = isset($leave_type['allowsat']) ? (bool) $leave_type['allowsat'] : false;
        $allow_sun = isset($leave_type['allowsun']) ? (bool) $leave_type['allowsun'] : false;

        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        $days = $start->diff($end)->days + 1;

        $business_days = 0;
        for ($i = 0; $i < $days; $i++) {
            $current_date = clone $start;
            $current_date->add(new DateInterval('P' . $i . 'D'));
            $day_of_week = (int) $current_date->format('N'); // 1 = Mon, 7 = Sun

            // Hitung sesuai aturan
            if (
                ($day_of_week >= 1 && $day_of_week <= 5) // Senin-Jumat selalu dihitung
                || ($day_of_week == 6 && $allow_sat)     // Sabtu
                || ($day_of_week == 7 && $allow_sun)
            ) {  // Minggu
                $business_days++;
            }
        }

        return $business_days;
    }

    private function send_leave_application_notification($emp_id, $leave_type_id, $start_date, $end_date)
    {
        // Load email library and implement email sending logic
        $this->load->library('email');

        $supervisor_info = $this->Leave_model->get_supervisor_info($emp_id);
        $sender_name = $this->Leave_model->get_employee_name($emp_id);
        $leave_type = $this->Leave_model->get_leave_type_description($leave_type_id);

        if ($supervisor_info && filter_var($supervisor_info['email'], FILTER_VALIDATE_EMAIL)) {
            // Configure and send email
            // Implementation depends on your email configuration
        }
    }

    private function send_leave_status_notification($emp_id, $leave_type_id, $start_date, $end_date, $status)
    {
        // Load email library and implement email sending logic
        $this->load->library('email');

        $employee_emails = $this->Leave_model->get_all_employee_emails();
        $sender_name = $this->Leave_model->get_employee_name($emp_id);
        $leave_type = $this->Leave_model->get_leave_type_description($leave_type_id);

        // Send notifications to all employees
        // Implementation depends on your email configuration
    }

}
