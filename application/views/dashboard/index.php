<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row">
                <!-- user card  start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card widget-card-1">
                        <div class="card-block-small">
                            <i class="feather icon-user bg-c-blue card1-icon"></i>
                            <span class="text-c-blue f-w-600">Total Pegawai</span>
                            <?php if ($total_employee == 0): ?>
                                <h4>No</h4>
                            <?php else: ?>
                                <h4><?= $total_employee ?></h4>
                            <?php endif; ?>
                            <div>
                                <span class="f-left m-t-10 text-muted">
                                    <i class="text-c-blue f-16 feather icon-user m-r-10"></i>Pegawai Tersedia
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card widget-card-1">
                        <div class="card-block-small">
                            <i class="feather icon-home bg-c-pink card1-icon"></i>
                            <span class="text-c-pink f-w-600">Unit Kerja</span>
                            <?php if ($total_depart == 0): ?>
                                <h4>No</h4>
                            <?php else: ?>
                                <h4><?= $total_depart ?></h4>
                            <?php endif; ?>
                            <div>
                                <span class="f-left m-t-10 text-muted">
                                    <i class="text-c-pink f-16 feather icon-home m-r-10"></i>Unit Kerja Tersedia
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card widget-card-1">
                        <div class="card-block-small">
                            <i class="feather icon-tag bg-c-green card1-icon"></i>
                            <span class="text-c-green f-w-600">Jenis Cuti</span>
                            <?php if ($total_types == 0): ?>
                                <h4>No</h4>
                            <?php else: ?>
                                <h4><?= $total_types ?></h4>
                            <?php endif; ?>
                            <div>
                                <span class="f-left m-t-10 text-muted">
                                    <i class="text-c-green f-16 feather icon-tag m-r-10"></i>Jenis Cuti Tersedia
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card widget-card-1">
                        <div class="card-block-small">
                            <i class="feather icon-list bg-c-yellow card1-icon"></i>
                            <span class="text-c-yellow f-w-600">Cuti</span>
                            <?php if ($total_leave == 0): ?>
                                <h4>No</h4>
                            <?php else: ?>
                                <h4><?= $total_leave ?></h4>
                            <?php endif; ?>
                            <div>
                                <span class="f-left m-t-10 text-muted">
                                    <i class="text-c-yellow f-16 feather icon-list m-r-10"></i>Pengajuan Cuti
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- user card  end -->

                <!-- statustic with progressbar  start -->
                <div class="col-xl-3 col-md-6">
                    <div class="card statustic-progress-card">
                        <div class="card-header">
                            <h5>Pending Admin Approval</h5>
                        </div>
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col">
                                    <label class="label bg-c-lite-green">
                                        <?php echo $pending_percentage; ?>% <i class="m-l-10 feather icon-arrow-up"></i>
                                    </label>
                                </div>
                                <div class="col text-right">
                                    <h5 class=""><?php echo $pending_leave; ?></h5>
                                </div>
                            </div>
                            <div class="progress m-t-15">
                                <div class="progress-bar bg-c-lite-green"
                                    style="width:<?php echo $pending_percentage; ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card statustic-progress-card">
                        <div class="card-header">
                            <h5>Approved</h5>
                        </div>
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col">
                                    <label class="label label-success">
                                        <?php echo $approved_percentage; ?>% <i
                                            class="m-l-10 feather icon-arrow-up"></i>
                                    </label>
                                </div>
                                <div class="col text-right">
                                    <h5 class=""><?php echo $approved_leave; ?></h5>
                                </div>
                            </div>
                            <div class="progress m-t-15">
                                <div class="progress-bar bg-c-green" style="width:<?php echo $approved_percentage; ?>%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card statustic-progress-card">
                        <div class="card-header">
                            <h5>Cancelled</h5>
                        </div>
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col">
                                    <label class="label label-danger">
                                        <?php echo $cancelled_leave; ?>% <i
                                            class="m-l-10 feather icon-arrow-up"></i>
                                    </label>
                                </div>
                                <div class="col text-right">
                                    <h5 class=""><?php echo $cancelled_leave; ?></h5>
                                </div>
                            </div>
                            <div class="progress m-t-15">
                                <div class="progress-bar bg-c-pink" style="width:<?php echo $cancelled_leave; ?>%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card statustic-progress-card">
                        <div class="card-header">
                            <h5>Recalled</h5>
                        </div>
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col">
                                    <label class="label label-warning">
                                        <?php echo $recalled_percentage; ?>% <i
                                            class="m-l-10 feather icon-arrow-up"></i>
                                    </label>
                                </div>
                                <div class="col text-right">
                                    <h5 class=""><?php echo $recalled_leave; ?></h5>
                                </div>
                            </div>
                            <div class="progress m-t-15">
                                <div class="progress-bar bg-c-yellow"
                                    style="width:<?php echo $recalled_percentage; ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- statustic with progressbar  end -->

                <!-- Department  start -->
                <?php foreach ($departments as $department): ?>
                    <div class="col-md-12 col-xl-6 ">
                        <div class="card app-design">
                            <div class="card-block">
                                <a href="staff_list.php?department=<?= urlencode($department['name']) ?>"><button
                                        class="btn btn-primary f-right"><?= $department['name'] ?></button></a>
                                <h6 class="f-w-400 text-muted"><?= $department['desc'] ?></h6>
                                <div class="design-description d-inline-block m-r-40">
                                    <?php if ($department['staffCount'] > 0): ?>
                                        <h3 class="f-w-400"><?= $department['staffCount'] ?></h3>
                                    <?php else: ?>
                                        <h5>No</h5>
                                    <?php endif; ?>
                                    <p class="text-muted">Total Staff</p>
                                </div>
                                <div class="design-description d-inline-block">
                                    <?php if ($department['managerCount'] > 0): ?>
                                        <h3 class="f-w-400"><?= $department['managerCount'] ?></h3>
                                    <?php else: ?>
                                        <h5>No</h5>
                                    <?php endif; ?>
                                    <p class="text-muted">Total Managers</p>
                                </div>
                                <div class="team-box p-b-20">
                                    <p class="d-inline-block m-r-20 f-w-400">
                                        <?php
                                        if ($department['staffCount'] > 0) {
                                            echo "Team";
                                        } else {
                                            echo "No Staff";
                                        }
                                        ?>
                                    </p>
                                    <div class="team-section d-inline-block">
                                        <?php 
                                        $staffList = $this->Department_model->get_staff_by_department($department['id']);
                                        foreach ($staffList as $staff):
                                            $staffImage = base_url($staff['image_path']);
                                            $staffName = $staff['first_name'].' '.$staff['last_name'];
                                            echo "<a href='#'><img src='{$staffImage}' title='{$staffName}' class='m-l-5'></a>";
                                        endforeach;
                                        ?>
                                    </div>
                                    
                                </div>
                                <div class="progress-box">
                                    <p class="d-inline-block m-r-20 f-w-400">Progress</p>
                                    <div class="progress d-inline-block">
                                        <?php
                                        $staffPercentage = $total_employee > 0 ? round(($department['staffCount'] / $total_employee) * 100) : 0;
                                        ?>
                                        <div class="progress-bar bg-c-blue" style="width:<?= $staffPercentage ?>% ">
                                            <label><?= $staffPercentage ?>%</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- Department  end -->

                <!-- Start Newest Employee -->
                <div class="col-md-12 col-xl-6">
                    <!-- contact data table card start -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">Pegawai Terbaru</h5>
                        </div>
                        <div class="card-block contact-details">
                            <div class="data_table_main table-responsive dt-responsive">
                                <table class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>Nama Lengkap</th>
                                            <th>Jabatan</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($newest_employees)): ?>
                                            <?php foreach ($newest_employees as $row): ?>
                                                <tr>
                                                    <td><strong><?= htmlspecialchars(trim($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'])) ?></strong>
                                                    </td>
                                                    <td><?= htmlspecialchars($row['designation']) ?></td>
                                                    <td><?= htmlspecialchars($row['role']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center">No data available</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- contact data table card end -->
                </div>
                <!-- End Newest Employee -->

                <!-- Start Recent Leave -->
                <div class="col-md-12 col-xl-6">
                    <!-- contact data table card start -->

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">Pengajuan Cuti Terbaru</h5>
                        </div>
                        <div class="card-block contact-details">
                            <div class="data_table_main table-responsive dt-responsive">
                                <table class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>Nama Lengkap</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($recent_leave)): ?>
                                            <?php foreach ($recent_leave as $row): ?>
                                                <?php
                                                $fromDate = !empty($row->from_date) ? date('jS F, Y', strtotime($row->from_date)) : '-';
                                                $toDate = !empty($row->to_date) ? date('jS F, Y', strtotime($row->to_date)) : '-';
                                                ?>
                                                <tr>
                                                    <td>
                                                        <strong>
                                                            <?php echo htmlspecialchars($row->first_name . ' ' . $row->middle_name . ' ' . $row->last_name); ?>
                                                        </strong>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($fromDate); ?></td>
                                                    <td><?php echo htmlspecialchars($toDate); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center">No data available</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- contact data table card end -->
                </div>
                <!-- End Recent Leave -->
            </div>
        </div>
        <!-- Page-body end -->

    </div>
    <div id="styleSelector"> </div>
</div>
