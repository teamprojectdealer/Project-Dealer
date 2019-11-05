<?php
session_start();
if( !isset($_SESSION["login"]) ){
	header("Location: index.php");
	exit();
} 
$_SESSION = array();

if ( session_destroy() ) {
	header("Location: index.php");
	exit();
}else{
	echo "Error while logging out. Please refresh this page.";
	exit();
}

?>