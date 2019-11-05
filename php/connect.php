<?php
	error_reporting(0);
	date_default_timezone_set('Asia/Kathmandu');
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "projectdealer";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error || mysqli_connect_error() ) {
	    die("Connection error!!!");
	}else{
		global $conn;
	}

?>