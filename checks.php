<?php 

include_once 'php/classes/statics.php';
include_once 'php/connect.php';

if ( $_POST["regCheck"] ) {
	
	$attr = $_POST["attr"];
	$val = $_POST["value"];

	$user = Statics::getUser($attr,'s',$val,$conn);
	if ( $user->getId() == 0 ) {
		echo "available";
	}else{
		echo "unavailable";
	}

}

?>