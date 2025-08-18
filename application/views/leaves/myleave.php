<!-- Main-body start -->
<div class="main-body" id="main-body">
    <div class="page-wrapper" id="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header" id="pageHeader">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>E-Cuti-Kemenag - Cuti Saya</h4>
                            <span>Verifikasi dan berikan respons terhadap permintaan cuti</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <!-- My leave start -->
                <div class="card col-xl-12 col-md-12">
                    <div class="card-header">
                        <h5>Ringkasan Permintaan Cuti <?php echo $leaveTypeCount; ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row card-block">
                        <?php if (!empty($leaveSummary)): ?>
                            <!-- My leave type start -->
                            <?php foreach ($leaveSummary as $leaveTypeId => $summary): ?>
                                <div class="col-xl-4 col-md-12">
                                    <div class="card statustic-card">
                                        <div class="card-header">
                                            <h5 class="mb-0 d-flex align-items-center font-weight-bold" style="font-size:60px !important;">
                                                <span style="font-size:20px !important;color:#303548"><?= htmlspecialchars($summary['type']) ?></span>
                                                <span class="text-primary f-30 ml-2">
                                                    <?= ': ' .$summary['total_awal']. ' (n) ' ?>
                                                </span>
                                                <span class="text-warning f-30 ml-2">
                                                    <?= ' + ' . $summary['n1']. ' (n1) ' ?>
                                                </span>
                                                <span class="text-success f-30 ml-2">
                                                    <?= ' + ' . $summary['n2']. ' (n2) ' ?>
                                                </span>
                                            </h5>
                                        </div>
                                        <div class="card-block text-center">
                                            <div class="row">
                                                <div class="col">
                                                    <span class="d-block text-c-blue f-30"
                                                        style="font-weight: bold;"><?= $summary['total'] ?></span>

                                                    <p class="m-b-0 text-c-blue">Total</p>
                                                </div>
                                                <div class="col">
                                                    <span class="d-block text-c-green f-30"
                                                        style="font-weight: bold;"><?= $summary['remaining'] ?></span>
                                                    <p class="m-b-0 text-c-green">Sisa Jatah Cuti</p>
                                                </div>
                                                <div class="col">
                                                    <span class="d-block text-c-pink f-30"
                                                        style="font-weight: bold;"><?= $summary['used'] ?></span>
                                                    <p class="m-b-0 text-c-pink">Digunakan</p>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-c-blue"
                                                    style="width: <?= ($summary['total'] > 0 ? ($summary['used'] / $summary['total'] * 100) : 0) ?>%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <!-- My leave type end -->
                        <?php else: ?>
                            <div class="col-12 text-center">
                                <div class="alert" style="color: #0c5460; background-color: #d1ecf1; border-color: #bee5eb;"
                                    role="alert">
                                    <i class="fa fa-info-circle fa-3x"></i>
                                    <p class="m-b-0">Ringkasan permintaan cuti tidak tersedia</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- My leave end -->

                <div class="col-xl-12 col-md-12 filter-bar">
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
                                    <i class="icofont icofont-home"></i> <?php echo $selectedLeaveStatusName; ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="bystatus">
                                    <a class="dropdown-item <?php echo ($selectedLeaveStatusName === 'Show all') ? 'active' : ''; ?>"
                                        href="?leave_status=Show all">Show all</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item <?php echo ($selectedLeaveStatusName === 'Pending Admin Approval') ? 'active' : ''; ?>"
                                        href="?leave_status=0">Pending Admin Approval</a>
                                    <a class="dropdown-item <?php echo ($selectedLeaveStatusName === 'Rejected by Admin') ? 'active' : ''; ?>"
                                        href="?leave_status=1">Rejected by Admin</a>
                                    <a class="dropdown-item <?php echo ($selectedLeaveStatusName === 'Forwarded to Kepala') ? 'active' : ''; ?>"
                                        href="?leave_status=2">Forwarded to Kepala</a>
                                    <a class="dropdown-item <?php echo ($selectedLeaveStatusName === 'Rejected by Kepala') ? 'active' : ''; ?>"
                                        href="?leave_status=3">Rejected by Kepala</a>
                                    <a class="dropdown-item <?php echo ($selectedLeaveStatusName === 'Approved') ? 'active' : ''; ?>"
                                        href="?leave_status=4">Approved</a>
                                    <a class="dropdown-item <?php echo ($selectedLeaveStatusName === 'Cancelled') ? 'active' : ''; ?>"
                                        href="?leave_status=5">Cancelled</a>
                                    <a class="dropdown-item <?php echo ($selectedLeaveStatusName === 'Recalled') ? 'active' : ''; ?>"
                                        href="?leave_status=6">Recalled</a>

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
                <div id="leaveMain" class="col-xl-12 col-md-12">
                    <div id="leaveContainer" class="job-card card-columns">
                        <!-- Populate it from leave_functions.php -->
                    </div>
                </div>
                <!-- Detailed Leave start -->
                <div id="detailed-leave" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="login-card card-block login-card-modal">
                            <form class="md-float-material">
                                <div class="card m-t-15">
                                    <div class="auth-box card-block">
                                        <div class="row m-b-20">
                                            <div class="col-md-12 confirm">
                                                <h3 class="text-center txt-primary"><i
                                                        class="icofont icofont-check-circled text-primary"></i> Detail
                                                    Pengajuan Cuti</h3>
                                            </div>
                                        </div>
                                        <input hidden type="text" class="form-control leave-id" name="leave-id">
                                        <p class="text-inverse text-left m-t-15 f-16"><b>Halo <span
                                                    id="modalReviewer"></span></b>, </p>
                                        <p id="modalMessage" class="text-inverse text-left m-b-20"></p>
                                        <ul class="text-inverse text-left">
                                            <li><strong>Tipe Cuti: </strong> <span id="modalLeaveType"></span></li>
                                            <li><strong>Total Hari Cuti diajukan: </strong> <span
                                                    id="modalRequestedDays"></span>
                                            </li>
                                            <li><strong>Sisa Jatah Cuti: </strong> <span id="modalRemaing"></span></li>
                                            <li><strong>Status: </strong> <span id="modalLeaveStatus"></span></li>
                                        </ul>


                                        <div class="card-block">

                                            <!-- New input for Letter Number -->
                                            <div class="row mb-3 mt-0">
                                                <label for="letterNumber"><strong>No Surat (Admin)</strong></label>
                                                <input type="text" class="form-control" id="letterNumber"
                                                    name="letterNumber" placeholder="Masukkan Nomor Surat dari Admin"
                                                    disabled>
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
                                                    <input type="text" class="form-control" id="approvalFileName"
                                                        readonly>
                                                    <a id="approvalFileLink" href="#" target="_blank"
                                                        class="btn btn-sm btn-info ml-3">Lihat File</a>
                                                </div>
                                            </div>
                                            <label class="m-l-0 p-l-0" style="margin-left:-14px"
                                                for="st"><strong>Status</strong></label>
                                            <div class="row" id="radioButtonsContainer">
                                                <!-- options will be dynamically inserted here -->
                                            </div>

                                        </div>
                                        <div class="row m-t-15">
                                            <div class="col-md-12">
                                                <button type="button"
                                                    class="btn btn-primary btn-md btn-block waves-effect text-center">Update</button>
                                            </div>
                                        </div>
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
                <!-- Detailed Leave end-->
            </div>
        </div>
        <!-- Page-body end -->
    </div>
    <div id="styleSelector"></div>
</div>

<div id="userIdCust" data-user-id="<?= isset($userIdCust) ? $userIdCust : '' ?>"></div>

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

<!-- FETCH DATA -->
<script type="text/javascript">
    $(document).ready(function () {
        // Retrieve the initial department filter value
        var selectedStatus = $(".dropdown-menu .dropdown-item.active").attr("href").split("leave_status=")[1];
        // Function to fetch and display the filtered staff
        console.log('RESPONSE HERE: ' + selectedStatus);

        var userIdCust = $('#userIdCust').data('user-id') || null;
        if (userIdCust) {
            $('#pageHeader').fadeOut('slow'); // sembunyikan dengan efek fade
            $('#main-body').css('margin-top', '-60px');
        }
        console.log('RESPONSE userIdCust: ' + userIdCust);
        function fetchStaff() {
            var searchQuery = $('#searchInput').val(); // Get the search query
            var leaveStatusFilter = (selectedStatus === 'Show all') ? '' : selectedStatus; // Get the selectedStatus filter value
            // Make an AJAX request to fetch the filtered staff
            $.ajax({
                url: '<?= base_url('Leave/fetchStaff') ?>' + (userIdCust ? '/' + userIdCust : ''),
                type: 'POST',
                data: { searchQuery: searchQuery, leaveStatusFilter: leaveStatusFilter },

                success: function (response) {
                    // Clear the existing staff cards
                    $('#leaveContainer').empty();

                    console.log('RESPONSE HERE: ' + response);

                    // Append the fetched staff cards to the container
                    if (response.includes('files/assets/images/no_data.png')) {
                        console.log('No data image found in the response.');

                        // Set the class of the id leaveMain to be col-sm-12
                        $('#leaveMain').removeClass().addClass('col-sm-12');

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

            // console.log('sick file : ' + sickFile);
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
            echo $this->session->userdata("first_name") . " " .
                $this->session->userdata("middle_name") . " " .
                $this->session->userdata("last_name");
            ?>';

            // Map leave status strings to numeric values
            var statusMap = {
                "Pending Admin Approval": 0,
                "Rejected by Admin": 1,
                "Forwarded to Kepala": 2,
                "Rejected by Kepala": 3,
                "Approved": 4,
                "Cancelled": 5,
                "Recalled": 6,
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
                    $('#modalLeaveStatus').addClass('text-warning');
                    break;
                case "Recalled":
                    $('#modalLeaveStatus').addClass('text-info');
                    break;
                default:
                    // Default color or handling if status is not recognized
                    break;
            }

            var modalMessage;
            switch (leaveStatusValue) {
                case 0: // Pending Admin Approval
                    if (today > endDate) {
                        modalMessage = "Pengajuan cuti Anda diajukan pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> Masih menunggu, tetapi periode cuti yang diajukan sudah lewat. Terlalu terlambat untuk menyetujui atau menolak permintaan ini.";
                    } else {
                        modalMessage = "Pengajuan cuti Anda yang belum diproses, diajukan pada  <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b>. Silakan mengingatkan atasan Anda jika pengajuan cuti ini memerlukan waktu lama untuk ditinjau.";
                    }
                    break;
                case 1: // Rejected by Admin
                    modalMessage = "Pengajuan cuti Anda diajukan pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> telah ditolak oleh admin.";
                    break;
                case 2: // Forwarded to Kepala
                    modalMessage = "Pengajuan cuti Anda diajukan pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> telah diteruskan ke kepala.";
                    break;
                case 3: // Rejected by Kepala
                    modalMessage = "Pengajuan cuti Anda diajukan pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> telah ditolak oleh kepala.";
                    break;
                case 4: // Approved
                    if (today < startDate) {
                        modalMessage = "Pengajuan cuti Anda diajukan pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> Telah disetujui. Anda dapat menarik persetujuan ini jika diperlukan.";
                    } else if (today >= startDate && today <= endDate) {
                        modalMessage = "Pengajuan cuti Anda diajukan pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> masih dalam proses.";
                    } else {
                        modalMessage = "Pengajuan cuti Anda diajukan pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> telah selesai.";
                    }
                    break;
                case 5: // Cancelled
                    modalMessage = "Pengajuan cuti Anda diajukan pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> telah dibatalkan.";
                    break;
                case 6: // Recalled
                    modalMessage = "Pengajuan cuti yang disetujui, diajukan pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b> telah ditarik kembali.";
                    break;
                default:
                    modalMessage = "Anda akan meninjau pengajuan cuti yang diajukan pada <b>" + formattedSubmissionDate + "</b> untuk periode dari <b>" + formattedStartDate + "</b> sampai <b>" + formattedEndDate + "</b>. Harap tinjau detailnya dengan cermat dan tentukan apakah permintaan ini disetujui atau ditolak.";
            }
            $('#modalMessage').html(modalMessage);

            // Determine if options should be shown based on leave status and dates
            if (leaveStatusValue === 0) { // Pending
                if (today <= endDate) {
                    $('#radioButtonsContainer').append(`
                            <select name="select" id="select" class="form-control form-control-primary">
                                <option value="0" selected>Pending Admin Approval</option>
                                <option value="5">Cancelled</option>
                            </select>
                        `);
                } else {
                    $('#radioButtonsContainer').append(`
                            <select name="select" id="select" class="form-control form-control-primary" disabled>
                                <option value="0" selected>Pending Admin Approval</option>
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
            if (leaveStatusValue === 0) { // Pending Admin Approval
                if (today > endDate) {
                    updateButtonHTML = '<button type="button" class="btn btn-disabled btn-md btn-block waves-effect text-center status-update" disabled>This request was <b style="color: #eb3422;"> PASSED </b></button>';
                } else {
                    updateButtonHTML = '<button type="button" class="btn btn-primary btn-md btn-block waves-effect text-center status-update">Update</button>';
                }
            }
            else if (leaveStatusValue === 1) { // Rejected by Admin
                updateButtonHTML = '<button type="button" class="btn btn-disabled btn-md btn-block waves-effect text-center status-update" disabled>This request was <b style="color: #eb3422;"> REJECTED </b></button>';

            } else if (leaveStatusValue === 2) { // Forwarded to Kepala
                if (today >= startDate && today <= endDate) {
                    updateButtonHTML = '<button type="button" class="btn btn-primary btn-md btn-block waves-effect text-center status-update">Update</button>';
                } else if (today < startDate) {
                    updateButtonHTML = '<button type="button" class="btn btn-primary btn-md btn-block waves-effect text-center status-update">Update</button>';
                } else {
                    updateButtonHTML = '<button type="button" class="btn btn-disabled btn-md btn-block waves-effect text-center status-update" disabled>This request has <b style="color: #eb3422;"> EXPIRED </b></button>';
                }
            }
            else if (leaveStatusValue === 3) { // Rejected by Kepala
                updateButtonHTML = '<button type="button" class="btn btn-disabled btn-md btn-block waves-effect text-center status-update" disabled>This request was <b style="color: #eb3422;"> REJECTED </b></button>';
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
            } else if (leaveStatusValue === 6) { // Recalled
                updateButtonHTML = '<button type="button" class="btn btn-disabled btn-md btn-block waves-effect text-center status-update" disabled>This request was <b style="color: #eb3422;"> RECALLED </b></button>';
            }

            // Update the button in the modal
            $('.row.m-t-15 .col-md-12').html(updateButtonHTML);

            function performInitialCheck() {
                var stat = $('#select').val();
                console.log("COMPARE: " + stat);
                // Compare leaveStatusValue with the selected option value (stat)
                if (leaveStatusValue == stat) {
                    // If they are the same, disable the update button
                    $('.status-update').prop('disabled', true).removeClass('btn-primary').addClass('btn-disabled');
                } else {
                    // If they are different, enable the update button
                    $('.status-update').prop('disabled', false).removeClass('btn-disabled').addClass('btn-primary');
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

<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
</script>