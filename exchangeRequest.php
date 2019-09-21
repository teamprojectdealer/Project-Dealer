<?php
include_once 'php/sessionCheck.php';
include_once 'php/classes/statics.php';
//this variable is used for navigation active purpose
$activePage = "";

if ( !$userLogin ) {
	header("Location:index.php");
	exit();
}

if ( isset($_POST["acceptRequest"]) ) {

	$requestId = intval($_POST["requestId"]);
	$myProjectId = intval($_POST["myProjectId"]);
	$requestorProjectsId = intval($_POST["requestorProjectsId"]);
	$requestorUserId = intval($_POST["requestorUserId"]);

	//change requestors project to my user id
	Statics::updateTable("project","userId = ".$_SESSION["id"],"id = ".$requestorProjectsId,$conn);

	//change my projects user id to requestors user id
	Statics::updateTable("project","userId = ".$requestorUserId,"id = ".$myProjectId,$conn);

	//delete reqeuest
	Statics::deleteRow("exchangerequest","id = ".$requestId,$conn);

	echo "exchanged";
	exit();

}

if ( isset($_POST["declineRequest"]) ) {

	$requestId = intval($_POST["requestId"]);

	//delete reqeuest
	Statics::deleteRow("exchangerequest","id = ".$requestId,$conn);

	echo "declined";
	exit();

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>About | Online Project Dealer</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<?php include 'htmlIncludes/headIncludes.php'; ?>
</head>
<body>

	<div id="main">
		
		<?php include_once 'htmlIncludes/headerNav.php'; ?>

		<div id="themePic"></div>

		<div id="showCase">

			<div class="dark center fam1 fs2">Exchange Requests For Your Projects</div>	
			<div class="hrow"></div>
			<div class="clear"></div>

			<?php 

				$q = "SELECT `id`,`requestedBy`, `requestedProjectId`, `toBeExchangedWithProjectId` FROM `exchangerequest` WHERE requestedTo = ?";
				$qs = $conn->prepare($q);
				$qs->bind_param("i",$_SESSION["id"]);
				$qs->execute();
				$qs->bind_result($reqId,$reqBy,$myProjectId,$requestorProjectsId);
				while ($qs->fetch()) {
					echo '

						<div class="request" by="'.$reqBy.'" id="'.$reqId.'" myProjectId="'.$myProjectId.'" requestorProjectsId="'.$requestorProjectsId.'">
							<div>Your Project: <a target="_blank" href="viewProject.php?id='.$myProjectId.'">View Project</a></div>
							<div>To be exchanged with: <a target="_blank" href="viewProject.php?id='.$requestorProjectsId.'">View Project</a></div>
							<div class="btn acceptBtn">Accept</div>
							<div class="btn declineBtn">Decline</div>
						</div>

					';
				}
				if ( $qs->num_rows == 0 ) {
					echo '<div class="small fam1 center">There is no request.</div>';
				}
				$qs->close();


			?>

		<?php include_once 'htmlIncludes/footer.php'; ?>

		</div>


	</div>


	<script type="text/javascript" src="js/nav.js"></script>

	<script type="text/javascript">
		var acceptButtons =  document.getElementsByClassName("acceptBtn"),
		declineButtons =  document.getElementsByClassName("declineBtn");

		for (var i = acceptButtons.length - 1; i >= 0; i--) {
			acceptButtons[i].onclick = acceptRequest;
		}
		for (var i = declineButtons.length - 1; i >= 0; i--) {
			declineButtons[i].onclick = declineRequest;
		}

		function acceptRequest(){

			var parent = this.parentNode;
			var requestId = parent.id,
			myProjectId = parent.getAttribute("myProjectId"),
			requestorProjectsId = parent.getAttribute("requestorProjectsId"),
			requestorUserId = parent.getAttribute("by");


			if ( confirm("Are you sure you want to exchange?") ) {
				var params = "&requestId="+requestId+"&myProjectId="+myProjectId+"&requestorProjectsId="+requestorProjectsId+"&requestorUserId="+requestorUserId;
				ajax({
				    meth : "POST",
				    url : "exchangeRequest.php",
				    params : "acceptRequest=yes"+params,
				    onsuccess: "f",
				    onsuccessFunc : function(rtxt){
				    	if ( rtxt == "exchanged" ) {
				    		addFixedNotif("Project has been accpeted and exchanged. For confirmation, view your projects list.");
				    		document.body.removeChild(document.getElementById(requestId));
				    	}
				    }
				});

			}

		}

		function declineRequest(){

			var parent = this.parentNode;
			var requestId = parent.id;


			if ( confirm("Are you sure you want to decline?") ) {
				var params = "&requestId="+requestId;
				ajax({
				    meth : "POST",
				    url : "exchangeRequest.php",
				    params : "declineRequest=yes"+params,
				    onsuccess: "f",
				    onsuccessFunc : function(rtxt){
				    	if ( rtxt == "declined" ) {
				    		addFixedNotif("Project has been declined.");
				    		document.body.removeChild(document.getElementById(requestId));
				    	}
				    }
				});

			}

		}

	</script>

</body>
</html>