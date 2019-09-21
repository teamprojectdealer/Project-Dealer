<?php 

class Register
{

	private $user;
	private $conn;

	public function __construct($user,$conn){
		$this->user = $user;
		$this->conn = $conn;
	}

	public function addUser(){
		$r = false;
		$q = "INSERT INTO `users`(`username`, `password`, `fullname`, `gender`, `type`, `profilePic`, `email`) VALUES (?,?,?,?,?,?,?)";
		$qs = $this->conn->prepare($q);
		$qs->bind_param('sssssss',$u,$p,$f,$g,$t,$pf,$e);

		$u = $this->user->getUsername();

		//hash the passwrod first
		$this->hashPass();
		$p = $this->user->getPassword();

		$f = $this->user->getFullName();
		$g = $this->user->getGender();
		$t = $this->user->getType();
		$pf = $this->user->getProfilePic();
		$e = $this->user->getEmail();

		$r =  $qs->execute();
		$qs->close();
		return $r;
	}

	private function hashPass(){
		$this->user->setPassword( password_hash($this->user->getPassword(), PASSWORD_BCRYPT) );
	}

}

?>

