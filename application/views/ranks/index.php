<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <h4>Golongan</h4>
                    </div>
                </div>
                <div class="col-lg-4 text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#leaveTypeModal">
                        <i class="icofont icofont-plus"></i> Tambah Golongan
                    </button>
                </div>
            </div>
        </div>

        <div class="page-body">
            <div class="card">
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="leaveTypeTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Kategori</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1;
                                foreach ($ranks as $rk): ?>
                                    <tr>
                                        <td><?= $count++ ?></td>
                                        <td><?= $rk['name'] ?></td>
                                        <td><?= $rk['description'] ?></td>
                                        <td><?= $rk['category_name'] ?></td>
                                        <td><?= date("jS F, Y - H:i", strtotime($rk['creation_date'])) ?></td>
                                        <td>
                                        <button 
                                            class="btn btn-outline-warning btn-sm edit-btn" 
                                            style="border-radius: 20px; padding: 4px 12px; font-weight: 500;"
                                            data-id="<?= $rk['id'] ?>"
                                            data-name="<?= $rk['name'] ?>"
                                            data-id_category="<?= $rk['id_category'] ?>"
                                            data-description="<?= $rk['description'] ?>">
                                            <i class="icofont icofont-ui-edit"></i> Edit
                                        </button>
                                        <button 
                                            class="btn btn-outline-danger btn-sm delete-btn" 
                                            style="border-radius: 20px; padding: 4px 12px; font-weight: 500; margin-left: 5px;"
                                            data-id="<?= $rk['id'] ?>">
                                            <i class="icofont icofont-ui-delete"></i> Delete
                                        </button>



                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Form -->
        <div class="modal fade" id="leaveTypeModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <form id="leaveTypeForm">
                    <input type="hidden" name="id" id="id">
                    <div class="modal-content" style="border: none;">
                        <div class="modal-header" style="background-color: #01a9ac; color: #fff; border-top-left-radius: .3rem; border-top-right-radius: .3rem;">
                            <h5 class="modal-title">Tambah Golongan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color: #fff; opacity: 1;">
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Golongan</label>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
                                <select class="form-control" name="id_category" id="id_category" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="saveBtn" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>

    $(document).ready(function () {
        $('#leaveTypeTable').DataTable({
            responsive: true, // kalau mau table responsive
            autoWidth: false,
            columnDefs: [
                { orderable: false, targets: -1 } // kolom terakhir (Action) tidak ikut sorting
            ],
            pageLength: 10,
            ordering: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Tidak ditemukan data yang sesuai",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(difilter dari total _MAX_ data)"
            }
        });
    });


    $(document).ready(function () {
        // Add & Edit
        $('#leaveTypeForm').on('submit', function (e) {
            e.preventDefault();
            let url = $('#id').val() 
                ? '<?= site_url("Rank/update") ?>' 
                : '<?= site_url("Rank/save") ?>';

            $.post(url, $(this).serialize(), function (res) {
                let data = JSON.parse(res);

                // Tampilkan notifikasi singkat tanpa tombol OK
                Swal.fire({
                    icon: data.status,
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1500
                });

                // Tutup modal
                $('#leaveTypeModal').modal('hide');

                // Reload data setelah sedikit delay (supaya swal sempat tampil)
                setTimeout(() => {
                    location.reload();
                }, 1600);
            });
        });


        // Populate form for edit
        $('.edit-btn').on('click', function () {
            $('#id').val($(this).data('id'));
            $('#name').val($(this).data('name'));
            $('#id_category').val($(this).data('id_category'));
            $('#description').val($(this).data('description'));
            $('#leaveTypeModal').modal('show');
        });

        // Saat tombol tambah ditekan
        $('[data-target="#leaveTypeModal"]').on('click', function () {
            $('#leaveTypeForm')[0].reset();
            $('#id').val('');
            $('#leaveTypeModal .modal-title').text('Tambah Golongan');
        });

        // Delete
        $('.delete-btn').on('click', function () {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Hapus Golongan?',
                text: "Data kategori ini akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('<?= site_url("Rank/delete") ?>', { id: id }, function (res) {
                        let data = JSON.parse(res);
                        Swal.fire({ icon: data.status, title: data.message }).then(() => location.reload());
                    });
                }
            });
        });
    });
</script>