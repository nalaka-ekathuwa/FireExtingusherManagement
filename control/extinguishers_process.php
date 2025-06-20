<?php
session_start();
require_once "../config.php";

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

$session_urole = $_SESSION['role_id'];

if ($action == 'add') {

  $key = $conn->real_escape_string($_POST['key']);
  $interneseriennummer = isset($_POST['interneseriennummer']) ? $conn->real_escape_string($_POST['interneseriennummer']) : '';
  $geprueftam = $conn->real_escape_string($_POST['geprueftam']);
  $naechstepruefung = $conn->real_escape_string($_POST['naechstepruefung']);
  $beschreibungstandort1 = $conn->real_escape_string($_POST['beschreibungstandort1']);
  $beschreibungstandort = $conn->real_escape_string($_POST['beschreibungstandort']);
  $gps = $conn->real_escape_string($_POST['gps']);
  $created = date('Y-m-d h:i:sa');

  // Add email duplicate function

  //image function
  if ($_FILES['image']['name'] != "") { // If a file has been uploaded
    $img_name = $_FILES['image']['name']; // To get file name
    $img_name_tmp = $_FILES['image']['tmp_name']; // To get file name temporary location

    $ext = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_new = time(); //New image name
    $path = "../assets/images/extinguisher/" . $img_new . "." . $ext; //New path to move
    $path_db = "assets/images/extinguisher/" . $img_new . "." . $ext;
    move_uploaded_file($img_name_tmp, $path); // To move the image to user_images folder
  }

  $sql = "INSERT INTO `extinguisher`(`brand`, `color`, `type`, `size`, `loeschmittel`, `hersteller`, `image`)
          VALUES ('$brand','$color','$type','$size','$loeschmittel','$hersteller','$path_db')";
  $result = mysqli_query($conn, $sql);

  header("location: ../extinguishers.php?msg=" . ($result ? "2" : "1"));
}

if ($action == 'edit') {

  // echo '<pre>';
  // var_dump($_POST);
  // var_dump($_FILES['fotofeuerloescher']['name']);
  // echo '<pre>';
  // exit;
  $key = $conn->real_escape_string($_POST['key']);
  $interneseriennummer = isset($_POST['interneseriennummer']) ? $conn->real_escape_string($_POST['interneseriennummer']) : '';
  $geprueftam = $conn->real_escape_string($_POST['geprueftam']);
  $naechstepruefung = $conn->real_escape_string($_POST['naechstepruefung']);
  $beschreibungstandort1 = $conn->real_escape_string($_POST['beschreibungstandort1']);
  $beschreibungstandort = $conn->real_escape_string($_POST['beschreibungstandort']);
  $beschaedigung = $conn->real_escape_string($_POST['beschaedigung']);
  $gps = $conn->real_escape_string($_POST['gps']);
  $updated = date('Y-m-d h:i:sa');

  $sql_f = "SELECT * FROM `location` WHERE `ext_id` = '$key'";
  $result_f = mysqli_query($conn, $sql_f);
  $rowcount = mysqli_num_rows($result_f);
  //image function

  $hasImage = ($_FILES['fotofeuerloescher']['name'] != "");
  $path_db = null;
  // echo $hasImage; exit;
  if ($hasImage) {
    $img_name = $_FILES['fotofeuerloescher']['name'];
    $img_name_tmp = $_FILES['fotofeuerloescher']['tmp_name'];
    $ext = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_new = time();
    $path = "../assets/images/extinguisher/" . $img_new . "." . $ext;
    $path_db = "assets/images/extinguisher/" . $img_new . "." . $ext;
    move_uploaded_file($img_name_tmp, $path);
  }

  // Common kundenbestand SQL
  $kundenbestand_fields = "`beschreibungstandort1`='$beschreibungstandort1',`beschaedigung`='$beschaedigung',
   `beschreibungstandort`='$beschreibungstandort', `gps`='$gps', `interneseriennummer`='$interneseriennummer'";
  if ($hasImage) {
    $kundenbestand_fields .= ", `fotofeuerloescher`='$path_db'";
  }
  $sql = "UPDATE `kundenbestand` SET $kundenbestand_fields WHERE `idkundenbestand` = '$key'";
  $result = mysqli_query($conn, $sql);

  // Common location SQL
  if ($rowcount == 0) {
    $sql_l = "INSERT INTO `location`(`ext_id`, " . ($hasImage ? "`img`, " : "") . "`gps`) VALUES ('$key', " . ($hasImage ? "'$path_db', " : "") . "'$gps')";
  } else {
    $sql_l = "UPDATE `location` SET " . ($hasImage ? "`img`='$path_db', " : "") . "`gps`='$gps' WHERE `ext_id`='$key'";
  }
  $result_l = mysqli_query($conn, $sql_l);

  // Redirect based on result
  header("location: ../extinguishers.php?msg=" . ($result ? "4" : "3"));

}

if ($action == 'delete') {
  if (isset($_GET['key'])) {
    $key = $_GET['key'];
  }
  //  var_dump($key);exit;
  $sql = "DELETE FROM `kundenbestand` WHERE `idkundenbestand` = '$key'";
  $result = mysqli_query($conn, $sql);

  header("location: ../extinguishers.php?msg=" . ($result ? "5" : "6"));

}


if ($action == 'update') {

  // echo '<pre>';
  // var_dump($_POST);
  // var_dump($_FILES['foto1']['name']);
  // echo '<pre>';
  // exit;

  $key = $conn->real_escape_string($_POST['key']);
  $interneseriennummer = isset($_POST['interneseriennummer']) ? $conn->real_escape_string($_POST['interneseriennummer']) : '';
  $beschreibungstandort = $conn->real_escape_string($_POST['beschreibungstandort']);
  $beschreibungstandort1 = $conn->real_escape_string($_POST['beschreibungstandort1']);
  $beschaedigung = $conn->real_escape_string($_POST['beschaedigung']);
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
  `beschreibungstandort`='$beschreibungstandort', `interneseriennummer`='$interneseriennummer'";

  // Append any uploaded image fields
  foreach ($uploadedFotos as $fotoKey => $path) {
    $kundenbestand_fields .= ", `$fotoKey`='$path'";
  }

  $sql = "UPDATE `kundenbestand` SET $kundenbestand_fields WHERE `idkundenbestand` = '$key'";
  $result = mysqli_query($conn, $sql);
  header("location: ../locations.php?msg=" . ($result ? "4" : "3"));

}

if ($action == 'clear') {
  if (isset($_GET['key'])) {
    $key = $_GET['key'];
  }
  //  var_dump($key);exit;
  $sql = "SELECT foto1,foto2,foto3 FROM `kundenbestand` WHERE `idkundenbestand` = '$key'";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $updateFields = ["`beschreibungstandort1` = NULL,`beschaedigung` = NULL"]; // always set this to NULL

    for ($i = 1; $i <= 3; $i++) {
      $fotoKey = "foto$i";
      if (!empty($row[$fotoKey])) {
        $filePath = "../" . $row[$fotoKey];
        if (file_exists($filePath)) {
          unlink($filePath);
        }
        $updateFields[] = "`$fotoKey` = NULL";
      }
    }

    $updateSQL = "UPDATE `kundenbestand` SET " . implode(", ", $updateFields) . " WHERE `idkundenbestand` = '$key'";
    mysqli_query($conn, $updateSQL);
  }

  header("location: ../damage_extinguishers.php?msg=" . ($result ? "2" : "1"));

}

