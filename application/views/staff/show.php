<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <?php
                                $get_id = isset($_GET['id']) ? $_GET['id'] : $employee['emp_id'];
                                $profileText = ($session_id == $get_id) ? "My Profile" : "Staff Profile";
                            ?>
                            <h4><?= htmlspecialchars($profileText) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page-header end -->

        <!-- Page-body start -->
        <div class="page-body">
            <!--profile cover start-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="cover-profile">
                        <div class="profile-bg-img">
                            <img class="profile-bg-img img-fluid" src="<?= base_url('/files/assets/images/user-profile/bg-img1.jpg') ?>" alt="bg-img">
                            <div class="card-block user-info">
                                <div class="col-md-12">
                                    <div class="media-left">
                                        <a class="profile-image">
                                            <img class="user-img img-radius" style="width: 108px; height: 108px;" 
                                                 src="<?php echo isset($employee['image_path']) ? base_url($employee['image_path']) : base_url('/files/assets/images/user-card/img-round1.jpg'); ?>" 
                                                 alt="user-img">
                                        </a>
                                    </div>
                                    <div class="media-body row">
                                        <div class="col-lg-12">
                                            <div class="user-title">
                                                <h2><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['middle_name'] . ' ' . $employee['last_name']); ?></h2>
                                                <span class="text-white"><?php echo htmlspecialchars($employee['designation']); ?></span>
                                            </div>
                                        </div>
                                        <?php if ($this->session->userdata('role') == 'Admin'): ?>
                                            <div class="pull-right cover-btn">
                                                <button type="button" class="btn btn-primary m-r-10 m-b-5" data-toggle="modal" data-target="#change-password-dialog">Ubah Password</button>
                                            </div>
                                        <?php endif; ?>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--profile cover end-->
            
            <div class="row">
                <div class="col-lg-12">
                    <!-- tab header start -->
                    <div class="tab-header card">
                        <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Personal Info</a>
                                <div class="slide"></div>
                            </li>
                        </ul>
                    </div>
                    <!-- tab header end -->
                    
                    <!-- tab content start -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal" role="tabpanel">
                            <div class="row">
                                <div class="col-xl-4">
                                    <!-- user contact card left side start -->
                                    <div class="card">
                                        <div class="card-block groups-contact" style="margin-bottom:-43px">
                                            <div class="card-header">
                                                <h5 class="card-header-text">Assigned Supervisor</h5>
                                                <?php if ($user_role === 'Admin'): ?>
                                                    <button data-toggle="modal" data-target="#edit-supervisor" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right">
                                                        <i class="icofont icofont-settings"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                            <ul class="list-group">
                                                <?php if ($supervisor): ?>
                                                    <li class="list-group-item justify-content-between">
                                                        <?php echo htmlspecialchars($supervisor['first_name'] . ' ' . $supervisor['middle_name'] . ' ' . $supervisor['last_name']); ?>
                                                    </li>
                                                <?php else: ?>
                                                    <li class="list-group-item justify-content-between">
                                                        No supervisor assigned.
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                        
                                        <div class="card-block groups-contact">
                                            <div class="card-header">
                                                <h5 class="card-header-text">Kredit Cuti</h5>
                                                <?php if ($user_role === 'Admin'): ?>
                                                    <button data-toggle="modal" data-target="#edit-leave-type" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right">
                                                        <i class="icofont icofont-settings"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-block table-border-style">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Jenis Cuti</th>
                                                                <th>Durasi Cuti</th>
                                                                <th>Sisa Cuti</th>
                                                                <th>N1</th>
                                                                <th>N2</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($assigned_leave_types)): ?>
                                                                <?php foreach ($assigned_leave_types as $leaveType): ?>
                                                                    <tr>
                                                                        <td><?php echo htmlspecialchars($leaveType['leave_type']); ?></td>
                                                                        <td><?php echo htmlspecialchars($leaveType['assign_days']); ?></td>
                                                                        <td><?php echo htmlspecialchars($leaveType['available_days']); ?></td>
                                                                                    <!-- Kolom N1 -->
                                                                        <td>
                                                                            <?php echo htmlspecialchars($leaveType['n1'] !== null ? $leaveType['n1'] : 0); ?>
                                                                            
                                                                            <!-- Tombol tambah N1 -->
                                                                            <button type="button" class="btn btn-success btn-sm p-1 ml-1 addNBtn" 
                                                                                    style="font-size:0.75rem; background-color:#0AC282; border:none;"
                                                                                    data-id="<?php echo $leaveType['leave_type_id']; ?>" 
                                                                                    data-name="<?php echo $leaveType['leave_type']; ?>" 
                                                                                    data-n="n1" 
                                                                                    title="Tambah N1">
                                                                                <i class="icofont icofont-plus"></i>
                                                                            </button>

                                                                            <!-- Tombol hapus N1 -->
                                                                            <button type="button" class="btn btn-danger btn-sm p-1 ml-1 deleteNBtn" 
                                                                                    style="font-size:0.75rem; border:none;"
                                                                                    data-id="<?php echo $leaveType['leave_type_id']; ?>" 
                                                                                    data-name="<?php echo $leaveType['leave_type']; ?>" 
                                                                                    data-n="n1" 
                                                                                    title="Hapus N1">
                                                                                <i class="icofont icofont-trash"></i>
                                                                            </button>
                                                                        </td>

                                                                        <td>
                                                                            <?php echo htmlspecialchars($leaveType['n2'] !== null ? $leaveType['n2'] : 0); ?>
                                                                                
                                                                                <!-- Tombol tambah N2 -->
                                                                                <button type="button" class="btn btn-success btn-sm p-1 ml-1 addNBtn" 
                                                                                        style="font-size:0.75rem; background-color:#0AC282; border:none;"
                                                                                        data-id="<?php echo $leaveType['leave_type_id']; ?>" 
                                                                                        data-name="<?php echo $leaveType['leave_type']; ?>" 
                                                                                        data-n="n2" 
                                                                                        title="Tambah N2">
                                                                                    <i class="icofont icofont-plus"></i>
                                                                                </button>

                                                                                <!-- Tombol hapus N2 -->
                                                                                <button type="button" class="btn btn-danger btn-sm p-1 ml-1 deleteNBtn" 
                                                                                        style="font-size:0.75rem; border:none;"
                                                                                        data-id="<?php echo $leaveType['leave_type_id']; ?>" 
                                                                                        data-name="<?php echo $leaveType['leave_type']; ?>" 
                                                                                        data-n="n2" 
                                                                                        title="Hapus N2">
                                                                                    <i class="icofont icofont-trash"></i>
                                                                                </button>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr>
                                                                    <td colspan="3" class="text-center">Tidak ada Jenis Cuti yang diperbolehkan.</td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- user contact card left side end -->
                                </div>
                                
                                <div class="col-xl-8">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!-- contact data table card start -->
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-header-text">Tentang Pegawai</h5>
                                                </div>
                                                <div class="card-block">
                                                    <div class="view-info">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="general-info">
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-xl-6">
                                                                            <div class="table-responsive">
                                                                                <table class="table m-0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <th scope="row">Nama Lengkap</th>
                                                                                            <td><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['middle_name'] . ' ' . $employee['last_name']); ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Jenis Kelamin</th>
                                                                                            <td><?php echo htmlspecialchars($employee['gender']); ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Date Created</th>
                                                                                            <td><?php echo htmlspecialchars(date('jS F, Y', strtotime($employee['date_created']))); ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Jabatan</th>
                                                                                            <td><?php echo htmlspecialchars($employee['designation']); ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Is Supervisor?</th>
                                                                                            <td><?php echo htmlspecialchars($employee['is_supervisor'] == 1 ? 'Yes' : 'No'); ?></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                        <!-- end of table col-lg-6 -->
                                                                        <div class="col-lg-12 col-xl-6">
                                                                            <div class="table-responsive">
                                                                                <table class="table">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <th scope="row">Email</th>
                                                                                            <td><a href="#!"><span class="__cf_email__"><?php echo htmlspecialchars($employee['email_id']); ?>&#160;</span></a></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">No HP</th>
                                                                                            <td><?php echo htmlspecialchars($employee['phone_number']); ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">NIP</th>
                                                                                            <td><?php echo htmlspecialchars($employee['staff_id']); ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Role</th>
                                                                                            <td><?php echo htmlspecialchars($employee['role']); ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Unit Kerja</th>
                                                                                            <td><?php echo htmlspecialchars($department_name); ?></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                        <!-- end of table col-lg-6 -->
                                                                    </div>
                                                                    <!-- end of row -->
                                                                </div>
                                                                <!-- end of general info -->
                                                            </div>
                                                            <!-- end of col-lg-12 -->
                                                        </div>
                                                        <!-- end of row -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- contact data table card end -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- tab content end -->

                    <!-- Modal Leave Type start -->
                    <div id="edit-leave-type" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="login-card card-block login-card-modal">
                                <form class="md-float-material">
                                    <div class="card m-t-15">
                                        <div class="auth-box card-block">
                                            <div class="row m-b-20">
                                                <div class="col-md-12">
                                                    <h5 class="text-center txt-primary">Manajemen Jenis Cuti <strong><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['middle_name'] . ' ' . $employee['last_name']); ?></strong></h5>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="card-block groups-contact">
                                                <ul class="list-group">
                                                    <li class="list-group-item justify-content-between">
                                                        <div class="checkbox-fade fade-in-primary">
                                                            <label>
                                                                <input type="checkbox" id="selectAllLeaveTypes">
                                                                <span class="cr">
                                                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                </span>
                                                            </label>
                                                            <span class="text" style="margin-left: 15px;">Jenis Cuti</span>
                                                        </div>
                                                        <span class="text" style="margin-left: 15px;">Kredit Cuti</span>
                                                    </li>
                                                    <?php foreach ($all_leave_types as $leaveType): ?>
                                                        <?php
                                                            $isChecked = array_key_exists($leaveType['id'], $assigned_leave_types_ids);
                                                            $isDisabled = $isChecked && $assigned_leave_types_ids[$leaveType['id']] != $leaveType['assign_days'];
                                                            
                                                        ?>
                                                        <li class="list-group-item justify-content-between">
                                                            <div class="checkbox-fade fade-in-primary">
                                                                <label>
                                                                    <input type="checkbox" name="leaveTypes[]" value="<?php echo $leaveType['id']; ?>"
                                                                        <?php echo $isChecked ? 'checked' : ''; ?>
                                                                        <?php echo $isDisabled ? 'disabled' : ''; ?>>
                                                                    <span class="cr">
                                                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                    </span>
                                                                </label>
                                                                <span class="text" style="margin-left: 15px;"><?php echo $leaveType['leave_type']; ?></span>
                                                            </div>
                                                            <span class="badge badge-inverse-info"><?php echo $leaveType['assign_days']; ?></span>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <div class="row m-t-15">
                                                <div class="col-md-12">
                                                    <button type="button" id="saveLeaveTypesBtn" class="btn btn-primary btn-md btn-block waves-effect text-center">Save</button>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p class="text-inverse text-center m-b-0">Anda dapat menetapkan berbagai jenis cuti kepada anggota staf Anda.</p>
                                                    <p></p>
                                                    <p class="text-inverse text-left text-warning"><b>Catatan : </b>Jenis cuti yang sudah digunakan oleh karyawan tidak dapat ditetapkan kembali dan akan dinonaktifkan.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Leave Type end-->

                    <!-- Modal Input N1 N2 -->
                    <div id="modalAddN" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <form id="formAddN" method="post" action="<?php echo base_url('Staff/add_n'); ?>">
                            <div class="modal-header">
                            <h5 class="modal-title">Tambah Data untuk <span id="leaveTypeName"></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="leave_type_id" id="leaveTypeId">
                                <input type="hidden" name="employee_id" value="<?php echo $employee['emp_id']; ?>">
                                <div class="form-group">
                                    <label for="n1">Nilai N1</label>
                                    <input type="text" class="form-control" name="n1">
                                </div>
                                <div class="form-group">
                                    <label for="n2">Nilai N2</label>
                                    <input type="text" class="form-control" name="n2">
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </form>
                        </div>
                    </div>
                    </div>

                    <!-- Modal Assign Supervisor start -->
                    <div id="edit-supervisor" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="login-card card-block login-card-modal">
                                <form class="md-float-material">
                                    <div class="card m-t-15">
                                        <div class="auth-box card-block">
                                            <div class="row m-b-20">
                                                <div class="col-md-12">
                                                    <h5 class="text-center txt-primary">Manage Supervisor <strong><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['middle_name'] . ' ' . $employee['last_name']); ?></strong></h5>
                                                </div>
                                            </div>
                                            <hr>
                                            <select name="supervisor" class="form-control form-control-info">
                                                <option value="">Select One Value Only</option>
                                                <?php foreach ($potential_supervisors as $supervisorRow): ?>
                                                    <?php
                                                        $supervisorId = htmlspecialchars($supervisorRow['emp_id']);
                                                        $supervisorName = htmlspecialchars($supervisorRow['first_name'] . ' ' . $supervisorRow['middle_name'] . ' ' . $supervisorRow['last_name']);
                                                    ?>
                                                    <option value="<?= $supervisorId ?>"><?= $supervisorName ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                            <div class="row m-t-15">
                                                <div class="col-md-12">
                                                    <button type="button" id="assignSupervisorBtn" class="btn btn-primary btn-md btn-block waves-effect text-center">Assign Supervisor</button>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p class="text-inverse text-center m-b-0">You can assign supervisors to your staff members.</p>
                                                </br>
                                                    <p class="text-inverse text-left"><b>Note:</b> Please select the appropriate supervisor for each employee.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Assign Supervisor end-->

                </div>
            </div>
        </div>
        <!-- Page-body end -->
    </div>
</div>

<!-- Change password modal start -->
<div id="change-password-dialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="login-card card-block login-card-modal">
            <form class="md-float-material">
                <div class="card m-t-15">
                    <div class="auth-box card-block">
                        <div class="row m-b-20">
                            <div class="col-md-12">
                                <h3 class="text-center txt-primary">Ubah Password</h3>
                            </div>
                        </div>
                        <hr>
                        <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $employee['emp_id']; ?>">
                        <div class="input-group">
                            <input id="old_password" type="password" class="form-control" placeholder="Old Password">
                            <span class="md-line"></span>
                        </div>
                        <div class="input-group">
                            <input id="new_password" type="password" class="form-control" placeholder="New Password">
                            <span class="md-line"></span>
                        </div>
                        <div class="input-group">
                            <input id="confirm_password" type="password" class="form-control" placeholder="Confirm New Password">
                            <span class="md-line"></span>
                        </div>
                        <div class="row m-t-15">
                            <div class="col-md-12">
                                <button id="change_password" type="button" class="btn btn-primary btn-md btn-block waves-effect text-center">Update</button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-10">
                                <p class="text-inverse text-left"><b>Kamu akan logout setelah kata sandi diubah.</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Change password modal end-->

<script>
    document.getElementById('selectAllLeaveTypes').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('input[name="leaveTypes[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = this.checked;
        }.bind(this));
    });

    document.addEventListener('DOMContentLoaded', function() {
        var checkboxes = document.querySelectorAll('input[name="leaveTypes[]"]');
        var saveButton = document.getElementById('saveLeaveTypesBtn');
        var initialCheckedStates = Array.from(checkboxes).map(checkbox => checkbox.checked);

        // Function to check for changes and enable/disable the Save button
        function checkForChanges() {
            var currentCheckedStates = Array.from(checkboxes).map(checkbox => checkbox.checked);
            var hasChanges = !initialCheckedStates.every((state, index) => state === currentCheckedStates[index]);
            
            if (hasChanges) {
                saveButton.classList.remove('btn-disabled');
                saveButton.classList.add('btn-primary');
            } else {
                saveButton.classList.remove('btn-primary');
                saveButton.classList.add('btn-disabled');
            }
            saveButton.disabled = !hasChanges;
        }

        // Disable the Save button on page load
        saveButton.classList.remove('btn-primary');
        saveButton.classList.add('btn-disabled');
        saveButton.disabled = true;

        // Event listener for checkbox changes
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', checkForChanges);
        });

        // Event listener for the "Select All" checkbox
        document.getElementById('selectAllLeaveTypes').addEventListener('change', function(event) {
            checkboxes.forEach(function(checkbox) {
                if (!checkbox.disabled) {
                    checkbox.checked = event.target.checked;
                }
            });
            checkForChanges();
        });

        // Check for changes when the modal is opened
        $('#edit-leave-type').on('shown.bs.modal', function() {
            initialCheckedStates = Array.from(checkboxes).map(checkbox => checkbox.checked);
            checkForChanges();
        });
    });

    document.getElementById('saveLeaveTypesBtn').addEventListener('click', function(event) {
        event.preventDefault();
        
        // Validate if at least one leave type is selected
        var checkboxes = document.querySelectorAll('input[name="leaveTypes[]"]');
        var isChecked = false;
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                isChecked = true;
            }
        });
        
        if (!isChecked) {
            $('.modal').css('z-index', '1050');
            Swal.fire({
                icon: 'warning',
                text: 'Please select at least one leave type',
                confirmButtonColor: '#ffc107',
                confirmButtonText: 'OK',
                didClose: () => {
                    $('.modal').css('z-index', '');
                }
            });
            return;
        }

        // If validation passes, proceed with form submission
        var formData = new FormData();
        formData.append('employeeId', <?php echo $employee['emp_id']; ?>);
        formData.append('action', 'assign-leave-types');   

        // Append selected leave types to formData
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                formData.append('leaveTypes[]', checkbox.value);
            }
        });

        fetch('<?= base_url('staff/staff_functions') ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        }).then(response => response.text())
        .then(data => {
            $('.modal').css('z-index', '1050');
            Swal.fire({
                icon: 'success',
                text: 'Jenis cuti berhasil diberikan!',
                confirmButtonColor: '#01a9ac',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.modal').css('z-index', '');
                    location.reload();
                }
            });
        }).catch(error => {
            console.error('Error:', error);
            $('.modal').css('z-index', '1050');
            Swal.fire({
                icon: 'error',
                text: 'An error occurred while updating leave types',
                confirmButtonColor: '#eb3422',
                confirmButtonText: 'OK',
                didClose: () => {
                    $('.modal').css('z-index', '');
                }
            });
        });
    });

    // Assign supervisor
    document.getElementById('assignSupervisorBtn').addEventListener('click', function(event) {
        event.preventDefault();
        
        var supervisorId = document.querySelector('select[name="supervisor"]').value;
        var employeeId = <?php echo $employee['emp_id']; ?>;
        
        if (!supervisorId) {
            $('.modal').css('z-index', '1050');
            Swal.fire({
                icon: 'warning',
                text: 'Please select a supervisor',
                confirmButtonColor: '#ffc107',
                confirmButtonText: 'OK',
                didClose: () => {
                    $('.modal').css('z-index', '');
                }
            });
            return;
        }

        var formData = new FormData();
        formData.append('employeeId', employeeId);
        formData.append('supervisorId', supervisorId);
        formData.append('action', 'assign-supervisor');
        
        fetch('<?= base_url('staff/staff_functions') ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        }).then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                $('.modal').css('z-index', '1050');
                Swal.fire({
                    icon: 'success',
                    text: 'Supervisor assigned successfully!',
                    confirmButtonColor: '#01a9ac',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                         $('.modal').css('z-index', '');
                        location.reload();
                    }
                });
            } else {
                $('.modal').css('z-index', '1050');
                Swal.fire({
                    icon: 'error',
                    text: 'An error occurred while assigning supervisor',
                    confirmButtonColor: '#eb3422',
                    confirmButtonText: 'OK',
                    didClose: () => {
                        $('.modal').css('z-index', '');
                    }
                });
            }
        }).catch(error => {
            console.error('Error:', error);
             $('.modal').css('z-index', '1050');
            Swal.fire({
                icon: 'error',
                text: 'An error occurred while assigning supervisor',
                confirmButtonColor: '#eb3422',
                confirmButtonText: 'OK',
                didClose: () => {
                    $('.modal').css('z-index', '');
                }
            });
        });
    });

    // Change password functionality
    $('#change_password').click(function(event) {
        event.preventDefault();
        $('.modal').css('z-index', '1050');

        var data = {
            old_password: $('#old_password').val(),
            new_password: $('#new_password').val(),
            confirm_password: $('#confirm_password').val(),
            employee_id: $('#employee_id').val(),
            action: "change_password",
        };

        if (data.old_password.trim() === '' || data.new_password.trim() === '' || data.confirm_password.trim() === '') {
            Swal.fire({
                icon: 'warning',
                text: 'Harap isi semua kolom.',
                confirmButtonColor: '#ffc107',
                confirmButtonText: 'OK'
            });
            return;
        }

        if (data.new_password !== data.confirm_password) {
            Swal.fire({
                icon: 'warning',
                text: 'Kata sandi baru dan konfirmasi kata sandi tidak cocok.',
                confirmButtonColor: '#ffc107',
                confirmButtonText: 'OK'
            });
            return;
        }

        $.ajax({
            url: '<?= base_url('staff/change_password') ?>',
            type: 'post',
            data: data,
            success: function(response) {
                response = JSON.parse(response);
                $('#change-password-dialog').modal('hide');
                if (response.status == 'success') {
                    <?php if ($this->session->userdata('role') == 'Admin') : ?>
                    Swal.fire({
                        icon: 'info',
                        title: 'Password Berhasil Diubah',
                        text: 'Kata sandi berhasil diubah. Anda tetap masuk sebagai admin.',
                        confirmButtonColor: '#01a9ac',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#change-password-dialog').modal('hide'); // tutup modal
                        }
                    });
                    <?php else: ?>
                        Swal.fire({
                            icon: 'success',
                            title: 'Reset Kata Sandi Berhasil',
                            text: 'Kata sandi Anda telah berhasil diubah. Silakan masuk kembali.',
                            confirmButtonColor: '#01a9ac',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#change-password-dialog').modal('hide'); // tutup modal
                                window.location = '<?= base_url('auth/logout') ?>';
                            }
                        });
                    <?php endif; ?>
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: response.message,
                        confirmButtonColor: '#eb3422',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    });
</script>

<!-- open modal add n1 n2 -->
<script>
$(document).on("click", ".addNBtn", function() {
    var leaveId = $(this).data("id");
    var leaveName = $(this).data("name");

    $("#leaveTypeId").val(leaveId);
    $("#leaveTypeName").text(leaveName);
    $("#modalAddN").modal("show");
});
</script>

<!-- submit add n1 n2-->
<script>
$(document).ready(function() {
    // Submit form pakai AJAX
    $("#formAddN").on("submit", function(e) {
        e.preventDefault();

        $.ajax({
            url: "<?php echo base_url('Staff/add_n_employee'); ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                $("#modalAddN").modal("hide");
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    $("#modalAddN").modal("hide");

                    // Optional: reload halaman atau refresh bagian tertentu
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: response.message
                    });
                }
            },
            error: function() {
                $("#modalAddN").modal("hide");
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Terjadi kesalahan server!"
                });
            }
        });
    });
});
</script>

<!-- delete n1 n2 -->
<script>
$(document).on("click", ".deleteNBtn", function() {
    var leaveTypeId = $(this).data("id");
    var empId       = "<?php echo $employee['emp_id']; ?>"; // sesuaikan
    var nColumn     = $(this).data("n"); // n1 atau n2

    Swal.fire({
        title: 'Yakin?',
        text: "Data " + nColumn.toUpperCase() + " akan dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo base_url('Staff/delete_n'); ?>",
                type: "POST",
                data: { leave_type_id: leaveTypeId, emp_id: empId, column: nColumn },
                dataType: "json",
                success: function(response) {
                    $("#modalAddN").modal("hide");
                    if(response.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        // Optional: update tampilan real-time
                        setTimeout(function() { location.reload(); }, 1500);
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal",
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Terjadi kesalahan server!"
                    });
                }
            });
        }
    });
});
</script>

