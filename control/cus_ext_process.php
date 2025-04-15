<?php
session_start();
require_once "../config.php";

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

if ($action == 'add') { 

    // var_dump($_POST);exit;
    $serial_no = $conn->real_escape_string($_POST['serial_no']);
    $bj = $conn->real_escape_string($_POST['bj']);
    $desc_short = $conn->real_escape_string($_POST['desc_short']);
    $dec_long = $conn->real_escape_string($_POST['dec_long']);
    $gps = $conn->real_escape_string($_POST['gps']);
    $damage = $conn->real_escape_string($_POST['damage']);
    $test_interval = $conn->real_escape_string($_POST['test_interval']);
    $checked_on = $conn->real_escape_string($_POST['checked_on']);
    $next_check = $conn->real_escape_string($_POST['next_check']);
    $cus_id = $conn->real_escape_string($_POST['cus_id']);
    $ext_id = $conn->real_escape_string($_POST['ext_id']);
  $created = date('Y-m-d h:i:sa');

  // Add email duplicate function

  //image function
  if ($_FILES['location_img']['name'] != "") { // If a file has been uploaded
    $img_name = $_FILES['location_img']['name']; // To get file name
    $img_name_tmp = $_FILES['location_img']['tmp_name']; // To get file name temporary location

    $ext = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_new = time(); //New image name
    $path = "../assets/images/location_img/" . $img_new.".".$ext; //New path to move
    $path_db = "assets/images/location_img/" . $img_new.".".$ext;
    move_uploaded_file($img_name_tmp, $path); // To move the image to user_images folder
  }

  $sql = "INSERT INTO `ext_customer`(`ext_id`, `serial_no`, `bj`, `desc_short`, `dec_long`, `location_img`, `cus_id`, `damage`, `gps`, `checked_on`, `next_check`, `test_interval`, `created`)
                            VALUES ('$ext_id','$serial_no','$bj','$desc_short','$dec_long','$path_db','$cus_id','$damage','$gps','$checked_on','$next_check','$test_interval','$created')";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    header("location: ../cus_ext.php?msg=2");
  } else {
    header("location: ../cus_ext.php?msg=1");
  }
}

if ($action == 'edit') {

  // echo '<pre>';
  // var_dump($_POST);
  // echo '<pre>';exit;
  $key = $conn->real_escape_string($_POST['key']);  
  $serial_no = $conn->real_escape_string($_POST['serial_no']);
  $bj = $conn->real_escape_string($_POST['bj']);
  $desc_short = $conn->real_escape_string($_POST['desc_short']);
  $dec_long = $conn->real_escape_string($_POST['dec_long']);
  $gps = $conn->real_escape_string($_POST['gps']);
  $damage = $conn->real_escape_string($_POST['damage']);
  $test_interval = $conn->real_escape_string($_POST['test_interval']);
  $checked_on = $conn->real_escape_string($_POST['checked_on']);
  $next_check = $conn->real_escape_string($_POST['next_check']);
  $cus_id = $conn->real_escape_string($_POST['cus_id']);
  $ext_id = $conn->real_escape_string($_POST['ext_id']);
  $updated = date('Y-m-d h:i:sa');

  //image function
  $result = '';
  if ($_FILES['location_img']['name'] != "") { // If a file has been uploaded
    $img_name = $_FILES['location_img']['name']; // To get file name
    $img_name_tmp = $_FILES['location_img']['tmp_name']; // To get file name temporary location
    $ext = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_new = time(); //New image name
    $path = "../assets/images/location_img/" . $img_new.".".$ext; //New path to move
    $path_db = "assets/images/location_img/" . $img_new.".".$ext;
    move_uploaded_file($img_name_tmp, $path); // To move the image to user_images folder

    $sql = "UPDATE `ext_customer` SET `serial_no`='$serial_no',`bj`='$bj',`desc_short`='$desc_short',`dec_long`='$dec_long',`gps`='$gps',
    `damage`='$damage',`test_interval`='$test_interval',location_img`='$path_db',`checked_on`='$checked_on',`next_check`='$next_check' WHERE `id` = '$key'";
    // var_dump($sql);exit;
    $result = mysqli_query($conn, $sql);

  } else {

    $sql = "UPDATE `ext_customer` SET `serial_no`='$serial_no',`bj`='$bj',`desc_short`='$desc_short',`dec_long`='$dec_long',`gps`='$gps',
    `damage`='$damage',`test_interval`='$test_interval',`checked_on`='$checked_on',`next_check`='$next_check' WHERE `id` = '$key'";
    $result = mysqli_query($conn, $sql);

  }

  if ($result) {
    header("location: ../cus_ext.php?msg=4");
  } else {
    header("location: ../cus_ext.php?msg=3");
  }
}

if ($action == 'delete') {
  if (isset($_GET['key'])) {
    $key = $_GET['key'];
  }
//  var_dump($key);exit;
  $sql = "DELETE FROM `ext_customer` WHERE `id` = '$key'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    header("location: ../cus_ext.php?msg=5");
  } else {
    header("location: ../cus_ext.php?msg=6");
  }

}
