<?php
session_start();
require_once "../config.php";

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

if ($action == 'add') { 

  // echo '<pre>';
  // var_dump($_POST);
  // echo '<pre>';exit;
  $anrede = $conn->real_escape_string($_POST['anrede']);
  $nachname = $conn->real_escape_string($_POST['nachname']);
  $vorname = $conn->real_escape_string($_POST['vorname']);
  $kundennummer = $conn->real_escape_string($_POST['kundennummer']);
  $strasse = $conn->real_escape_string($_POST['strasse']);
  $nr = $conn->real_escape_string($_POST['nr']);
  $plz = $conn->real_escape_string($_POST['plz']);
  $ort = $conn->real_escape_string($_POST['ort']);
  $ortauswahl = $conn->real_escape_string($_POST['ortauswahl']);
  $kontaktperson = $conn->real_escape_string($_POST['kontaktperson']);
  $handyfirma  = $conn->real_escape_string($_POST['handyfirma']);
  $handyprivat = $conn->real_escape_string($_POST['handyprivat']);
  $telefonfirma = $conn->real_escape_string($_POST['telefonfirma']);
  $telefonprivat = $conn->real_escape_string($_POST['telefonprivat']);
  $fax = $conn->real_escape_string($_POST['fax']);
  $emailp = $conn->real_escape_string($_POST['emailp']);
  $geprueftam = $conn->real_escape_string($_POST['geprueftam']);
  $naechstepruefung = $conn->real_escape_string($_POST['naechstepruefung']);
  // $safe_off_availability = empty($_POST['safety_off'])?'20':'10';
  $created = date('Y-m-d h:i:sa');

  // Add email duplicate function

  $sql = "INSERT INTO `kundenadressen` (`anrede`, `nachname`, `vorname`, `kundennummer`, `strasse`, `nr`, `plz`, `ort`, `ortauswahl`, `kontaktperson`, `handyfirma`, `handyprivat`, `telefonfirma`, `telefonprivat`, `fax`, `emailp`, `geprueftam`, `naechstepruefung`)
                          VALUES ('$anrede','$nachname','$vorname','$kundennummer','$strasse','$nr','$plz','$ort','$ortauswahl','$kontaktperson','$handyfirma','$handyprivat','$telefonfirma','$telefonprivat','$fax','$emailp','$geprueftam','$naechstepruefung')";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    header("location: ../customers.php?msg=2");
  } else {
    header("location: ../customers.php?msg=1");
  }
}

if ($action == 'edit') {

    // echo '<pre>';
    // var_dump($_POST);
    // echo '<pre>';exit;

  $key = $conn->real_escape_string($_POST['key']);
  $anrede = $conn->real_escape_string($_POST['anrede']);
  $nachname = $conn->real_escape_string($_POST['nachname']);
  $vorname = $conn->real_escape_string($_POST['vorname']);
  $kundennummer = $conn->real_escape_string($_POST['kundennummer']);
  $strasse = $conn->real_escape_string($_POST['strasse']);
  $nr = $conn->real_escape_string($_POST['nr']);
  $plz = $conn->real_escape_string($_POST['plz']);
  $ort = $conn->real_escape_string($_POST['ort']);
  $ortauswahl = $conn->real_escape_string($_POST['ortauswahl']);
  $kontaktperson = $conn->real_escape_string($_POST['kontaktperson']);
  $handyfirma  = $conn->real_escape_string($_POST['handyfirma']);
  $handyprivat = $conn->real_escape_string($_POST['handyprivat']);
  $telefonfirma = $conn->real_escape_string($_POST['telefonfirma']);
  $telefonprivat = $conn->real_escape_string($_POST['telefonprivat']);
  $fax = $conn->real_escape_string($_POST['fax']);
  $emailp = $conn->real_escape_string($_POST['emailp']);
  $geprueftam = $conn->real_escape_string($_POST['geprueftam']);
  $naechstepruefung = $conn->real_escape_string($_POST['naechstepruefung']);
  // $safety_officer = $conn->real_escape_string(empty($_POST['safety_off'])?'':$_POST['safety_off']);
  $updated = date('Y-m-d h:i:sa');

    $sql = "UPDATE `kundenadressen` SET `anrede`='$anrede',`nachname`='$nachname',`vorname`='$vorname',`kundennummer`='$kundennummer',`strasse`='$strasse',`nr`='$nr',`plz`='$plz',`ort`='$ort',`ortauswahl`='$ortauswahl',
    `kontaktperson`='$kontaktperson',`handyfirma`='$handyfirma',`handyprivat`='$handyprivat',`telefonfirma`='$telefonfirma',`telefonprivat`='$telefonprivat',`fax`='$fax',
    `emailp`='$emailp',`geprueftam`='$geprueftam',`naechstepruefung`='$naechstepruefung' WHERE `IDKunde` = '$key'";
    $result = mysqli_query($conn, $sql);


  if ($result) {
    header("location: ../customers.php?msg=4");
  } else {
    header("location: ../customers.php?msg=3");
  }
}

if ($action == 'delete') {
  if (isset($_GET['key'])) {
    $key = $_GET['key'];
  }
//  var_dump($key);exit;
  $sql = "DELETE FROM `kundenadressen` WHERE `IDKunde` = '$key'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    header("location: ../customers.php?msg=5");
  } else {
    header("location: ../customers.php?msg=6");
  }

}
