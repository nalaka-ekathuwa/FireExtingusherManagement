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
            if (isset($_GET['key'])) {
                $key = $_GET['key'];
                $action = 'edit';
                $sql = "SELECT * FROM `kundenadressen` c WHERE c.IDKunde =$key";
                //echo $sql;
                $conn = $GLOBALS['con'];
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $image = !empty($row['Logo']) ? $row['Logo'] : 'assets/images/users/default.jpg';
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
                        <h2 class="header-title">Kundenliste</h2>
                        <div class="header-sub-title">
                            <nav class="breadcrumb breadcrumb-dash">
                                <a href="#" class="breadcrumb-item"><i
                                        class="anticon anticon-home m-r-5"></i>Startseite</a>
                                <span class="breadcrumb-item active"><?php echo ucfirst($action); ?> Kunde</span>
                            </nav>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-30">
                                <div class="col-lg-12">
                                    <form action="control/customer_process.php?action=<?php echo $action; ?>"
                                        method="post">
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="Anrede">Anrede</label>
                                                <input name="Anrede" type="text" class="form-control" id="Anrede"
                                                    value="<?php echo isset($_GET['key']) ? $row['Anrede'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="Nachname">Nachname</label>
                                                <input name="Nachname" type="text" class="form-control" id="Nachname"
                                                    value="<?php echo isset($_GET['key']) ? $row['Nachname'] : ''; ?>"
                                                    required>
                                                <?php if (isset($_GET['key'])) { ?><input type="hidden" name="key"
                                                        value="<?php echo $key; ?>"> <?php } ?>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="Vorname">Vorname</label>
                                                <input name="Vorname" type="text" class="form-control" id="Vorname"
                                                    value="<?php echo isset($_GET['key']) ? $row['Vorname'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="Kundennummer">Kundennummer</label>
                                                <input name="Kundennummer" type="text" class="form-control"
                                                    id="Kundennummer" placeholder="Kundennummer"
                                                    value="<?php echo isset($_GET['key']) ? $row['Kundennummer'] : ''; ?>"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="Strasse">Strasse</label>
                                                <input name="Strasse" type="text" class="form-control" id="Strasse"
                                                    value="<?php echo isset($_GET['key']) ? $row['Strasse'] : ''; ?>"
                                                    required>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="Nr">Nr </label>
                                                <input name="Nr" type="text" class="form-control" id="Nr"
                                                    placeholder="Nr"
                                                    value="<?php echo isset($_GET['key']) ? $row['Nr'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="Plz">Plz</label>
                                                <input name="Plz" type="text" class="form-control" id="Plz"
                                                    value="<?php echo isset($_GET['key']) ? $row['Plz'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="Ort">Ort</label>
                                                <input name="Ort" type="text" class="form-control" id="Ort"
                                                    placeholder="Ort"
                                                    value="<?php echo isset($_GET['key']) ? $row['Ort'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="Ortauswahl">Ortauswahl</label>
                                                <input name="Ortauswahl" type="text" class="form-control"
                                                    id="Ortauswahl"
                                                    value="<?php echo isset($_GET['key']) ? $row['Ortauswahl'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="Kontaktperson">Kontaktperson</label>
                                                <input name="Kontaktperson" type="text" class="form-control"
                                                    id="Kontaktperson" placeholder="Kontaktperson"
                                                    value="<?php echo isset($_GET['key']) ? $row['Kontaktperson'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="HandyFirma">HandyFirma</label>
                                                <input name="HandyFirma" type="tel" class="form-control" id="HandyFirma"
                                                    value="<?php echo isset($_GET['key']) ? $row['HandyFirma'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="HandyPrivat">HandyPrivat</label>
                                                <input name="HandyPrivat" type="tel" class="form-control"
                                                    id="HandyPrivat"
                                                    value="<?php echo isset($_GET['key']) ? $row['HandyPrivat'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="TelefonFirma">TelefonFirma</label>
                                                <input name="TelefonFirma" type="tel" class="form-control"
                                                    id="TelefonFirma"
                                                    value="<?php echo isset($_GET['key']) ? $row['TelefonFirma'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="TelefonPrivat">TelefonPrivat</label>
                                                <input name="TelefonPrivat" type="tel" class="form-control"
                                                    id="TelefonPrivat"
                                                    value="<?php echo isset($_GET['key']) ? $row['TelefonPrivat'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="Fax">Fax</label>
                                                <input name="Fax" type="tel" class="form-control" id="Fax"
                                                    value="<?php echo isset($_GET['key']) ? $row['Fax'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="E-Mail">E-Mail</label>
                                                <input name="E-Mail" type="email" class="form-control" id="E-Mail"
                                                    placeholder="E-Mail"
                                                    value="<?php echo isset($_GET['key']) ? $row['E-Mail'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="Ortauswahl">Ortauswahl</label>
                                                <input name="Ortauswahl" type="text" class="form-control"
                                                    id="Ortauswahl"
                                                    value="<?php echo isset($_GET['key']) ? $row['Ortauswahl'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="Kontaktperson">Kontaktperson</label>
                                                <input name="Kontaktperson" type="text" class="form-control"
                                                    id="Kontaktperson" placeholder="Kontaktperson"
                                                    value="<?php echo isset($_GET['key']) ? $row['Kontaktperson'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="Geprüftam">Geprüftam</label>
                                                <input name="Geprüftam" type="date" class="form-control" id="Geprüftam"
                                                    value="<?php $dt = new DateTime($row['Geprüftam']);
                                                    echo isset($_GET['key']) ? $dt->format('Y-m-d') : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="NächstePrüfung">NächstePrüfung</label>
                                                <input name="NächstePrüfung" type="date" class="form-control"
                                                    id="NächstePrüfung" placeholder="NächstePrüfung"
                                                    value="<?php $ds = new DateTime($row['NächstePrüfung']);
                                                    echo isset($_GET['key']) ? $ds->format('Y-m-d') : ''; ?>">
                                            </div>
                                        </div>


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
                <!-- Footer END -->

            </div>
            <!-- Page Container END -->

        </div>
    </div>

    <?php include 'foot.php'; ?>

</body>

</html>