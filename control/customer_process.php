<?php
session_start();
require_once "../config.php";

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

if ($action == 'add') { 

  // echo '<pre>';
  //   var_dump($_POST);
  //   echo '<pre>';exit;
  $contact_person = $conn->real_escape_string($_POST['contact_person']);
  $cus_number = $conn->real_escape_string($_POST['cus_number']);
  $postal_code = $conn->real_escape_string($_POST['postal_code']);
  $salutation = $conn->real_escape_string($_POST['salutation']);
  $last_name = $conn->real_escape_string($_POST['last_name']);
  $first_name = $conn->real_escape_string($_POST['first_name']);
  $street = $conn->real_escape_string($_POST['street']);
  $place = $conn->real_escape_string($_POST['place']);
  $mobile_company = $conn->real_escape_string($_POST['mobile_company']);
  $mobile_private = $conn->real_escape_string($_POST['mobile_private']);
  $phone_company  = $conn->real_escape_string($_POST['phone_company']);
  $phone_private = $conn->real_escape_string($_POST['phone_private']);
  $owner = $conn->real_escape_string($_POST['owner']);
  $safety_officer = $conn->real_escape_string(empty($_POST['safety_off'])?'':$_POST['safety_off']);
  $safe_off_availability = empty($_POST['safety_off'])?'20':'10';
  $created = date('Y-m-d h:i:sa');

  // Add email duplicate function

  $sql = "INSERT INTO `customers`(`contact_person`, `cus_number`, `postal_code`, `salutation`, `last_name`, `first_name`, `street`, `place`, `mobile_company`, `mobile_private`, `phone_company`, `phone_private`, `owner`, `safety_officer`, `safe_off_availability`, `created`)
          VALUES ('$contact_person','$cus_number','$postal_code','$salutation','$last_name','$first_name','$street','$place','$mobile_company','$mobile_private','$phone_company','$phone_private','$owner','$safety_officer','$safe_off_availability','$created')";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    header("location: ../customers.php?msg=2");
  } else {
    header("location: ../customers.php?msg=1");
  }
}

if ($action == 'edit') {

  $key = $conn->real_escape_string($_POST['key']);
  $contact_person = $conn->real_escape_string($_POST['contact_person']);
  $cus_number = $conn->real_escape_string($_POST['cus_number']);
  $postal_code = $conn->real_escape_string($_POST['postal_code']);
  $salutation = $conn->real_escape_string($_POST['salutation']);
  $last_name = $conn->real_escape_string($_POST['last_name']);
  $first_name = $conn->real_escape_string($_POST['first_name']);
  $street = $conn->real_escape_string($_POST['street']);
  $place = $conn->real_escape_string($_POST['place']);
  $mobile_company = $conn->real_escape_string($_POST['mobile_company']);
  $mobile_private = $conn->real_escape_string($_POST['mobile_private']);
  $phone_company  = $conn->real_escape_string($_POST['phone_company']);
  $phone_private = $conn->real_escape_string($_POST['phone_private']);
  $owner = $conn->real_escape_string($_POST['owner']);
  $safety_officer = $conn->real_escape_string(empty($_POST['safety_off'])?'':$_POST['safety_off']);
  $updated = date('Y-m-d h:i:sa');

    $sql = "UPDATE `customers` SET `contact_person`='$contact_person',`cus_number`='$cus_number',`postal_code`='$postal_code',`salutation`='$salutation',`last_name`='$last_name',`first_name`='$first_name',`street`='$street',
    `place`='$place',`mobile_company`='$mobile_company',`mobile_private`='$mobile_private',`phone_company`='$phone_company',`phone_private`='$phone_private',`safety_officer`='$safety_officer',`updated`='$updated' WHERE `id` = '$key'";
    $result = mysqli_query($conn, $sql);


  if ($result) {
    header("location: ../customers.php?msg=4");
  } else {
    header("location: ../customers.php?msg=3");
  }
}

if ($action == 'delete') {
  if (isset($_GET['key'])) {
    $key = $_GET['key'];
  }
//  var_dump($key);exit;
  $sql = "DELETE FROM `customers` WHERE `id` = '$key'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    header("location: ../customers.php?msg=5");
  } else {
    header("location: ../customers.php?msg=6");
  }

}
