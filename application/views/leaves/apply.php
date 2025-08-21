<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>e-cuti Kemenag - <?php echo isset($leaveData['id']) ? 'Edit' : 'Ajukan'; ?> Cuti</h4>
                            <span><?php echo isset($leaveData['id']) ? 'Edit permintaan cuti Anda' : 'Kirim semua permintaan cuti Anda dari sini.'; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page-header end -->

        <!-- Page body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="j-wrapper j-wrapper-640">
                                <form method="post" class="j-pro" id="j-pro" enctype="multipart/form-data" novalidate="">
                                    <div class="j-content">
                                        <div class="j-wrapper">
                                            <h4 style="text-align: center;">
                                                <?php echo isset($leaveData['id']) ? 'Edit Pengajuan' : 'Tambah Pengajuan Baru'; ?>
                                            </h4>
                                        </div>

                                        <!-- Hidden field for leave ID when editing -->
                                        <?php if (isset($leaveData['id'])): ?>
                                            <input type="hidden" name="leave_id" value="<?php echo $leaveData['id']; ?>">
                                        <?php endif; ?>

                                        <!-- Employee Selection -->
                                        <div class="j-unit">
                                            <?php if ($userRole === 'Admin' && $userDesignation === 'Administrator'): ?>
                                                <select class="js-example-disabled-results col-sm-12" name="empId" id="empId" required>
                                                    <?php if (!empty($employees)): ?>
                                                        <?php foreach ($employees as $emp): ?>
                                                            <option value="<?php echo $emp['id']; ?>" 
                                                                <?php echo (isset($leaveData['emp_id']) && $leaveData['emp_id'] == $emp['id']) ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($emp['name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <option value="">-- Tidak ada karyawan tersedia --</option>
                                                    <?php endif; ?>
                                                </select>
                                            <?php else: ?>
                                                <input type="hidden" id="empId" value="<?php echo isset($leaveData['emp_id']) ? $leaveData['emp_id'] : htmlspecialchars($this->session->userdata('emp_id')); ?>">
                                            <?php endif; ?>
                                        </div>
                                        <!-- End of Employee list -->

                                        <!-- Start Leave type -->
                                        <div class="j-unit">
                                            <label class="j-input j-select">
                                                <select name="leave_type" id="leave_type">
                                                    <option value="" selected="">Pilih Tipe Cuti</option>
                                                    <!-- Options will be loaded via AJAX -->
                                                </select>
                                                <i></i>
                                            </label>
                                        </div>
                                        <!-- end leave type -->

                                        <!-- start date -->
                                        <div class="j-unit">
                                            <div class="j-input">
                                                <span style="margin-bottom: 8px;" class="j-hint">Tanggal Mulai</span>
                                                <input id="start_date" name="start_date" class="form-control" type="date" 
                                                    value="<?php echo isset($leaveData['start_date']) ? $leaveData['start_date'] : ''; ?>">
                                                <span class="j-tooltip j-tooltip-right-top">Pick your start leave date</span>
                                            </div>
                                        </div>
                                        <!-- end start date -->

                                        <!-- end date -->
                                        <div class="j-unit">
                                            <div class="j-input">
                                                <span style="margin-bottom: 8px;" class="j-hint">Tanggal Selesai</span>
                                                <input id="end_date" name="end_date" class="form-control" type="date" 
                                                    value="<?php echo isset($leaveData['end_date']) ? $leaveData['end_date'] : ''; ?>">
                                                <span class="j-tooltip j-tooltip-right-top">Pick your end leave date</span>
                                            </div>
                                        </div>
                                        <!-- end end date -->

                                        <!-- start Number Days -->
                                        <div class="j-unit">
                                            <div class="j-input">
                                                <label class="j-icon-right" for="number_days">
                                                    <i class="icofont icofont-math"></i>
                                                </label>
                                                <input type="text" id="number_days" 
                                                    value="<?php echo isset($leaveData['number_days']) ? $leaveData['number_days'] : '0'; ?>" 
                                                    name="number_days" readonly disabled>
                                            </div>
                                        </div>
                                        <!-- end Number days -->

                                        <!-- start remarks -->
                                        <div class="j-unit">
                                            <div class="j-input">
                                                <textarea placeholder="Alasan Cuti" spellcheck="true" name="remarks" id="remarks"><?php echo isset($leaveData['remarks']) ? $leaveData['remarks'] : ''; ?></textarea>
                                                <span class="j-tooltip j-tooltip-right-top">Tambahan Informasi tentang Cuti</span>
                                            </div>
                                        </div>
                                        <!-- end remarks -->

                                        <!-- start files -->
                                        <div class="j-unit" id="approve_file_container">
                                            <div class="j-input j-append-small-btn">
                                                <div class="j-file-button">
                                                    Cari
                                                    <input type="file" name="approve_file" id="approve_file" accept=".pdf, .jpg, .jpeg, .png" onchange="validateFileApprove(this)">
                                                </div>
                                                <input type="text" id="approve_file_input" readonly="" 
                                                    placeholder="Masukkan File Pengajuan Cuti"
                                                    value="<?php echo isset($leaveData['file']) ? basename($leaveData['file']) : ''; ?>">
                                                <span class="j-hint">Only: pdf, jpg, jpeg, png, less than 2MB</span>
                                                <?php if (isset($leaveData['file']) && !empty($leaveData['file'])): ?>
                                                    <div class="existing-file">
                                                        <small>File saat ini: <a href="<?php echo base_url('uploads/leave_files/' . $leaveData['file']); ?>" target="_blank"><?php echo $leaveData['file']; ?></a></small>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="j-unit" id="sick_file_container">
                                            <div class="j-input j-append-small-btn">
                                                <div class="j-file-button">
                                                    Cari
                                                    <input type="file" name="sick_file" id="sick_file" accept=".pdf, .jpg, .jpeg, .png" onchange="validateFile(this)">
                                                </div>
                                                <input type="text" id="sick_file_input" readonly="" 
                                                    placeholder="Masukkan Surat Sakit"
                                                    value="<?php echo isset($leaveData['sick_file']) ? basename($leaveData['sick_file']) : ''; ?>">
                                                <span class="j-hint">Only: pdf, jpg, jpeg, png, less than 2MB</span>
                                                <?php if (isset($leaveData['sick_file']) && !empty($leaveData['sick_file'])): ?>
                                                    <div class="existing-file">
                                                        <small>File saat ini: <a href="<?php echo base_url('uploads/leave_files/' . $leaveData['sick_file']); ?>" target="_blank"><?php echo $leaveData['sick_file']; ?></a></small>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <!-- end files -->
                                    </div>
                                    <!-- end /.content -->

                                    <div class="j-footer">
                                        <button id="apply-leave" type="submit" class="btn btn-primary">
                                            <?php echo isset($leaveData['id']) ? 'Update' : 'Submit'; ?>
                                        </button>
                                        <button type="reset" class="btn btn-default m-r-20">Reset</button>
                                    </div>
                                    <!-- end /.footer -->
                                </form>
                            </div>
                            <label class="col-sm-5"></label>
                        </div>
                    </div>
                    <!-- Basic Inputs Validation end -->
                </div>
            </div>
        </div>
        <!-- Page body end -->
    </div>
</div>
<!-- Main-body end -->

<script>
$(document).ready(function () {
    // Store edit data if available
    var editData = <?php echo isset($leaveData) ? json_encode($leaveData) : 'null'; ?>;
    
    $('#apply-leave').click(function (event) {
        event.preventDefault();

        // Collect form data
        var formData = new FormData();
        var empId = $('#empId').val();
        var leaveType = $('#leave_type').val();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        var numberDays = $('#number_days').val();
        var remarks = $('#remarks').val();
        var sickFile = $('#sick_file')[0].files[0];
        var approveFile = $('#approve_file')[0].files[0];

        console.log('numberDays : ' + numberDays);
        console.log('available_days : ' + availableDays);
        
        if (parseInt(numberDays) > availableDays) {
            Swal.fire({
                icon: 'warning',
                title: 'Jatah Cuti Tidak Mencukupi',
                text: `Anda hanya memiliki ${availableDays} hari cuti tersisa. Anda mengajukan ${numberDays} hari.`,
                confirmButtonColor: '#ffc107',
                confirmButtonText: 'OK'
            });
            return;
        }
        // Add leave ID if editing
        if (editData && editData.id) {
            formData.append('leave_id', editData.id);
        }

        // Validate fields
        if (!empId || !leaveType || !startDate || !endDate || !numberDays || numberDays <= 0) {
            Swal.fire({
                icon: 'warning',
                text: 'Please fill in all required fields.',
                confirmButtonColor: '#ffc107',
                confirmButtonText: 'OK'
            });
            return;
        }

        var selectedLeaveType = $('#leave_type option:selected').text().toLowerCase();
        if ((selectedLeaveType.includes('sick') || selectedLeaveType === 'sick leave') && !sickFile && (!editData || !editData.sick_file)) {
            Swal.fire({
                icon: 'warning',
                text: 'Please upload a file for sick leave.',
                confirmButtonColor: '#ffc107',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Append data to FormData
        formData.append('empId', empId);
        formData.append('leave_type', leaveType);
        formData.append('start_date', startDate);
        formData.append('end_date', endDate);
        formData.append('number_days', numberDays);
        formData.append('remarks', remarks);
        
        if (sickFile) formData.append('sick_file', sickFile);
        if (approveFile) formData.append('approve_file', approveFile);
        
        formData.append('action', editData && editData.id ? 'update-leave' : 'apply-leave');

        // AJAX request to submit the form data
        $.ajax({
            url: '<?php echo base_url('Leave/applyleave') ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                try {
                    response = JSON.parse(response);
                    console.log('RESPONSE HERE: ' + response.status);
                    console.log(`RESPONSE HERE: ${response.message}`);
                    
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                            confirmButtonColor: '#01a9ac',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '<?php echo base_url('Leave/myleave'); ?>';
                            }
                        });
                    } else {
                        console.log('RESPONSE HERE: ' + response.status);
                        Swal.fire({
                            icon: 'error',
                            text: response.message,
                            confirmButtonColor: '#eb3422',
                            confirmButtonText: 'OK'
                        });
                    }
                } catch (e) {
                    console.error("Parsing error:", e);
                    console.error("Received response:", response);
                    Swal.fire({
                        icon: 'error',
                        text: 'An unexpected error occurred. Please try again.',
                        confirmButtonColor: '#eb3422',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('AJAX Data HERE: ' + JSON.stringify(formData));
                console.log("Response from server: " + jqXHR.responseText);
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                Swal.fire({
                    icon: 'error',
                    text: 'AJAX error: ' + textStatus + ' : ' + errorThrown,
                    confirmButtonColor: '#eb3422',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
</script>

<!-- Load leave types -->
<script>
$(document).ready(function () {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const numberDaysInput = document.getElementById('number_days');
    var editData = <?php echo isset($leaveData) ? json_encode($leaveData) : 'null'; ?>;

    const redDates = <?php echo json_encode($holiday_dates); ?>; 

    // Set min attribute
    const today = new Date().toISOString().split('T')[0];
    startDateInput.setAttribute('min', today);
    endDateInput.setAttribute('min', today);

    let allowSat = false;
    let allowSun = false;

    // Load leave types
    function loadLeaveTypes(empId) {
        $.ajax({
            url: '<?php echo base_url('Leave/loadLeaveTypes') ?>',
            type: 'POST',
            data: { empId: empId },
            success: function(response) {
                $('#leave_type').html(response);
                
                // If editing, select the correct leave type
                if (editData && editData.leave_type_id) {
                    $('#leave_type').val(editData.leave_type_id);
                    $('#leave_type').trigger('change');
                }
            }
        });
    }

    // When employee changes
    $('#empId').change(function() {
        const empId = $(this).val();
        loadLeaveTypes(empId);
    });

    // Automatically load for non-admin or set initial value for edit
    <?php if ($userRole !== 'Admin' || $userDesignation !== 'Administrator'): ?>
        var empId = $('#empId').val();
        loadLeaveTypes(empId);
    <?php else: ?>
        // For admin, load leave types for selected employee when editing
        if (editData && editData.emp_id) {
            loadLeaveTypes(editData.emp_id);
        }
    <?php endif; ?>

    // Handle leave type change
    $('#leave_type').change(function() {
        const selectedOption = $(this).find('option:selected');
        allowSat = selectedOption.data('allowsat') == 1;
        allowSun = selectedOption.data('allowsun') == 1;

        allowsatleave = selectedOption.data('allowsatleave') == 1;
        allowsunleave = selectedOption.data('allowsunleave') == 1;

        // Override kalau leave type punya aturan sendiri
        if (selectedOption.data('allowsatleave') !== undefined) {
            allowSat = allowsatleave;
        }
        if (selectedOption.data('allowsunleave') !== undefined) {
            allowSun = allowsunleave;
        }
     
        availableDays = parseInt(selectedOption.data('available_days')) || 0; // simpan ke variabel global

        // ===== BAGIAN BARU: Reset semua input lain =====
        // Reset tanggal
        $('#start_date').val('');
        $('#end_date').val('');
        
        // Reset number of days
        $('#number_days').val('0');
        
        // Reset remarks/alasan cuti
        $('#remarks').val('');
        
        // Reset file inputs dan display names
        $('#sick_file').val('');
        $('#sick_file_input').val('');
        $('#approve_file').val('');
        $('#approve_file_input').val('');
        
        // Hide existing file info jika ada
        $('.existing-file').hide();
        // ===== AKHIR BAGIAN BARU =====

        // Show or hide file input if sick leave
        const leaveText = selectedOption.text().toLowerCase();
        if (leaveText.includes('sakit') || leaveText === 'cuti sakit') {
            $('#sick_file_container').show();
        } else {
            $('#sick_file_container').hide();
        }

        // Recalculate days if dates are already selected
        calculateDays();

    });

    function handleDateInput(input) {
        input.addEventListener('input', function() {
            const date = new Date(this.value);
            const day = date.getUTCDay();

            // ✅ cek apakah tanggal masuk daftar merah
            if (redDates.includes(this.value)) {
                Swal.fire({
                    icon: 'warning',
                    text: 'Tanggal ini adalah tanggal merah, tidak dapat dipilih untuk cuti.',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'OK'
                });
                this.value = '';
                calculateDays();
                return;
            }

            // Validate based on leave type
            if ((day === 6 && !allowSat) || (day === 0 && !allowSun)) {
                Swal.fire({
                    icon: 'warning',
                    text: 'Tanggal ini tidak diperbolehkan untuk cuti yang dipilih.',
                    confirmButtonColor: '#ffc107',
                    confirmButtonText: 'OK'
                });
                this.value = '';
                calculateDays();
                return;
            }

            // Validate start/end date
            if (input.id === 'end_date' && startDateInput.value && new Date(this.value) < new Date(startDateInput.value)) {
                Swal.fire({
                    icon: 'warning',
                    text: 'End date cannot be earlier than start date. Please select a valid date.',
                    confirmButtonColor: '#ffc107',
                    confirmButtonText: 'OK'
                });
                this.value = '';
                calculateDays();
                return;
            }

            if (input.id === 'start_date' && endDateInput.value && new Date(this.value) > new Date(endDateInput.value)) {
                Swal.fire({
                    icon: 'warning',
                    text: 'Start date cannot be later than end date. Please select a valid date.',
                    confirmButtonColor: '#ffc107',
                    confirmButtonText: 'OK'
                });
                this.value = '';
                calculateDays();
                return;
            }

            calculateDays();
        });
    }

    function isWeekend(date) {
        const day = date.getUTCDay();
        if (day === 6) return !allowSat;
        if (day === 0) return !allowSun;
        return false;
    }

    // function calculateDays() {
    //     const startDateValue = startDateInput.value;
    //     const endDateValue = endDateInput.value;

    //     if (startDateValue && endDateValue) {
    //         const startDate = new Date(startDateValue);
    //         const endDate = new Date(endDateValue);
    //         let count = 0;

    //         for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
    //             if (!isWeekend(d)) count++;
                
    //         }

    //         numberDaysInput.value = count;
    //     } else {
    //         numberDaysInput.value = '';
    //     }
    // }

    function calculateDays() {
        const startDateValue = startDateInput.value;
        const endDateValue = endDateInput.value;

        if (startDateValue && endDateValue) {
            const startDate = new Date(startDateValue);
            const endDate = new Date(endDateValue);
            let count = 0;

            for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
                const isoDate = d.toISOString().split('T')[0];

                // skip weekend kalau tidak diizinkan
                if (isWeekend(d)) continue;

                // skip tanggal merah dari DB
                if (redDates.includes(isoDate)) continue;

                count++;
            }

            numberDaysInput.value = count;
        } else {
            numberDaysInput.value = '';
        }
    }


    handleDateInput(startDateInput);
    handleDateInput(endDateInput);

    // Calculate initial days if editing
    if (editData && editData.start_date && editData.end_date) {
        calculateDays();
    }
});
</script>

<!-- validate file sick and approval -->
<script>
function validateFile(input) {
    var file = input.files[0];
    var fileType = file.type.toLowerCase();
    var fileSize = file.size; // in bytes

    // Allowed file types and maximum file size (2MB)
    var allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    var maxSize = 2 * 1024 * 1024; // 2MB

    if (!allowedTypes.includes(fileType)) {
        Swal.fire({
            icon: 'error',
            text: 'Invalid file type. Please select a PDF, JPG, or PNG file.',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'OK'
        });
        input.value = '';
        return false;
    }

    if (fileSize > maxSize) {
        Swal.fire({
            icon: 'error',
            text: 'File size exceeds the limit of 2MB. Please select a smaller file.',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'OK'
        });
        input.value = '';
        return false;
    }

    // Display the selected file name in the input field
    var fileName = file.name;
    $('#sick_file_input').val(fileName);
}

function validateFileApprove(input) {
    var file = input.files[0];
    var fileType = file.type.toLowerCase();
    var fileSize = file.size; // in bytes

    // Allowed file types and maximum file size (2MB)
    var allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    var maxSize = 2 * 1024 * 1024; // 2MB

    if (!allowedTypes.includes(fileType)) {
        Swal.fire({
            icon: 'error',
            text: 'Invalid file type. Please select a PDF, JPG, or PNG file.',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'OK'
        });
        input.value = '';
        return false;
    }

    if (fileSize > maxSize) {
        Swal.fire({
            icon: 'error',
            text: 'File size exceeds the limit of 2MB. Please select a smaller file.',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'OK'
        });
        input.value = '';
        return false;
    }

    // Display the selected file name in the input field
    var fileName = file.name;
    $('#approve_file_input').val(fileName);
}
</script>

<style>
/* Disable style for weekend days */
.disabled {
    pointer-events: none;
    opacity: 0.5;
}

.existing-file {
    margin-top: 5px;
}

.existing-file small {
    color: #666;
}

.existing-file a {
    color: #007bff;
    text-decoration: none;
}

.existing-file a:hover {
    text-decoration: underline;
}
</style>