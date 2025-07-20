<?php include 'init.php'; ?>
<!DOCTYPE html>
<html lang="de">

<?php include 'head.php';?>

<body>
    <div class="app">
        <div class="layout">
            <!-- Header START -->
            <?php include 'config.php'; ?>
            <?php include 'header.php'; ?>
            <?php include 'sidebar.php';
            function displayAlert()
            {
                $msg = isset($_GET['msg']) ? $_GET['msg'] : '';

                switch ($msg) {
                    case '11':
                        $alertType = 'alert-warning';
                        $icon = 'anticon-check-o';
                        $message = 'Duplicate email';
                        break;
                    case '10':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Passwort war nicht changed';
                        break;
                    case '9':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Passwort changed';
                        break;
                    case '8':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Passwort war nicht rest';
                        break;
                    case '7':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Passwort war rest';
                        break;
                    case '5':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Benutzer wurde gelöscht';
                        break;
                    case '6':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Benutzer wurde nicht gelöscht';
                        break;
                    case '2':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Benutzer wurde erstellt';
                        break;
                    case '1':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Benutzer wurde nicht erstellt';
                        break;
                    case '4':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Benutzer wurde aktualisiert';
                        break;
                    case '3':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Benutzer wurde nicht aktualisiert';
                        break;
                    // default:
                    //     $alertType = 'alert-secondary';
                    //     $icon = 'anticon-info-o';
                    //     $message = 'Something went wrong!';
                }

                echo '<div class="alert ' . $alertType . '">
                         <div class="d-flex align-items-center justify-content-start">
                             <span class="alert-icon">
                                 <i class="anticon ' . $icon . '"></i>
                             </span>
                             <span>' . $message . '</span>
                         </div>
                       </div>';
            }

            // Call the function to display the alert
            
            ?>

            <!-- Page Container START -->
            <div class="page-container">

                <!-- Content Wrapper START -->
                <div class="main-content">
                    <div class="page-header">
                        <h2 class="header-title">Mitarbeiter des Unternehmens</h2>
                        <div class="header-sub-title">
                            <nav class="breadcrumb breadcrumb-dash">
                                <a href="#" class="breadcrumb-item"><i
                                        class="anticon anticon-home m-r-5"></i>Startseite</a>
                                <span class="breadcrumb-item active">Firmenbenutzer</span>
                            </nav>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-30">
                                <div class="col-lg-8">
                                     <?php isset($_GET['msg']) ? displayAlert() : ''; ?>
                                    <!-- <h3><span class="badge badge-info lh-1">Firmenadministratorbenutzer</span></h3> -->
                                </div>
                                <div class="col-lg-4 text-right">
                                    <a href="add_user.php" class="btn btn-primary"><i
                                            class="anticon anticon-plus-square m-r-5"></i>Benutzer hinzufügen</a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover e-commerce-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>E-Mail</th>
                                            <th>Angemeldet als</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //get Instrument Rating detials
                                        $sql = "SELECT u.`id`, `name`,`img`, `email`, `role`,a.anmeldenals FROM `users` u JOIN
                                         `anmeldenals` a ON u.role_id=a.idanmeldenals ";
                                        $conn = $GLOBALS['con'];
                                        $result = mysqli_query($conn, $sql);
                                        $number = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $image = !empty($row['img']) ? $row['img'] : 'assets/images/users/default.jpg';
                                            ?>
                                            <tr>
                                                <td><?php echo $number++; ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-image avatar-sm m-r-10">
                                                            <img src="<?php echo $image; ?>" alt="">
                                                        </div>
                                                        <h6 class="m-b-0"><?php echo $row['name']; ?></h6>
                                                    </div>
                                                </td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['anmeldenals']; ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="badge badge-success badge-dot m-r-10"></div>
                                                        <div>Aktiv</div>
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <a data-toggle="tooltip" data-placement="top"
                                                        title="Benutzer bearbeiten"
                                                        href="manage_user.php?key=<?php echo $row['id']; ?>"
                                                        class="btn btn-icon btn-hover btn-sm btn-rounded pull-right"><i
                                                            class="anticon anticon-edit"></i></a>
                                                    <a data-toggle="tooltip" data-placement="top"
                                                        title="Passwort zurücksetzen"
                                                        onclick="return confirm('Sind Sie sicher, dass Sie dieses Element löschen möchten?');"
                                                        href="control/users_process.php?key=<?php echo $row['id']; ?>&action=reset"
                                                        class="btn btn-icon btn-hover btn-sm btn-rounded"><i
                                                            class="anticon anticon-reload"></i></a>
                                                    <a data-toggle="tooltip" data-placement="top" title="Benutzer löschen"
                                                        onclick="return confirm('Sind Sie sicher, dass Sie dieses Element löschen möchten?');"
                                                        href="control/users_process.php?key=<?php echo $row['id']; ?>&action=delete"
                                                        class="btn btn-icon btn-hover btn-sm btn-rounded"><i
                                                            class="anticon anticon-delete"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Content Wrapper END -->

                <!-- Footer START -->
                <?php include 'footer.php'; ?>
                <!-- Footer END -->

            </div>
            <!-- Page Container END -->
        </div>
    </div>
    <?php include 'foot.php'; ?>
</body>

</html>