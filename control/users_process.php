<?php
session_start();
require_once "../config.php";

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

if ($action == 'add') { 

  $name = $conn->real_escape_string($_POST['name']);
  // $img = $conn->real_escape_string($_POST['img']);
  $email = $conn->real_escape_string($_POST['email']);
  // $password = $conn->real_escape_string($_POST['password']);
  $hashed_password = password_hash('123456', PASSWORD_DEFAULT);
  $nic = $conn->real_escape_string($_POST['nic']);
  $role = $conn->real_escape_string($_POST['role']);
  $created = date('Y-m-d h:i:sa');

  // Add email duplicate function

  //image function
  if ($_FILES['img']['name'] != "") { // If a file has been uploaded
    $img_name = $_FILES['img']['name']; // To get file name
    $img_name_tmp = $_FILES['img']['tmp_name']; // To get file name temporary location

    $ext = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_new = time(); //New image name
    $path = "../assets/images/users/" . $img_new.".".$ext; //New path to move
    $path_db = "assets/images/users/" . $img_new.".".$ext;
    move_uploaded_file($img_name_tmp, $path); // To move the image to user_images folder
  }

  $sql = "INSERT INTO `users`(`name`, `email`, `password`, `img`, `role_id`, `nic`, `created`, `updated`)
          VALUES ('$name','$email','$hashed_password','$path_db','$role','$nic','$created','')";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    header("location: ../users.php?msg=2");
  } else {
    header("location: ../users.php?msg=1");
  }
}

if ($action == 'edit') {

  $key = $conn->real_escape_string($_POST['key']);
  $name = $conn->real_escape_string($_POST['name']);
  // $img = $conn->real_escape_string($_POST['img']);
  $email = $conn->real_escape_string($_POST['email']);
  // $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $nic = $conn->real_escape_string($_POST['nic']);
  // $role = $conn->real_escape_string($_POST['role']);
  $updated = date('Y-m-d h:i:sa');

  //image function
  $result = '';
  if ($_FILES['img']['name'] != "") { // If a file has been uploaded
    $img_name = $_FILES['img']['name']; // To get file name
    $img_name_tmp = $_FILES['img']['tmp_name']; // To get file name temporary location
    $ext = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_new = time(); //New image name
    $path = "../assets/images/users/" . $img_new.".".$ext; //New path to move
    $path_db = "assets/images/users/" . $img_new.".".$ext;
    move_uploaded_file($img_name_tmp, $path); // To move the image to user_images folder

    $sql = "UPDATE `users` SET `name`='$name',`email`='$email',`nic`='$nic',
    `img`='$path_db',`updated`='$updated' WHERE `id` = '$key'";
    // var_dump($sql);exit;
    $result = mysqli_query($conn, $sql);

  } else {

    $sql = "UPDATE `users` SET `name`='$name',`email`='$email',`nic`='$nic',
    `updated`='$updated' WHERE `id` = '$key'";
    $result = mysqli_query($conn, $sql);

  }

  if ($result) {
    header("location: ../users.php?msg=4");
  } else {
    header("location: ../users.php?msg=3");
  }
}

if ($action == 'delete') {
  if (isset($_GET['key'])) {
    $key = $_GET['key'];
  }
//  var_dump($key);exit;
  $sql = "DELETE FROM `users` WHERE `id` = '$key'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    header("location: ../users.php?msg=5");
  } else {
    header("location: ../users.php?msg=6");
  }

}
