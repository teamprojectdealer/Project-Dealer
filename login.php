<?php 

include_once 'php/sessionCheck.php';

if ($userLogin) {
	header("Location: index.php");
	exit();
}


//this variable is used for navigation active purpose
$activePage = "login";

include_once 'php/classes/loginClass.php';

if( isset($_POST["loginBtn"]) ){

	$user = new User;
	$user->setUsername( trim($_POST["username"]) );
	$user->setPassword( trim($_POST["password"]) );

	$loginUser = new Login($user,$conn);

	$loginStat = $loginUser->login();

	$sendLocation = "";

	switch ($loginStat) {
		case 'failed':
			$sendLocation = "Location: login.php?msg=fail";
			break;

		case 'unregistered':
			$sendLocation = "Location: login.php?msg=nouser";
			break;

		case 'success':
			$sendLocation = "Location: index.php";
			break;

		case 'missmatch':
			$sendLocation = "Location: login.php?msg=missmatch";
			break;

		default:
			$sendLocation = "Location: login.php";
			break;
	}

	header($sendLocation);
	exit();

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login | Online Project Dealer</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<?php include 'htmlIncludes/headIncludes.php'; ?>
</head>
<body>

	<div id="main">
		
		<?php include_once 'htmlIncludes/headerNav.php'; ?>

		<div id="loginBody">

			<div class="title">
				<img src="img/user.png">
				Login
			</div>

			<form action="login.php" method="POST">
				<input type="text" name="username" placeholder="Username...">
				<input type="password" name="password" placeholder="Password...">
				<input type="submit" name="loginBtn" value="Login">
			</form>

		</div>

	</div>

	<script type="text/javascript">
	<?php 

		if ( isset($_GET["msg"]) ) {
			$msg = $_GET["msg"];

			if ($msg == "nouser") {
				echo 'addFixedNotif("The username is nt registered, Please try again after registration!")';
			}
			if ($msg == "fail") {
				echo 'addFixedNotif("Login failed. Please try again!")';
			}
			if ($msg == "missmatch") {
				echo 'addFixedNotif("Invalid password. Please try again!")';
			}

		}

	?>
	</script>

</body>
</html>