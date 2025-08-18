<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>E-Cuti-Kemenag - Semua Cuti</h4>
                            <span>Verifikasi dan berikan respons terhadap permintaan cuti</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12 filter-bar">
                    <!-- Nav Filter tab start -->
                    <nav class="navbar navbar-light bg-faded m-b-30 p-10">
                        <ul class="nav navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="#!">Filter By Status: <span
                                        class="sr-only">(current)</span></a>
                            </li>
                            <!-- Your existing HTML for the dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#!" id="bystatus" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="icofont icofont-home"></i> <?php echo $selected_leave_status_name; ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="bystatus">
                                    <?php if ($this->session->userdata('role') != 'Kepala'): ?>
                                        <a class="dropdown-item <?php echo ($selected_leave_status_name === 'Show all') ? 'active' : ''; ?>"
                                            href="?leave_status=Show all">Show all</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item <?php echo ($selected_leave_status_name === 'Pending Admin Approval') ? 'active' : ''; ?>"
                                            href="?leave_status=0">Pending Admin Approval</a>
                                        <a class="dropdown-item <?php echo ($selected_leave_status_name === 'Rejected by Admin') ? 'active' : ''; ?>"
                                            href="?leave_status=1">Rejected by Admin</a>
                                    <?php endif; ?>
                                    <a class="dropdown-item <?php echo ($selected_leave_status_name === 'Forwarded to Kepala') ? 'active' : ''; ?>"
                                        href="?leave_status=2">Forwarded to Kepala</a>
                                    <a class="dropdown-item <?php echo ($selected_leave_status_name === 'Rejected by Kepala') ? 'active' : ''; ?>"
                                        href="?leave_status=3">Rejected by Kepala</a>
                                    <a class="dropdown-item <?php echo ($selected_leave_status_name === 'Approved') ? 'active' : ''; ?>"
                                        href="?leave_status=4">Approved</a>

                                    <?php if ($this->session->userdata('role') != 'Kepala'): ?>
                                        <a class="dropdown-item <?php echo ($selected_leave_status_name === 'Cancelled') ? 'active' : ''; ?>"
                                            href="?leave_status=5">Cancelled</a>
                                        <a class="dropdown-item <?php echo ($selected_leave_status_name === 'Recalled') ? 'active' : ''; ?>"
                                            href="?leave_status=6">Recalled</a>
                                    <?php endif; ?>
                                </div>
                            </li>
                        </ul>
                        <div class="nav-item nav-grid">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput" placeholder="Search here...">
                                <span class="input-group-addon" id="basic-addon1"><i
                                        class="icofont icofont-search"></i></span>
                            </div>
                        </div>
                        <!-- end of by priority dropdown -->
                    </nav>
                </div>
            </div>
            <div class="row">
                <!-- Left column start -->
                <div id="leaveMain" class="col-lg-9">
                    <div id="leaveContainer" class="job-card card-columns">
                        <!-- Populate it from leave_functions.php -->
                    </div>
                </div>
                <!-- Left column end -->
                <!-- Right column start -->
                <div id="leaveInformation" class="col-lg-3">
                    <!-- Leave Status card start -->
                    <div class="card job-right-header">
                        <div class="card-header">
                            <h5>Informasi Status Cuti</h5>
                            <!-- <div class="card-header-right">
                                                            <label class="label label-danger">Add</label>
                                                        </div> -->
                        </div>
                        <div class="card-block">
                            <form action="#">
                                <?php
                                foreach ($leave_status_counts as $status => $count) {
                                    if (isset($leaveStatusMap[$status])) {
                                        $leaveStatus = $leaveStatusMap[$status];
                                    } else {
                                        $leaveStatus = 'Unknown';
                                    }
                                    echo '<div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" value="" checked="checked" disabled>
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                </span>
                                            </label>
                                            <div>
                                                <a href="javascript:void(0);" class="leave-status-link" data-status="' . $status . '">'
                                        . $leaveStatus . ' <span class="text-muted binding-custom">(' . $count . ')</span>
                                                </a>
                                            </div>
                                        </div>';
                                }
                                ?>

                            </form>
                        </div>

                    </div>
                    <!-- Leave Status card end -->
                </div>
            </div>
            <!-- Right column end -->

            <!-- confirm mail start -->
            <div id="confirm-mail" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="login-card card-block login-card-modal">
                        <form class="md-float-material" enctype="multipart/form-data" id="leaveForm">
                            <div class="card m-t-15">
                                <div class="auth-box card-block">
                                    <div class="row m-b-20">
                                        <div class="col-md-12 confirm">
                                            <h3 class="text-center txt-primary">
                                                <i class="icofont icofont-check-circled text-primary"></i> Detail
                                                Pengajuan Cuti
                                            </h3>
                                        </div>
                                    </div>
                                    <input hidden type="text" class="form-control leave-id" name="leave-id">
                                    <p class="text-inverse text-left m-t-15 f-16">
                                        <b>Halo <span id="modalReviewer"></span></b>,
                                    </p>
                                    <p id="modalMessage" class="text-inverse text-left m-b-20"></p>
                                    <ul class="text-inverse text-left">
                                        <li><strong>Tipe Cuti: </strong> <span id="modalLeaveType"></span></li>
                                        <li><strong>Hari Cuti di Ajukan: </strong> <span id="modalRequestedDays"></span>
                                        </li>
                                        <li><strong>Sisa Jatah Cuti: </strong> <span id="modalRemaing"></span></li>
                                        <li><strong>Status: </strong> <span id="modalLeaveStatus"></span>
                                        </li>
                                    </ul>

                                    <div class="card-block">

                                        <!-- New input for Letter Number -->
                                        <div class="row mb-3 mt-0">
                                            <label for="letterNumber"><strong>No Surat (Admin)</strong></label>
                                            <input type="text" class="form-control" id="letterNumber"
                                                name="letterNumber" placeholder="Masukkan Nomor Surat dari Admin">
                                        </div>

                                        <!-- New input for sick file -->
                                        <div class="mb-3" id="sickFileInfo"
                                            style="display:none;width:410px;margin-left:-14px">
                                            <label for="sickFile"><strong>Surat Sakit</strong></label>
                                            <div class="d-flex">
                                                <input type="text" class="form-control" id="sickFileName" readonly>
                                                <a id="sickFileLink" href="#" target="_blank"
                                                    class="btn btn-sm btn-info ml-3">Lihat File</a>
                                            </div>
                                        </div>

                                        <!-- New input for uploading Approval Letter -->
                                        <div class="mb-3" id="approvalFileInfo" class="mb-2"
                                            style="display:none;width:410px;margin-left:-14px">
                                            <label for="approvalFile"><strong>Surat
                                                    Persetujuan/Pengajuan</strong></label>
                                            <div class="d-flex mb-2">
                                                <input type="text" class="form-control" id="approvalFileName" readonly>
                                                <a id="approvalFileLink" href="#" target="_blank"
                                                    class="btn btn-sm btn-info ml-3">Lihat File</a>
                                            </div>
                                            <small class="text-muted">
                                                File lama sudah ter-upload, pilih file baru jika ingin mengganti.
                                            </small>
                                            <!-- Input untuk upload baru -->
                                            <input type="file" class="form-control" id="approvalFile"
                                                name="approvalFile" accept=".pdf,.doc,.docx,.jpg,.png">
                                        </div>
                                        <label class="m-l-0 p-l-0" style="margin-left:-14px"
                                            for="st"><strong>Status</strong></label>
                                        <div class="row mb-3" id="radioButtonsContainer">

                                            <!-- options will be dynamically inserted here -->
                                        </div>
                                        <!-- New input for Letter Number -->
                                        <div class="row  mt-0" id="remarksInfoAdmin">
                                            <label for="remarks_admin"><strong>Alasan (opsional) : </strong></label>
                                            <textarea id="remarks_admin" name="remarks_admin"
                                                class="form-control"></textarea>
                                        </div>

                                    </div>
                                    <?php if ($this->session->userdata('role') == 'Admin' || $this->session->userdata('role') == 'Kepala'): ?>
                                        <div class="row m-t-15">
                                            <div class="col-md-12">
                                                <button type="button"
                                                    class="btn btn-primary btn-md btn-block waves-effect text-center">Update</button>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="text-inverse text-left m-b-0 m-t-10"></p>
                                            <p class="text-inverse text-left"><b></b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- end of form -->
                    </div>
                </div>
            </div>
            <!-- Confirm mail end-->

        </div>
    </div>
    <!-- Page body start -->
</div>
</div>
<!-- Main-body end -->

<!-- UPDATE -->
<script>
    $(document).on('click', '.status-update', function (event) {
        event.preventDefault();

        $('.modal').css('z-index', '1050');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to update this status!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = $('#leaveForm')[0]; // ambil form element
                let formData = new FormData(form);

                // kalau mau tambahkan manual
                formData.append("id", $('.leave-id').val());
                formData.append("status", $('#select').val());
                formData.append("action", "update-leave-status");

                $.ajax({
                    url: "<?php echo base_url('Leave/update_leave_status') ?>",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log("Response:", response);
                        const res = JSON.parse(response);

                        if (res.status === "success") {
                            Swal.fire('Updated!', res.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', res.message, 'error');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", error);
                        Swal.fire('Error!', 'Request failed', 'error');
                    }
                });
            }
        });
    });

</script>

<!-- DELETE -->
<script type="text/javascript">
    $(document).ready(function () {
        // Event listener for "Delete" buttons with class "delete-leave"
        $(document).on('click', '.delete-leave', function (event) {
            event.preventDefault();
            const leaveId = $(this).data('id');
            const leaveStatus = $(this).data('status');

            console.log("LEAVE STATUS FOR DELETE HERE " + (leaveStatus == "Pending") + leaveStatus);

            if (leaveStatus !== "Pending" && leaveStatus !== "Cancelled") {
                Swal.fire({
                    icon: 'warning',
                    text: 'Please you are only allowed to delete leave request that are pending or cancelled.',
                    confirmButtonColor: '#ffc107',
                    confirmButtonText: 'OK'
                });
                return;
            }

            (async () => {
                const { value: formValues } = await Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                });

                if (formValues) {
                    var data = {
                        id: leaveId,
                        action: "delete-leave"
                    };

                    $.ajax({
                        url: 'leave_functions.php',
                        type: 'post',
                        data: data,
                        success: function (response) {
                            const responseObject = JSON.parse(response);
                            if (response && responseObject.status === 'success') {
                                // Show success message
                                Swal.fire({
                                    icon: 'success',
                                    html: responseObject.message,
                                    confirmButtonColor: '#01a9ac',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    text: responseObject.message,
                                    confirmButtonColor: '#eb3422',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log("AJAX error: " + error);
                            Swal.fire('Error!', 'Failed to delete leave request.', 'error');
                        }
                    });
                }
            })();
        });
    });
</script>

<!-- FETCH -->
<script type="text/javascript">
    $(document).ready(function () {
        // Retrieve the initial department filter value

        var selectedStatus = $(".dropdown-menu .dropdown-item.active").attr("href").split("leave_status=")[1];
        // Function to fetch and display the filtered staff
        console.log('RESPONSE HERE: ' + selectedStatus);
        function fetchStaff() {
            var searchQuery = $('#searchInput').val(); // Get the search query
            var leaveStatusFilter = (selectedStatus === 'Show all') ? '' : selectedStatus; // Get the selectedStatus filter value
            // Make an AJAX request to fetch the filtered staff

            $.ajax({
                url: '<?php echo base_url('Leave/fetch_leaves') ?>', // Replace with the actual PHP script that fetches the staff from the database
                type: 'POST',
                data: { searchQuery: searchQuery, leaveStatusFilter: leaveStatusFilter },

                success: function (response) {
                    // Clear the existing staff cards
                    $('#leaveContainer').empty();
                    $('#leaveInformation').show();

                    console.log('RESPONSE HERE: ' + response);

                    // Append the fetched staff cards to the container
                    if (response.includes('files/assets/images/no_data.png')) {
                        console.log('No data image found in the response.');

                        // Set the class of the id leaveMain to be col-sm-12
                        $('#leaveMain').removeClass().addClass('col-sm-12');
                        $('#leaveInformation').hide();

                        // Remove the class of the id leaveContainer
                        $('#leaveContainer').removeClass();

                        // Append the fetched staff cards to the container
                        $('#leaveContainer').append(response);
                    } else {
                        // Maintain the current setup and append the response
                        $('#leaveContainer').append(response);
                    }
                }
            });
        }

        // Event listener for search input field
        $('#searchInput').on('keyup', function () {
            fetchStaff();
        });

        // Event listener for department filter dropdown
        $('#bystatus .dropdown-item').on('click', function (event) {
            event.preventDefault();
            // Update the selected department variable and dropdown text
            selectedStatus = $(this).text().trim();
            $('#bystatus').text(selectedStatus);

            // Fetch the staff based on the updated filter
            fetchStaff();
        });

        // Event listener leave request sidebar
        $('.leave-status-link').on('click', function (event) {
            event.preventDefault();

            // Ambil nilai status dari atribut data-status
            selectedStatus = $(this).data('status');

            // (opsional) beri highlight ke status yang dipilih
            $('.leave-status-link').removeClass('active');
            $(this).addClass('active');

            // Panggil fungsi fetchStaff sesuai filter
            fetchStaff();
        });

        // Fetch the initial staff based on the default filter
        fetchStaff();
    });

    $(document).ready(function () {
        // Function to format dates as "6th May, 2024"
        function formatDate(date) {
            const day = date.getDate();

            // Nama bulan dalam bahasa Indonesia
            const months = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];
            const month = months[date.getMonth()];
            const year = date.getFullYear();

            return day + ' ' + month + ' ' + year;
        }

        // Handle the click event for the "Review" link
        $(document).on('click', '.review-btn', function () {

            var letterNumber = $(this).data('letter-number');
            var approvalFile = $(this).data('approval-file');
            var sickFile = $(this).data('sick-file');
            var remarksAdmin = $(this).data('remarks-admin');

            console.log('sick file : ' + sickFile);
            if (approvalFile) {
                let fileUrl = "<?= base_url() ?>" + approvalFile;
                $('#approvalFileInfo').show();
                $('#approvalFileName').val(approvalFile);
                $('#approvalFileLink').attr('href', fileUrl);
            } else {
                $('#approvalFileInfo').hide();
                $('#approvalFileName').val('');
                $('#approvalFileLink').attr('href', '#');
            }

            if (sickFile) {
                let fileUrl = "<?= base_url() ?>" + sickFile;
                $('#sickFileInfo').show();
                $('#sickFileName').val(sickFile);
                $('#sickFileLink').attr('href', fileUrl);
            } else {
                $('#sickFileInfo').hide();
                $('#sickFileName').val('');
                $('#sickFileLink').attr('href', '#');
            }

            // Isi nomor surat kalau ada
            if (letterNumber) {
                $('#letterNumber').val(letterNumber);
            } else {
                $('#letterNumber').val(''); // kosongkan kalau null
            }

            $('#remarks_admin').val(remarksAdmin);


            // Get the data attributes from the clicked link
            var leaveType = $(this).data('leave-type');
            var reason = $(this).data('leave-reason');
            var remaing = $(this).data('leave-remaing');
            var requestedDays = $(this).data('requested-days');
            var staff = $(this).data('leave-staff');
            var leaveStatus = $(this).data('leave-status');
            var leaveId = $(this).data('leave-id');
            var startDate = new Date($(this).data('start-date'));
            var endDate = new Date($(this).data('expiry-date'));
            var submissionDate = new Date($(this).data('submission-date'));
            var reviewer = '<?php
            $first = $this->session->userdata('first_name') ?? '';
            $middle = $this->session->userdata('middle_name') ?? '';
            $last = $this->session->userdata('last_name') ?? '';
            echo trim($first . ' ' . $middle . ' ' . $last);


            ?>';

            // Map leave status strings to numeric values
            var statusMap = {
                "Pending Admin Approval": 0,
                "Rejected by Admin": 1,
                "Forwarded to Kepala": 2,
                "Rejected by Kepala": 3,
                "Approved": 4,
                "Cancelled": 5,
                "Recalled": 6
            };

            // Convert the string leave status to its corresponding numeric value
            var leaveStatusValue = statusMap[leaveStatus];

            // Populate the modal with the data
            $('#modalLeaveType').text(leaveType);
            $('#modalRequester').text(staff);
            $('#modalReviewer').text(reviewer);
            $('#modalRequestedDays').text(requestedDays);
            $('#modalRemaing').text(remaing);
            $('#modalLeaveStatus').text(leaveStatus);
            $('#modalLeaveId').text(leaveId);

            $('.leave-id').val(leaveId);

            // Clear previous radio buttons
            $('#radioButtonsContainer').empty();

            var today = new Date();

            console.log("COMPARE: " + (today < startDate) + startDate + today);
            console.log("COMPARE: " + endDate);

            var formattedSubmissionDate = formatDate(submissionDate);
            var formattedStartDate = formatDate(startDate);
            var formattedEndDate = formatDate(endDate);

            switch (leaveStatus) {
                case "Pending Admin Approval":
                    $('#modalLeaveStatus').addClass('text-primary');
                    break;
                case "Rejected by Admin":
                    $('#modalLeaveStatus').addClass('text-danger');
                    break;
                case "Forwarded to Kepala":
                    $('#modalLeaveStatus').addClass('text-success');
                    break;
                case "Rejected by Kepala":
                    $('#modalLeaveStatus').addClass('text-danger');
                    break;
                case "Approved":
                    $('#modalLeaveStatus').addClass('text-success');
                    break;
                case "Cancelled":
                    $('#modalLeaveStatus').addClass('text-info');
                    break;
                case "Recalled":
                    $('#modalLeaveStatus').addClass('text-warning');
                    break;
                default:
                    // Default color or handling if status is not recognized
                    break;
            }

            var modalMessage;
            switch (leaveStatusValue) {
                case 0: // Pending Admin Approval
                    if (today > endDate) {
                        modalMessage = "Permohonan cuti yang diajukan oleh <b>" + staff + "</b> on <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> is pending, but the requested leave period has already passed. It is too late to approve or reject this request.";
                    } else {
                        modalMessage = "Anda akan meninjau permohonan cuti yang masih menunggu persetujuan yang diajukan oleh <b>" + staff + "</b> pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b>. Mohon periksa rincian dengan teliti dan tentukan apakah permintaan tersebut disetujui atau ditolak.";
                    }
                    break;
                case 1: // Rejected by Admin
                    modalMessage = "Permohonan cuti yang diajukan oleh <b>" + staff + "</b> pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> has been rejected by admin";
                    break;
                case 2: // Forwarded to Kepala
                    modalMessage = "Permohonan cuti yang diajukan oleh <b>" + staff + "</b> pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> forwarder to kepala";
                    break;
                case 3: // Rejected by Kepala
                    modalMessage = "Permohonan cuti yang diajukan oleh <b>" + staff + "</b> pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> has been rejected by Kepala";
                    break;
                case 4: // Approved
                    if (today < startDate) {
                        modalMessage = "Permohonan cuti yang diajukan oleh <b>" + staff + "</b> pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> telah disetujui. Anda dapat memilih untuk menarik kembali persetujuan tersebut jika diperlukan.";
                    } else if (today >= startDate && today <= endDate) {
                        modalMessage = "Permohonan cuti yang diajukan oleh <b>" + staff + "</b> pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> telah disetujui.";
                    } else {
                        modalMessage = "Permohonan cuti yang diajukan oleh <b>" + staff + "</b> pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> telah diselesaikan.";
                    }
                    break;
                case 5: // Cancelled
                    modalMessage = "Permohonan cuti yang diajukan oleh <b>" + staff + "</b> pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> telah dibatalkan.";
                    break;
                case 6: // Recalled
                    modalMessage = "Permohonan cuti yang disetujui dan diajukan oleh <b>" + staff + "</b> pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> telah ditarik kembali.";
                    break;
                default:
                    modalMessage = "Anda akan meninjau permohonan cuti yang diajukan oleh <b>" + staff + "</b> pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b>.Harap tinjau detailnya dengan saksama dan putuskan apakah akan menyetujui atau menolak permohonan tersebut.";
            }
            $('#modalMessage').html(modalMessage);

            // Determine if options should be shown based pada leave status and dates
            if (leaveStatusValue === 0) { // Pending Admin Approval
                if (today <= endDate) {
                    $('#radioButtonsContainer').append(`
                        <select name="select" id="select" class="form-control form-control-primary">
                            <option value="0" selected>Pending Admin Approval</option>
                            <option value="1">Rejected by Admin</option>
                            <option value="2">Forwarded to Kepala</option>
                            <option value="3">Rejected by Kepala</option>
                            <option value="4">Approved</option>
                            <option value="5">Cancelled</option>
                            <option value="6">Recalled</option>
                        </select>
                    `);
                } else {
                    $('#radioButtonsContainer').append(`
                        <select name="select" id="select" class="form-control form-control-primary" disabled>
                            <option value="0" selected>Pending Admin Approval</option>
                        </select>
                    `);
                }
            } else if (leaveStatusValue === 4) { // Approved
                if (today < startDate || (today >= startDate && today <= endDate)) {
                    $('#radioButtonsContainer').append(`
                        <select name="select" id="select" class="form-control form-control-primary">
                            <option value="4" selected>Approved</option>
                            <option value="6">Recalled</option>
                        </select>
                    `);
                } else {
                    $('#radioButtonsContainer').append(`
                        <select name="select" id="select" class="form-control form-control-primary" disabled>
                            <option value="4" selected>Approved</option>
                        </select>
                    `);
                }
            } else if (leaveStatusValue === 5) { // Cancelled
                if (today < startDate) {
                    $('#radioButtonsContainer').append(`
                        <select name="select" id="select" class="form-control form-control-primary">
                            <option value="5" selected>Cancelled</option>
                            <option value="0">Pending Admin Approval</option>
                        </select>
                    `);
                } else {
                    $('#radioButtonsContainer').append(`
                        <select name="select" id="select" class="form-control form-control-primary" disabled>
                           <option value="5" selected>Cancelled</option>
                        </select>
                    `);
                }
            }
            else if (leaveStatusValue === 2) { // Forwarded to Kepala
                if (today < startDate) {
                    $('#radioButtonsContainer').append(`
                        <select name="select" id="select" class="form-control form-control-primary">
                            <option value="2" selected>Forwarded to Kepala</option>
                            <option value="3">Rejected by Kepala</option>
                            <option value="4">Approved</option>
                            <option value="5">Cancelled</option>
                            <option value="6">Recalled</option>
                        </select>
                    `);
                } else {
                    $('#radioButtonsContainer').append(`
                        <select name="select" id="select" class="form-control form-control-primary" disabled>
                           <option value="2" selected>Forwarded to Kepala</option>
                        </select>
                    `);
                }
            }
            // No options for Rejected (4) or Recalled (3)
            else {
                $('#radioButtonsContainer').append(`
                    <select name="select" id="select" class="form-control form-control-primary" disabled>
                        <option value="${leaveStatusValue}" selected>${leaveStatus}</option>
                    </select>
                `);
            }

            // Update the button based on the status and date
            var updateButtonHTML;
            if (leaveStatusValue === 0) { // Pending
                if (today > endDate) {
                    updateButtonHTML = '<button type="button" class="btn btn-disabled btn-md btn-block waves-effect text-center status-update" disabled>This request was <b style="color: #eb3422;"> PASSED </b></button>';
                } else {
                    updateButtonHTML = '<button type="button" class="btn btn-primary btn-md btn-block waves-effect text-center status-update">Update</button>';
                }
            }
            else if (leaveStatusValue === 1) { // Rejected by Admin
                updateButtonHTML = '<button type="button" class="btn btn-disabled btn-md btn-block waves-effect text-center status-update" disabled>This request was <b style="color: #eb3422;"> REJECTED BY ADMIN </b></button>';
            }
            else if (leaveStatusValue === 2) { // Forwarded to Kepala
                if (today >= startDate && today <= endDate) {
                    updateButtonHTML = '<button type="button" class="btn btn-primary btn-md btn-block waves-effect text-center status-update">Update</button>';
                } else if (today < startDate) {
                    updateButtonHTML = '<button type="button" class="btn btn-primary btn-md btn-block waves-effect text-center status-update">Update</button>';
                } else {
                    updateButtonHTML = '<button type="button" class="btn btn-disabled btn-md btn-block waves-effect text-center status-update" disabled>This request has <b style="color: #eb3422;"> EXPIRED </b></button>';
                }
            }
            else if (leaveStatusValue === 3) { // Rejected by Kepala
                updateButtonHTML = '<button type="button" class="btn btn-disabled btn-md btn-block waves-effect text-center status-update" disabled>This request was <b style="color: #eb3422;"> REJECTED BY KEPALA </b></button>';
            }
            else if (leaveStatusValue === 4) { // Approved
                if (today >= startDate && today <= endDate) {
                    updateButtonHTML = '<button type="button" class="btn btn-primary btn-md btn-block waves-effect text-center status-update">Update</button>';
                } else if (today < startDate) {
                    updateButtonHTML = '<button type="button" class="btn btn-primary btn-md btn-block waves-effect text-center status-update">Update</button>';
                } else {
                    updateButtonHTML = '<button type="button" class="btn btn-disabled btn-md btn-block waves-effect text-center status-update" disabled>This request has <b style="color: #eb3422;"> EXPIRED </b></button>';
                }
            } else if (leaveStatusValue === 5) { // Cancelled
                if (today < startDate) {
                    updateButtonHTML = '<button type="button" class="btn btn-primary btn-md btn-block waves-effect text-center status-update">Update</button>';
                } else {
                    updateButtonHTML = '<button type="button" class="btn btn-disabled btn-md btn-block waves-effect text-center status-update" disabled>This request was <b style="color: #eb3422;"> CANCELLED </b></button>';
                }
            }
            else if (leaveStatusValue === 6) { // Recalled
                updateButtonHTML = '<button type="button" class="btn btn-disabled btn-md btn-block waves-effect text-center status-update" disabled>This request was <b style="color: #eb3422;"> RECALLED </b></button>';
            }

            // Update the button in the modal
            $('.row.m-t-15 .col-md-12').html(updateButtonHTML);

            function performInitialCheck() {
                var stat = $('#select').val();
                console.log("COMPARE: " + stat);
                // Kalau statusnya Approved (4), biarkan tombol selalu aktif
                if (leaveStatusValue == 4) {
                    $('.status-update').prop('disabled', false).removeClass('btn-disabled').addClass('btn-primary');
                } else {
                    // Bandingkan status asli dengan pilihan select
                    if (leaveStatusValue == stat) {
                        $('.status-update').prop('disabled', true).removeClass('btn-primary').addClass('btn-disabled');
                    } else {
                        $('.status-update').prop('disabled', false).removeClass('btn-disabled').addClass('btn-primary');
                    }
                }
            }

            // Set the initial value of the select element based on data from the database
            $('#select').val(leaveStatusValue);

            // Perform the initial check
            performInitialCheck();

            // Attach change event handler to perform the check whenever the select value changes
            $('#select').change(performInitialCheck);

        });
    });
</script>