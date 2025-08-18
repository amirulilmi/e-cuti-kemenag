<div class="pcoded-main-container">
    <div class="pcoded-wrapper">

        <nav class="pcoded-navbar">
            <div class="pcoded-inner-navbar main-menu">
                <?php if ($this->session->userdata('role') == 'Admin'): ?>
                    <div class="pcoded-navigatio-lavel">Navigasi</div>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="<?php echo ($page_name == 'dashboard') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('Dashboard') ?>">
                                <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                <span class="pcoded-mtext">Dashboard</span>
                            </a>
                        </li>
                    </ul>
                    <div class="pcoded-navigatio-lavel">Master Data</div>
                    <ul class="pcoded-item pcoded-left-item">
                        <li
                            class="pcoded-item pcoded-left-item <?php echo ($page_name == 'category') ? 'active pcoded-trigger' : ''; ?>">
                            <a href="<?php echo base_url('Category') ?>">
                                <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                                <span class="pcoded-mtext">Kategori</span>
                            </a>
                        </li>
                        <li
                            class="pcoded-item pcoded-left-item <?php echo ($page_name == 'rank') ? 'active pcoded-trigger' : ''; ?>">
                            <a href="<?php echo base_url('Rank') ?>">
                                <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
                                <span class="pcoded-mtext">Golongan</span>
                            </a>
                        </li>
                        <li class="<?php echo ($page_name == 'department') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('Department') ?>">
                                <span class="pcoded-micon"><i class="feather icon-monitor"></i></span>
                                <span class="pcoded-mtext">Unit Kerja</span>
                            </a>
                        </li>
                        <li
                            class="pcoded-item pcoded-left-item <?php echo ($page_name == 'staff' || $page_name == 'new_staff' || $page_name == 'staff_list') ? 'active pcoded-trigger' : ''; ?>">
                            <a href="<?php echo base_url('Staff') ?>">
                                <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                                <span class="pcoded-mtext">Pegawai</span>
                            </a>
                        </li>
                        <li class="<?php echo ($page_name == 'leave_type') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('Leave_type') ?>">
                                <span class="pcoded-micon"><i class="feather icon-shuffle"></i></span>
                                <span class="pcoded-mtext">Tipe Cuti</span>
                            </a>
                        </li>
                        <li class="<?php echo ($page_name == 'calender') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('calender/index') ?>">
                                <span class="pcoded-micon"><i class="feather  icon-calendar"></i></span>
                                <span class="pcoded-mtext">Kalender</span>
                            </a>
                        </li>
                        <li class="<?php echo ($page_name == 'FAQ') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('FAQ/index') ?>">
                                <span class="pcoded-micon"><i class="feather  icon-folder"></i></span>
                                <span class="pcoded-mtext">Template Surat</span>
                            </a>
                        </li>

                        <div class="pcoded-navigatio-lavel">Application</div>
                        <li
                            class="pcoded-hasmenu <?php echo ($page_name == 'leave' || $page_name == 'apply_leave' || $page_name == 'leave_request' || $page_name == 'my_leave') ? 'active pcoded-trigger' : ''; ?>">

                        <li class="<?php echo ($page_name == 'apply_leave') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('Leave/apply') ?>">
                                <span class="pcoded-micon"><i class="feather icon-edit"></i></span>
                                <span class="pcoded-mtext">Ajukan Cuti</span>
                            </a>
                        </li>

                        <li class="<?php echo ($page_name == 'my_leave') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('Leave/myLeave') ?>">
                                <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                                <span class="pcoded-mtext">Cuti Saya</span>
                            </a>
                        </li>
                        <li class="<?php echo ($page_name == 'all_leave') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('Leave/all_leaves') ?>">
                                <span class="pcoded-micon"><i class="feather  icon-file-text"></i></span>
                                <span class="pcoded-mtext">Semua Cuti</span>
                            </a>
                        </li>



                        </li>
                    </ul>
                <?php endif; ?>


                <!-- STAFF -->
                <?php if ($this->session->userdata('role') == 'Staff'): ?>
                    <div class="pcoded-navigatio-lavel">Navigation</div>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="<?php echo ($page_name == 'dashboard') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('Dashboard') ?>">
                                <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                <span class="pcoded-mtext">Dashboard</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="pcoded-item pcoded-left-item">
                        <div class="pcoded-navigatio-lavel">Application</div>
                        <li
                            class="pcoded-hasmenu <?php echo ($page_name == 'leave' || $page_name == 'apply_leave' || $page_name == 'leave_request' || $page_name == 'my_leave') ? 'active pcoded-trigger' : ''; ?>">

                        <li class="<?php echo ($page_name == 'apply_leave') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('Leave/apply') ?>">
                                <span class="pcoded-micon"><i class="feather icon-edit"></i></span>
                                <span class="pcoded-mtext">Ajukan Cuti</span>
                            </a>
                        </li>

                        <li class="<?php echo ($page_name == 'my_leave') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('Leave/myLeave') ?>">
                                <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                                <span class="pcoded-mtext">Cuti Saya</span>
                            </a>
                        </li>
                        <li class="<?php echo ($page_name == 'FAQ') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('FAQ/index') ?>">
                                <span class="pcoded-micon"><i class="feather  icon-folder"></i></span>
                                <span class="pcoded-mtext">Template Surat</span>
                            </a>
                        </li>

                        </li>

                    </ul>
                <?php endif; ?>
                <!-- AKHIR STAFF -->

                <!-- KEPALA DAN PTSP-->
                <?php if ($this->session->userdata('role') == 'PTSP' || $this->session->userdata('role') == 'Kepala'): ?>
                    <div class="pcoded-navigatio-lavel">Navigasi</div>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="<?php echo ($page_name == 'dashboard') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('Dashboard') ?>">
                                <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                <span class="pcoded-mtext">Dashboard</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="pcoded-item pcoded-left-item">
                        <div class="pcoded-navigatio-lavel">Application</div>
                        <li
                            class="pcoded-hasmenu <?php echo ($page_name == 'leave' || $page_name == 'apply_leave' || $page_name == 'leave_request' || $page_name == 'my_leave') ? 'active pcoded-trigger' : ''; ?>">

                        <li class="<?php echo ($page_name == 'apply_leave') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('Leave/apply') ?>">
                                <span class="pcoded-micon"><i class="feather icon-edit"></i></span>
                                <span class="pcoded-mtext">Ajukan Cuti</span>
                            </a>
                        </li>

                        <li class="<?php echo ($page_name == 'my_leave') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('Leave/myLeave') ?>">
                                <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                                <span class="pcoded-mtext">Cuti Saya</span>
                            </a>
                        </li>
                        <li class="<?php echo ($page_name == 'all_leave') ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('Leave/all_leaves') ?>">
                                <span class="pcoded-micon"><i class="feather  icon-file-text"></i></span>
                                <span class="pcoded-mtext">Semua Cuti</span>
                            </a>
                        </li>
                        </li>
                    </ul>
                <?php endif; ?>
                <!-- AKHIR KEPALA -->
            </div>
        </nav>


        <div class="pcoded-content">
            <div class="pcoded-inner-content">