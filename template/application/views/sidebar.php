<nav class="pcoded-navbar">
        <div class="navbar-wrapper">
            <div class="navbar-brand header-logo">
                <a href="index.html" class="b-brand">
                    <div class="b-bg">
                        <i class="feather icon-layers"></i>
                    </div>
                    <span class="b-title">Graduation</span>
                </a>
                <a class="mobile-menu" id="mobile-collapse" href="javascript:"><span></span></a>
            </div>
            <div class="navbar-content scroll-div">
                <ul class="nav pcoded-inner-navbar">
                    <li class="nav-item pcoded-menu-caption">
                        <label>Navigation</label>
                    </li>
                    <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item active">
                        <a href="index.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                    </li>
                    <li class="nav-item pcoded-menu-caption">
                        <label>UI Element</label>
                    </li>

                   
                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu">
                        <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Projects</span></a>
                        <ul class="pcoded-submenu">

                        
                        <?php
                    // Start the session
                    // session_start();

                    // Check if the user role is 'admin'
                    if (isset($_SESSION['Role']) && $_SESSION['Role'] === 'admin') {
                    ?>
                            <li class=""><a href="application/views/form.php" class="get_form">Project Registration</a></li>
                            <li class=""><a href="application/views/project_report.php" class="get">View and manage project</a></li>
                            <?php
                    } // End role check
                    ?>

<?php
                    // Start the session
                    // session_start();

                    // Check if the role is either 'student' or 'supervisor'
                if (isset($_SESSION['Role']) && ($_SESSION['Role'] === 'student' || $_SESSION['Role'] === 'supervisor')) {
                    ?>
                        <li class=""><a href="application/views/student.php" class="get_student">Project Taken</a></li>
                    <?php
                    } // End role check
                    ?>
                            </ul>
                    </li>
                   


                     
                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu">
                        <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-users"></i></span><span class="pcoded-mtext">supervisor</span></a>
                        <ul class="pcoded-submenu">
                        <?php
                    // Start the session
                    // session_start();

                    // Check if the user role is 'admin'
                    if (isset($_SESSION['Role']) && $_SESSION['Role'] === 'admin') {
                    ?>
                            <li class=""><a href="bc_button.html" class="">supervisor Registratiion</a></li>
                            <li class=""><a href="bc_badges.html" class="">View and manage supervisor</a></li>
                            <li class=""><a href="bc_breadcrumb-pagination.html" class="">View Submission</a></li>
                            
                            <?php
                    } // End role check
                    ?>    
                        </ul>
                    </li>




<?php
                    // Start the session
                    // session_start();

                    // Check if the user role is 'admin'
                    if (isset($_SESSION['Role']) && $_SESSION['Role'] ==='admin') {
                    ?>

                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu">
                        <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-lock"></i></span><span class="pcoded-mtext">User Managment</span></a>
                        <ul class="pcoded-submenu">
                            <li class=""><a href="application/views/user.php" class="yuu">Student Registartion</a></li>
                            <li class=""><a href="application/views/supervisor.php" class="super">Supervisor Registartion</a></li>
                            
                           
                        </ul>
                    </li>

                    <?php
                    } // End role check
                    ?>

                    <style>
                        a{
                            text-decoration:none;
                        }
                    </style>

                    
                    
                   
                    
                    
                    
                    

                    <li data-username="Disabled Menu" class="nav-item "><a href="application/api/logout.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-power"></i></span><span class="pcoded-mtext">Logout</span></a></li>
                </ul>
            </div>
        </div>
    </nav>


