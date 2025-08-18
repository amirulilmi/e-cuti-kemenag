<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Staff List</h4>
                        </div>

                    </div>
                </div>

            </div>
            <div class="text-right m-b-20">
                <a href="<?php echo base_url('Staff/form') ?>" class="btn btn-primary"><i
                        class="icofont icofont-plus m-r-5"></i>Tambah Pegawai</a>
            </div>
        </div>

        <!-- Filter -->
        <div class="page-body">
            <div class="row">
                <div class="col-lg-12 filter-bar">
                    <nav class="navbar navbar-light bg-faded m-b-30 p-10">
                        <ul class="nav navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Filter By Department</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="bydepartment" data-toggle="dropdown">
                                    <i class="icofont icofont-home"></i> <?= $departmentFilter ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="bydepartment">
                                    <a class="dropdown-item <?= ($departmentFilter === 'Show all') ? 'active' : ''; ?>"
                                        href="?department=Show all">Show all</a>
                                    <div class="dropdown-divider"></div>
                                    <?php foreach ($departments as $dept): ?>
                                        <a class="dropdown-item <?= ($departmentFilter === $dept['department_name']) ? 'active' : ''; ?>"
                                            href="?department=<?= $dept['department_name'] ?>"><?= $dept['department_name'] ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </li>
                        </ul>
                        <div class="nav-item nav-grid mt-2">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput" placeholder="Search here...">
                                <span class="input-group-addon"><i class="icofont icofont-search"></i></span>
                            </div>
                        </div>
                    </nav>
                </div>

            </div>
            <!-- Staff Cards -->
            <div id="staffContainer" class="row users-card"></div>

        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
        var selectedDepartment = '<?= $departmentFilter ?>';

        function fetchStaff() {
            var searchQuery = $('#searchInput').val();
            var departmentFilter = (selectedDepartment === 'Show all') ? '' : selectedDepartment;

            $.post("<?= site_url('staff/fetch_staff') ?>",
                { searchQuery: searchQuery, departmentFilter: departmentFilter },
                function (response) {
                    $('#staffContainer').html(response);
                }
            );
        }

        $('#searchInput').on('keyup', fetchStaff);

        $('#bydepartment .dropdown-item').on('click', function (e) {
            e.preventDefault();
            selectedDepartment = $(this).text().trim();
            $('#bydepartment').text(selectedDepartment);
            fetchStaff();
        });

        fetchStaff();
    });
</script>