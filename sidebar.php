<!-- Side Nav START -->
<div class="side-nav">
    <div class="side-nav-inner">
        <ul class="side-nav-menu scrollable">
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="dashboard.php">
                    <span class="icon-holder">
                        <i class="anticon anticon-dashboard"></i>
                    </span>
                    <span class="title">Instrumententafel</span>
                </a>
            </li>

            <?php if ($session_urole == 2) { ?>

                <!-- Firmeninhaber -->
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="employee.php">
                        <span class="icon-holder">
                            <i class="anticon anticon-solution"></i>
                        </span>
                        <span class="title">Mitarbeiter</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="fab fa-gripfire"></i>
                        </span>
                        <span class="title">Meine Feuerlöscher</span>
                        <span class="arrow">
                            <i class="arrow-icon"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="my_ext.php">Verwalten</a>
                        </li>
                        <li>
                            <a href="manage_cus_ext.php">Hinzufügen</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <?php if ($session_urole == 3) { ?>
                <!-- For Safety Officer -->
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="anticon anticon-environment"></i>
                        </span>
                        <span class="title">Standorte</span>
                        <span class="arrow">
                            <i class="arrow-icon"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="locations.php">Verwalten</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <?php if ($session_urole == 1) { ?>
                <li class="nav-item dropdown">

                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="anticon anticon-appstore"></i>
                        </span>
                        <span class="title">Kunden</span>
                        <span class="arrow">
                            <i class="arrow-icon"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="customers.php">Verwalten</a>
                        </li>
                        <li>
                            <a href="manage_customer.php">Hinzufügen</a>
                        </li>
                        <li>
                            <a href="assign_company.php">Zuordnen</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="anticon anticon-team"></i>
                        </span>
                        <span class="title">Benutzer</span>
                        <span class="arrow">
                            <i class="arrow-icon"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="users.php">Verwalten</a>
                        </li>
                        <li>
                            <a href="add_user.php">Hinzufügen</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="fab fa-gripfire"></i>
                        </span>
                        <span class="title">Feuerlöscher</span>
                        <span class="arrow">
                            <i class="arrow-icon"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="extinguishers.php">Verwalten</a>
                        </li>
                        <li>
                            <a href="manage_extinguisher.php">Hinzufügen</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="manage_user.php?key=<?php echo $sesssion_uid; ?>">
                    <span class="icon-holder">
                        <i class="anticon anticon-setting"></i>
                    </span>
                    <span class="title">Einstellungen</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="logout.php">
                    <span class="icon-holder">
                        <i class="anticon anticon-logout"></i>
                    </span>
                    <span class="title">Abmelden</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- Side Nav END -->