<?php
session_start();
require_once "../config.php";

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

$session_urole = $_SESSION['role_id'];

if ($action == 'add') {

  $key = $conn->real_escape_string($_POST['key']);
  $interneseriennummer =  isset($_POST['interneseriennummer'])?$conn->real_escape_string($_POST['interneseriennummer']):'';
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
  // echo '<pre>';
  // exit;
  $key = $conn->real_escape_string($_POST['key']);
  $interneseriennummer =  isset($_POST['interneseriennummer'])?$conn->real_escape_string($_POST['interneseriennummer']):'';
  $geprueftam = $conn->real_escape_string($_POST['geprueftam']);
  $naechstepruefung = $conn->real_escape_string($_POST['naechstepruefung']);
  $beschreibungstandort1 = $conn->real_escape_string($_POST['beschreibungstandort1']);
  $beschreibungstandort = $conn->real_escape_string($_POST['beschreibungstandort']);
  $gps = $conn->real_escape_string($_POST['gps']);
  $updated = date('Y-m-d h:i:sa');

  $sql_f = "SELECT * FROM `location` WHERE `ext_id` = '$key'";  
  $result_f = mysqli_query($conn, $sql_f);
  $rowcount = mysqli_num_rows($result_f);
  //image function

  $hasImage = ($_FILES['fotofeuerloescher']['name'] != "");
  $has_Interneseriennummer = ($session_urole==1);
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
  $kundenbestand_fields = "`beschreibungstandort1`='$beschreibungstandort1',
   `beschreibungstandort`='$beschreibungstandort', `gps`='$gps'";
  if ($hasImage) {
    $kundenbestand_fields .= ", `fotofeuerloescher`='$path_db'";
  }
  if ($has_Interneseriennummer) {
    $kundenbestand_fields .= ", `interneseriennummer`='$interneseriennummer'";
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
