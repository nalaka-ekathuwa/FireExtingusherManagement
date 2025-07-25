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

            <!-- Page Container START -->
            <div class="page-container">

                <!-- Content Wrapper START -->
                <div class="main-content">
                    <div class="page-header">
                        <h2 class="header-title">Benutzerliste</h2>
                        <div class="header-sub-title">
                            <nav class="breadcrumb breadcrumb-dash">
                                <a href="#" class="breadcrumb-item"><i
                                        class="anticon anticon-home m-r-5"></i>Startseite</a>
                                <span class="breadcrumb-item active">Benutzer hinzufügen</span>
                            </nav>
                        </div>

                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-30">
                                <div class="col-lg-12">
                                    <form action="control/users_process.php?action=add" method="post"
                                        enctype='multipart/form-data'>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="image">Bild</label>
                                                <input name="img" type="file" class="form-control" id="image">
                                                <img src="" alt="" />
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="in_name">Name</label>
                                                <input name="name" type="text" class="form-control" id="in_name"
                                                    placeholder="Name" required>
                                                <label for="inputEmail4">E-Mail</label>
                                                <input name="email" type="email" class="form-control" id="inputEmail4"
                                                    placeholder="E-Mail" required>

                                                <label for="inputState">Benutzer anmelden als</label>
                                                <select name="role" id="inputState" class="form-control" required>
                                                    <option value="" selected disabled>Auswählen...</option>
                                                    <?php
                                                    //get User Roles
                                                    $sql1 = "SELECT * FROM `anmeldenals` WHERE anmeldenals NOT IN ('super') ";
                                                    $conn = $GLOBALS['con'];
                                                    $result1 = mysqli_query($conn, $sql1);
                                                    while ($row1 = mysqli_fetch_assoc($result1)) {
                                                        ?>
                                                        <option value="<?php echo $row1['idanmeldenals']; ?>">
                                                            <?php echo $row1['anmeldenals']; ?>
                                                        </option> <?php } ?>
                                                </select>
                                                <input type="hidden" name="idfirma" value="<?php echo $sesssion_firma; ?>">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Erstellen</button> &nbsp;
                                        <button type="reset" class="btn btn-secondary">Zurücksetzen</button>

                                    </form>
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

</body>

</html>