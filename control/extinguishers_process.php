<?php
session_start();
require_once "../config.php";

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

$session_urole = $_SESSION['role_id'];

if ($action == 'add') {

  $brand = $conn->real_escape_string($_POST['brand']);
  $color = $conn->real_escape_string($_POST['color']);
  $type = $conn->real_escape_string($_POST['type']);
  $size = $conn->real_escape_string($_POST['size']);
  $loeschmittel = $conn->real_escape_string($_POST['loeschmittel']);
  $hersteller = $conn->real_escape_string($_POST['hersteller']);
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
  // echo $session_urole;
  // echo '<pre>';
  // exit;
  $key = $conn->real_escape_string($_POST['key']);
  $Interneseriennummer =  isset($_POST['Interneseriennummer'])?$conn->real_escape_string($_POST['Interneseriennummer']):'';
  $Beschädigung1 = $conn->real_escape_string($_POST['Beschädigung1']);
  $BeschreibungStandort2 = $conn->real_escape_string($_POST['BeschreibungStandort2']);
  $Geprüftam = $conn->real_escape_string($_POST['Geprüftam']);
  $LöschmittelGewicht = $conn->real_escape_string($_POST['LöschmittelGewicht']);
  $updated = date('Y-m-d h:i:sa');

  $sql_f = "SELECT * FROM `locations` WHERE `IDKundenbestand` = '$key'";
  $result_f = mysqli_query($conn, $sql_f);
  $rowcount = mysqli_num_rows($result_f);
  // echo $rowcount; exit;
  //image function

  $hasImage = ($_FILES['FotoFeuerlöscher']['name'] != "");
  $has_Interneseriennummer = ($session_urole==1);
  $path_db = null;

  if ($hasImage) {
    $img_name = $_FILES['FotoFeuerlöscher']['name'];
    $img_name_tmp = $_FILES['FotoFeuerlöscher']['tmp_name'];
    $ext = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_new = time();
    $path = "../assets/images/extinguisher/" . $img_new . "." . $ext;
    $path_db = "assets/images/extinguisher/" . $img_new . "." . $ext;
    move_uploaded_file($img_name_tmp, $path);
  }

  // Common kundenbestand SQL
  $kundenbestand_fields = "`Interneseriennummer`='$Interneseriennummer', `Beschädigung1`='$Beschädigung1', `BeschreibungStandort2`='$BeschreibungStandort2'";
  if ($hasImage) {
    $kundenbestand_fields .= ", `FotoFeuerlöscher`='$path_db'";
  }
  if ($has_Interneseriennummer) {
    $kundenbestand_fields .= ", `Interneseriennummer`='$Interneseriennummer'";
  }
  $sql = "UPDATE `kundenbestand` SET $kundenbestand_fields WHERE `IDKundenbestand` = '$key'";
  $result = mysqli_query($conn, $sql);

  // Common locations SQL
  if ($rowcount == 0) {
    $sql_l = "INSERT INTO `locations`(`IDKundenbestand`, " . ($hasImage ? "`foto`, " : "") . "`Koordinaten`) VALUES ('$key', " . ($hasImage ? "'$path_db', " : "") . "'$BeschreibungStandort2')";
  } else {
    $sql_l = "UPDATE `locations` SET `IDKundenbestand`='$key', " . ($hasImage ? "`foto`='$path_db', " : "") . "`Koordinaten`='$BeschreibungStandort2' WHERE `id`='$key'";
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
  $sql = "DELETE FROM `kundenbestand` WHERE `IDKundenbestand` = '$key'";
  $result = mysqli_query($conn, $sql);

  header("location: ../extinguishers.php?msg=" . ($result ? "5" : "6"));

}
