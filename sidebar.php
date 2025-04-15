<!-- Side Nav START -->
<div class="side-nav">
    <div class="side-nav-inner">
        <ul class="side-nav-menu scrollable">
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="dashboard.php">
                    <span class="icon-holder">
                        <i class="anticon anticon-dashboard"></i>
                    </span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            
            <?php  if ($session_urole == 2) { ?>
            
            <!-- Company owner -->
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="employee.php">
                    <span class="icon-holder">
                        <i class="anticon anticon-solution"></i>
                    </span>
                    <span class="title">Employee</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                        <i class="fab fa-gripfire"></i>
                    </span>
                    <span class="title">My Extinguishers</span>
                    <span class="arrow">
                        <i class="arrow-icon"></i>
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="my_ext.php">Manage</a>
                    </li>
                    <li>
                        <a href="manage_cus_ext.php">Add</a>
                    </li>
                </ul>
            </li>
            <?php  } ?>
            <?php if ($session_urole == 3) { ?>
            <!-- For Safety Officer -->
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                        <i class="anticon anticon-environment"></i>
                    </span>
                    <span class="title">locations</span>
                    <span class="arrow">
                        <i class="arrow-icon"></i>
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="locations.php">Manage</a>
                    </li>
                    <li>
                        <a href="manage_location.php">View</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="#">
                    <span class="icon-holder">
                        <i class="anticon anticon-setting"></i>
                    </span>
                    <span class="title">Maintenance</span>
                </a>
            </li>
            <?php } ?>
            <?php if ($session_urole == 1) { ?>
            <li class="nav-item dropdown">
               
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                        <i class="anticon anticon-appstore"></i>
                    </span>
                    <span class="title">Customers</span>
                    <span class="arrow">
                        <i class="arrow-icon"></i>
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="customers.php">Manage</a>
                    </li>
                    <li>
                        <a href="manage_customer.php">Add</a>
                    </li>
                    <li>
                        <a href="user_assign.php">Owners</a>
                    </li>
                    <li>
                        <a href="user_assign.php">Safe. Off.</a>
                    </li>
                </ul>
            </li>


            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                        <i class="anticon anticon-team"></i>
                    </span>
                    <span class="title">Users</span>
                    <span class="arrow">
                        <i class="arrow-icon"></i>
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="users.php">Manage</a>
                    </li>
                    <li>
                        <a href="add_user.php">Add</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                        <i class="anticon anticon-fire"></i>
                    </span>
                    <span class="title">Extinguishers</span>
                    <span class="arrow">
                        <i class="arrow-icon"></i>
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="extinguishers.php">Manage</a>
                    </li>
                    <li>
                        <a href="manage_extinguisher.php">Add</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                        <i class="fab fa-gripfire"></i>
                    </span>
                    <span class="title">Planted Exting.</span>
                    <span class="arrow">
                        <i class="arrow-icon"></i>
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="cus_ext.php">Manage</a>
                    </li>
                    <li>
                        <a href="manage_cus_ext.php">Add</a>
                    </li>
                </ul>
            </li>
            <?php } ?>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="logout.php">
                    <span class="icon-holder">
                        <i class="anticon anticon-lock"></i>
                    </span>
                    <span class="title">Sign out</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- Side Nav END -->