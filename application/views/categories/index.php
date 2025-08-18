<!-- Main content -->
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Kategori</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= site_url('dashboard') ?>"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Kategori</a></li>
                </ul>
            </div>
        </div>

        <!-- Tambah Kategori Button -->
        <div class="text-right m-b-20">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addModal"><i
                    class="icofont icofont-plus m-r-5"></i> Tambah Kategori</button>
        </div>

        <div class="page-body">
            <div class="row">
                <?php foreach ($categories as $category): ?>
                    <div class="col-md-12 col-xl-6">
                        <div class="card app-design">
                            <div class="card-block">
                                <div class="f-right">
                                    <div class="dropdown-secondary dropdown">
                                        <button class="btn btn-primary btn-min text-bold" type="button">
                                            <?= $category['name'] ?></button>
                                    </div>
                                </div>
                                <h6 class="f-w-400 text-bold"><?= $category['description'] ?></h6>
                                <p class="text-c-blue f-w-400"><?= date('jS F, Y', strtotime($category['creation_date'])) ?>
                                </p>

                                <div class="design-description d-inline-block m-r-40">
                                    <h3 class="f-w-400"><?= $category['rank_count'] ?: 'No' ?></h3>
                                    <p class="text-muted">Total Golongan</p>
                                </div>
                                <div class="design-description d-inline-block">
                                    <h3 class="f-w-400"><?= $category['staff_count'] ?: 'No' ?></h3>
                                    <p class="text-muted">Total Staff</p>
                                </div>

                                <div class="team-box p-b-20">
                                    <p class="d-inline-block m-r-4 f-w-400">
                                        <?= $category['rank_count'] > 0 ? 'Golongan : ' : 'Tidak Ada Golongan Terkait' ?>
                                    </p>
                                    <div class="team-section d-inline-block">
                                        <?php
                                        $categorylist = $this->Category_model->get_ranks_by_category($category['id']);
                                        foreach ($categorylist as $rank):
                                            $categoryName = $rank['name'];
                                            echo "<span class='badge badge-primary m-1'>{$categoryName}</span>";
                                        endforeach;
                                        ?>
                                    </div>

                                </div>

                                <?php
                                $staffPercentage = $totalRank > 0 ? round(($category['rank_count'] / $totalRank) * 100) : 0;
                                ?>
                                <div class="row col-lg-12 mx-0 my-1">
                                    <div class="col-4 px-1">
                                        <a href="<?= site_url('Rank/') ?>"
                                            class="btn btn-sm w-100"
                                            style="background-color: #e0f3ff; color: #0d6efd; border: 1px solid #b3e0ff;">
                                            <i class="feather icon-eye"></i> View
                                        </a>
                                    </div>
                                    <div class="col-4 px-1">
                                        <a href="#" class="btn btn-sm w-100 edit-btn" data-id="<?= $category['id'] ?>"
                                            data-name="<?= $category['name'] ?>"
                                            data-description="<?= $category['description'] ?>"
                                            style="background-color: #fff5e0; color: #fd7e14; border: 1px solid #ffd6a8;">
                                            <i class="feather icon-edit"></i> Edit
                                        </a>
                                    </div>
                                    <div class="col-4 px-1">
                                        <a href="#" class="btn btn-sm w-100 delete-btn" data-id="<?= $category['id'] ?>"
                                            style="background-color: #ffe0e0; color: #dc3545; border: 1px solid #ffb3b3;">
                                            <i class="feather icon-trash"></i> Delete
                                        </a>
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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Kategori</label>
                        <textarea name="description" class="form-control" required></textarea>
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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="name" id="edit-name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Kategori</label>
                        <textarea name="description" id="edit-description" class="form-control" required></textarea>
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
            $.post("<?= site_url('category/save') ?>", $(this).serialize(), function (res) {
                var data = JSON.parse(res);
                if (data.status === 'success') {
                    // Tutup modal tambah
                    $('#addModal').modal('hide');

                    // SweetAlert sukses
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
                    // SweetAlert error
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

        // Update
        $('#editForm').on('submit', function (e) {
            e.preventDefault();
            $.post("<?= site_url('category/update') ?>", $(this).serialize(), function (res) {
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
                    $.post("<?= site_url('category/delete') ?>", { id: id }, function (res) {
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