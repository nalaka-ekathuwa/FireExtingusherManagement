<?php
session_start();
require_once "../config.php";

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}



if ($action == 'edit') {

    // echo '<pre>';
    // var_dump($_POST);
    // echo '<pre>';
    // exit;
    $key = $conn->real_escape_string($_POST['key']);
    // $serial_no = $conn->real_escape_string($_POST['serial_no']);
    // $bj = $conn->real_escape_string($_POST['bj']);
    $desc_short = $conn->real_escape_string($_POST['desc_short']);
    $dec_long = $conn->real_escape_string($_POST['dec_long']);
    // $gps = $conn->real_escape_string($_POST['gps']);
    $damage = $conn->real_escape_string($_POST['damage']);
    $test_interval = $conn->real_escape_string($_POST['test_interval']);
    // $checked_on = $conn->real_escape_string($_POST['checked_on']);
    // $next_check = $conn->real_escape_string($_POST['next_check']);
    // $cus_id = $conn->real_escape_string($_POST['cus_id']);
    // $ext_id = $conn->real_escape_string($_POST['ext_id']);
    $updated = date('Y-m-d h:i:sa');

    //image function
    $result = '';

    $sql = "UPDATE `ext_customer` SET `desc_short`='$desc_short',`dec_long`='$dec_long',
    `damage`='$damage',`test_interval`='$test_interval' WHERE `id` = '$key'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("location: ../locations.php?msg=4");
    } else {
        header("location: ../locations.php?msg=3");
    }
}


