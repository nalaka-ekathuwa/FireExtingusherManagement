<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $today = date('Y-m-d');
        $current_time = date('H:i:s');

        if ($today > $row['last_date']) {
            // Expired login
            header("location: ../index.php?s=3"); // custom error code for expired date
            exit;
        }

        if ($current_time < $row['from_time'] || $current_time > $row['end_time']) {
            // Outside allowed login time
            header("location: ../index.php?s=4"); // custom error code for invalid time
            exit;
        }

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_img'] = $row['img'];
            $_SESSION['role_id'] = $row['role_id'];
            $_SESSION['idfirma'] = $row['idfirma'];

            $page = '';
            switch ($row['role_id']) {
                case '1':
                    $page = 'customers.php'; break;
                case '3':
                    $page = 'view_locations.php'; break;
                case '6':
                case '7':
                case '10':
                    $page = 'customers.php'; break;
                case '9':
                    $page = 'company.php'; break;
                case '11':
                    $page = 'damage_map.php'; break;
                default:
                    $page = 'dashboard.php';
            }
            header("location: ../" . $page);
        } else {
            header("location: ../index.php?s=1"); // wrong password
        }
    } else {
        header("location: ../index.php?s=2"); // user not found
    }
}
