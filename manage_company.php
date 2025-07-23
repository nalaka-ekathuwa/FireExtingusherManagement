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
            if (isset($_GET['key'])) {
                $key = $_GET['key'];
                $action = 'edit';
                $sql = "SELECT * FROM `firma` f WHERE f.idfirma =$key";
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
                        <h2 class="header-title">Firmenliste</h2>
                        <div class="header-sub-title">
                            <nav class="breadcrumb breadcrumb-dash">
                                <a href="#" class="breadcrumb-item"><i
                                        class="anticon anticon-home m-r-5"></i>Startseite</a>
                                <span class="breadcrumb-item active"><?php echo ucfirst($action); ?> Firma</span>
                            </nav>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-30">
                                <div class="col-lg-12">
                                    <form action="control/company_process.php?action=<?php echo $action; ?>"
                                        method="post" enctype= 'multipart/form-data' >
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="Anrede">Anrede</label>
                                                <input name="anrede" type="text" class="form-control" id="anrede"
                                                    value="<?php echo isset($_GET['key']) ? $row['anrede'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="nachname">Nachname</label>
                                                <input name="nachname" type="text" class="form-control" id="nachname"
                                                    value="<?php echo isset($_GET['key']) ? $row['nachname'] : ''; ?>"
                                                    required>
                                                <?php if (isset($_GET['key'])) { ?><input type="hidden" name="key"
                                                        value="<?php echo $key; ?>"> <?php } ?>
                                            </div>
                                            <div class="form-group col-md-4">
                                                 <label for="vorname">Vorname</label>
                                                <input name="vorname" type="text" class="form-control" id="vorname"
                                                    value="<?php echo isset($_GET['key']) ? $row['vorname'] : ''; ?>">
                                           </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="idanmelden">Idanmelden</label>
                                                <input name="idanmelden" type="number" class="form-control" id="idanmelden"
                                                    value="<?php echo isset($_GET['key']) ? $row['idanmelden'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="firmenname">Firmenname</label>
                                                <input name="firmenname" type="text" class="form-control"
                                                    id="firmenname" placeholder="firmenname"
                                                    value="<?php echo isset($_GET['key']) ? $row['firmenname'] : ''; ?>"
                                                    required>
                                           </div>
                                            <div class="form-group col-md-4">
                                                <label for="straße">Strasse</label>
                                                <input name="straße" type="text" class="form-control" id="straße"
                                                    value="<?php echo isset($_GET['key']) ? $row['straße'] : ''; ?>"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="nr">NR</label>
                                                <input name="nr" type="text" class="form-control" id="nr"
                                                    value="<?php echo isset($_GET['key']) ? $row['nr'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="plz">Plz</label>
                                                <input name="plz" type="number" min="0" max="10" step="0.01" class="form-control" id="plz"
                                                    value="<?php echo isset($_GET['key']) ? $row['plz'] : ''; ?>"
                                                    required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="ort">Ort</label>
                                                <input name="ort" type="text" class="form-control" id="ort"
                                                    value="<?php echo isset($_GET['key']) ? $row['ort'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="niederlassung">Niederlassung</label>
                                                <input name="niederlassung" type="text" class="form-control" id="niederlassung"
                                                    value="<?php echo isset($_GET['key']) ? $row['niederlassung'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="firmatelefon">Firmatelefon</label>
                                                <input name="firmatelefon" type="tel" class="form-control" id="firmatelefon"
                                                    value="<?php echo isset($_GET['key']) ? $row['firmatelefon'] : ''; ?>"
                                                    required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="firmamobil">Firmamobil</label>
                                                <input name="firmamobil" type="tel" class="form-control" id="firmamobil"
                                                    value="<?php echo isset($_GET['key']) ? $row['firmamobil'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="firmafax">Firmafax</label>
                                                <input name="firmafax" type="tel" class="form-control" id="firmafax"
                                                    value="<?php echo isset($_GET['key']) ? $row['firmafax'] : ''; ?>"
                                                    required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="benutzername">Benutzername </label>
                                                <input name="benutzername" type="text" class="form-control" id="benutzername"
                                                    placeholder="benutzername"
                                                    value="<?php echo isset($_GET['key']) ? $row['benutzername'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="ansprechperson">Ansprechperson</label>
                                                <input name="ansprechperson" type="text" class="form-control" id="ansprechperson"
                                                    value="<?php echo isset($_GET['key']) ? $row['ansprechperson'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="privattelefon">Privattelefon</label>
                                                <input name="privattelefon" type="tel" class="form-control" id="privattelefon"
                                                    placeholder="privattelefon"
                                                    value="<?php echo isset($_GET['key']) ? $row['privattelefon'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="privathandy">Privathandy</label>
                                                <input name="privathandy" type="tel" class="form-control"
                                                    id="privathandy"
                                                    value="<?php echo isset($_GET['key']) ? $row['privathandy'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="anmerkung">Anmerkung</label>
                                                <input name="anmerkung" type="text" class="form-control"
                                                    id="anmerkung" placeholder="anmerkung"
                                                    value="<?php echo isset($_GET['key']) ? $row['anmerkung'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="information">Information</label>
                                                <input name="information" type="text" class="form-control" id="information"
                                                    value="<?php echo isset($_GET['key']) ? $row['information'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="bankname">Bank Name</label>
                                                <input name="bankname" type="text" class="form-control"
                                                    id="bankname"
                                                    value="<?php echo isset($_GET['key']) ? $row['bankname'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="iban">IBAN</label>
                                                <input name="iban" type="text" class="form-control"
                                                    id="iban"
                                                    value="<?php echo isset($_GET['key']) ? $row['iban'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="steuernummer">Steuernummer</label>
                                                <input name="steuernummer" type="text" class="form-control"
                                                    id="steuernummer"
                                                    value="<?php echo isset($_GET['key']) ? $row['steuernummer'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="nachricht">Nachricht</label>
                                                <input name="nachricht" type="text" class="form-control" id="nachricht"
                                                    value="<?php echo isset($_GET['key']) ? $row['nachricht'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="firmenlogo">Firmenlogo</label>
                                                <input name="firmenlogo" type="file" class="form-control" id="firmenlogo"
                                                    placeholder="firmenlogo"
                                                    value="<?php echo isset($_GET['key']) ? $row['firmenlogo'] : ''; ?>">
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