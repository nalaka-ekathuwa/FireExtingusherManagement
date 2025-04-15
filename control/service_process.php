<?php
session_start();
require_once "../config.php";

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if ($action == 'add') {

    $title_en = $sql_con->real_escape_string($_POST['title_en']);
    $description_en = $sql_con->real_escape_string($_POST['description_en']);
    $title_si = $sql_con->real_escape_string($_POST['title_si']);
    $description_si = $sql_con->real_escape_string($_POST['description_si']);
    $title_ta = $sql_con->real_escape_string($_POST['title_ta']);
    $description_ta = $sql_con->real_escape_string($_POST['description_ta']);

    $update_on = date('Y-m-d');

    $sql = "INSERT INTO `services`(`title_en`, `description_en`, `title_si`, `description_si`, `title_ta`, `description_ta`, `update_on`) 
                         VALUES ('$title_en','$description_en','$title_si','$description_si','$title_ta','$description_ta','$update_on')";
    $result = mysqli_query($sql_con, $sql);

    if ($result) {
        header("location: ../services.php?msg=2");
    } else {
        header("location: ../index.php?msg=1");
    }
}

if ($action == 'edit') {

    $key = $sql_con->real_escape_string($_POST['key']);
    $title_en = $sql_con->real_escape_string($_POST['title_en']);
    $description_en = $sql_con->real_escape_string($_POST['description_en']);
    $title_si = $sql_con->real_escape_string($_POST['title_si']);
    $description_si = $sql_con->real_escape_string($_POST['description_si']);
    $title_ta = $sql_con->real_escape_string($_POST['title_ta']);
    $description_ta = $sql_con->real_escape_string($_POST['description_ta']);
    $update_on = date('Y-m-d');

    //image function
    $sql = "UPDATE `services` SET `title_en`='$title_en',`description_en`='$description_en',
    `title_si`='$title_si',`description_si`='$description_si',`title_ta`='$title_ta',
    `description_ta`='$description_ta',`update_on`='$update_on' WHERE `id` = '$key'";
    $result = mysqli_query($sql_con, $sql);

    if ($result) {
        header("location: ../services.php?msg=3");
    } else {
        header("location: ../index.php?msg=1");
    }
}

if ($action == 'delete') {
    if (isset($_GET['key'])) {
        $key = $_GET['key'];
    }

    $sql = "DELETE FROM `services` WHERE `id` = '$key'";
    $result = mysqli_query($sql_con, $sql);

    if ($result) {
        header("location: ../services.php?msg=5");
    } else {
        header("location: ../index.php?msg=1");
    }
}
