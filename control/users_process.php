<?php
session_start();
require_once "../config.php";

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

$session_urole = $_SESSION['role_id'];

if ($action == 'add') {

  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $hashed_password = password_hash('123456', PASSWORD_DEFAULT);
  $role = $conn->real_escape_string($_POST['role']);
  $idfirma = $conn->real_escape_string($_POST['idfirma']);
  $created = date('Y-m-d h:i:sa');
  empty($idfirma)?$idfirma=0: $idfirma;
  // Add email duplicate function
  $check = check_email($email);
  $path_db = null;

  if ($check>0) {
    //duplicate email
    header("location: ../users.php?msg=11");
  } else {
    //image function
    if ($_FILES['img']['name'] != "") { // If a file has been uploaded
      $img_name = $_FILES['img']['name']; // To get file name
      $img_name_tmp = $_FILES['img']['tmp_name']; // To get file name temporary location

      $ext = pathinfo($img_name, PATHINFO_EXTENSION);
      $img_new = time(); //New image name
      $path = "../assets/images/users/" . $img_new . "." . $ext; //New path to move
      $path_db = "assets/images/users/" . $img_new . "." . $ext;
      move_uploaded_file($img_name_tmp, $path); // To move the image to user_images folder
    }

    $sql = "INSERT INTO `users`(`name`, `email`, `password`, `img`, `idfirma`,`role_id`)
        VALUES ('$name','$email','$hashed_password','$path_db','$idfirma','$role')";
    $result = mysqli_query($conn, $sql);

    header("location: ../users.php?msg=" . ($result ? "2" : "1"));
  }

}
if ($action == 'edit') {

    $key = $conn->real_escape_string($_POST['key']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $last_date = $conn->real_escape_string($_POST['last_date']);
    $from_time = $conn->real_escape_string($_POST['from_time']);
    $end_time = $conn->real_escape_string($_POST['end_time']);
    $updated = date('Y-m-d h:i:sa');

    // Default SQL without image
    $sql = "UPDATE `users` SET 
                `name` = '$name',
                `email` = '$email',
                `last_date` = '$last_date',
                `from_time` = '$from_time',
                `end_time` = '$end_time'";

    // If image is uploaded
    if (!empty($_FILES['img']['name'])) {
        $img_name = $_FILES['img']['name'];
        $img_tmp = $_FILES['img']['tmp_name'];
        $ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_new = time() . "." . $ext;
        $path = "../assets/images/users/" . $img_new;
        $path_db = "assets/images/users/" . $img_new;
        move_uploaded_file($img_tmp, $path);

        $sql .= ", `img` = '$path_db'";
    }

    $sql .= " WHERE `id` = '$key'";
    $result = mysqli_query($conn, $sql);

    $redirect_page = ($session_urole == 1) ? "users" : "locations";
    $msg = $result ? "4" : "3";
    header("Location: ../{$redirect_page}.php?msg={$msg}");
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

  $sql = "INSERT INTO `user_logins`( `user_id`, `company_id`) 
                    VALUES ('$user','$company')";
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


if ($action == 'change') {

  $key = $conn->real_escape_string($_POST['key']);
  $old = $conn->real_escape_string($_POST['old']);
  $inputPassword = $conn->real_escape_string($_POST['inputPassword']);
  $confirm = $conn->real_escape_string($_POST['confirm']);
  $old_hash = $conn->real_escape_string($_POST['old_hash']);

  $hashed_new = password_hash($inputPassword, PASSWORD_DEFAULT);

  if (password_verify($old, $old_hash)) {

    $sql = "UPDATE `users` SET `password`='$hashed_new' WHERE `id` = $key";
    $result = mysqli_query($conn, $sql);
    header("location: ../manage_password.php?key=" . $key . "&msg=9");
  } else {

    header("location: ../manage_password.php?key=" . $key . "&msg=10");
  }

}