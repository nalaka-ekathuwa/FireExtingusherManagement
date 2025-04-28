<?php include 'init.php'; ?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'; ?>

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
                    case '5':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Feuerlöscher wurde gelöscht';
                        break;
                    case '6':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Feuerlöscher wurde nicht gelöscht';
                        break;
                    case '2':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Feuerlöscher wurde erstellt';
                        break;
                    case '1':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Feuerlöscher wurde nicht erstellt';
                        break;
                    case '4':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Feuerlöscher wurde aktualisiert';
                        break;
                    case '3':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Feuerlöscher wurde nicht aktualisiert';
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
                        <h2 class="header-title">Feuerlöscher Liste</h2>
                        <div class="header-sub-title">
                            <nav class="breadcrumb breadcrumb-dash">
                                <a href="#" class="breadcrumb-item"><i
                                        class="anticon anticon-home m-r-5"></i>Startseite</a>
                                <span class="breadcrumb-item active">Feuerlöscher Liste</span>
                            </nav>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-30">
                                <div class="col-lg-8">

                                    <?php isset($_GET['msg']) ? displayAlert() : ''; ?>

                                </div>
                                <!-- <div class="col-lg-4 text-right">
                                    <a href="manage_extinguisher.php" class="btn btn-primary">
                                        <i class="anticon anticon-plus-square m-r-5"></i>Feuerlöscher hinzufügen
                                    </a>
                                </div> -->
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover e-commerce-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Loeschmittel</th>
                                            <th>Datumangelegt</th>
                                            <th>Anzahl</th>
                                            <th>Hersteller</th>
                                            <th>Typ</th>
                                            <th>Inhalt</th>
                                            <th>BJ</th>
                                            <th>Befund</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //get Instrument Rating detials
                                        $sql = "SELECT idkundenbestand,fotofeuerloescher,loeschmittel,datumangelegt,anzahl,hersteller,typ,inhalt,bj,befund FROM `kundenbestand`";
                                        //echo $sql;
                                        $conn = $GLOBALS['con'];
                                        $result = mysqli_query($conn, $sql);
                                        $no = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $image = !empty($row['fotofeuerloescher']) ? $row['fotofeuerloescher'] : 'assets/images/extinguisher/dummy_ext.jpg';
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-image avatar-sm m-r-10">
                                                            <img src="<?php echo $image; ?>" alt="">
                                                        </div>
                                                        <h6 class="m-b-0"><?php echo '(' . $row['loeschmittel'] . ')'; ?>
                                                        </h6>
                                                    </div>
                                                </td>
                                                <td><?php echo $row['datumangelegt']; ?></td>
                                                <td><?php echo $row['anzahl']; ?></td>
                                                <td><?php echo $row['hersteller']; ?></td>
                                                <td><?php echo $row['typ']; ?></td>
                                                <td><?php echo $row['inhalt']; ?></td>
                                                <td><?php echo $row['bj']; ?></td>
                                                <td><?php echo $row['befund']; ?></td>
                                                <!-- <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="badge badge-success badge-dot m-r-10"></div>
                                                        <div>Approved</div>
                                                    </div>
                                                </td> -->
                                                <td class="text-right">
                                                    <a data-toggle="tooltip" data-placement="top"
                                                        title="Feuerlöscher bearbeiten"
                                                        href="manage_extinguisher.php?key=<?php echo $row['idkundenbestand']; ?>"
                                                        class="btn btn-icon btn-hover btn-sm btn-rounded pull-right"><i
                                                            class="anticon anticon-edit"></i></a>
                                                    <a data-toggle="tooltip" data-placement="top"
                                                        title="Feuerlöscher löschen"
                                                        onclick="return confirm('Bist du sicher, dass du dieses Element löschen möchtest?');"
                                                        href="control/extinguishers_process.php?key=<?php echo $row['idkundenbestand']; ?>&action=delete"
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