<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Brandschutzbeauftragter</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/logo/favicon-32x32.png">

    <!-- page css -->

    <!-- Core css -->
    <link href="assets/css/app.min.css" rel="stylesheet">

</head>

<body>
    <div class="app">
        <div class="container-fluid p-h-0 p-v-20 bg full-height d-flex" style="background-image: url('6.jpg')">
            <div class="d-flex flex-column justify-content-between w-100">
                <div class="container d-flex h-100">
                    <div class="row align-items-center w-100">
                        <div class="col-md-7 col-lg-5 m-h-auto">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between m-b-30">
                                        <img class="img-fluid" alt="" src="assets/images/logo/brand.jpg"
                                            style="width:150px;">
                                        <h2 class="m-b-0">Anmelden</h2>
                                    </div>
                                    <?php
                                    if (isset($_GET['s'])) {
                                        $s = $_GET['s'];

                                        if ($s == 1) { ?>
                                            <br>
                                            <div class="alert alert-danger alert-dismissible fade show">
                                                Falsche Anmeldeinformationen!
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <br>
                                        <?php } else if ($s == 2) { ?>
                                                <br>
                                                <div class="alert alert-danger alert-dismissible fade show">
                                                    Kein Benutzer mit dieser E-Mail gefunden!
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <br>
                                        <?php }
                                    } ?>
                                    <form action="control/loginprocess.php" method="post">
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="userName">Benutzername:</label>
                                            <div class="input-affix">
                                                <i class="prefix-icon anticon anticon-user"></i>
                                                <input type="text" name="username" class="form-control" id="userName"
                                                    placeholder="Benutzername">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="password">Passwort:</label>
                                            <!-- <a class="float-right font-size-13 text-muted" href="">Passwort
                                                vergessen?</a> -->
                                            <div class="input-affix m-b-10">
                                                <i class="prefix-icon anticon anticon-lock"></i>
                                                <input name="password" type="password" class="form-control" id="password"
                                                    placeholder="Passwort">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-size-13 text-muted">
                                                    Haben Sie kein Konto?
                                                    <a class="small" href="">Registrieren</a>
                                                </span>
                                                <button class="btn btn-danger">Anmelden</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-none d-md-flex p-h-40 justify-content-between">
                    <span class="">© <?php echo date("Y"); ?> <a href="https://promodesoftware.com/">Promode Software
                            Solutions</a></span>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a class="text-dark text-link" href="">Legal</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-dark text-link" href="">Privacy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <!-- Core Vendors JS -->
    <script src="assets/js/vendors.min.js"></script>

    <!-- page js -->

    <!-- Core JS -->
    <script src="assets/js/app.min.js"></script>

</body>

</html>