<!-- Main content -->
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>FAQ</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= site_url('dashboard') ?>"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">FAQ</a></li>
                </ul>
            </div>
        </div>

        <!-- Tambah Button -->
        <div class="text-right m-b-20">
        <?php if ($this->session->userdata('role') == 'Admin'): ?>
            <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                <i class="icofont icofont-plus m-r-5"></i> Tambah Template Surat Pengajuan
            </button>
        <?php endif; ?>
        </div>

        <div class="page-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Daftar Template Surat Pengajuan</h5>
                        </div>
                        <div class="card-block">
                            <div class="table-responsive">
                                <table id="faqTable" class="table table-striped table-bordered">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Template</th>
                                            <th>Deskripsi</th>
                                            <th>Dokumen</th>
                                            <?php if ($this->session->userdata('role') == 'Admin'): ?>
                                            <th>Aksi</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($faq_list)): ?>
                                            <?php $no = 1;
                                            foreach ($faq_list as $faq): ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= htmlspecialchars($faq->name) ?></td>
                                                    <td><?= htmlspecialchars($faq->description) ?></td>
                                                    <td>
                                                        <?php if ($faq->document): ?>
                                                            <a href="<?= base_url($faq->document) ?>" target="_blank"
                                                                class="btn btn-outline-success btn-sm d-flex align-items-center gap-1">
                                                                <i class="feather icon-file-text"></i> Lihat
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted">Belum ada file</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <?php if ($this->session->userdata('role') == 'Admin'): ?>
                                                    <td>
                                                        <button data-id="<?= $faq->id ?>"
                                                            data-name="<?= htmlspecialchars($faq->name) ?>"
                                                            data-description="<?= htmlspecialchars($faq->description) ?>"
                                                            class="btn btn-outline-warning btn-sm edit-btn"
                                                            style="border-radius: 20px; padding: 4px 12px; font-weight: 500;">
                                                            <i class="icofont icofont-ui-edit"></i> Edit
                                                        </button>
                                                        <button data-id="<?= $faq->id ?>"
                                                            class="btn btn-outline-danger btn-sm delete-btn"
                                                            style="border-radius: 20px; padding: 4px 12px; font-weight: 500; margin-left: 5px;">
                                                            <i class="icofont icofont-ui-delete"></i>Delete
                                                        </button>
                                                    </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">Belum ada data</td>
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

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="addForm" enctype="multipart/form-data">
            <div class="modal-content" style="border:none">
                <div class="modal-header"
                    style="background-color: #01a9ac; color: #fff; border-top-left-radius: .3rem; border-top-right-radius: .3rem;">
                    <h5 class="modal-title">Tambah Template Surat Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color: #fff; opacity: 1;">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Template</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Upload Dokumen</label>
                        <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx" required>
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
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="editForm" enctype="multipart/form-data">
            <input type="hidden" name="id" id="edit-id">
            <div class="modal-content" style="border:none">
                <div class="modal-header"
                    style="background-color: #01a9ac; color: #fff; border-top-left-radius: .3rem; border-top-right-radius: .3rem;">
                    <h5 class="modal-title">Edit Template Surat Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color: #fff; opacity: 1;">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Template</label>
                        <input type="text" name="name" id="edit-name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" id="edit-description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Upload Dokumen (biarkan kosong jika tidak diubah)</label>
                        <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx">
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
            var formData = new FormData(this);

            $.ajax({
                url: "<?= site_url('FAQ/save') ?>",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (res) {
                    var data = JSON.parse(res);
                    if (data.status === 'success') {
                        $('#addModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message
                        });
                    }
                }
            });
        });

        // Update
        $('#editForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: "<?= site_url('FAQ/update') ?>",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (res) {
                    var data = JSON.parse(res);
                    if (data.status === 'success') {
                        $('#editModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message
                        });
                    }
                }
            });
        });

        // Update
        $('#editForm').on('submit', function (e) {
            e.preventDefault();
            $.post("<?= site_url('FAQ/update') ?>", $(this).serialize(), function (res) {
                var data = JSON.parse(res);
                if (data.status === 'success') {
                    $('#editModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
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
            $('#editModal').modal('show');
        });

        // Delete
        $('.delete-btn').on('click', function () {
            var id = $(this).data('id');

            Swal.fire({
                title: 'Hapus Kategori?',
                text: "Data kategori ini akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("<?= site_url('FAQ/delete') ?>", { id: id }, function (res) {
                        var data = JSON.parse(res);
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: data.message
                            });
                        }
                    });
                }
            });
        });

    });
</script>

<!-- DATATABLES -->
<script>
    $(document).ready(function () {
        $('#faqTable').DataTable({
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "paginate": {
                    "first": "Awal",
                    "last": "Akhir",
                    "next": "›",
                    "previous": "‹"
                }
            },
            "pageLength": 5,
            "lengthMenu": [5, 10, 20, 50]
        });
    });
</script>