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
                        $message = 'Location was deleted';
                        break;
                    case '6':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Location was not deleted';
                        break;
                    case '2':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Location was Created';
                        break;
                    case '1':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Location was not created';
                        ;
                        break;
                    case '4':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Location was Updated';
                        break;
                    case '3':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Location was not Updated';
                        ;
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
                        <h2 class="header-title">Standortliste</h2>
                        <div class="header-sub-title">
                            <nav class="breadcrumb breadcrumb-dash">
                                <a href="#" class="breadcrumb-item"><i
                                        class="anticon anticon-home m-r-5"></i>Startseite</a>
                                <span class="breadcrumb-item active">Standortliste</span>
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
                                    <a href="manage_Location.php" class="btn btn-primary"><i
                                            class="anticon anticon-plus-square m-r-5"></i>Add Location</a>
                                </div> -->
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover e-commerce-table">
                                    <thead>
                                        <tr>
                                            <!-- <th>No</th> -->
                                            <th>interne seriennummer</th>
                                            <th>Werksende</th>
                                            <th>Loeschmittel</th>
                                            <!-- <th>Datumangelegt</th> -->
                                            <th>Geprueft am</th>
                                            <th>Nächste Prüfung</th>
                                            <th>Hersteller</th>
                                            <th>Typ</th>
                                            <!-- <th>Inhalt</th> -->
                                            <th>BJ</th>
                                            <th>Kurz Beschreibung</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //get Instrument Rating detials
                                        $sql = "SELECT k.idkunde,k.nachname ,k.anrede ,k.vorname ,e.werksende ,k.geprueftam ,k.naechstepruefung,
                                        e.interneseriennummer,e.idkundenbestand,e.loeschmittel,e.hersteller,e.typ,e.inhalt,e.bj,e.beschreibungstandort FROM `user_logins` u JOIN kundenadressen k ON u.company_id=k.idkunde JOIN `kundenbestand` e ON e.idkunde=u.company_id WHERE u.user_id = '$sesssion_uid' ";
                                        // echo $sql;
                                        $conn = $GLOBALS['con'];
                                        $result = mysqli_query($conn, $sql);
                                        $no = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <!-- <td><?php echo $no++; ?></td> -->
                                                <td><?php echo $row['interneseriennummer']; ?></td>
                                                <!-- <td><?php echo $row['werksende']; ?></td> -->
                                                <td><?php if(!is_null($row['werksende'])){
                                                        echo (new DateTime($row['werksende']))->format('m/y');
                                                }  ?></td>
                                                <td><?php echo $row['loeschmittel']; ?></td>
                                                <td><?php if(!is_null($row['geprueftam'])){
                                                        echo (new DateTime($row['geprueftam']))->format('m/y');
                                                }  ?></td>
                                                <td><?php if(!is_null($row['naechstepruefung'])){
                                                        echo (new DateTime($row['naechstepruefung']))->format('m/y');
                                                }  ?></td>
                                                
                                                <td><?php echo $row['hersteller']; ?></td>
                                                <td><?php echo $row['typ']; ?></td>
                                                <!-- <td><?php echo $row['inhalt']; ?></td> -->
                                                <td><?php if(!is_null($row['bj'])){
                                                        echo (new DateTime($row['bj']))->format('Y');
                                                }  ?></td>
                                                <td><?php echo $row['beschreibungstandort']; ?></td>
                                                <td class="text-right">
                                                    <a data-toggle="tooltip" data-placement="top" title="Standort anzeigen"
                                                        href="manage_locations.php?key=<?php echo $row['idkundenbestand']; ?>"
                                                        id="view_equipments"
                                                        class="btn btn-icon btn-hover btn-sm btn-secondary btn-rounded pull-right"><i
                                                            class="fas fa-fire-extinguisher"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- <div id="equipment_section">
                    </div> -->

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
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
    <!-- <script>
        function loadEquipmentTable(clicked_id) {
            $.ajax({
                url: 'load_equipment.php', // This is the URL to your PHP script
                type: 'POST',
                data: { clicked_id: clicked_id },
                success: function (response) {
                    $('#equipment_section').html(response);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script> -->

</body>

</html>