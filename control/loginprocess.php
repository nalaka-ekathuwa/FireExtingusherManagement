<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$email = $conn->real_escape_string($_POST['username']);
	$password =$conn->real_escape_string($_POST['password']);

	$sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
   
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    //  var_dump($hashed_password);exit;

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_img'] = $row['img'];
            $_SESSION['role_id'] = $row['role_id'];
			// var_dump($row['role_id']);exit;
            header("location: ../dashboard.php?");
          
        } else {
			header("location: ../index.php?s=1");
		}
		
	} 
	else { header("location: ../index.php?s=2");
	}
}
