<?php

session_start();
unset($_SESSION["login_team_id"]); 
unset($_SESSION["login_username"]);
unset($_SESSION["login_user_role"]); 
unset($_SESSION["team_name"]); 
header("Location: index.php")

?>