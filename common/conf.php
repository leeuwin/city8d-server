<?php
	//database parameter
	$servername = "127.0.0.1";
	$username = "root";
	$password = "Lm@3292103$6182!99";
	$dbname = "city8d";

	function get_db_conn()
	{
		$conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
		if ($conn->connect_error) {
			return null;
		}
		$conn->set_charset('utf8');
		return $conn;
	}	

	//appid secret
	$appid="wx72f8912d30adb441";
	$secret="46cfd45178c548c4fd2887f05771360e";
?>

