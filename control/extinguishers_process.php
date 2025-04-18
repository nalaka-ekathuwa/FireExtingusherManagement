<?php
session_start();
require_once "../config.php";

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

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
    $path = "../assets/images/extinguisher/" . $img_new.".".$ext; //New path to move
    $path_db = "assets/images/extinguisher/" . $img_new.".".$ext;
    move_uploaded_file($img_name_tmp, $path); // To move the image to user_images folder
  }

  $sql = "INSERT INTO `extinguisher`(`brand`, `color`, `type`, `size`, `loeschmittel`, `hersteller`, `image`)
          VALUES ('$brand','$color','$type','$size','$loeschmittel','$hersteller','$path_db')";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    header("location: ../extinguishers.php?msg=2");
  } else {
    header("location: ../extinguishers.php?msg=1");
  }
}

if ($action == 'edit') {

    // echo '<pre>';
    // var_dump($_POST);
    // echo '<pre>';exit;
  $key = $conn->real_escape_string($_POST['key']);
  $Interneseriennummer = $conn->real_escape_string($_POST['Interneseriennummer']);
  $Beschädigung1 = $conn->real_escape_string($_POST['Beschädigung1']);
  $BeschreibungStandort2 = $conn->real_escape_string($_POST['BeschreibungStandort2']);
  // $loeschmittel = $conn->real_escape_string($_POST['loeschmittel']);
  // $hersteller = $conn->real_escape_string($_POST['hersteller']);
  $updated = date('Y-m-d h:i:sa');

  $sql_f = "SELECT * FROM `locations` WHERE `IDKundenbestand` = '$key'";
  $result_f = mysqli_query($conn, $sql_f);
  $rowcount=mysqli_num_rows($result_f);
  // echo $rowcount; exit;
  //image function
 
  if ($_FILES['FotoFeuerlöscher']['name'] != "") { // If a file has been uploaded
    $img_name = $_FILES['FotoFeuerlöscher']['name']; // To get file name
    $img_name_tmp = $_FILES['FotoFeuerlöscher']['tmp_name']; // To get file name temporary location
    $ext = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_new = time(); //New image name
    $path = "../assets/images/extinguisher/" . $img_new.".".$ext; //New path to move
    $path_db = "assets/images/extinguisher/" . $img_new.".".$ext;
    move_uploaded_file($img_name_tmp, $path); // To move the image to user_images folder

    $sql = "UPDATE `kundenbestand` SET `Interneseriennummer`='$Interneseriennummer',`Beschädigung1`='$Beschädigung1',
    `BeschreibungStandort2`='$BeschreibungStandort2',`FotoFeuerlöscher`='$path_db' WHERE `IDKundenbestand` = '$key'";
    // var_dump($sql);exit;
    $result = mysqli_query($conn, $sql);
    if($rowcount == 0){
      $sql_l = "INSERT INTO `locations`(`IDKundenbestand`, `foto`, `Koordinaten`) VALUES
      ('$key', '$path_db', '$BeschreibungStandort2')";
    }else{
      $sql_l = "UPDATE `locations` SET `IDKundenbestand`='$key',`foto`='$path_db',`Koordinaten`='$BeschreibungStandort2' WHERE `id`='$key'";
    }
    $result_l = mysqli_query($conn, $sql_l);

  } else {

    $sql = "UPDATE `kundenbestand` SET `Interneseriennummer`='$Interneseriennummer',`Beschädigung1`='$Beschädigung1',
    `BeschreibungStandort2`='$BeschreibungStandort2' WHERE `IDKundenbestand` = '$key'";
    $result = mysqli_query($conn, $sql);

    if($rowcount == 0 && !empty($BeschreibungStandort2)){
      $sql_l = "INSERT INTO `locations`(`IDKundenbestand`, `Koordinaten`) VALUES
      ('$key',  '$BeschreibungStandort2')";
    }else{
      $sql_l = "UPDATE `locations` SET `IDKundenbestand`='$key',`Koordinaten`='$BeschreibungStandort2' WHERE `id`='$key'";
    }
    $result_l = mysqli_query($conn, $sql_l);

  }

  if ($result) {
    header("location: ../extinguishers.php?msg=4");
  } else {
    header("location: ../extinguishers.php?msg=3");
  }
}

if ($action == 'delete') {
  if (isset($_GET['key'])) {
    $key = $_GET['key'];
  }
//  var_dump($key);exit;
  $sql = "DELETE FROM `kundenbestand` WHERE `IDKundenbestand` = '$key'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    header("location: ../extinguishers.php?msg=5");
  } else {
    header("location: ../extinguishers.php?msg=6");
  }

}
