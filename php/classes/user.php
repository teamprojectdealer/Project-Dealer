<?php

class User
{

	private $id;
	private $username;
	private $password;
	private $fullName;
	private $gender;
	private $type;
	private $email;
	private $profilePic;
	private $amount;

	//getters
	public function getId(){
		return $this->id;
	}
	public function getUsername(){
		return $this->username;
	}
	public function getPassword(){
		return $this->password;
	}
	public function getFullName(){
		return $this->fullName;
	}
	public function getGender(){
		return $this->gender;
	}
	public function getType(){
		return $this->type;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getProfilePic(){
		return $this->profilePic;
	}
	public function getAmount(){
		return $this->amount;
	}


	//setters
	public function setId($id){
		$this->id = $id;
	}
	public function setUsername($username){
		$this->username = $username;
	}
	public function setPassword($password){
		$this->password = $password;
	}
	public function setFullName($fullName){
		$this->fullName = $fullName;
	}
	public function setGender($gender){
		$this->gender = $gender;
	}
	public function setType($type){
		$this->type = $type;
	}
	public function setEmail($email){
		$this->email = $email;
	}
	public function setProfilePic($profilePic){
		$this->profilePic = $profilePic;
	}
	public function setAmount($amount){
		$this->amount = $amount;
	}


}

?>