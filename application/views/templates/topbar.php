<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">

        <div class="navbar-logo">
            <a class="mobile-menu" id="mobile-collapse" href="#!">
                <i class="feather icon-menu"></i>
            </a>
            <a class="mobile-options">
                <i class="feather icon-more-horizontal"></i>
            </a>
        </div>

        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                <li class="header-search">
                    <div class="main-search morphsearch-search">
                        <div class="input-group">
                            <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                            <input type="text" class="form-control">
                            <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="#!" onclick="javascript:toggleFullScreen()">
                        <i class="feather icon-maximize full-screen"></i>
                    </a>
                </li>
            </ul>
            <!-- TOPBAR HEADER MESSAGE -->
            <ul class="nav-right">
                <!-- <li class="header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <i class="feather icon-bell"></i>
                            <span class="badge bg-c-pink">5</span>
                        </div>
                        <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn"
                            data-dropdown-out="fadeOut">
                            <li>
                                <h6>Notifications</h6>
                                <label class="label label-danger">New</label>
                            </li>
                            
                        </ul>
                    </div>
                </li> -->
                <li class="user-profile header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <?php
                            $session_image = $this->session->userdata('image');
                            $image_src = !empty($session_image)
                                ? base_url($session_image)
                                : base_url('files/assets/images/avatar-4.jpg');

                            $first_name = $this->session->userdata('first_name');
                            $middle_name = $this->session->userdata('middle_name');
                            $last_name = $this->session->userdata('last_name');

                            echo '<img src="' . $image_src . '" class="img-radius" alt="User-Profile-Image">';
                            ?>
                            <span><?php echo $first_name . ' ' . $middle_name . ' ' . $last_name; ?></span>
                            <i class="feather icon-chevron-down"></i>
                        </div>
                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn"
                            data-dropdown-out="fadeOut">
                            <li>
                                <a
                                    href="<?php echo site_url('staff/profile/' . $this->session->userdata('emp_id')); ?>">
                                    <i class="feather icon-user"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('auth/logout'); ?>">
                                    <i class="feather icon-log-out"></i> Logout
                                </a>
                            </li>
                        </ul>

                    </div>
                </li>
            </ul>
            <!-- TOPBAR HEADER MESSAGE -->


        </div>
    </div>
</nav>