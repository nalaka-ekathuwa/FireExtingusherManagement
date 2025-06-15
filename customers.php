<?php include 'init.php'; ?>
<!DOCTYPE html>
<html lang="de">

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
                        $message = 'Kunde wurde gelöscht';
                        break;
                    case '6':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Kunde wurde nicht gelöscht';
                        break;
                    case '2':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Kunde wurde erstellt';
                        break;
                    case '1':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Kunde wurde nicht erstellt';
                        break;
                    case '4':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Kunde wurde aktualisiert';
                        break;
                    case '3':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Kunde wurde nicht aktualisiert';
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
                        <h2 class="header-title">Kundenliste</h2>
                        <div class="header-sub-title">
                            <nav class="breadcrumb breadcrumb-dash">
                                <a href="#" class="breadcrumb-item"><i
                                        class="anticon anticon-home m-r-5"></i>Startseite</a>
                                <span class="breadcrumb-item active">Kundenliste</span>
                            </nav>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-30">
                                <div class="col-lg-8">

                                    <?php isset($_GET['msg']) ? displayAlert() : ''; ?>

                                </div>
                                <div class="col-lg-4 text-right">
                                    <a href="manage_customer.php" class="btn btn-primary">
                                        <i class="anticon anticon-plus-square m-r-5"></i>Kunde hinzufügen
                                    </a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover e-commerce-table">
                                    <thead>
                                        <tr>
                                            <th>Kn.-Nr</th>
                                            <!-- <th>IDWartungspersonal</th>-->
                                            <th>Name</th> 
                                            <th>Strasse</th>
                                            <th>Nr</th>
                                            <th>Plz</th>
                                            <th>Ort</th>
                                            <!--<th>Ortauswahl</th>-->
                                            <th>Nächste Wartung</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //get Instrument Rating detials
                                        $sql = "SELECT idkunde,kundennummer,strasse,anrede,vorname,nachname,nr,plz,ort,ortauswahl,naechstepruefung FROM `kundenadressen`";
                                        //echo $sql;
                                        $conn = $GLOBALS['con'];
                                        $result = mysqli_query($conn, $sql);
                                        $no = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            //    $badge = ($row['safe_off_availability'] =='10')?'info':'danger';
                                            //    $availability = ($row['safe_off_availability'] =='10')?'Available':'Not Available';
                                            ?>
                                            <tr>
                                                <!-- <td><?php echo $no++; ?></td> -->
                                                <td><?php echo $row['kundennummer']; ?></td>
                                                <td><?php echo $row['anrede'] . '. ' . $row['vorname'] . ' ' . $row['nachname']; ?>
                                                </td>
                                                <td><?php echo $row['strasse']; ?></td>
                                                <td><?php echo $row['nr']; ?></td>
                                                <td><?php echo $row['plz']; ?></td>
                                                <!--<td><?php echo $row['ort']; ?></td>-->
                                                <td><?php echo $row['ortauswahl']; ?></td>
                                                <td><?php if (!empty($row['naechstepruefung'])) {
                                                        $dt = new DateTime($row['naechstepruefung']);
                                                        echo $dt->format('m/Y');
                                                    } ?></td>
                                                <!-- <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="badge badge-<?php // echo $badge; ?> badge-dot m-r-10"></div>
                                                        <div><?php // echo $availability; ?></div>
                                                    </div>
                                                </td> -->
                                                <td class="text-right">
                                                    <a data-toggle="tooltip" data-placement="top" title="Kunden bearbeiten"
                                                        href="manage_customer.php?key=<?php echo $row['idkunde']; ?>"
                                                        class="btn btn-icon btn-hover btn-sm btn-rounded pull-right"><i
                                                            class="anticon anticon-edit"></i></a>

                                                    <a data-toggle="tooltip" data-placement="top" title="Kunden löschen"
                                                        onclick="return confirm('Bist du sicher, dass du dieses Element löschen möchtest?');"
                                                        href="control/customer_process.php?key=<?php echo $row['idkunde']; ?>&action=delete"
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