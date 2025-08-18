<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4><?php echo isset($staff) ? 'Edit Pegawai' : 'Tambah Pegawai'; ?></h4>
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
                        <div class="card-block">
                            <div class="row">
                                <!-- Personal Details -->
                                <div class="col-sm-6 mobile-inputs">
                                    <h4 class="sub-title">Informasi Pribadi</h4>

                                    <form enctype="multipart/form-data" id="staffForm">
                                        <input type="hidden" name="edit_id" id="edit_id"
                                            value="<?php echo isset($staff['emp_id']) ? $staff['emp_id'] : ''; ?>">
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label>Foto Profil <span class="text-danger">*</span></label>
                                                <input type="file" id="image_path" name="image_path"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label>Nama Depan <span class="text-danger">*</span></label>
                                                <input type="text" id="firstname" name="firstname" class="form-control"
                                                    value="<?php echo isset($staff['first_name']) ? $staff['first_name'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="userName-2" class="block">Nama Tengah <span
                                                        class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" id="middlename" name="middlename" autocomplete="off"
                                                    class="form-control" placeholder=""
                                                    value="<?php echo isset($staff['middle_name']) ? $staff['middle_name'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="userName-2" class="block">Nama Belakang <span
                                                        class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" id="lastname" name="lastname" autocomplete="off"
                                                    class="form-control" placeholder=""
                                                    value="<?php echo isset($staff['last_name']) ? $staff['last_name'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="userName-2" class="block">No Telepon <span
                                                        class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="number" id="contact" name="contact" autocomplete="off"
                                                    class="form-control" placeholder=""
                                                    value="<?php echo isset($staff['phone_number']) ? $staff['phone_number'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="userName-2" class="block">Jabatan <span
                                                        class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" id="designation" name="designation"
                                                    autocomplete="off" class="form-control" placeholder=""
                                                    value="<?php echo isset($staff['designation']) ? $staff['designation'] : ''; ?>">
                                            </div>
                                        </div>
                                        <h4 class="sub-title">Jenis Kelamin <span class="text-danger">*</span></h4>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="form-radio">
                                                    <div class="radio radiofill radio-inline">
                                                        <label>
                                                            <input type="radio" name="gender" value="Female" <?php echo (isset($staff['gender']) && $staff['gender'] === 'Female') ? 'checked="checked"' : ''; ?>>
                                                            <i class="helper"></i>Perempuan
                                                        </label>
                                                    </div>
                                                    <div class="radio radiofill radio-inline">
                                                        <label>
                                                            <input type="radio" name="gender" value="Male" <?php echo (isset($staff['gender']) && $staff['gender'] === 'Male') ? 'checked="checked"' : ''; ?>>
                                                            <i class="helper"></i>Laki-laki
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- tambahkan field lainnya sesuai original -->
                                </div>

                                <!-- Company Details -->
                                <div class="col-sm-6 mobile-inputs">
                                    <h4 class="sub-title">Detail Unit Kerja</h4>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label>Unit Kerja <span class="text-danger">*</span></label>
                                            <select id="department" name="department" class="form-control">
                                                <option value="" disabled selected>Pilih Unit Kerja</option>
                                                <?php foreach ($departments as $dept): ?>
                                                    <option value="<?php echo $dept['id']; ?>" <?php echo (isset($staff['department']) && $staff['department'] == $dept['id']) ? 'selected' : ''; ?>>
                                                        <?php echo $dept['department_name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label>Golongan <span class="text-danger">*</span></label>
                                            <select id="id_ranks" name="id_ranks" class="form-control">
                                                <option value="" disabled selected>Pilih Golongan</option>
                                                <?php foreach ($ranks as $rk): ?>
                                                    <option value="<?php echo $rk['id']; ?>" <?php echo (isset($staff['id_ranks']) && $staff['id_ranks'] == $rk['id']) ? 'selected' : ''; ?>>
                                                        <?php echo $rk['name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- tambahkan field lainnya sesuai original -->
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label for="userName-2" class="block">NIP <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-12">
                                            <input type="text" id="staff_id" name="staff_id" autocomplete="off"
                                                class="form-control" placeholder=""
                                                value="<?php echo isset($staff['staff_id']) ? $staff['staff_id'] : ''; ?>">
                                        </div>
                                        <!-- <div class="col-sm-2">
                                                                        <i id="generate" class="fa fa-cog btn btn-primary" style="cursor: pointer; padding: 10px; border-radius: 5px;" aria-hidden="true" title="Generate ID"></i>
                                                                    </div> -->
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label for="userName-2" class="block">Email <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-12">
                                            <input type="email" id="email" name="email" autocomplete="off"
                                                class="form-control" placeholder=""
                                                value="<?php echo isset($staff['email_id']) ? $staff['email_id'] : ''; ?>">
                                        </div>
                                    </div>
                                    <?php if (!isset($staff) || empty($staff)): ?>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="userName-2" class="block">Password <span
                                                        class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="password" placeholder="**********" id="password"
                                                    name="password" autocomplete="off" class="form-control">
                                                <?php if (isset($staff) && !empty($staff)): ?>
                                                    <label for="userName" class="block"
                                                        style="font-style: italic; font-size: 12px;">Leave this blank if you
                                                        don't want to change password</label>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="userName-2" class="block">Konfirmasi Password  <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="password" placeholder="**********" id="c_password"
                                                    name="c_password" autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <!-- <h4 class="sub-title">Is Supervisor? *</h4>
                                                                <div class="form-group row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-radio">
                                                                            <div class="radio radiofill radio-inline">
                                                                                <label>
                                                                                    <input type="radio" name="is_supervisor" value="1" <?php echo (isset($staff['is_supervisor']) && $staff['is_supervisor'] == 1) ? 'checked="checked"' : ''; ?>>
                                                                                    <i class="helper"></i>Yes
                                                                                </label>
                                                                            </div>
                                                                            <div class="radio radiofill radio-inline">
                                                                                <label>
                                                                                    <input type="radio" name="is_supervisor" value="0" <?php echo (isset($staff['is_supervisor']) && $staff['is_supervisor'] == 0) ? 'checked="checked"' : ''; ?>>
                                                                                    <i class="helper"></i>No
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->

                                    <h4 class="sub-title">Role <span class="text-danger">*</span></h4>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div class="form-radio">
                                                <div class="radio radiofill radio-inline">
                                                    <label>
                                                        <input type="radio" name="role" value="Staff" <?php echo (isset($staff['role']) && $staff['role'] === 'Pegawai') ? 'checked="checked"' : ''; ?>>
                                                        <i class="helper"></i>Pegawai
                                                    </label>
                                                </div>
                                                <div class="radio radiofill radio-inline">
                                                    <label>
                                                        <input type="radio" name="role" value="Kepala" <?php echo (isset($staff['role']) && $staff['role'] === 'Kepala') ? 'checked="checked"' : ''; ?>>
                                                        <i class="helper"></i>Kepala
                                                    </label>
                                                </div>
                                                <div class="radio radiofill radio-inline">
                                                    <label>
                                                        <input type="radio" name="role" value="PTSP" <?php echo (isset($staff['role']) && $staff['role'] === 'PTSP') ? 'checked="checked"' : ''; ?>>
                                                        <i class="helper"></i>PTSP
                                                    </label>
                                                </div>
                                                <?php if ($session_role == 'Admin'): ?>
                                                    <div class="radio radiofill radio-inline">
                                                        <label>
                                                            <input type="radio" name="role" value="Admin" <?php echo (isset($staff['role']) && $staff['role'] === 'Admin') ? 'checked="checked"' : ''; ?>>
                                                            <i class="helper"></i>Admin
                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-5"></label>
                                <div class="col-sm-5">
                                    <button id="btnSubmit" class="btn btn-primary m-b-0">
                                        <?php echo isset($staff) ? 'Update' : 'Submit'; ?>
                                    </button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body end -->
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#btnSubmit').click(function (e) {
            e.preventDefault();
            var formData = new FormData($('#staffForm')[0]);
            $.ajax({
                url: '<?php echo site_url("staff/save"); ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (res) {
                    var response = JSON.parse(res);
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                            confirmButtonColor: '#01a9ac',
                            confirmButtonText: 'OK'
                        }).then(() => window.location.href = '<?php echo site_url("staff"); ?>');
                    } else {
                        // Menampilkan validasi error dari backend
                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            html: response.message.replace(/\n/g, "<br>"), // format line break
                            confirmButtonColor: '#eb3422',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan pada server: ' + textStatus,
                        confirmButtonColor: '#eb3422',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // $('#generate').click(function(){
        //     $.get('<?php echo site_url("staff/generate_id"); ?>', function(res){
        //         $('#staff_id').val(res);
        //     });
        // });
    });
</script>