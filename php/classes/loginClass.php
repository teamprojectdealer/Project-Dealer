<?php 
include_once 'statics.php';

class Login
{

	private $user;
	private $conn;

	public function __construct($user,$conn){
		$this->user = $user;
		$this->conn = $conn;
	}

	public function login(){
		
		$loginStat = "failed";

		$userDetailsDb = Statics::getUser("username","s",$this->user->getUsername(),$this->conn);

		if( $userDetailsDb->getId() == 0 ){
			$loginStat = "unregistered";
		}else{
			
			if( password_verify( $this->user->getPassword(),  $userDetailsDb->getPassword() ) ){

				//set session variables
				$_SESSION["login"] = true;
				$_SESSION["id"] =  $userDetailsDb->getId();
				$_SESSION["username"] =  $userDetailsDb->getUsername();
				$_SESSION["profile"] =  $userDetailsDb->getProfilePic();
				$_SESSION["fullname"] =  $userDetailsDb->getFullName();
				$_SESSION["email"] =  $userDetailsDb->getEmail();
				$_SESSION["gender"] =  $userDetailsDb->getGender() == "m" ? "Male" : "Female";
				$_SESSION["type"] =  $userDetailsDb->getType() == "a" ? "Administrator" : "User";

				$loginStat = "success";
			}else{
				$loginStat = "missmatch";
			}

		}

		return $loginStat;

	}

	private function hashPass(){
		$this->user->setPassword( password_hash($this->user->getPassword(), PASSWORD_BCRYPT) );
	}

}

?>

