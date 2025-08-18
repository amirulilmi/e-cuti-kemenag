<!-- Main content -->
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Unit Kerja</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= site_url('dashboard') ?>"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Unit Kerja</a></li>
                </ul>
            </div>
        </div>

        <!-- Add Department Button -->
        <div class="text-right m-b-20">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addModal"><i
                    class="icofont icofont-plus m-r-5"></i> Tambah Unit Kerja</button>
        </div>

        <div class="page-body">
            <div class="row">
                <?php foreach ($departments as $department): ?>
                    <div class="col-md-12 col-xl-6">
                        <div class="card app-design">
                            <div class="card-block">
                                <div class="f-right">
                                    <div class="dropdown-secondary dropdown">
                                        <button class="btn btn-primary btn-mini dropdown-toggle waves-effect waves-light"
                                            type="button"
                                            data-toggle="dropdown"><?= $department['department_name'] ?></button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="<?= site_url('staff/') ?>?department=<?= urlencode($department['department_name']) ?>">View
                                                Staff</a>
                                            <a class="dropdown-item edit-btn" href="#" data-id="<?= $department['id'] ?>"
                                                data-name="<?= $department['department_name'] ?>"
                                                data-description="<?= $department['department_desc'] ?>"
                                                data-dept_allowsat="<?= $department['dept_allowsat'] ?>"
                                                data-dept_allowsun="<?= $department['dept_allowsun'] ?>">Edit</a>
                                            <a class="dropdown-item delete-btn" href="#"
                                                data-id="<?= $department['id'] ?>">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="f-w-400 text-muted"><?= $department['department_desc'] ?></h6>
                                <p class="text-c-blue f-w-400">
                                    <?= date('jS F, Y', strtotime($department['creation_date'])) ?>
                                </p>

                                <div class="design-description d-inline-block m-r-40">
                                    <h3 class="f-w-400"><?= $department['employee_count'] ?: 'No' ?></h3>
                                    <p class="text-muted">Total Staff</p>
                                </div>
                                <div class="design-description d-inline-block">
                                    <h3 class="f-w-400"><?= $department['manager_count'] ?: 'No' ?></h3>
                                    <p class="text-muted">Total Managers</p>
                                </div>

                                <div class="team-box p-b-20">
                                    <p class="d-inline-block m-r-20 f-w-400">
                                        <?= $department['employee_count'] > 0 ? 'Team' : 'No Staff' ?>
                                    </p>
                                    <div class="team-section d-inline-block">
                                        <?php
                                        $staffList = $this->Department_model->get_staff_by_department($department['id']);
                                        foreach ($staffList as $staff):
                                            $staffImage = base_url($staff['image_path']);
                                            $staffName = $staff['first_name'] . ' ' . $staff['last_name'];
                                            echo "<a href='#'><img src='{$staffImage}' title='{$staffName}' class='m-l-5'></a>";
                                        endforeach;
                                        ?>
                                    </div>
                                </div>

                                <?php
                                $staffPercentage = $totalStaff > 0 ? round(($department['employee_count'] / $totalStaff) * 100) : 0;
                                ?>
                                <div class="progress-box">
                                    <p class="d-inline-block m-r-20 f-w-400">Progress</p>
                                    <div class="progress d-inline-block">
                                        <div class="progress-bar bg-c-blue" style="width:<?= $staffPercentage ?>%">
                                            <label><?= $staffPercentage ?>%</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="addForm">
            <div class="modal-content" style="border:none">
                <div class="modal-header"
                    style="background-color: #01a9ac; color: #fff; border-top-left-radius: .3rem; border-top-right-radius: .3rem;">
                    <h5 class="modal-title">Tambah Unit Kerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color: #fff; opacity: 1;">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Unit Kerja</label>
                        <input type="text" name="department_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Unit Kerja</label>
                        <textarea name="department_desc" class="form-control" required></textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label>Perbolehkan Cuti Hari Sabtu</label> <!-- Label tambahan -->
                            <div class="form-radio">
                                <div class="radio radiofill radio-inline">
                                    <label>
                                        <input type="radio" class="allowsat" name="dept_allowsat" value="1">
                                        <i class="helper"></i>Ya
                                    </label>
                                </div>
                                <div class="radio radiofill radio-inline">
                                    <label>
                                        <input type="radio" class="allowsat" name="dept_allowsat" value="0">
                                        <i class="helper"></i>Tidak
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label>Perbolehkan Cuti Hari Minggu</label> <!-- Label tambahan -->
                            <div class="form-radio">
                                <div class="radio radiofill radio-inline">
                                    <label>
                                        <input type="radio" class="allowsun" name="dept_allowsun" value="1">
                                        <i class="helper"></i>Ya
                                    </label>
                                </div>
                                <div class="radio radiofill radio-inline">
                                    <label>
                                        <input type="radio" class="allowsun" name="dept_allowsun" value="0">
                                        <i class="helper"></i>Tidak
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="editForm">
            <input type="hidden" name="id" id="edit-id">
            <div class="modal-content" style="border:none">
                <div class="modal-header"
                    style="background-color: #01a9ac; color: #fff; border-top-left-radius: .3rem; border-top-right-radius: .3rem;">
                    <h5 class="modal-title">Edit Unit Kerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color: #fff; opacity: 1;">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Unit Kerja</label>
                        <input type="text" name="department_name" id="edit-name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Unit Kerja</label>
                        <textarea name="department_desc" id="edit-description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label>Perbolehkan Cuti Hari Sabtu</label> <!-- Label tambahan -->
                            <div class="form-radio">
                                <div class="radio radiofill radio-inline">
                                    <label>
                                        <input type="radio" class="allowsat" name="dept_allowsat" id="dept_allowsat"
                                            value="1">
                                        <i class="helper"></i>Ya
                                    </label>
                                </div>
                                <div class="radio radiofill radio-inline">
                                    <label>
                                        <input type="radio" class="allowsat" name="dept_allowsat" id="dept_allowsat"
                                            value="0">
                                        <i class="helper"></i>Tidak
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label>Perbolehkan Cuti Hari Minggu</label> <!-- Label tambahan -->
                            <div class="form-radio">
                                <div class="radio radiofill radio-inline">
                                    <label>
                                        <input type="radio" class="allowsun" name="dept_allowsun" id="dept_allowsun"
                                            value="1">
                                        <i class="helper"></i>Ya
                                    </label>
                                </div>
                                <div class="radio radiofill radio-inline">
                                    <label>
                                        <input type="radio" class="allowsun" name="dept_allowsun" id="dept_allowsun"
                                            value="0">
                                        <i class="helper"></i>Tidak
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JS for AJAX CRUD -->
<script>
    $(function () {
        // Save
        $('#addForm').on('submit', function (e) {
            e.preventDefault();

            $.post("<?= site_url('department/save') ?>", $(this).serialize(), function (res) {
                var data = JSON.parse(res);
                if (data.status === 'success') {
                    $('#addModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Unit Kerja berhasil ditambahkan.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message
                    });
                }
            });
        });

        // Edit Button
        $('.edit-btn').on('click', function () {
            $('#edit-id').val($(this).data('id'));
            $('#edit-name').val($(this).data('name'));
            $('#edit-description').val($(this).data('description'));
            // untuk radio allowsat
            $("input[name='dept_allowsat'][value='" + $(this).data('dept_allowsat') + "']").prop("checked", true);

            // untuk radio allowsun
            $("input[name='dept_allowsun'][value='" + $(this).data('dept_allowsun') + "']").prop("checked", true);
            $('#editModal').modal('show');
        });

        // Update
        $('#editForm').on('submit', function (e) {
            e.preventDefault();
            $.post("<?= site_url('department/update') ?>", $(this).serialize(), function (res) {
                var data = JSON.parse(res);
                if (data.status === 'success') {
                    $('#editModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Unit Kerja berhasil diperbarui.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message
                    });
                }
            });
        });

        // Delete
        $('.delete-btn').on('click', function () {
            if (confirm('Are you sure to delete this department?')) {
                $.post("<?= site_url('department/delete') ?>", { id: $(this).data('id') }, function (res) {
                    var data = JSON.parse(res);
                    if (data.status === 'success') {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                });
            }
        });
    });
</script>