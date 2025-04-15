<?php
/*
Master Config file
*/

//error_reporting(0);
//clearstatcache();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
function getRealIpAddr()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	{
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}


$log_name = '86da4a2f0d20f29cc3b8c95fa05b109a';
$log_pass = 'a26366e36575312a1f9790d49a393ac9';

$master_token = str_rot13($log_name) . str_rot13($log_pass);

// define("C_MYSQL_HOST", "127.0.0.1");
// define("C_MYSQL_DB", "nacwc");
// define("C_MYSQL_USER",	"nacusr");
// define("C_MYSQL_PWD", "Nc#@N6@pPL3#D!r");

define("C_MYSQL_HOST", "127.0.0.1");
define("C_MYSQL_DB", "feuerschutz_new");
define("C_MYSQL_USER",	"root");
define("C_MYSQL_PWD", "");

$conn = mysqli_connect(C_MYSQL_HOST, C_MYSQL_USER, C_MYSQL_PWD);
$GLOBALS['con'] = $conn;
//mysqli_select_db (C_MYSQL_DB, $sql_con) or die(mysqli_error());
$db_select = mysqli_select_db($conn, C_MYSQL_DB);
if (!$db_select) {
	error_log("Database selection failed: " . mysqli_error($conn));
	die('Internal server error');
} else {
	// die('success');
}

session_start();

ini_set("mysql.trace_mode", 0);
ini_set("session.auto_start", 1);



