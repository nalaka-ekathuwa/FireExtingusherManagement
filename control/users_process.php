<?php
session_start();
require_once "../config.php";

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

$session_urole = $_SESSION['role_id'];

if ($action == 'add') { 

  // echo '<pre>';
  // var_dump($_POST);
  // echo '<pre>';exit;
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $hashed_password = password_hash('123456', PASSWORD_DEFAULT);
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

  $sql = "INSERT INTO `users`(`name`, `email`, `password`, `img`, `role`,`role_id`)
          VALUES ('$name','$email','$hashed_password','$path_db',' ','$role')";
  $result = mysqli_query($conn, $sql);

  header("location: ../users.php?msg=" . ($result ? "2" : "1"));
}

if ($action == 'edit') {

  $key = $conn->real_escape_string($_POST['key']);
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
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

    $sql = "UPDATE `users` SET `name`='$name',`email`='$email', `img`='$path_db' WHERE `id` = '$key'";
    // var_dump($sql);exit;
    $result = mysqli_query($conn, $sql);

  } else {

    $sql = "UPDATE `users` SET `name`='$name',`email`='$email' WHERE `id` = '$key'";
    $result = mysqli_query($conn, $sql);

  }

  header("location: ../". (($session_urole==1) ? "dashboard" : "extinguishers").".php?msg=" . ($result ? "4" : "3"));
}

if ($action == 'delete') {
  if (isset($_GET['key'])) {
    $key = $_GET['key'];
  }
//  var_dump($key);exit;
  $sql = "DELETE FROM `users` WHERE `id` = '$key'";
  $result = mysqli_query($conn, $sql);

  header("location: ../users.php?msg=" . ($result ? "5" : "6"));

}

if ($action == 'assign') {

  $user = $conn->real_escape_string($_POST['user']);
  $company = $conn->real_escape_string($_POST['company']);
  $created = date('Y-m-d h:i:sa');

  $sql = "INSERT INTO `user_logins`( `user_id`, `company_id`, `created_at`) 
                    VALUES ('$user','$company','$created')";
  $result = mysqli_query($conn, $sql);

  header("location: ../assign_company.php?msg=" . ($result ? "2" : "1"));

}
if ($action == 'remove') {
  if (isset($_GET['key'])) {
    $key = $_GET['key'];
  }
  $sql = "DELETE FROM `user_logins` WHERE `id` = '$key'";
  $result = mysqli_query($conn, $sql);

  header("location: ../assign_company.php?msg=" . ($result ? "5" : "6"));

}

if ($action == 'reset') {
  if (isset($_GET['key'])) {
    $key = $_GET['key'];
  }

  $hashed_password = password_hash('123456', PASSWORD_DEFAULT);
  $sql = "UPDATE `users` SET `password`='$hashed_password' WHERE `id` = '$key'";
  $result = mysqli_query($conn, $sql);

  header("location: ../users.php?msg=" . ($result ? "7" : "8"));

}