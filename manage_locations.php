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
                $action = 'update';
                $sql = "SELECT k.*, k.fotofeuerloescher as img,  c.plz, c.anrede, c.vorname, c.nachname, c.kontaktperson, c.naechstepruefung, c.handyfirma, c.telefonfirma, c.ortauswahl, c.email, c.geprueftam FROM `kundenbestand` k JOIN kundenadressen c ON k.idkunde=c.idkunde  LEFT JOIN `location` l ON k.idkundenbestand=l.ext_id  WHERE k.idkundenbestand =$key";
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
                                            <p class="text-dark m-b-20">PLZ -
                                                <?php echo isset($_GET['key']) ? $row['plz'] : ''; ?>
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
                                            <?php if (isset($_GET['key'])) { ?><input type="hidden" name="key"
                                                    value="<?php echo $key; ?>"> <?php } ?>
                                            <div class="form-group col-md-3">
                                                <label for="geprueftam">Geprüft am</label>
                                                <input name="geprueftam" type="text"
                                                    class="form-control datepicker-input" id="geprueftam" value="<?php
                                                    if (isset($_GET['key'])) {
                                                        $dt = new DateTime($row['geprueftam']);
                                                        echo $dt->format('m/Y');
                                                    } ?>" disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="naechstepruefung">Nächste Wartung</label>
                                                <input name="naechstepruefung" type="text"
                                                    class="form-control datepicker-input" id="naechstepruefung" value="<?php if (isset($_GET['key'])) {
                                                        $ds = new DateTime($row['naechstepruefung']);
                                                        echo $ds->format('m/Y');
                                                    } ?>" disabled>
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
                                                <label for="inhalt">Inhalt l/kg</label>
                                                <input name="inhalt" type="text" class="form-control" id="inhalt"
                                                    value="<?php echo isset($_GET['key']) ? $row['inhalt'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="bj">BJ</label>
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
                                                <label for="foto1">Beschädigung Foto 1</label>
                                                <input name="foto1" type="file" class="form-control" id="foto1">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="foto2">Beschädigung Foto 2</label>
                                                <input name="foto2" type="file" class="form-control" id="foto2">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="foto3">Beschädigung Foto 3</label>
                                                <input name="foto3" type="file" class="form-control" id="foto3">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="beschreibungstandort">Kurz Beschreibung </label>
                                                <input name="beschreibungstandort" type="text" class="form-control"
                                                    id="beschreibungstandort"
                                                    value="<?php echo isset($_GET['key']) ? $row['beschreibungstandort'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="beschreibungstandort1">Genaue beschreibung des Standortes</label>
                                                <textarea name="beschreibungstandort1"
                                                    class="form-control"><?php echo isset($_GET['key']) ? $row['beschreibungstandort1'] : ''; ?></textarea>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="beschaedigung">Beschreibung der Beschädigung</label>
                                                <textarea name="beschaedigung"
                                                    class="form-control"><?php echo isset($_GET['key']) ? $row['beschaedigung'] : ''; ?></textarea>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="gps">GPS Koordinaten</label>
                                                <textarea name="gps"
                                                    class="form-control"><?php echo isset($_GET['key']) ? $row['gps'] : ''; ?></textarea>
                                            </div>
                                        </div>

                                        <?php if (!empty($row['foto1']) || !empty($row['foto2']) || !empty($row['foto3'])): ?>
                                            <p class="card-title">Beschädigungs Fotos</p>
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
                                            <p class="card-title">Standort des Feuerlöschers</p>

                                            <?php if ($has_gps) { ?>
                                                <div id="map_view"></div>
                                            <?php } else { ?>
                                                <div class="alert alert-warning" role="alert">
                                                    ❗ GPS sind noch nicht eingetragen.
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                        <br>

                                        <button type="submit" class="btn btn-primary"><?php echo $action; ?></button>
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