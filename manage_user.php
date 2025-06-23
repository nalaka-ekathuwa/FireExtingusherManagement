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
            $key = isset($_GET['key']) ? $_GET['key'] : '';
            $sql = "SELECT `name`,`img`, `email`, `role_id` FROM `users` u  WHERE u.id=$key";
            //echo $sql;
            $conn = $GLOBALS['con'];
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $image = !empty($row['img']) ? $row['img'] : 'assets/images/users/default.jpg';

            ?>

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
                                <span class="breadcrumb-item active">Benutzer bearbeiten</span>
                            </nav>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-30">
                                <div class="col-lg-12">
                                    <form action="control/users_process.php?action=edit" method="post"
                                        enctype='multipart/form-data'>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="image">Bild</label>
                                                <input name="img" type="file" class="form-control" id="image">
                                                <br>
                                                <div style="padding-left:25px;">
                                                    <img src="<?php echo $image; ?>" alt=""
                                                        style="border-radius:25px; width:200px; height: auto;" />
                                                </div>

                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="in_name">Name</label>
                                                <input name="name" type="text" class="form-control" id="in_name"
                                                    placeholder="Name" value="<?php echo $row['name']; ?>" required>
                                                <label for="inputEmail4">E-Mail</label>
                                                <input name="email" type="email" class="form-control" id="inputEmail4"
                                                    placeholder="Email" value="<?php echo $row['email']; ?>" required>
                                                <!-- <div class="form-group">
                                                    <label for="nic">ID Number</label>
                                                    <input name="nic" type="text" class="form-control" id="nic"
                                                        placeholder="Identification Number" value="<?php // echo $row['nic']; ?>" required>
                                                </div> -->

                                                <label for="inputState">Benutze anmelden als</label>
                                                <select name="role" id="inputState" class="form-control" disabled>
                                                    <option>Wählen...</option>
                                                    <?php
                                                    //get User Roles
                                                    $sql1 = "SELECT * FROM `anmeldenals`";
                                                    //echo $sql;
                                                    $conn = $GLOBALS['con'];
                                                    $result1 = mysqli_query($conn, $sql1);
                                                    while ($row1 = mysqli_fetch_assoc($result1)) {
                                                        ?>
                                                        <option value="<?php echo $row1['idanmeldenals']; ?>" <?php echo ($row['role_id'] == $row1['idanmeldenals']) ? 'selected' : ''; ?>>
                                                            <?php echo $row1['anmeldenals']; ?>
                                                        </option> <?php } ?>
                                                </select>
                                                <input type="hidden" name="key" value="<?php echo $key; ?>">
                                                <!-- <br>
                                                <label for="password">Change Password</label>
                                                <input name="password" type="password" class="form-control" id="password" placeholder="password"  > -->
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Aktualisieren</button> &nbsp;
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