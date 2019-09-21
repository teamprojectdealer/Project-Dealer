<?php
include_once 'php/sessionCheck.php';
include_once 'php/classes/statics.php';
//this variable is used for navigation active purpose
$activePage = "about";

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

			<div class="dark center fam1 fs2">About</div>	
			<div class="hrow"></div>

			<div class="fam2 full center">
				<p>Online Project Dealer is the best choice for the project dealing through out the internet. We have gathered a huge amount of trust from different comapnies in the IT field. 
				Here we care about the flexibility of our features and interaction with users or visitors.</p>

				<br/>
				<br/>
				Search a project as per your need.Then just buy at the best price.
				<br/>
				Any type of project can be uploaded for selling at your reasonable price.
				<br/>
				Have no money to buy it? 
				<br/>No worry! 
				<br/>Request for project exchange to the seller.
				<br/>Then trade it with one of your own projects.
			</div>

			<div class="clear"></div>

		<?php include_once 'htmlIncludes/footer.php'; ?>

		</div>


	</div>


	<script type="text/javascript" src="js/nav.js"></script>

</body>
</html>