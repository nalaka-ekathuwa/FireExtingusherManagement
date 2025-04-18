<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'; ?>
<!-- page css -->
<link href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">

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
                $sql = "SELECT k.*, l.foto as img, l.Koordinaten , c.Anrede, c.Vorname, c.Nachname, c.Kontaktperson, c.NächstePrüfung, c.HandyFirma, c.TelefonFirma, c.Ortauswahl,c.EMail,c.Geprüftam FROM `kundenbestand` k JOIN kundenadressen c ON k.IDKunde=c.IDKunde  LEFT JOIN `locations` l ON k.IDKundenbestand=l.IDKundenbestand  WHERE k.IDKundenbestand =$key";
                //echo $sql;
                $conn = $GLOBALS['con'];
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $image = !is_null($row['img']) ? $row['img'] : 'assets/images/extinguisher/dummy_ext.jpg';
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
                        <h2 class="header-title">Extinguisher List </h2>
                        <div class="header-sub-title">
                            <nav class="breadcrumb breadcrumb-dash">
                                <a href="#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                                <span class="breadcrumb-item active"><?php echo ucfirst($action); ?> Extinguisher</span>
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
                                                <?php echo isset($_GET['key']) ? $row['Anrede'] . '. ' . $row['Vorname'] . ' ' . $row['Nachname'] : ''; ?>
                                            </h2>
                                            <p class="text-opacity font-size-13">Kontaktperson -
                                                <?php echo isset($_GET['key']) ? $row['Kontaktperson'] : ''; ?>
                                            </p>
                                            <p class="text-dark m-b-20">NächstePrüfung -
                                                <?php echo isset($_GET['key']) ? $row['NächstePrüfung'] : ''; ?>
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
                                                        <?php echo isset($_GET['key']) ? $row['EMail'] : ''; ?>
                                                    </p>
                                                </li>
                                                <li class="row">
                                                    <p class="col-sm-4 col-4 font-weight-semibold text-dark m-b-5">
                                                        <i class="m-r-10 text-primary anticon anticon-phone"></i>
                                                        <span>Phone: </span>
                                                    </p>
                                                    <p class="col font-weight-semibold">
                                                        <?php echo isset($_GET['key']) ? $row['HandyFirma'] . ' ' . $row['TelefonFirma'] : ''; ?>
                                                    </p>
                                                </li>
                                                <li class="row">
                                                    <p class="col-sm-4 col-5 font-weight-semibold text-dark m-b-5">
                                                        <i class="m-r-10 text-primary anticon anticon-compass"></i>
                                                        <span>Location: </span>
                                                    </p>
                                                    <p class="col font-weight-semibold">
                                                        <?php echo isset($_GET['key']) ? $row['Ortauswahl'] : ''; ?>
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
                                                <label for="Interneseriennummer">Interneseriennummer</label>
                                                <input name="Interneseriennummer" type="text" class="form-control"
                                                    id="Interneseriennummer"
                                                    value="<?php echo isset($_GET['key']) ? $row['Interneseriennummer'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="Datumangelegt">Datumangelegt</label>
                                                <input name="Datumangelegt" type="text" class="form-control"
                                                    id="Datumangelegt"
                                                    value="<?php echo isset($_GET['key']) ? $row['Datumangelegt'] : ''; ?>"
                                                    disabled>
                                                <?php if (isset($_GET['key'])) { ?><input type="hidden" name="key"
                                                        value="<?php echo $key; ?>"> <?php } ?>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="Anzahl">Anzahl</label>
                                                <input name="Anzahl" type="text" class="form-control" id="Anzahl"
                                                    value="<?php echo isset($_GET['key']) ? $row['Anzahl'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="Artikel">Artikel</label>
                                                <input name="Artikel" type="text" class="form-control" id="Artikel"
                                                    value="<?php echo isset($_GET['key']) ? $row['Artikel'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="Löschmittel">Löschmittel</label>
                                                <input name="Löschmittel" type="text" class="form-control"
                                                    id="Löschmittel"
                                                    value="<?php echo isset($_GET['key']) ? $row['Löschmittel'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="Typ">Typ</label>
                                                <input name="Typ" type="text" class="form-control" id="Typ"
                                                    value="<?php echo isset($_GET['key']) ? $row['Typ'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="Inhalt">Inhalt</label>
                                                <input name="Inhalt" type="text" class="form-control" id="Inhalt"
                                                    value="<?php echo isset($_GET['key']) ? $row['Inhalt'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="BJ">BJ</label>
                                                <input name="BJ" type="text" class="form-control" id="BJ"
                                                    value="<?php echo isset($_GET['key']) ? $row['BJ'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="PrüfungEinzelP">PrüfungEinzelP</label>
                                                <input name="PrüfungEinzelP" type="text" class="form-control"
                                                    id="PrüfungEinzelP"
                                                    value="<?php echo isset($_GET['key']) ? $row['PrüfungEinzelP'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="Prüfung§15P">Prüfung§15P</label>
                                                <input name="Prüfung§15P" type="text" class="form-control"
                                                    id="Prüfung§15P"
                                                    value="<?php echo isset($_GET['key']) ? $row['Prüfung§15P'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="InnenkontroP">InnenkontroP</label>
                                                <input name="InnenkontroP" type="number" class="form-control"
                                                    id="InnenkontroP"
                                                    value="<?php echo isset($_GET['key']) ? $row['InnenkontroP'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label
                                                    for="FeuerlöscherZusammengeholt">FeuerlöscherZusammengeholt</label>
                                                <input name="FeuerlöscherZusammengeholt" type="text"
                                                    class="form-control" id="FeuerlöscherZusammengeholt"
                                                    value="<?php echo isset($_GET['key']) ? $row['FeuerlöscherZusammengeholt'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="RüstkostenP">RüstkostenP</label>
                                                <input name="RüstkostenP" type="text" class="form-control"
                                                    id="RüstkostenP"
                                                    value="<?php echo isset($_GET['key']) ? $row['RüstkostenP'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="ORingErsetzt">ORingErsetzt</label>
                                                <input name="ORingErsetzt" type="text" class="form-control"
                                                    id="ORingErsetzt"
                                                    value="<?php echo isset($_GET['key']) ? $row['ORingErsetzt'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="ORingFarbe">ORingFarbe</label>
                                                <input name="ORingFarbe" type="text" class="form-control"
                                                    id="ORingFarbe"
                                                    value="<?php echo isset($_GET['key']) ? $row['ORingFarbe'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="AnzahlO">AnzahlO</label>
                                                <input name="AnzahlO" type="text" class="form-control" id="AnzahlO"
                                                    value="<?php echo isset($_GET['key']) ? $row['AnzahlO'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="ORingP">ORingP</label>
                                                <input name="ORingP" type="text" class="form-control" id="ORingP"
                                                    value="<?php echo isset($_GET['key']) ? $row['ORingP'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="Voltprüfung">Voltprüfung</label>
                                                <input name="Voltprüfung" type="text" class="form-control"
                                                    id="Voltprüfung"
                                                    value="<?php echo isset($_GET['key']) ? $row['Voltprüfung'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="Prüfung500VoltP">Prüfung500VoltP</label>
                                                <input name="Prüfung500VoltP" type="text" class="form-control"
                                                    id="Prüfung500VoltP"
                                                    value="<?php echo isset($_GET['key']) ? $row['Prüfung500VoltP'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="CO2Ventielprüfung">CO2Ventielprüfung</label>
                                                <input name="CO2Ventielprüfung" type="text" class="form-control"
                                                    id="CO2Ventielprüfung"
                                                    value="<?php echo isset($_GET['key']) ? $row['CO2Ventielprüfung'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="CO2VentielprüfungP">CO2VentielprüfungP</label>
                                                <input name="CO2VentielprüfungP" type="text" class="form-control"
                                                    id="CO2VentielprüfungP"
                                                    value="<?php echo isset($_GET['key']) ? $row['CO2VentielprüfungP'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="CO2GesamtGewicht">CO2GesamtGewicht</label>
                                                <input name="CO2GesamtGewicht" type="text" class="form-control"
                                                    id="CO2GesamtGewicht"
                                                    value="<?php echo isset($_GET['key']) ? $row['CO2GesamtGewicht'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="DauerdruckPrüfP">DauerdruckPrüfP</label>
                                                <input name="DauerdruckPrüfP" type="text" class="form-control"
                                                    id="DauerdruckPrüfP"
                                                    value="<?php echo isset($_GET['key']) ? $row['DauerdruckPrüfP'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="DauerdruckventielP">DauerdruckventielP</label>
                                                <input name="DauerdruckventielP" type="text" class="form-control"
                                                    id="DauerdruckventielP"
                                                    value="<?php echo isset($_GET['key']) ? $row['DauerdruckventielP'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="AutoventielP">AutoventielP</label>
                                                <input name="AutoventielP" type="text" class="form-control"
                                                    id="AutoventielP"
                                                    value="<?php echo isset($_GET['key']) ? $row['AutoventielP'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="AutoprüfPreis">AutoprüfPreis</label>
                                                <input name="AutoprüfPreis" type="text" class="form-control"
                                                    id="AutoprüfPreis"
                                                    value="<?php echo isset($_GET['key']) ? $row['AutoprüfPreis'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="PlatzscheibeGeprüft">PlatzscheibeGeprüft</label>
                                                <input name="PlatzscheibeGeprüft" type="text" class="form-control"
                                                    id="PlatzscheibeGeprüft"
                                                    value="<?php echo isset($_GET['key']) ? $row['PlatzscheibeGeprüft'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label
                                                    for="RoststellenBehandlungBis5mm">RoststellenBehandlungBis5mm</label>
                                                <input name="RoststellenBehandlungBis5mm" type="text"
                                                    class="form-control" id="RoststellenBehandlungBis5mm"
                                                    value="<?php echo isset($_GET['key']) ? $row['RoststellenBehandlungBis5mm'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="KorrosionP">KorrosionP</label>
                                                <input name="KorrosionP" type="text" class="form-control"
                                                    id="KorrosionP"
                                                    value="<?php echo isset($_GET['key']) ? $row['KorrosionP'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="AutoprüfPreis">AutoprüfPreis</label>
                                                <input name="AutoprüfPreis" type="text" class="form-control"
                                                    id="AutoprüfPreis"
                                                    value="<?php echo isset($_GET['key']) ? $row['AutoprüfPreis'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="EntsorgtJN123">EntsorgtJN123</label>
                                                <input name="EntsorgtJN123" type="text" class="form-control"
                                                    id="EntsorgtJN123"
                                                    value="<?php echo isset($_GET['key']) ? $row['EntsorgtJN123'] : ''; ?>"
                                                    disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="Entsorgt">Entsorgt</label>
                                                <input name="Entsorgt" type="text" class="form-control" id="Entsorgt"
                                                    value="<?php echo isset($_GET['key']) ? $row['Entsorgt'] : ''; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="FotoFeuerlöscher">FotoFeuerlöscher</label>
                                                <input name="FotoFeuerlöscher" type="file" class="form-control"
                                                    id="FotoFeuerlöscher"
                                                    value="<?php echo isset($_GET['key']) ? $row['FotoFeuerlöscher'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="Geprüftam">Geprüft am</label>
                                                <input name="Geprüftam" type="text"
                                                    class="form-control datepicker-input" id="Geprüftam" value="<?php $dt = new DateTime($row['Geprüftam']);
                                                    echo isset($_GET['key']) ? $dt->format('m/d/Y') : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="LöschmittelGewicht">NächstePrüfung</label>
                                                <input name="LöschmittelGewicht" type="text"
                                                    class="form-control datepicker-input" id="LöschmittelGewicht" value="<?php $ds = new DateTime($row['NächstePrüfung']);
                                                    echo isset($_GET['key']) ? $ds->format('m/d/Y') : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="BeschreibungStandort1">Kurz Beschreibung </label>
                                                <input name="BeschreibungStandort1" type="text" class="form-control"
                                                    id="BeschreibungStandort1"
                                                    value="<?php echo isset($_GET['key']) ? $row['BeschreibungStandort1'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="Beschädigung1">Beschädigung</label>
                                                <textarea name="Beschädigung1" class="form-control" ><?php echo isset($_GET['key']) ? $row['Beschädigung1'] : ''; ?></textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="BeschreibungStandort2">Standortquelle</label>
                                                <textarea name="BeschreibungStandort2" class="form-control"><?php echo isset($_GET['key']) ? $row['BeschreibungStandort2'] : ''; ?></textarea>
                                            </div>
                                        </div>

                                        <hr>
                                        <p class="card-title">Standortdetails</p>
                                        <div class="map rounded overflow-hidden">
                                            <div style="width: 100%">
                                                <?php $map_src = !is_null($row['BeschreibungStandort2']) ? $row['BeschreibungStandort2'] : "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d336579.39401982195!2d9.760397307209544!3d48.77183768336409!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4799af50b1556c91%3A0xc12c3d86f8e797ee!2s73547%20Lorch%2C%20Germany!5e0!3m2!1sen!2sfi!4v1744974868972!5m2!1sen!2sfi"; ?>
                                                <iframe src="<?php echo $map_src; ?>" width="100%" height="400"
                                                    style="border:0;" allowfullscreen="" loading="lazy"
                                                    referrerpolicy="no-referrer-when-downgrade"></iframe>

                                            </div>
                                        </div>
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
    <?php include 'foot.php'; ?>
    <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script>
        $('.datepicker-input').datepicker();
    </script>
</body>

</html>