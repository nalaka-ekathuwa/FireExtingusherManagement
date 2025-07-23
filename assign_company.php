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
            <?php include 'sidebar.php'; ?>
            
            <?php 
                function displayAlert(){
                $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
                    
                switch ($msg) {
                    case '5':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Benutzer wurde entfernt';
                        break;
                    case '6':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Benutzer wurde nicht entfernt';
                        break;
                    case '2':
                        $alertType = 'alert-success';
                        $icon = 'anticon-check-o';
                        $message = 'Benutzer wurde zugewiesen';
                        break;
                    case '1':
                        $alertType = 'alert-danger';
                        $icon = 'anticon-close-o';
                        $message = 'Benutzer wurde nicht zugewiesen';                                        
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
                }  ?>
            <!-- Page Container START -->
            <div class="page-container">

                <!-- Content Wrapper START -->
                <div class="main-content">
                    <div class="page-header">
                        <h2 class="header-title">Benutzerliste</h2>
                        <div class="header-sub-title">
                            <nav class="breadcrumb breadcrumb-dash">
                                <a href="#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Hauptseite</a>
                                <span class="breadcrumb-item active">Firma zuordnen</span>
                            </nav>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-30">
                                <div class="col-lg-12">
                                    
                                    <form action="control/users_process.php?action=assign" method="post"
                                        enctype='multipart/form-data'>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="inputState">Benutzername</label>
                                                <select name="user" id="inputState" class="select2 form-control" required>
                                                    <option value="" selected disabled>Choose...</option>
                                                    <?php
                                                    //get User Roles
                                                    $sql1 = "SELECT u.*, a.anmeldenals FROM `users` u  JOIN `anmeldenals` a ON u.role_id=a.idanmeldenals";
                                                    //echo $sql;
                                                    $conn = $GLOBALS['con'];
                                                    $result1 = mysqli_query($conn, $sql1);
                                                    while ($row1 = mysqli_fetch_assoc($result1)) {
                                                        ?>
                                                        <option value="<?php echo $row1['id']; ?>">
                                                            <?php echo $row1['name']. ' | '.$row1['anmeldenals']; ?></option> <?php } ?>
                                                </select>

                                                <!-- <label for="in_name">Benutzerrolle</label>
                                                <input name="role" type="text" class="form-control" id="role"
                                                    placeholder="role" required> -->
                                                    <br><br>
                                                    
                                                    <label for="Kunde">Kunde</label>
                                                <select name="company" id="Kunde" class="select2 form-control" required>
                                                    <option value="" selected disabled>Auswählen...</option>
                                                    <?php
                                                    //get User Roles
                                                    $sql2 = "SELECT idkunde,kundennummer,anrede,nachname,vorname FROM `kundenadressen`";
                                                    //echo $sql;
                                                    $conn = $GLOBALS['con'];
                                                    $result2 = mysqli_query($conn, $sql2);
                                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                                        ?>
                                                        <option value="<?php echo $row2['idkunde']; ?>">
                                                            <?php echo $row2['kundennummer'].' | '.$row2['anrede'].' '.$row2['vorname'].' '.$row2['nachname']; ?></option> <?php } ?>
                                                </select>
                                                
                                            </div>
                                        </div>
                                        <br>
                                        <button type="submit" class="btn btn-primary">Zuordnen</button> &nbsp; <button
                                            type="reset" class="btn btn-secondary">Stornieren</button>
                                    </form>
                                    <br>
                                    <hr>
                                    <br>
                                    <div class="table-responsive">
                                <table class="table table-hover e-commerce-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Benutzer</th>
                                            <!-- <th>Benutzerrolle</th> -->
                                            <th>IDKunde </th>
                                            <th>Kundennummer</th>
                                            <th>Kundenname</th>
                                            <th>Ortauswahl</th>
                                            <!-- <th>Ort</th> -->
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //get Instrument Rating detials
                                        $sql = "SELECT l.id, u.name,u.role_id,u.img,k.idkunde,k.anrede,k.nachname,k.vorname,k.ortauswahl,k.kundennummer 
                                        FROM `user_logins` l JOIN users u ON l.user_id=u.id JOIN kundenadressen k ON k.IDKunde=l.company_id WHERE k.idfirma='$sesssion_firma'";
                                        //echo $sql;
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
                                                        <!-- <div class="avatar avatar-image avatar-sm m-r-10">
                                                            <img src="<?php echo $image; ?>" alt="">
                                                        </div> -->
                                                        <h6 class="m-b-0"><?php echo $row['name']; ?></h6>
                                                    </div>
                                                </td>
                                                <!-- <td><?php echo $row['role_id']; ?></td> -->
                                                <td><?php echo $row['idkunde']; ?></td>
                                                <td><?php echo $row['kundennummer']; ?></td>
                                                <td><?php echo $row['anrede'].' '.$row['vorname'].' '.$row['nachname']; ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="badge badge-success badge-dot m-r-10"></div>
                                                        <div><?php echo $row['ortauswahl']; ?></div>
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <a onclick="return confirm('Bist du sicher, dass du dieses Element löschen möchtest?');"
                                                        href="control/users_process.php?key=<?php echo $row['id']; ?>&action=remove"
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
    <!-- page css -->
    <link href="assets/vendors/select2/select2.css" rel="stylesheet">

    <!-- page js -->
    <script src="assets/vendors/select2/select2.min.js"></script>

    <script>
        $('.select2').select2();
        </script>

</body>

</html>