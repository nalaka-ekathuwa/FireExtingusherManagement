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

  $key = $conn->real_escape_string($_POST['key']);
  $brand = $conn->real_escape_string($_POST['brand']);
  $color = $conn->real_escape_string($_POST['color']);
  $type = $conn->real_escape_string($_POST['type']);
  $size = $conn->real_escape_string($_POST['size']);
  $loeschmittel = $conn->real_escape_string($_POST['loeschmittel']);
  $hersteller = $conn->real_escape_string($_POST['hersteller']);
  $updated = date('Y-m-d h:i:sa');

  //image function
  $result = '';
  if ($_FILES['image']['name'] != "") { // If a file has been uploaded
    $img_name = $_FILES['image']['name']; // To get file name
    $img_name_tmp = $_FILES['image']['tmp_name']; // To get file name temporary location
    $ext = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_new = time(); //New image name
    $path = "../assets/images/extinguisher/" . $img_new.".".$ext; //New path to move
    $path_db = "assets/images/extinguisher/" . $img_new.".".$ext;
    move_uploaded_file($img_name_tmp, $path); // To move the image to user_images folder

    $sql = "UPDATE `extinguisher` SET `brand`='$brand',`color`='$color',`type`='$type',
    `size`='$size',`image`='$path_db',`loeschmittel`='$loeschmittel',`hersteller`='$hersteller' WHERE `id` = '$key'";
    // var_dump($sql);exit;
    $result = mysqli_query($conn, $sql);

  } else {

    $sql = "UPDATE `extinguisher` SET `brand`='$brand',`color`='$color',`type`='$type',
    `size`='$size',`loeschmittel`='$loeschmittel',`hersteller`='$hersteller' WHERE `id` = '$key'";
    $result = mysqli_query($conn, $sql);

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
  $sql = "DELETE FROM `extinguisher` WHERE `id` = '$key'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    header("location: ../extinguishers.php?msg=5");
  } else {
    header("location: ../extinguishers.php?msg=6");
  }

}
