<style>
    /* Kalender */
    .soft-red {
        background-color: #fdecea;
        /* merah pastel */
        color: #c62828;
        /* teks merah tua */
    }

    .calendar td {
        text-align: center;
        height: 70px;
        vertical-align: middle;
        font-weight: 500;
    }

    .calendar td.today {
        background-color: #e0f7fa;
        /* biru muda soft */
        border: 2px solid #26a69a;
        font-weight: bold;
        color: #00796b;
        border-radius: 6px;
    }

    .calendar td.red-day {
        background-color: #fdecea;
        /* merah muda soft */
        color: #c62828;
        font-weight: bold;
        border-radius: 6px;
    }

    .calendar th {
        background-color: #f8f9fa;
        text-align: center;
    }
</style>

<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="mb-4">Kalender Cuti Tahun <?= $year ?></h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?= site_url('dashboard') ?>"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Kalender</a></li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <!-- Form Input Tanggal Merah -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">Tambah Tanggal Merah</div>
                <div class="card-body">
                    <form id="holidayForm" class="row g-3">
                        <div class="col-md-4">
                            <input type="date" name="holiday_date" id="holiday_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="description" id="description" class="form-control"
                                placeholder="Keterangan (opsional)">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success w-100">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Daftar Tanggal Merah -->
            <div class="card mb-4">
                <div class="card-header text-white soft-red" style="background-color: #FF6961;">Daftar Tanggal Merah
                </div>
                <div class="card-body p-8 m-t-8">
                    <table class="table table-striped table-bordered nowrap" id="holidayTable">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($holidays as $h): ?>
                                <tr data-id="<?= $h['id'] ?>">
                                    <td><?= $h['holiday_date'] ?></td>
                                    <td><?= $h['description'] ?></td>
                                    <td>
                                        <button class="btn btn-outline-danger btn-sm delete-btn"
                                            style="border-radius: 20px; padding: 4px 12px; font-weight: 500; margin-left: 5px;">
                                            <i class="icofont icofont-ui-delete"></i>Hapus</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($holidays)): ?>
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada tanggal merah</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Kalender -->

            <div class="row">
                <?php
                // Loop semua bulan (1 - 12)
                for ($m = 1; $m <= 12; $m++) {
                    // Nama bulan (Indonesia)
                    $nama_bulan = date('F', mktime(0, 0, 0, $m, 1, $year));

                    echo '<div class="col-md-6 mb-4">';
                    echo '<div class="card">';
                    echo '<div class="card-header bg-primary text-white text-center fw-bold fs-5">' . $nama_bulan . ' ' . $year . '</div>';
                    echo '<table class="calendar table table-bordered mb-0">';
                    echo '<thead class="table-light">
                <tr>
                    <th>Minggu</th>
                    <th>Senin</th>
                    <th>Selasa</th>
                    <th>Rabu</th>
                    <th>Kamis</th>
                    <th>Jumat</th>
                    <th>Sabtu</th>
                </tr>
              </thead>';
                    echo '<tbody>';

                    $first_day = date('w', strtotime($year . '-' . $m . '-01'));
                    $days_in_month = date('t', strtotime($year . '-' . $m . '-01'));
                    $rows = ceil(($days_in_month + $first_day) / 7);

                    for ($i = 0; $i < $rows; $i++) {
                        echo "<tr>";
                        for ($j = 0; $j < 7; $j++) {
                            $cell_day = ($i * 7 + $j - $first_day + 1);

                            if ($cell_day < 1 || $cell_day > $days_in_month) {
                                echo "<td></td>";
                            } else {
                                $current_date = $year . '-' . str_pad($m, 2, '0', STR_PAD_LEFT) . '-' . str_pad($cell_day, 2, '0', STR_PAD_LEFT);
                                $class = '';
                                $tooltip = '';

                                if ($current_date == date('Y-m-d')) {
                                    $class = 'today';
                                } elseif (isset($red_dates[$current_date])) {
                                    $class = 'red-day';
                                    $tooltip = $red_dates[$current_date]; // ambil deskripsi dari backend
                                }

                                // tambahkan title untuk tooltip (hover)
                                echo "<td class='$class' title='$tooltip'>$cell_day</td>";
                            }
                        }
                        echo "</tr>";
                    }

                    echo '</tbody></table></div></div>';
                }
                ?>
            </div>



        </div>
    </div>
</div>




<!-- CRUD -->
<script>
    $(document).ready(function () {

        // Tambah tanggal merah
        $('#holidayForm').on('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah Anda yakin ingin menambahkan tanggal merah?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url("Calender/add_holiday") ?>',
                        type: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function (res) {
                            if (res.status === 'success') {
                                Swal.fire('Berhasil!', res.message, 'success');
                                // reload table tanpa refresh
                                $('#holidayTable tbody').append(`
                                <tr data-id="${res.data.id}">
                                    <td>${res.data.holiday_date}</td>
                                    <td>${res.data.description ?? ''}</td>
                                    <td><button class="btn btn-sm btn-danger btn-delete">Hapus</button></td>
                                </tr>
                            `);
                                $('#holidayForm')[0].reset();
                            } else {
                                Swal.fire('Gagal!', res.message, 'error');
                            }
                        }
                    });
                }
            });
        });

        //  Delete tanggal merah
        $(document).on('click', '.btn-delete', function () {
            let row = $(this).closest('tr');
            let id = row.data('id');

            Swal.fire({
                title: 'Hapus Tanggal Merah?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url("Calender/delete_holiday") ?>/' + id,
                        type: 'POST',
                        dataType: 'json',
                        success: function (res) {
                            if (res.status === 'success') {
                                Swal.fire('Terhapus!', res.message, 'success');
                                row.remove();
                            } else {
                                Swal.fire('Gagal!', res.message, 'error');
                            }
                        }
                    });
                }
            });
        });

    });
</script>

<!-- DATATABLE -->
<script>
    $(document).ready(function () {
        $('#holidayTable').DataTable({
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>