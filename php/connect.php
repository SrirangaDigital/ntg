<?php
	$host = 'localhost';
	$user = 'root';
	$password = 'mysql';
	$database = 'ntg';
	$supportEmail = 'arjun.kashyap@srirangadigital.com';

	$mysqli = new mysqli("$host","$user","$password", "$database");
	
	if ($mysqli->connect_errno) {
		
		echo "Error: Failed to make a Database connection, here is why: \n";
		echo "Errno: " . $mysqli->connect_errno . "\n";
		echo "Error: " . $mysqli->connect_error . "\n";
		exit;
	}
	mysqli_set_charset($mysqli,"utf8");

?>
