<?php
session_start();
require 'connect.php';

$userLogin = false;

if ( isset($_SESSION["login"]) ) {
	$userLogin = true;
}

?>