<?php 

echo '<footer class="footer-distributed">

<div class="footer-right">

	<a href="https://facebook.com/opd/"><i class="fa fa-facebook"></i></a>
	<a href="https://twitter.com/opd/"><i class="fa fa-twitter"></i></a>
	<a href="https://linkedin.com/opd/"><i class="fa fa-linkedin"></i></a>
	<a href="https://github.com/opd/"><i class="fa fa-github"></i></a>

</div>

<div class="footer-left">

	<p class="footer-links">
		<a href="index.php">Home</a>
		·
		<a href="about.php">About</a>
		·
		<a href="contact.php">Contact</a>
		';
		if( isset($_SESSION["login"]) ){
			echo '
				·
				<a href="logout.php">Logout</a>
			';
		}
echo'
	</p>

	<p>Online Project Dealer &copy; 2018</p>
</div>

</footer>';

if ( $userLogin ) {
	echo '
		<script type="text/javascript" src="js/profile.js"></script>
	';
}

?>