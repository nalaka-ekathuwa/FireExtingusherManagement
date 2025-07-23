<?php
session_start();
require_once "../config.php";

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

$session_urole = $_SESSION['role_id'];


if ($action == 'add') {

    // echo '<pre>';
    // var_dump($_POST);
    // echo '<pre>';exit;

    $anrede = $conn->real_escape_string($_POST['anrede']);
    $nachname = $conn->real_escape_string($_POST['nachname']);
    $vorname = $conn->real_escape_string($_POST['vorname']);
    $idanmelden = $conn->real_escape_string($_POST['idanmelden']);
    $firmenname = $conn->real_escape_string($_POST['firmenname']);
    $straße = $conn->real_escape_string($_POST['straße']);
    $nr = $conn->real_escape_string($_POST['nr']);
    $plz = $conn->real_escape_string($_POST['plz']);
    $ort = $conn->real_escape_string($_POST['ort']);
    $niederlassung = $conn->real_escape_string($_POST['niederlassung']);
    $firmatelefon = $conn->real_escape_string($_POST['firmatelefon']);
    $firmamobil = $conn->real_escape_string($_POST['firmamobil']);
    $firmafax = $conn->real_escape_string($_POST['firmafax']);
    $benutzername = $conn->real_escape_string($_POST['benutzername']);
    $ansprechperson = $conn->real_escape_string($_POST['ansprechperson']);
    $privattelefon = $conn->real_escape_string($_POST['privattelefon']);
    $privathandy = $conn->real_escape_string($_POST['privathandy']);
    $anmerkung = $conn->real_escape_string($_POST['anmerkung']);
    $information = $conn->real_escape_string($_POST['information']);
    $bankname = $conn->real_escape_string($_POST['bankname']);
    $iban = $conn->real_escape_string($_POST['iban']);
    $steuernummer = $conn->real_escape_string($_POST['steuernummer']);
    $nachricht = $conn->real_escape_string($_POST['nachricht']);

    $hasImage = ($_FILES['firmenlogo']['name'] != "");
    $path_db = null;

    if ($hasImage) {
        $img_name = $_FILES['firmenlogo']['name'];
        $img_name_tmp = $_FILES['firmenlogo']['tmp_name'];
        $ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_new = time();
        $path = "../assets/images/firmenlogo/" . $img_new . "." . $ext;
        $path_db = "assets/images/firmenlogo/" . $img_new . "." . $ext;
        move_uploaded_file($img_name_tmp, $path);
    }
    // $safety_officer = $conn->real_escape_string(empty($_POST['safety_off'])?'':$_POST['safety_off']);
    $updated = date('Y-m-d h:i:sa');

    // Common kundenbestand SQL
    $sql = "INSERT INTO `firma` (
    `anrede`, `nachname`, `vorname`, `idanmelden`, `firmenname`, `straße`, `nr`, `plz`, `ort`, `niederlassung`, 
    `firmatelefon`, `firmamobil`, `firmafax`, `benutzername`, `ansprechperson`, `privattelefon`, `privathandy`, 
    `anmerkung`, `information`, `bankname`, `iban`, `steuernummer`, `nachricht`, `firmenlogo`
    ) VALUES (
    '$anrede', '$nachname', '$vorname', '$idanmelden', '$firmenname', '$straße', '$nr', '$plz', '$ort', '$niederlassung',
    '$firmatelefon', '$firmamobil', '$firmafax', '$benutzername', '$ansprechperson', '$privattelefon', '$privathandy',
    '$anmerkung', '$information', '$bankname', '$iban', '$steuernummer', '$nachricht', '$path_db'
    )";

    $result = mysqli_query($conn, $sql);
    header("location: ../company.php?msg=" . ($result ? "2" : "1"));
}

if ($action == 'edit') {

    $key = $conn->real_escape_string($_POST['key']);
    $anrede = $conn->real_escape_string($_POST['anrede']);
    $nachname = $conn->real_escape_string($_POST['nachname']);
    $vorname = $conn->real_escape_string($_POST['vorname']);
    $idanmelden = $conn->real_escape_string($_POST['idanmelden']);
    $firmenname = $conn->real_escape_string($_POST['firmenname']);
    $straße = $conn->real_escape_string($_POST['straße']);
    $nr = $conn->real_escape_string($_POST['nr']);
    $plz = $conn->real_escape_string($_POST['plz']);
    $ort = $conn->real_escape_string($_POST['ort']);
    $niederlassung = $conn->real_escape_string($_POST['niederlassung']);
    $firmatelefon = $conn->real_escape_string($_POST['firmatelefon']);
    $firmamobil = $conn->real_escape_string($_POST['firmamobil']);
    $firmafax = $conn->real_escape_string($_POST['firmafax']);
    $benutzername = $conn->real_escape_string($_POST['benutzername']);
    $ansprechperson = $conn->real_escape_string($_POST['ansprechperson']);
    $privattelefon = $conn->real_escape_string($_POST['privattelefon']);
    $privathandy = $conn->real_escape_string($_POST['privathandy']);
    $anmerkung = $conn->real_escape_string($_POST['anmerkung']);
    $information = $conn->real_escape_string($_POST['information']);
    $bankname = $conn->real_escape_string($_POST['bankname']);
    $iban = $conn->real_escape_string($_POST['iban']);
    $steuernummer = $conn->real_escape_string($_POST['steuernummer']);
    $nachricht = $conn->real_escape_string($_POST['nachricht']);

    $hasImage = ($_FILES['firmenlogo']['name'] != "");
    $path_db = null;

    if ($hasImage) {
        $img_name = $_FILES['firmenlogo']['name'];
        $img_name_tmp = $_FILES['firmenlogo']['tmp_name'];
        $ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_new = time();
        $path = "../assets/images/firmenlogo/" . $img_new . "." . $ext;
        $path_db = "assets/images/firmenlogo/" . $img_new . "." . $ext;
        move_uploaded_file($img_name_tmp, $path);
    }
    // $safety_officer = $conn->real_escape_string(empty($_POST['safety_off'])?'':$_POST['safety_off']);
    $updated = date('Y-m-d h:i:sa');

    // Common kundenbestand SQL
    $kundenbestand_fields = "`anrede`='$anrede',`nachname`='$nachname',`vorname`='$vorname',`idanmelden`='$idanmelden',`firmenname`='$firmenname',`straße`='$straße',
   `nr`='$nr', `plz`='$plz', `ort`='$ort', `niederlassung`='$niederlassung', `firmatelefon`='$firmatelefon', `firmafax`='$firmafax', `benutzername`='$benutzername', 
   `ansprechperson`='$ansprechperson', `privattelefon`='$privattelefon', `privathandy`='$privathandy', `anmerkung`='$anmerkung', `information`='$information', 
   `bankname`='$bankname', `iban`='$iban', `steuernummer`='$steuernummer', `nachricht`='$nachricht'";
    if ($hasImage) {
        $kundenbestand_fields .= ", `firmenlogo`='$path_db'";
    }
    $sql = "UPDATE `firma` SET $kundenbestand_fields WHERE `idfirma` = '$key'";
    $result = mysqli_query($conn, $sql);

    // echo '<pre>';
    // var_dump($sql);
    // echo '<pre>';exit;

    header("location: ../company.php?msg=" . ($result ? "4" : "3"));
}

if ($action == 'delete') {
  if (isset($_GET['key'])) {
    $key = $_GET['key'];
  }
  //  var_dump($key);exit;
  $sql = "DELETE FROM `firma` WHERE `idfirma` = '$key'";
  $result = mysqli_query($conn, $sql);

  header("location: ../company.php?msg=" . ($result ? "5" : "6"));

}


