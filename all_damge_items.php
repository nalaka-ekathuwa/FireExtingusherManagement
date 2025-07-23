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
                   
                    case '2':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Schäden beseitigt';
                        break;
                    case '1':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Schäden wurden nicht beglichen';
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
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover e-commerce-table">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>NFC Adresse</th>
                                            <th>Hersteller</th>
                                            <th>Typ</th>
                                            <th>Löschmittel</th>
                                            <th>Inhalt</th>
                                            <th>BJ</th>
                                            <th>Beschreibung der Beschädigung</th>
                                            <th>Foto der Beschädigung</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //get Instrument Rating detials
                                        $sql = "SELECT t.idkunde,t.idkundenbestand, fotofeuerloescher,Foto1,Foto2,Foto3, loeschmittel, datumangelegt, 
                                        hersteller, typ, inhalt, bj, nfcadresse,BeschreibungStandort1,beschaedigung FROM kundenbestand t JOIN kundenadressen k
                                        ON t.idkunde=k.idkunde WHERE Foto1 IS NOT NULL OR Foto2 IS NOT NULL OR Foto3 IS NOT NULL OR beschreibungstandort1  <> '' 
                                        OR beschaedigung <> '' OR entsorgt =1 ";
                                        //echo $sql;
                                        $conn = $GLOBALS['con'];
                                        $result = mysqli_query($conn, $sql);
                                        $no = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                               $danger_text = (!empty($row['BeschreibungStandort1'])||!empty($row['beschaedigung']))?'checked':'';
                                               $danger_images = !((empty($row['Foto1'])) && (empty($row['Foto2'])) && (empty($row['Foto3'])))?'checked':'';
                                            $image = !empty($row['fotofeuerloescher']) ? $row['fotofeuerloescher'] : 'assets/images/extinguisher/dummy_ext.jpg';
                                            ?>
                                            <tr>
                                                <!-- <td><?php echo $no++; ?></td> -->
                                                <td>
                                                    <div class='d-flex align-items-center'>
                                                        <div class='avatar avatar-image avatar-sm m-r-10'>
                                                            <img src='<?php echo $image; ?>' alt=''>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?php echo $row['nfcadresse']; ?></td>
                                                <td><?php echo $row['hersteller']; ?></td>
                                                <td><?php echo $row['typ']; ?></td>
                                                <td><?php echo $row['loeschmittel']; ?></td>
                                                <td><?php echo $row['inhalt']; ?></td>
                                                <td><?php if (!empty($row['bj'])) {
                                                    $dt = new DateTime($row['bj']);
                                                    echo $dt->format('m/Y');
                                                } ?></td>
                                                <td>
                                                    <div class="form-group d-flex align-items-center">
                                                        <div class="switch m-r-10">
                                                            <input type="checkbox" id="switch-1" <?php echo $danger_text; ?> disabled >
                                                            <label for="switch-1"></label>
                                                        </div>
                                                        <!-- <label>Checked</label> -->
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group d-flex align-items-center">
                                                        <div class="switch m-r-10">
                                                            <input type="checkbox" id="switch-1" <?php echo $danger_images; ?> disabled >
                                                            <label for="switch-1"></label>
                                                        </div>
                                                        <!-- <label>Checked</label> -->
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <a data-toggle="tooltip" data-placement="top" title="Kunden bearbeiten"
                                                        href="view_damage_item.php?key=<?php echo $row['idkundenbestand']; ?>"
                                                        class="btn btn-icon btn-hover btn-sm btn-rounded pull-right"><i
                                                            class="anticon anticon-eye"></i></a> 
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