<?php 

function echoActive(){
	echo " class=\"active\" " ;
}

echo '
	
		<div id="notification">
			<p class="value">Notification</p>
			<div id="notifCancel"></div>
		</div>

		';

		if( $userLogin ){
			echo '

				<div id="profile">
					<div class="un">'.$_SESSION["username"].'</div>
					<img title="Close" src="img/close.png" class="close" onclick="hideProfile();"/>
					<div class="hr"></div>
					<img src="profiles/'.$_SESSION["profile"].'"/>
					<div class="hr"></div>
					<div class="body">
						<div>Full Name: <b>'.$_SESSION["fullname"].'</b></div>
						<div>Email: <b>'.$_SESSION["email"].'</b></div>
						<div>Gender: <b>'.$_SESSION["gender"].'</b></div>
						<div>Your Amount: <b>&pound;'.Statics::getUser("id","i",$_SESSION["id"],$conn)->getAmount().'</b></div>
						<div>Position: <b>'.$_SESSION["type"].'</b></div>
					</div>
					<div class="hr"></div>
					<br/>
					<a href="myprojects.php" class="btn">My Projects</a>
					<a href="exchangeRequest.php" class="btn">Exchange Requests</a>
					<br/>
					<br/>
				</div>

			';
		}

		echo'

		<script type="text/javascript" src="js/notification.js"></script>

		<div id="headerMain">
			<img src="img/sell.png" />
			<p>Online Project Dealer</p>
		</div>

		<div id="nav">
			
			<div class="left">
				
				<a href="index.php" '; if( $activePage == "home" ) echoActive(); echo ' >Home 
				<span class="home"></span> </a>
				<a href="about.php" '; if( $activePage == "about" ) echoActive(); echo ' >About 
				<span class="about"></span> </a>
				<a href="contact.php" '; if( $activePage == "contact" ) echoActive(); echo ' >Contact 
				<span class="contact"></span> </a>
			</div>

			';
			if ($userLogin) {
				echo '
					<div class="right">
						<a href="logout.php">Logout</a>
						<a onclick="openProfile();" class="plink"><img src="profiles/'.$_SESSION["profile"].'" />'
						.substr($_SESSION["username"],0,10).'</a>
					</div>

				';
			}else{
				echo '
					<div class="right">
						<a href="login.php" '; if( $activePage == "login" ) echoActive(); echo ' >Login</a>
						<a href="register.php" '; if( $activePage == "register" ) echoActive(); echo ' >Register</a>
					</div>

				';
			}
			echo '

		</div>


';

?>