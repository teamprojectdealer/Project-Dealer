<?php
include_once 'sessionCheck.php';
include_once 'classes/statics.php';

if( !$userLogin ){
	echo "Please login!";
	exit();
}

$myAmount = Statics::getUser("id","i",$_SESSION["id"],$conn)->getAmount();

if( isset($_POST["buy"]) ){

	$projectIdToBeBought = $_POST["projectId"];
	$buyerId = $_SESSION["id"];

	$theProject = Statics::getProject(false,"id = $projectIdToBeBought",$conn);
	$projectPrice = $theProject[1][0]->getPrice();

	$theProjectsOwnerId = $theProject[1][0]->getUserId();
	$projectOwnersAmount = Statics::getUser("id","i",$theProjectsOwnerId,$conn)->getAmount();

	if( $theProjectsOwnerId == $buyerId ){
		echo "own project";
		exit();
	}

	if( $myAmount >= $projectPrice ){
		$q = "INSERT INTO `buy`(`projectId`, `userId`) VALUES (?,?)";
		$qs = $conn->prepare($q);
		$qs->bind_param("ii",$projectIdToBeBought,$buyerId);
		$c = $qs->execute();
		$qs->close();
		if ( $c ) {
			$buyersFinalAmount = $myAmount - $projectPrice;
			Statics::updateTable("users","amount = $buyersFinalAmount","id = ".$_SESSION["id"],$conn);
			$ownersFinalAmount = $projectOwnersAmount + $projectPrice;
			Statics::updateTable("users","amount = $ownersFinalAmount","id = ".$theProjectsOwnerId,$conn);
			echo "bought";
		}else{
			echo "buy-error";
		}
		exit();
	}else{
		echo "lowamount";
		exit();
	}

	
}

if( isset($_POST["exchange"]) ){

	$theProjectsOwnerId = $_POST["projectOwnersId"];
	$theRequestedProjectsId = $_POST["requestedProjectId"];
	$toBeExchangedWithProjectId = $_POST["toBeExchangedWithProjectId"];

	$q = "INSERT INTO `exchangerequest`(`requestedBy`, `requestedTo`, `requestedProjectId`, `toBeExchangedWithProjectId`) VALUES (?,?,?,?)";
	$qs = $conn->prepare($q);
	$qs->bind_param("iiii",$_SESSION["id"],$theProjectsOwnerId,$theRequestedProjectsId,$toBeExchangedWithProjectId);
	$c = $qs->execute();
	$qs->close();

	if ( $c ) {
		echo "success";
	}else{
		echo "error";
	}
	exit();

}


?>