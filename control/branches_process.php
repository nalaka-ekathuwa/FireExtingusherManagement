<?php
session_start();
require_once "../config.php";

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

$session_urole = $_SESSION['role_id'];


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
  $email = $conn->real_escape_string($_POST['email']);
  $geprueftam = $conn->real_escape_string($_POST['geprueftam']);
  $naechstepruefung = $conn->real_escape_string($_POST['naechstepruefung']);
  // $safety_officer = $conn->real_escape_string(empty($_POST['safety_off'])?'':$_POST['safety_off']);
  $updated = date('Y-m-d h:i:sa');

    $sql = "UPDATE `kundenadressen` SET `anrede`='$anrede',`nachname`='$nachname',`vorname`='$vorname',`kundennummer`='$kundennummer',`strasse`='$strasse',`nr`='$nr',`plz`='$plz',`ort`='$ort',`ortauswahl`='$ortauswahl',
    `kontaktperson`='$kontaktperson',`handyfirma`='$handyfirma',`handyprivat`='$handyprivat',`telefonfirma`='$telefonfirma',`telefonprivat`='$telefonprivat',`fax`='$fax',
    `email`='$email',`geprueftam`='$geprueftam',`naechstepruefung`='$naechstepruefung' WHERE `IDKunde` = '$key'";
    $result = mysqli_query($conn, $sql);


  if ($result) {
    header("location: ../branches.php?msg=4");
  } else {
    header("location: ../branches.php?msg=3");
  }
}


if ($action == 'update') {

  // echo '<pre>';
  // var_dump($_POST);
  // var_dump($_FILES['foto1']['name']);
  // echo '<pre>';
  // exit;

  $sql_f = "SELECT * FROM `location` WHERE `ext_id` = '$key'";
  $result_f = mysqli_query($conn, $sql_f);
  $rowcount = mysqli_num_rows($result_f);

  $key = $conn->real_escape_string($_POST['key']);
  $beschreibungstandort = $conn->real_escape_string($_POST['beschreibungstandort']);
  $beschreibungstandort1 = $conn->real_escape_string($_POST['beschreibungstandort1']);
  $beschaedigung = $conn->real_escape_string($_POST['beschaedigung']);
  $gps = $conn->real_escape_string($_POST['gps']);
  // $hasImage = ($_FILES['foto1']['name'] != "");
  $path_db = null;

  $uploadedFotos = [];
  $fotoFields = [];

  for ($i = 1; $i <= 3; $i++) {
    $fotoKey = "foto$i";
    if (!empty($_FILES[$fotoKey]['name'])) {
      $img_name = $_FILES[$fotoKey]['name'];
      $img_tmp_name = $_FILES[$fotoKey]['tmp_name'];
      $ext = pathinfo($img_name, PATHINFO_EXTENSION);
      $img_new = time() . "_$i"; // prevent overwrite
      $path = "../assets/images/damages/" . $img_new . "." . $ext;
      $path_db = "assets/images/damages/" . $img_new . "." . $ext;

      if (move_uploaded_file($img_tmp_name, $path)) {
        $uploadedFotos[$fotoKey] = $path_db;
      }
    }
  }

  // Start with common SQL fields
  $kundenbestand_fields = "`beschreibungstandort1`='$beschreibungstandort1',`beschaedigung`='$beschaedigung',
  `gps`='$gps',`beschreibungstandort`='$beschreibungstandort'";

  // Append any uploaded image fields
  foreach ($uploadedFotos as $fotoKey => $path) {
    $kundenbestand_fields .= ", `$fotoKey`='$path'";
  }

  $sql = "UPDATE `kundenbestand` SET $kundenbestand_fields WHERE `idkundenbestand` = '$key'";
  $result = mysqli_query($conn, $sql);

    // Common location SQL
  if ($rowcount == 0) {
    $sql_l = "INSERT INTO `location`(`ext_id`, `gps`) VALUES ('$key', '$gps')";
  } else {
    $sql_l = "UPDATE `location` SET `gps`='$gps' WHERE `ext_id`='$key'";
  }
  $result_l = mysqli_query($conn, $sql_l);

  header("location: ../my_locations.php?msg=" . ($result ? "4" : "3"));

}

