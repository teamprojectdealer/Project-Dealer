<?php
include_once 'php/sessionCheck.php';
include_once 'php/classes/statics.php';

//this variable is used for navigation active purpose
$activePage = "home";


if( $userLogin ){

	//for project upload
	include_once 'php/uploadProject.php';


}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Home | Online Project Dealer</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<?php include 'htmlIncludes/headIncludes.php'; ?>
</head>
<body>

	<div id="main">
		
		<?php include_once 'htmlIncludes/headerNav.php'; ?>

		<div id="themePic" class="<?php if($userLogin) echo 'loggedIn'; ?>">
			<?php 

				if ( $userLogin ) {
					echo '<a href="#projectUploadDivExact" onclick="showUploadDiv();">Upload and Sell new project
					<img src="img/upload.png" />
					</a>';
				}

			?>
		</div>

		<div id="showCase">

			<?php 

				if(!$userLogin) include 'htmlIncludes/beforeLoginIndexHtml.php';  
				else include 'htmlIncludes/afterLoginIndexHtml.php';
			?>

			<div class="clear"></div>

			<?php include_once 'htmlIncludes/footer.php'; ?>

		</div>


	</div>


	<script type="text/javascript" src="js/nav.js"></script>

	<?php 

		if($userLogin) include 'htmlIncludes/afterLoginJS.php';  

	?>

	<script type="text/javascript">
	<?php 

		if ( isset($_GET["msg"]) ) {
			$msg = $_GET["msg"];

			if ($msg == "uploaded") {
				echo 'addFixedNotif("Project Uploaded Sucessfully!")';
			}
			if ($msg == "invalidImg") {
				echo 'addFixedNotif("Project Image must be jpeg,png or gif only.")';
			}

		}

	?>
	</script>

</body>
</html>