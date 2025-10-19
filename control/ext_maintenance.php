<?php
session_start();
require_once "../config.php";

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if ($action == 'edit') {

    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        // die('CSRF token validation failed');
        header("location: ../locations.php?msg=3");
    } else {
        $key = $conn->real_escape_string($_POST['key']);
        $desc_short = $conn->real_escape_string($_POST['desc_short']);
        $dec_long = $conn->real_escape_string($_POST['dec_long']);
        $damage = $conn->real_escape_string($_POST['damage']);
        $test_interval = $conn->real_escape_string($_POST['test_interval']);
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
}


