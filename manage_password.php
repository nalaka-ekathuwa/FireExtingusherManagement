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
            $key = isset($_GET['key']) ? $_GET['key'] : '';
            $sql = "SELECT `password`,`img` FROM `users` u  WHERE u.id=$key";
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
                                <span class="breadcrumb-item active">Kennwort ändern</span>
                            </nav>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-30">
                                <div class="col-lg-12">
                                    <form id="form-validation" action="control/users_process.php?action=change" method="post">
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <br>
                                                <div style="padding-left:25px;">
                                                    <img src="<?php echo $image; ?>" alt=""
                                                        style="border-radius:25px; width:200px; height: auto;" />
                                                </div>

                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="old">OLD password</label>
                                                <input name="old" type="password" class="form-control" id="old"
                                                    placeholder="old password" > <br>
                                                <label for="inputPassword">New Password</label>
                                                
                                                <input name="inputPassword" type="password" class="form-control"
                                                    id="inputPassword" placeholder="new password" ><br>

                                                <input type="hidden" name="key" value="<?php echo $key; ?>">
                                                <input type="hidden" name="old_hash" value="<?php echo $row['password'] ; ?>">
                                                <label for="confirm">Confirm Password</label>
                                                <input name="confirm" type="password" class="form-control" id="confirm"
                                                    placeholder="confirm password" >
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
    <!-- page js -->
    <script src="assets/vendors/jquery-validation/jquery.validate.min.js"></script>
    <script>
        $("#form-validation").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid',
            validClass: 'is-valid',
            rules: {
                old: {
                    required: true
                },
                inputPassword: {
                    required: true,
                    minlength: 6
                },
                confirm: {
                    required: true,
                    equalTo: '#inputPassword'
                }
            }
        });
    </script>

</body>

</html>