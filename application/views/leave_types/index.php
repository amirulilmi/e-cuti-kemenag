<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Tipe Cuti</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="button"
                                class="btn btn-primary waves-effect waves-light f-right d-inline-block"
                                data-toggle="modal" data-target="#modalleavetype">
                                <i class="icofont icofont-plus m-r-5"></i> Tambah Tipe Cuti
                            </button>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="contacts" role="tabpanel">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-block contact-details">
                                                <div class="data_table_main table-responsive dt-responsive">
                                                    <table id="simpletable"
                                                        class="table table-striped table-bordered nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Tipe Cuti</th>
                                                                <th>Durasi Cuti</th>
                                                                <th>Perbolehkan Sabtu</th>
                                                                <th>Perbolehkan Minggu</th>
                                                                <th>Deskripsi</th>
                                                                <th>Status</th>
                                                                <th>Created</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($leave_types)):
                                                                $count = 1; ?>
                                                                <?php foreach ($leave_types as $row): ?>
                                                                    <tr>
                                                                        <td><?= $count++; ?></td>
                                                                        <td><span
                                                                                style="font-weight: 600;"><?= $row['leave_type']; ?></span>
                                                                        </td>
                                                                        <td><?= $row['assign_days']; ?></td>
                                                                        <td>
                                                                            <?php if ($row['leave_allowsat'] == 1): ?>
                                                                                <span
                                                                                    style="color: green; font-weight: 600;">Ya</span>
                                                                            <?php else: ?>
                                                                                <span
                                                                                    style="color: red; font-weight: 600;">Tidak</span>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if ($row['leave_allowsun'] == 1): ?>
                                                                                <span
                                                                                    style="color: green; font-weight: 600;">Ya</span>
                                                                            <?php else: ?>
                                                                                <span
                                                                                    style="color: red; font-weight: 600;">Tidak</span>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td><?= $row['description']; ?></td>
                                                                        <td>
                                                                            <?php if ($row['status'] == 1): ?>
                                                                                <span
                                                                                    style="color: green; font-weight: 600;">Active</span>
                                                                            <?php else: ?>
                                                                                <span
                                                                                    style="color: red; font-weight: 600;">Inactive</span>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td><?= date("jS F, Y - H:i", strtotime($row['creation_date'])); ?>
                                                                        </td>
                                                                        <td class="action-icon">
                                                                            <a href="#" data-modal="modalleavetype"
                                                                                class="m-r-15 text-muted edit-btn md-trigger"
                                                                                data-id="<?= $row['id']; ?>"
                                                                                data-name="<?= $row['leave_type']; ?>"
                                                                                data-description="<?= $row['description']; ?>"
                                                                                data-assigned="<?= $row['assign_days']; ?>"
                                                                                data-status="<?= $row['status']; ?>"
                                                                                data-leave_allowsat="<?= $row['leave_allowsat']; ?>"
                                                                                data-leave_allowsun="<?= $row['leave_allowsun']; ?>">

                                                                                <i class="icofont icofont-ui-edit"></i>
                                                                            </a>
                                                                            <a href="#" class="delete-btn text-muted"
                                                                                data-id="<?= $row['id']; ?>">
                                                                                <i class="icofont icofont-ui-delete"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr>
                                                                    <td colspan="7" class="text-center">
                                                                        <img src="<?= base_url('files/assets/images/no_data.png'); ?>"
                                                                            class="img-radius" alt="No Data Found"
                                                                            style="width: 200px; height: auto;">
                                                                    </td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Contact Start Model start-->
        <!-- Modal -->
        <div class="modal fade" id="modalleavetype" tabindex="-1" role="dialog" aria-labelledby="modalleavetypeLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 400px;">
                <div class="modal-content " style="border-radius: 10px; overflow: hidden;border: none;">
                    <!-- Modal Header -->
                    <div class="modal-header"
                        style="background-color: #01a9ac; color: #fff; border-top-left-radius: .3rem; border-top-right-radius: .3rem;">
                        <h5 class="modal-title" id="modalleavetypeLabel">Tambah Tipe Cuti</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color: #fff; opacity: 1;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form id="formLeaveType">
                            <input hidden type="text" class="form-control id" name="id" id="id"
                                placeholder="Leave Type">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-bank-alt"></i></span>
                                <input type="text" class="form-control dname" name="dname" placeholder="Tipe Cuti">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icofont icofont-social-ebuddy"></i></span>
                                <input type="text" class="form-control assigned" name="assigned"
                                    placeholder="Durasi Hari Cuti">
                            </div>

                            <div class="input-group">
                                <textarea class="form-control description" name="description"
                                    placeholder="Masukkan Deskripsi disini" spellcheck="false" rows="5"></textarea>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label>Perbolehkan Cuti Hari Sabtu</label>
                                    <div class="form-radio">
                                        <div class="radio radiofill radio-inline">
                                            <label>
                                                <input type="radio" class="leave_allowsat" name="leave_allowsat" value="1">
                                                <i class="helper"></i>Ya
                                            </label>
                                        </div>
                                        <div class="radio radiofill radio-inline">
                                            <label>
                                                <input type="radio" class="leave_allowsat" name="leave_allowsat" value="0">
                                                <i class="helper"></i>Tidak
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label>Perbolehkan Cuti Hari Minggu</label> 
                                    <div class="form-radio">
                                        <div class="radio radiofill radio-inline">
                                            <label>
                                                <input type="radio" class="leave_allowsun" name="leave_allowsun" value="1">
                                                <i class="helper"></i>Ya
                                            </label>
                                        </div>
                                        <div class="radio radiofill radio-inline">
                                            <label>
                                                <input type="radio" class="leave_allowsun" name="leave_allowsun" value="0">
                                                <i class="helper"></i>Tidak
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label>Status Cuti</label> <!-- Label tambahan -->
                                    <div class="form-radio">
                                        <div class="radio radiofill radio-inline">
                                            <label>
                                                <input type="radio" class="status" name="status" value="1">
                                                <i class="helper"></i>Active
                                            </label>
                                        </div>
                                        <div class="radio radiofill radio-inline">
                                            <label>
                                                <input type="radio" class="status" name="status" value="2">
                                                <i class="helper"></i>Inactive
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" id="save-btn" form="formLeaveType" class="btn"
                            style="background-color:#01a9ac; color:#fff;">Simpan</button>
                        <button type="submit" id="update-btn" form="formLeaveType" class="btn"
                            style="background-color:#01a9ac; color:#fff; display:none;">Update</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Contact Ends Model end-->


        <script type="text/javascript">
            // SAVE
            $('#save-btn').click(function (event) {
                event.preventDefault();
                var data = {
                    dname: $('.dname').val(),
                    description: $('.description').val(),
                    assigned: $('.assigned').val(),
                    status: $('input[name="status"]:checked').val(),
                    leave_allowsat: $('input[name="leave_allowsat"]:checked').val(),
                    leave_allowsun: $('input[name="leave_allowsun"]:checked').val(),
                    action: "save",
                };
                if (!data.dname.trim() || !data.description.trim() || !data.assigned.trim() || !data.status.trim()) {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Please all fields are required. Kindly fill all',
                        confirmButtonColor: '#ffc107',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                $.post('<?= site_url("Leave_type/save") ?>', data, function (response) {
                    response = JSON.parse(response);
                    if (response.status == 'success') {
                        $('#modalleavetype').modal('hide'); // tutup modal dulu
                        Swal.fire({
                            icon: 'success',
                            title: 'Created Successfully',
                            html: 'Tipe Cuti<b> ' + data['dname'] + ' </b>berhasil ditambahkan',
                            confirmButtonColor: '#01a9ac'
                        }).then(() => {
                            $('#modalleavetype').modal('hide');
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: response.message,
                            confirmButtonColor: '#eb3422'
                        });
                    }
                });
            });

            // EDIT
            $('.edit-btn').click(function () {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var description = $(this).data('description');
                var assigned = $(this).data('assigned');
                var status = $(this).data('status');
                var leave_allowsat = $(this).data('leave_allowsat');
                var leave_allowsun = $(this).data('leave_allowsun');
                // console.log('ini dia');
                // console.log(allowsat, allowsun);

                $('#modalleavetype .id').val(id);
                $('#modalleavetype .dname').val(name);
                $('#modalleavetype .assigned').val(assigned);
                $('#modalleavetype .description').val(description);
                $('#modalleavetype .status[value="' + status + '"]').prop('checked', true);
                $('#modalleavetype .leave_allowsat[value="' + leave_allowsat + '"]').prop('checked', true);
                $('#modalleavetype .leave_allowsun[value="' + leave_allowsun + '"]').prop('checked', true);

                $('#save-btn').hide();
                $('#update-btn').show();

                $('#modalleavetype').modal('show');
            });

            // UPDATE
            $('#update-btn').click(function (event) {
                event.preventDefault();
                var data = {
                    id: $('.id').val(),
                    dname: $('.dname').val(),
                    description: $('.description').val(),
                    assigned: $('.assigned').val(),
                    status: $('input[name="status"]:checked').val(),
                    leave_allowsat: $('input[name="leave_allowsat"]:checked').val(),
                    leave_allowsun: $('input[name="leave_allowsun"]:checked').val(),
                    action: "update",
                };
                if (!data.dname.trim() || !data.description.trim() || !data.assigned.trim() || !data.status.trim()) {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Please all fields are required. Kindly fill all',
                        confirmButtonColor: '#ffc107'
                    });
                    return;
                }
                $.post('<?= site_url("Leave_type/update") ?>', data, function (response) {
                    response = JSON.parse(response);
                    if (response.status == 'success') {
                        $('#modalleavetype').modal('hide'); // tutup modal dulu
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated Successfully',
                            html: 'Tipe Cuti<b> ' + data['dname'] + '</b> berhasil diubah',
                            confirmButtonColor: '#01a9ac'
                        }).then(() => {
                            $('#modalleavetype').modal('hide');
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: response.message,
                            confirmButtonColor: '#eb3422'
                        });
                    }
                });
            });

            // DELETE
            $('.delete-btn').click(function () {
                var id = $(this).data("id");
                Swal.fire({
                    title: 'Hapus Tipe Cuti?',
                    text: "Data tipe cuti ini akan dihapus secara permanen.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post('<?= site_url("Leave_type/delete") ?>', { id: id, action: "delete" }, function (response) {
                            var res = JSON.parse(response);
                            if (res.status === 'success') {
                                Swal.fire('Deleted!', 'Tipe Cuti berhasil dihapus', 'success')
                                    .then(() => location.reload());
                            } else {
                                Swal.fire('Error!', 'Failed to delete leave type.', 'error');
                            }
                        }).fail(function () {
                            Swal.fire('Error!', 'Failed to delete leave type.', 'error');
                        });
                    }
                });
            });


        </script>