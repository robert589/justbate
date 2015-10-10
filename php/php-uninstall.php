<?php
	require_once __DIR__.'/db_connect.php';

	$db = new DB_CONNECT();
	$con =	$db->connect();

	//USER TABLE
	$sql = "DROP TABLE forgot_code, validation_code, thread, user; ";
	$con->query($sql) or die(mysqli_error($con));
?>