<?php include 'init.php'; ?>
<!DOCTYPE html>
<html lang="de">

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
                $sql = "SELECT k.*, l.img as img, l.gps , c.plz, c.anrede, c.kundennummer, c.vorname, c.nachname, c.kontaktperson, c.naechstepruefung, c.handyfirma, c.telefonfirma, c.ortauswahl,c.email,c.geprueftam, postp FROM `kundenbestand` k JOIN kundenadressen c ON k.idkunde=c.idkunde  LEFT JOIN `location` l ON k.idkundenbestand=l.ext_id  WHERE k.idkundenbestand =$key";
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
                $action = '';
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
                                <span class="breadcrumb-item active"><?php echo ucfirst($action); ?>Feuerlöscher</span>
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
                                            <p class="text-dark m-b-20">PLZ -
                                                <?php echo isset($_GET['key']) ? $row['plz'] : ''; ?>
                                            </p>
                                            <p class="text-dark m-b-20">Kn. Nr. -
                                                <?php echo isset($_GET['key']) ? $row['kundennummer'] : ''; ?>
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
                                                        <span>E-Mail: </span>
                                                    </p>
                                                    <p class="col font-weight-semibold">
                                                        <?php echo isset($_GET['key']) ? $row['email'] : ''; ?>
                                                    </p>
                                                </li>
                                                <li class="row">
                                                    <p class="col-sm-4 col-4 font-weight-semibold text-dark m-b-5">
                                                        <i class="m-r-10 text-primary anticon anticon-phone"></i>
                                                        <span>Telefon: </span>
                                                    </p>
                                                    <p class="col font-weight-semibold">
                                                        <?php echo isset($_GET['key']) ? $row['handyfirma'] . ' ' . $row['telefonfirma'] : ''; ?>
                                                    </p>
                                                </li>
                                                <li class="row">
                                                    <p class="col-sm-4 col-5 font-weight-semibold text-dark m-b-5">
                                                        <i class="m-r-10 text-primary anticon anticon-compass"></i>
                                                        <span>Ort: </span>
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
                                    <form >
                                        <p class="card-title">Einzelheiten zum Feuerlöscher</p>
                                        <br>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="interneseriennummer">Interneseriennummer</label>
                                                <input name="interneseriennummer" type="text" class="form-control"
                                                    id="interneseriennummer" disabled
                                                    value="<?php echo isset($_GET['key']) ? $row['interneseriennummer'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="datumangelegt">Datum Angelegt</label>
                                                <input name="datumangelegt" type="number" class="form-control" id="datumangelegt"
                                                    value="<?php 
                                                    if (isset($_GET['key']) && !empty($row['datumangelegt'])) {
                                                        $da = new DateTime($row['datumangelegt']);
                                                        echo $da->format('m/Y');
                                                    }
                                                    ?>"
                                                    disabled>
                                                <?php if (isset($_GET['key'])) { ?><input type="hidden" name="key"
                                                        value="<?php echo $key; ?>"> <?php } ?>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="anzahl">Anzahl</label>
                                                <input name="anzahl" type="text" class="form-control" id="anzahl"
                                                    value="<?php echo isset($_GET['key']) ? $row['flanzahl'] : ''; ?>"
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
                                                <label for="inhalt">Inhalt kg/l</label>
                                                <input name="inhalt" type="text" class="form-control" id="inhalt"
                                                    value="<?php echo isset($_GET['key']) ? $row['inhalt'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="bj">Hersteller Jahr</label>
                                                <input name="bj" type="number" class="form-control" id="bj"
                                                    value="<?php 
                                                    if (isset($_GET['key']) && !empty($row['bj'])) {
                                                        $bj = new DateTime($row['bj']);
                                                        echo $bj->format('Y');
                                                    }
                                                    ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="pruefungeinzelp">Prüfungs Preis</label>
                                                <input name="pruefungeinzelp" type="text" class="form-control"
                                                    id="pruefungeinzelp"
                                                    value="<?php echo isset($_GET['key']) ? $row['pruefungeinzelp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="pruefung15p">Prüfung gmß. §15</label>
                                                <input name="pruefung15p" type="text" class="form-control"
                                                    id="pruefung15p"
                                                    value="<?php echo isset($_GET['key']) ? $row['pruefung15p'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="innenkontrop">Innenkontrolle Preis je kg/l </label>
                                                <input name="innenkontrop" type="number" class="form-control"
                                                    id="innenkontrop"
                                                    value="<?php echo isset($_GET['key']) ? $row['innenkontrop'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="ruestkostenp">Rüstkosten Preis</label>
                                                <input name="ruestkostenp" type="text" class="form-control"
                                                    id="ruestkostenp"
                                                    value="<?php echo isset($_GET['key']) ? $row['ruestkostenp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="oringp">O-Ring Preis</label>
                                                <input name="oringp" type="text" class="form-control" id="oringp"
                                                    value="<?php echo isset($_GET['key']) ? $row['oringp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="co2ventielpruefungp">Co2 Ventiel Prüfpreis</label>
                                                <input name="co2ventielpruefungp" type="text" class="form-control"
                                                    id="co2ventielpruefungp"
                                                    value="<?php echo isset($_GET['key']) ? $row['co2ventielpruefungp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="pruefung500voltp">500 Volt Prüfpreis</label>
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
                                            <div class="form-group col-md-4">
                                                <label for="autoventielp">Autoventielp</label>
                                                <input name="autoventielp" type="text" class="form-control"
                                                    id="autoventielp"
                                                    value="<?php echo isset($_GET['key']) ? $row['autoventielp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="platzschp">Platzschp</label>
                                                <input name="platzschp" type="text" class="form-control" id="platzschp"
                                                    value="<?php echo isset($_GET['key']) ? $row['platzschp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="postp">Postp</label>
                                                <input name="postp" type="text" class="form-control" id="postp"
                                                    value="<?php echo isset($_GET['key']) ? $row['postp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="batteriep">Batteriep</label>
                                                <input name="batteriep" type="text" class="form-control" id="batteriep"
                                                    value="<?php echo isset($_GET['key']) ? $row['batteriep'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="pruefsetp">Pruefsetp</label>
                                                <input name="pruefsetp" type="text" class="form-control" id="pruefsetp"
                                                    value="<?php echo isset($_GET['key']) ? $row['pruefsetp'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-4">
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
                                                <label for="geprueftam">Geprüft am</label>
                                                <input name="geprueftam" type="text"
                                                    class="form-control datepicker-input" id="geprueftam" value="<?php
                                                    if (isset($_GET['key'])) {
                                                        $dt = new DateTime($row['geprueftam']);
                                                        echo $dt->format('m/Y');
                                                    } ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="naechstepruefung">Nächste Wartung</label>
                                                <input name="naechstepruefung" type="text"
                                                    class="form-control datepicker-input" id="naechstepruefung" value="<?php if (isset($_GET['key'])) {
                                                        $ds = new DateTime($row['naechstepruefung']);
                                                        echo $ds->format('m/Y');
                                                    } ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="beschreibungstandort">Kurz Beschreibung </label>
                                                <input name="beschreibungstandort" type="text" class="form-control"
                                                    id="beschreibungstandort"
                                                    value="<?php echo isset($_GET['key']) ? $row['beschreibungstandort'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="beschreibungstandort1">Beschreibungstandort</label>
                                                <textarea name="beschreibungstandort1" disabled
                                                    class="form-control"><?php echo isset($_GET['key']) ? $row['beschreibungstandort1'] : ''; ?></textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="gps">GPS Standort des Feuerlöschers</label>
                                                <textarea name="gps" disabled
                                                    class="form-control"><?php echo isset($_GET['key']) ? $row['gps'] : ''; ?></textarea>
                                            </div>
                                        </div>

                                        <?php if (!empty($row['foto1']) || !empty($row['foto2']) || !empty($row['foto3'])): ?>
                                            <p class="card-title">Schadensfotos</p>
                                            <hr>
                                            <div class="row">
                                                <?php if (!empty($row['foto1'])): ?>
                                                    <div class="col-md-4">
                                                        <img class="card-img-top" style="height: 200px; width: auto;"
                                                            src="<?= htmlspecialchars($row['foto1']) ?>" alt="Damage Image 1">
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (!empty($row['foto2'])): ?>
                                                    <div class="col-md-4">
                                                        <img class="card-img-top" style="height: 200px; width: auto;" src="<?= htmlspecialchars($row['foto2']) ?>"
                                                            alt="Damage Image 2">
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (!empty($row['foto3'])): ?>
                                                    <div class="col-md-4">
                                                        <img class="card-img-top" style="height: 200px; width: auto;" src="<?= htmlspecialchars($row['foto3']) ?>"
                                                            alt="Damage Image 3">
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <br>

                                        <?php if (isset($_GET['key'])) { ?>
                                            <hr>
                                            <p class="card-title">Standortdetails</p>

                                            <?php if ($has_gps) { ?>
                                                <div id="map_view"></div>
                                            <?php } else { ?>
                                                <div class="alert alert-warning" role="alert">
                                                    ❗ GPS noch nicht eingetragen.
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                        <br>

                                        <a href="all_damge_items.php" class="btn btn-primary">Go Back</a>
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
                .bindPopup('Standort')
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