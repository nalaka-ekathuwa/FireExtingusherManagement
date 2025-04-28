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
                                                <input name="anrede" type="text" class="form-control" id="anrede"
                                                    value="<?php echo isset($_GET['key']) ? $row['anrede'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="nachname">Nachname</label>
                                                <input name="nachname" type="text" class="form-control" id="nachname"
                                                    value="<?php echo isset($_GET['key']) ? $row['nachname'] : ''; ?>"
                                                    required>
                                                <?php if (isset($_GET['key'])) { ?><input type="hidden" name="key"
                                                        value="<?php echo $key; ?>"> <?php } ?>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="vorname">Vorname</label>
                                                <input name="vorname" type="text" class="form-control" id="vorname"
                                                    value="<?php echo isset($_GET['key']) ? $row['vorname'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="kundennummer">Kundennummer</label>
                                                <input name="kundennummer" type="number" class="form-control"
                                                    id="kundennummer" placeholder="Kundennummer"
                                                    value="<?php echo isset($_GET['key']) ? $row['kundennummer'] : ''; ?>"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="strasse">Strasse</label>
                                                <input name="strasse" type="text" class="form-control" id="strasse"
                                                    value="<?php echo isset($_GET['key']) ? $row['strasse'] : ''; ?>"
                                                    required>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="nr">Nr </label>
                                                <input name="nr" type="number" class="form-control" id="nr"
                                                    placeholder="Nr"
                                                    value="<?php echo isset($_GET['key']) ? $row['nr'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="plz">Plz</label>
                                                <input name="plz" type="number" class="form-control" id="plz"
                                                    value="<?php echo isset($_GET['key']) ? $row['plz'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="ort">Ort</label>
                                                <input name="ort" type="text" class="form-control" id="ort"
                                                    placeholder="Ort"
                                                    value="<?php echo isset($_GET['key']) ? $row['ort'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="ortauswahl">Ortauswahl</label>
                                                <input name="ortauswahl" type="text" class="form-control"
                                                    id="ortauswahl"
                                                    value="<?php echo isset($_GET['key']) ? $row['ortauswahl'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="kontaktperson">Kontaktperson</label>
                                                <input name="kontaktperson" type="text" class="form-control"
                                                    id="kontaktperson" placeholder="Kontaktperson"
                                                    value="<?php echo isset($_GET['key']) ? $row['kontaktperson'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="handyfirma">HandyFirma</label>
                                                <input name="handyfirma" type="tel" class="form-control" id="handyfirma"
                                                    value="<?php echo isset($_GET['key']) ? $row['handyfirma'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="handyprivat">HandyPrivat</label>
                                                <input name="handyprivat" type="tel" class="form-control"
                                                    id="handyprivat"
                                                    value="<?php echo isset($_GET['key']) ? $row['handyprivat'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="telefonfirma">TelefonFirma</label>
                                                <input name="telefonfirma" type="tel" class="form-control"
                                                    id="telefonfirma"
                                                    value="<?php echo isset($_GET['key']) ? $row['telefonfirma'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="telefonprivat">TelefonPrivat</label>
                                                <input name="telefonprivat" type="tel" class="form-control"
                                                    id="telefonprivat"
                                                    value="<?php echo isset($_GET['key']) ? $row['telefonprivat'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="fax">Fax</label>
                                                <input name="fax" type="tel" class="form-control" id="fax"
                                                    value="<?php echo isset($_GET['key']) ? $row['fax'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="emailp">E-Mail</label>
                                                <input name="emailp" type="email" class="form-control" id="emailp"
                                                    placeholder="E-Mail"
                                                    value="<?php echo isset($_GET['key']) ? $row['emailp'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="geprueftam">Geprueftam</label>
                                                <input name="geprueftam" type="date" class="form-control" id="geprueftam"
                                                    value="<?php $dt = new DateTime($row['geprueftam']);
                                                    echo isset($_GET['key']) ? $dt->format('Y-m-d') : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="naechstepruefung">Naechstepruefung</label>
                                                <input name="naechstepruefung" type="date" class="form-control"
                                                    id="naechstepruefung" placeholder="naechstepruefung"
                                                    value="<?php $ds = new DateTime($row['naechstepruefung']);
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