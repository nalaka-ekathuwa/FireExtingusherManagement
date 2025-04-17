<?php
session_start();
require_once "../config.php";

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

if ($action == 'add') { 

  // echo '<pre>';
  //   var_dump($_POST);
  //   echo '<pre>';exit;
  $Anrede = $conn->real_escape_string($_POST['Anrede']);
  $Nachname = $conn->real_escape_string($_POST['Nachname']);
  $Vorname = $conn->real_escape_string($_POST['Vorname']);
  $Kundennummer = $conn->real_escape_string($_POST['Kundennummer']);
  $Strasse = $conn->real_escape_string($_POST['Strasse']);
  $Nr = $conn->real_escape_string($_POST['Nr']);
  $Plz = $conn->real_escape_string($_POST['Plz']);
  $Ort = $conn->real_escape_string($_POST['Ort']);
  $Ortauswahl = $conn->real_escape_string($_POST['Ortauswahl']);
  $Kontaktperson = $conn->real_escape_string($_POST['Kontaktperson']);
  $HandyFirma  = $conn->real_escape_string($_POST['HandyFirma']);
  $HandyPrivat = $conn->real_escape_string($_POST['HandyPrivat']);
  $TelefonFirma = $conn->real_escape_string($_POST['TelefonFirma']);
  $TelefonPrivat = $conn->real_escape_string($_POST['TelefonPrivat']);
  $Fax = $conn->real_escape_string($_POST['Fax']);
  $E_Mail = $conn->real_escape_string($_POST['E-Mail']);
  $Geprüftam = $conn->real_escape_string($_POST['Geprüftam']);
  $NächstePrüfung = $conn->real_escape_string($_POST['NächstePrüfung']);
  // $safe_off_availability = empty($_POST['safety_off'])?'20':'10';
  $created = date('Y-m-d h:i:sa');

  // Add email duplicate function

  $sql = "INSERT INTO `kundenadressen` (`Anrede`, `Nachname`, `Vorname`, `Kundennummer`, `Strasse`, `Nr`, `Plz`, `Ort`, `Ortauswahl`, `Kontaktperson`, `HandyFirma`, `HandyPrivat`, `TelefonFirma`, `TelefonPrivat`, `Fax`, `E-Mail`, `Geprüftam`, `NächstePrüfung`)
                          VALUES ('$Anrede','$Nachname','$Vorname','$Kundennummer','$Strasse','$Nr','$Plz','$Ort','$Ortauswahl','$Kontaktperson','$HandyFirma','$HandyPrivat','$TelefonFirma','$TelefonPrivat','$Fax','$E_Mail','$Geprüftam','$NächstePrüfung')";
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
  $Anrede = $conn->real_escape_string($_POST['Anrede']);
  $Nachname = $conn->real_escape_string($_POST['Nachname']);
  $Vorname = $conn->real_escape_string($_POST['Vorname']);
  $Kundennummer = $conn->real_escape_string($_POST['Kundennummer']);
  $Strasse = $conn->real_escape_string($_POST['Strasse']);
  $Nr = $conn->real_escape_string($_POST['Nr']);
  $Plz = $conn->real_escape_string($_POST['Plz']);
  $Ort = $conn->real_escape_string($_POST['Ort']);
  $Ortauswahl = $conn->real_escape_string($_POST['Ortauswahl']);
  $Kontaktperson = $conn->real_escape_string($_POST['Kontaktperson']);
  $HandyFirma  = $conn->real_escape_string($_POST['HandyFirma']);
  $HandyPrivat = $conn->real_escape_string($_POST['HandyPrivat']);
  $TelefonFirma = $conn->real_escape_string($_POST['TelefonFirma']);
  $TelefonPrivat = $conn->real_escape_string($_POST['TelefonPrivat']);
  $Fax = $conn->real_escape_string($_POST['Fax']);
  $E_Mail = $conn->real_escape_string($_POST['E-Mail']);
  $Geprüftam = $conn->real_escape_string($_POST['Geprüftam']);
  $NächstePrüfung = $conn->real_escape_string($_POST['NächstePrüfung']);
  // $safety_officer = $conn->real_escape_string(empty($_POST['safety_off'])?'':$_POST['safety_off']);
  $updated = date('Y-m-d h:i:sa');

    $sql = "UPDATE `kundenadressen` SET `Anrede`='$Anrede',`Nachname`='$Nachname',`Vorname`='$Vorname',`Kundennummer`='$Kundennummer',`Strasse`='$Strasse',`Nr`='$Nr',`Plz`='$Plz',`Ort`='$Ort',`Ortauswahl`='$Ortauswahl',
    `Kontaktperson`='$Kontaktperson',`HandyFirma`='$HandyFirma',`HandyPrivat`='$HandyPrivat',`TelefonFirma`='$TelefonFirma',`TelefonPrivat`='$TelefonPrivat',`Fax`='$Fax',
    `E-Mail`='$E_Mail',`Geprüftam`='$Geprüftam',`NächstePrüfung`='$NächstePrüfung' WHERE `IDKunde` = '$key'";
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
