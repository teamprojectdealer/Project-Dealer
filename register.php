<?php 
include_once 'php/sessionCheck.php';

if ($userLogin) {
	header("Location: index.php");
	exit();
}

//this variable is used for navigation active purpose
$activePage = "register";

include_once 'php/classes/user.php';
include_once 'php/classes/registerClass.php';


if ( isset($_POST["registerBtn"]) ) {
	
	$regUsername = preg_replace("/[^0-9a-zA-Z]/", "",$_POST["username"]);
	$regPassword = trim($_POST["password"]);
	$regEmail = trim($_POST["email"]);
	$regFullName = trim($_POST["fullName"]);
	$regGender = trim($_POST["gender"]);

	if( strlen($regPassword) < 6 ){
		header("Location: register.php?msg=smallpass");
		exit();
	}

	$randomString = substr(md5(rand()), 0, 7);

	$regProfile = $_FILES["profilePic"]['tmp_name'];

	$regProfileName = $_FILES["profilePic"]['name'];
	$regProfileName = $randomString."_".$regProfileName;

	if(  move_uploaded_file($regProfile, "profiles/".$regProfileName) ){

		$newUser = new User;
		$newUser->setUsername($regUsername);
		$newUser->setPassword($regPassword);
		$newUser->setEmail($regEmail);
		$newUser->setFullName($regFullName);
		$newUser->setGender($regGender);
		$newUser->setProfilePic($regProfileName);
		$newUser->setType("u");

		$regUser = new Register($newUser,$conn);

		if ($regUser->addUser()) {
			header("Location: register.php?msg=ok");
			exit();
		}else{
			header("Location: register.php?msg=no");
			exit();
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Registration | Online Project Dealer</title>
	<link rel="stylesheet" type="text/css" href="css/register.css">
	<?php include 'htmlIncludes/headIncludes.php'; ?>
</head>
<body>

	<div id="main">
		
		<?php include_once 'htmlIncludes/headerNav.php'; ?>

		<div id="regBody">

			<div class="title">
				<img src="img/user.png">
				Register
			</div>

			<form action="register.php" method="POST" enctype="multipart/form-data">
				<div class="small white right">Only letters and numbers</div>
				<div class="small white left">Username</div>
				<input type="text" name="username" id="username" placeholder="Username..." required>
				<div class="clear"></div>
				<br/>
				
				<div class="small white right">At least 6 letters</div>
				<div class="small white left">Password</div>
				<input type="password" id="password" name="password" placeholder="Password..." required>
				<div class="small white left">Password Again</div>
				<input type="password" id="passwordRep" name="passwordRepeat" placeholder="Repeat Password..." required>

				<div class="clear"></div>
				<br/>
				<div class="small white left">Email</div>
				<input type="email" name="email" id="email" placeholder="Email address..." required>

				<div class="clear"></div>
				<br/>
				<div class="small white left">Full Name</div>
				<input type="text" name="fullName" placeholder="Your full name..." required>

				<div class="clear"></div>
				<br/>
				<p class="white">Gender</p>
				<select name="gender" required>
					<option value="m">Male</option>
					<option value="f">Female</option>
				</select>
				
				<div class="clear"></div>
				<br/>
				<p class="white">Choose Your Profile Picture</p>
				<input type="file" name="profilePic" required>
				<input type="submit" name="registerBtn" value="Register">
			</form>

		</div>

	</div>

	<script type="text/javascript" src="js/nav.js"></script>

	<script type="text/javascript">

		document.getElementById('username').onblur = function(){
			if( this.value.length != 0 ){
				isValueAvailable("username",this.value,"Username already taken!");
			}
		}

		document.getElementById('email').onblur = function(){
			if( this.value.length != 0 ){
				isValueAvailable("email",this.value,"Email : "+this.value+" already used for another account!");
			}
		}

		document.getElementById("passwordRep").onblur = checkPass;

		function checkPass(){
			if ( document.getElementById("password").value != document.getElementById("passwordRep").value ) {
				addFixedNotif("Password mismatch!");
			}
		}

		function isValueAvailable(attrName,value,unAvailableText){
			ajax({

				meth : "post",
				url : "checks.php",
				params : "regCheck=yes&attr="+attrName+"&value="+value,
				onsuccess : "f",
				onsuccessFunc : function(responseTxt){
					if ( responseTxt == "unavailable" ) {
						addFixedNotif(unAvailableText);
					}
				}

			});

		}
	</script>
	<script type="text/javascript">
	<?php 

		if ( isset($_GET["msg"]) ) {
			$msg = $_GET["msg"];

			if ($msg == "ok") {
				echo 'addFixedNotif("Registration Sucessfull, Please login!");';
			}
			if ($msg == "no") {
				echo 'addFixedNotif("Registration failed, Please try again!");';
			}
			if ($msg == "smallpass") {
				echo 'addFixedNotif("Password is too small!");';
			}

		}

	?>
	</script>
</body>
</html>