<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (empty($_SESSION["user_id"])) {
    header('Location:index.php');
} else {
    $session_urole = $_SESSION['role_id'];
    $session_uname = $_SESSION['user_name'];
    $session_uimg = $_SESSION['user_img'];
    $sesssion_uid = $_SESSION['user_id'];
    $sesssion_firma = $_SESSION['idfirma'];
}

?>
<!-- Header START -->
<div class="header">
    <div class="logo logo-dark">
        <a href="#">
            <img src="assets/images/logo/logo.png" alt="Logo">
            <img class="logo-fold" src="assets/images/logo/logo-fold.png" alt="Logo">
        </a>
    </div>
    <div class="logo logo-white">
        <a href="#">
            <img src="assets/images/logo/logo-white.png" alt="Logo">
            <img class="logo-fold" src="assets/images/logo/logo-fold-white.png" alt="Logo">
        </a>
    </div>
    <div class="nav-wrap">
        <ul class="nav-left">
            <li class="desktop-toggle">
                <a href="javascript:void(0);">
                    <i class="anticon"></i>
                </a>
            </li>
            <li class="mobile-toggle">
                <a href="javascript:void(0);">
                    <i class="anticon"></i>
                </a>
            </li>
            <!-- <li>
                <a href="javascript:void(0);" data-toggle="modal" data-target="#search-drawer">
                    <i class="anticon anticon-search"></i>
                </a>
            </li> -->
        </ul>
        <ul class="nav-right">
            <!-- <li class="dropdown dropdown-animated scale-left">
                <a href="javascript:void(0);" data-toggle="dropdown">
                    <i class="anticon anticon-bell notification-badge"></i>
                </a>
                <div class="dropdown-menu pop-notification">
                    <div class="p-v-15 p-h-25 border-bottom d-flex justify-content-between align-items-center">
                        <p class="text-dark font-weight-semibold m-b-0">
                            <i class="anticon anticon-bell"></i>
                            <span class="m-l-10">Notification</span>
                        </p>
                        <a class="btn-sm btn-default btn" href="javascript:void(0);">
                            <small>View All</small>
                        </a>
                    </div>
                    <div class="relative">
                        <div class="overflow-y-auto relative scrollable" style="max-height: 300px">
                            <a href="javascript:void(0);" class="dropdown-item d-block p-15 border-bottom">
                                <div class="d-flex">
                                    <div class="avatar avatar-blue avatar-icon">
                                        <i class="anticon anticon-mail"></i>
                                    </div>
                                    <div class="m-l-15">
                                        <p class="m-b-0 text-dark">You received a new message</p>
                                        <p class="m-b-0"><small>8 min ago</small></p>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item d-block p-15 border-bottom">
                                <div class="d-flex">
                                    <div class="avatar avatar-cyan avatar-icon">
                                        <i class="anticon anticon-user-add"></i>
                                    </div>
                                    <div class="m-l-15">
                                        <p class="m-b-0 text-dark">New user registered</p>
                                        <p class="m-b-0"><small>7 hours ago</small></p>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item d-block p-15 border-bottom">
                                <div class="d-flex">
                                    <div class="avatar avatar-red avatar-icon">
                                        <i class="anticon anticon-user-add"></i>
                                    </div>
                                    <div class="m-l-15">
                                        <p class="m-b-0 text-dark">System Alert</p>
                                        <p class="m-b-0"><small>8 hours ago</small></p>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item d-block p-15 ">
                                <div class="d-flex">
                                    <div class="avatar avatar-gold avatar-icon">
                                        <i class="anticon anticon-user-add"></i>
                                    </div>
                                    <div class="m-l-15">
                                        <p class="m-b-0 text-dark">You have a new update</p>
                                        <p class="m-b-0"><small>2 days ago</small></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </li> -->
            <li class="dropdown dropdown-animated scale-left">
                <div class="pointer" data-toggle="dropdown">
                    <div class="avatar avatar-image  m-h-10 m-r-15">
                        <img src="<?php echo $session_uimg; ?>" alt="">
                    </div>
                </div>
                <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                    <div class="p-h-20 p-b-15 m-b-10 border-bottom">
                        <div class="d-flex m-r-50">
                            <div class="avatar avatar-lg avatar-image">
                                <img src="<?php echo $session_uimg; ?>" alt="">
                            </div>
                            <div class="m-l-10">
                                <p class="m-b-0 text-dark font-weight-semibold"><?php echo $session_uname; ?></p>
                                <p class="m-b-0 opacity-07">Aktiv</p>
                            </div>
                        </div>
                    </div>
                    <a href="manage_user.php?key=<?php echo $sesssion_uid; ?>"
                        class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <i class="anticon opacity-04 font-size-16 anticon-user"></i>
                                <span class="m-l-10">Profil bearbeiten</span>
                            </div>
                            <i class="anticon font-size-10 anticon-right"></i>
                        </div>
                    </a>

                    <a href="manage_password.php?key=<?php echo $sesssion_uid; ?>" class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <i class="anticon opacity-04 font-size-16 anticon-lock"></i>
                                <span class="m-l-10">Password ändern</span>
                            </div>
                            <i class="anticon font-size-10 anticon-right"></i>
                        </div>
                    </a>
                    <a href="logout.php" class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                                <span class="m-l-10">Abmelden</span>
                            </div>
                            <i class="anticon font-size-10 anticon-right"></i>
                        </div>
                    </a>
                </div>
            </li>
            <!-- <li>
                <a href="javascript:void(0);" data-toggle="modal" data-target="#quick-view">
                    <i class="anticon anticon-appstore"></i>
                </a>
            </li> -->
        </ul>
    </div>
</div>
<!-- Header END -->