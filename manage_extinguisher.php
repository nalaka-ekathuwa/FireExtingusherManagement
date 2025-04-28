<?php include 'init.php'; ?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'; ?>
<!-- page css -->
<link href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
    #map_view {
        height: 400px;
        /* or 500px, whatever you like */
        width: 100%;
    }
</style>

<body>
    <div class="app">
        <div class="layout">
            <!-- Header START -->
            <?php include 'config.php'; ?>
            <?php include 'header.php'; ?>
            <?php include 'sidebar.php';
            if (isset($_GET['key'])) {
                $key = $_GET['key'];
                $action = 'edit';
                $sql = "SELECT k.*, l.img as img, l.gps , c.anrede, c.vorname, c.nachname, c.kontaktperson, c.naechstepruefung, c.handyfirma, c.telefonfirma, c.ortauswahl,c.emailp,c.geprueftam FROM `kundenbestand` k JOIN kundenadressen c ON k.idkunde=c.idkunde  LEFT JOIN `location` l ON k.idkundenbestand=l.ext_id  WHERE k.idkundenbestand =$key";
                echo $sql;
                $conn = $GLOBALS['con'];
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $image = !is_null($row['img']) ? $row['img'] : 'assets/images/extinguisher/dummy_ext.jpg';
                $gps = isset($row['gps']) ? trim($row['gps']) : '';
                if (!empty($gps) && strpos($gps, ',') !== false) {
                    list($latitude, $longitude) = explode(',', $gps);
                    $longitude = trim($longitude);
                    $latitude = trim($latitude);
                    $has_gps = true;
                } else {
                    $longitude = 0;
                    $latitude = 0;
                    $has_gps = false;
                }
            } else {
                $action = 'add';
                $key = '';
            }
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
                                <span class="breadcrumb-item active"><?php echo ucfirst($action); ?> Feuerlöscher</span>
                            </nav>
                        </div>

                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <div class="d-md-flex align-items-center">
                                        <div class="text-center text-sm-left ">
                                            <?php if (isset($_GET['key'])) { ?><img src="<?php echo $image; ?>"
                                                    style="height:150px; width: auto;" /> <?php } ?>
                                            <!-- <div class="avatar avatar-image" style="width: 90px; height:90px">
                                                <img src="assets/images/avatars/thumb-3.jpg" alt="">
                                            </div> -->
                                        </div>
                                        <div class="text-center text-sm-left m-v-15 p-l-30">
                                            <h2 class="m-b-5">
                                                <?php echo isset($_GET['key']) ? $row['anrede'] . '. ' . $row['vorname'] . ' ' . $row['nachname'] : ''; ?>
                                            </h2>
                                            <p class="text-opacity font-size-13">Kontaktperson -
                                                <?php echo isset($_GET['key']) ? $row['kontaktperson'] : ''; ?>
                                            </p>
                                            <p class="text-dark m-b-20">NächstePrüfung -
                                                <?php echo isset($_GET['key']) ? $row['naechstepruefung'] : ''; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="d-md-block d-none border-left col-1"></div>
                                        <div class="col">
                                            <ul class="list-unstyled m-t-10">
                                                <li class="row">
                                                    <p class="col-sm-4 col-4 font-weight-semibold text-dark m-b-5">
                                                        <i class="m-r-10 text-primary anticon anticon-mail"></i>
                                                        <span>Email: </span>
                                                    </p>
                                                    <p class="col font-weight-semibold">
                                                        <?php echo isset($_GET['key']) ? $row['emailp'] : ''; ?>
                                                    </p>
                                                </li>
                                                <li class="row">
                                                    <p class="col-sm-4 col-4 font-weight-semibold text-dark m-b-5">
                                                        <i class="m-r-10 text-primary anticon anticon-phone"></i>
                                                        <span>Phone: </span>
                                                    </p>
                                                    <p class="col font-weight-semibold">
                                                        <?php echo isset($_GET['key']) ? $row['handyfirma'] . ' ' . $row['telefonfirma'] : ''; ?>
                                                    </p>
                                                </li>
                                                <li class="row">
                                                    <p class="col-sm-4 col-5 font-weight-semibold text-dark m-b-5">
                                                        <i class="m-r-10 text-primary anticon anticon-compass"></i>
                                                        <span>Location: </span>
                                                    </p>
                                                    <p class="col font-weight-semibold">
                                                        <?php echo isset($_GET['key']) ? $row['ortauswahl'] : ''; ?>
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b-30">
                                <div class="col-lg-12">
                                    <hr>
                                    <form action="control/extinguishers_process.php?action=<?php echo $action; ?>"
                                        method="post" enctype=multipart/form-data>
                                        <p class="card-title">Einzelheiten zum Feuerlöscher</p>
                                        <br>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="interneseriennummer">Interneseriennummer</label>
                                                <input name="interneseriennummer" type="text" class="form-control"
                                                    id="interneseriennummer"
                                                    value="<?php echo isset($_GET['key']) ? $row['interneseriennummer'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="datumangelegt">Datumangelegt</label>
                                                <input name="datumangelegt" type="text" class="form-control"
                                                    id="datumangelegt"
                                                    value="<?php echo isset($_GET['key']) ? $row['datumangelegt'] : ''; ?>"
                                                    disabled>
                                                <?php if (isset($_GET['key'])) { ?><input type="hidden" name="key"
                                                        value="<?php echo $key; ?>"> <?php } ?>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="anzahl">Anzahl</label>
                                                <input name="anzahl" type="text" class="form-control" id="anzahl"
                                                    value="<?php echo isset($_GET['key']) ? $row['anzahl'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="hersteller">Hersteller</label>
                                                <input name="hersteller" type="text" class="form-control"
                                                    id="hersteller"
                                                    value="<?php echo isset($_GET['key']) ? $row['hersteller'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="loeschmittel">Löschmittel</label>
                                                <input name="loeschmittel" type="text" class="form-control"
                                                    id="loeschmittel"
                                                    value="<?php echo isset($_GET['key']) ? $row['loeschmittel'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="typ">Typ</label>
                                                <input name="typ" type="text" class="form-control" id="typ"
                                                    value="<?php echo isset($_GET['key']) ? $row['typ'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inhalt">Inhalt</label>
                                                <input name="inhalt" type="text" class="form-control" id="inhalt"
                                                    value="<?php echo isset($_GET['key']) ? $row['inhalt'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="bj">BJ</label>
                                                <input name="bj" type="text" class="form-control" id="bj"
                                                    value="<?php echo isset($_GET['key']) ? $row['bj'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="pruefungeinzelp">PrüfungEinzelP</label>
                                                <input name="pruefungeinzelp" type="text" class="form-control"
                                                    id="pruefungeinzelp"
                                                    value="<?php echo isset($_GET['key']) ? $row['pruefungeinzelp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="pruefung15p">Prüfung§15P</label>
                                                <input name="pruefung15p" type="text" class="form-control"
                                                    id="pruefung15p"
                                                    value="<?php echo isset($_GET['key']) ? $row['pruefung15p'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="innenkontrop">InnenkontroP</label>
                                                <input name="innenkontrop" type="number" class="form-control"
                                                    id="innenkontrop"
                                                    value="<?php echo isset($_GET['key']) ? $row['innenkontrop'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="ruestkostenp">Ruestkostenp</label>
                                                <input name="ruestkostenp" type="text" class="form-control"
                                                    id="ruestkostenp"
                                                    value="<?php echo isset($_GET['key']) ? $row['ruestkostenp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="oringp">Oringp</label>
                                                <input name="oringp" type="text" class="form-control" id="oringp"
                                                    value="<?php echo isset($_GET['key']) ? $row['oringp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="co2ventielpruefungp">Co2ventielpruefungp</label>
                                                <input name="co2ventielpruefungp" type="text" class="form-control"
                                                    id="co2ventielpruefungp"
                                                    value="<?php echo isset($_GET['key']) ? $row['co2ventielpruefungp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="pruefung500voltp">Pruefung500voltp</label>
                                                <input name="pruefung500voltp" type="text" class="form-control"
                                                    id="pruefung500voltp"
                                                    value="<?php echo isset($_GET['key']) ? $row['pruefung500voltp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="dauerdruckventielp">Dauerdruckventielp</label>
                                                <input name="dauerdruckventielp" type="text" class="form-control"
                                                    id="dauerdruckventielp"
                                                    value="<?php echo isset($_GET['key']) ? $row['dauerdruckventielp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="autoventielp">Autoventielp</label>
                                                <input name="autoventielp" type="text" class="form-control"
                                                    id="autoventielp"
                                                    value="<?php echo isset($_GET['key']) ? $row['autoventielp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="platzschp">Platzschp</label>
                                                <input name="platzschp" type="text" class="form-control" id="platzschp"
                                                    value="<?php echo isset($_GET['key']) ? $row['platzschp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="postp">Postp</label>
                                                <input name="postp" type="text" class="form-control" id="postp"
                                                    value="<?php echo isset($_GET['key']) ? $row['postp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="vorbeigebrachtp">Vorbeigebrachtp</label>
                                                <input name="vorbeigebrachtp" type="text" class="form-control"
                                                    id="vorbeigebrachtp"
                                                    value="<?php echo isset($_GET['key']) ? $row['vorbeigebrachtp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="entsorgungsp">Entsorgungsp</label>
                                                <input name="entsorgungsp" type="text" class="form-control"
                                                    id="entsorgungsp"
                                                    value="<?php echo isset($_GET['key']) ? $row['entsorgungsp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="batteriep">Batteriep</label>
                                                <input name="batteriep" type="text" class="form-control" id="batteriep"
                                                    value="<?php echo isset($_GET['key']) ? $row['batteriep'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="pruefsetp">Pruefsetp</label>
                                                <input name="pruefsetp" type="text" class="form-control" id="pruefsetp"
                                                    value="<?php echo isset($_GET['key']) ? $row['pruefsetp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="datenbereitstp">Datenbereitstp</label>
                                                <input name="datenbereitstp" type="text" class="form-control"
                                                    id="datenbereitstp"
                                                    value="<?php echo isset($_GET['key']) ? $row['datenbereitstp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="pruefungsintervall">Pruefungsintervall</label>
                                                <input name="pruefungsintervall" type="text" class="form-control"
                                                    id="pruefungsintervall"
                                                    value="<?php echo isset($_GET['key']) ? $row['pruefungsintervall'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="befestigungsp">Befestigungsp</label>
                                                <input name="befestigungsp" type="text" class="form-control"
                                                    id="befestigungsp"
                                                    value="<?php echo isset($_GET['key']) ? $row['befestigungsp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="loeschmittelneup">Loeschmittelneup</label>
                                                <input name="loeschmittelneup" type="text" class="form-control"
                                                    id="loeschmittelneup"
                                                    value="<?php echo isset($_GET['key']) ? $row['loeschmittelneup'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="entsorgtp">Entsorgtp</label>
                                                <input name="entsorgtp" type="text" class="form-control" id="entsorgtp"
                                                    value="<?php echo isset($_GET['key']) ? $row['entsorgtp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="korrosiop">KorrosionP</label>
                                                <input name="korrosiop" type="text" class="form-control" id="korrosiop"
                                                    value="<?php echo isset($_GET['key']) ? $row['korrosiop'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="datumstop24st">Datumstop24st</label>
                                                <input name="datumstop24st" type="text" class="form-control"
                                                    id="datumstop24st"
                                                    value="<?php echo isset($_GET['key']) ? $row['datumstop24st'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="reservep">Reservep</label>
                                                <input name="reservep" type="text" class="form-control" id="reservep"
                                                    value="<?php echo isset($_GET['key']) ? $row['reservep'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="reserveanz1">Reserveanz1</label>
                                                <input name="reserveanz1" type="text" class="form-control"
                                                    id="reserveanz1"
                                                    value="<?php echo isset($_GET['key']) ? $row['reserveanz1'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="fotofeuerloescher">Fotofeuerloescher</label>
                                                <input name="fotofeuerloescher" type="file" class="form-control"
                                                    id="fotofeuerloescher">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="geprueftam">Geprueftam</label>
                                                <input name="geprueftam" type="text"
                                                    class="form-control datepicker-input" id="geprueftam" value="<?php
                                                    if (isset($_GET['key'])) {
                                                        $dt = new DateTime($row['geprueftam']);
                                                        echo $dt->format('m/d/Y');
                                                    } ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="naechstepruefung">Naechstepruefung</label>
                                                <input name="naechstepruefung" type="text"
                                                    class="form-control datepicker-input" id="naechstepruefung" value="<?php if (isset($_GET['key'])) {
                                                        $ds = new DateTime($row['naechstepruefung']);
                                                        echo $ds->format('m/d/Y');
                                                    } ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="beschreibungstandort1">Kurz Beschreibung </label>
                                                <input name="beschreibungstandort1" type="text" class="form-control"
                                                    id="beschreibungstandort1"
                                                    value="<?php echo isset($_GET['key']) ? $row['beschreibungstandort1'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="beschreibungstandort">Beschreibungstandort</label>
                                                <textarea name="beschreibungstandort"
                                                    class="form-control"><?php echo isset($_GET['key']) ? $row['beschreibungstandort'] : ''; ?></textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="gps">gps</label>
                                                <textarea name="gps"
                                                    class="form-control"><?php echo isset($_GET['key']) ? $row['gps'] : ''; ?></textarea>
                                            </div>
                                        </div>

                                        <?php if (isset($_GET['key'])) { ?>
                                            <hr>
                                            <p class="card-title">Standortdetails</p>

                                            <?php if ($has_gps) { ?>
                                                <div id="map_view"></div>
                                            <?php } else { ?>
                                                <div class="alert alert-warning" role="alert">
                                                    ❗ GPS data not available for this extinguisher.
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                        <br>

                                        <button type="submit"
                                            class="btn btn-primary"><?php echo ($action == 'add') ? 'Create' : 'Update'; ?></button>
                                        &nbsp;
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Content Wrapper END -->

                <!-- Footer START -->
                <?php include 'footer.php'; ?>

                <!-- page js -->

                <!-- Footer END -->
            </div>
            <!-- Page Container END -->
        </div>
    </div>
    <!-- Include Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        <?php if ($has_gps) { ?>
            var latitude = <?php echo $latitude; ?>;
            var longitude = <?php echo $longitude; ?>;

            var map = L.map('map_view').setView([latitude, longitude], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var marker = L.marker([latitude, longitude]).addTo(map)
                .bindPopup('Extinguisher Location')
                .openPopup();
        <?php } ?>
    </script>
    <?php include 'foot.php'; ?>
    <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script>
        $('.datepicker-input').datepicker();
    </script>

</body>

</html>