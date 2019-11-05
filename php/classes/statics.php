<?php
include_once 'user.php';
include_once 'project.php';

class Statics
{

	public static function getUser($attr,$attrType,$value,$conn){

		$q = "SELECT * FROM users WHERE $attr = ? ";
		$qs = $conn->prepare($q);
		$qs->bind_param($attrType,$value);
		$qs->execute();
		$qs->store_result();

		$user = new User();

		if ( $qs->num_rows == 0 ) {
			// id = 0 implies no row fetched
			// that means no user found
			$user->setId(0);
		}else{
			$qs->bind_result($id,$username,$password,$fullname,$gender,$type,$profilePic,$email,$amount);

			if ($qs->fetch()) {
				$user->setId($id);
				$user->setUsername($username);
				$user->setPassword($password);
				$user->setFullName($fullname);
				$user->setGender($gender);
				$user->setType($type);
				$user->setProfilePic($profilePic);
				$user->setEmail($email);
				$user->setAmount($amount);
			}
		}

		$qs->free_result();
		$qs->close();

		return $user;

	}


	public static function updateTable($tableName,$sets,$conditions,$conn){

		$q = "UPDATE $tableName SET $sets WHERE $conditions";
		$qs = $conn->prepare($q);
		$c = $qs->execute();
		$qs->close();
		return $c;

	}

	public static function deleteRow($tableName,$conditions,$conn){

		$q = "DELETE FROM $tableName WHERE $conditions";
		$qs = $conn->prepare($q);
		$c = $qs->execute();
		$qs->close();
		return $c;

	}

	public static function getProject($fetchAll,$conditions,$conn){

		if(!$fetchAll) $q = "SELECT * FROM project WHERE $conditions";
		else $q = "SELECT * FROM project ORDER BY id DESC";

		$qs = $conn->prepare($q);
		$qs->execute();
		$qs->store_result();

		$allProjects = array();
		$allCount = 0;

		$totalRows = $qs->num_rows;

		if ( $totalRows != 0 ) {
			$qs->bind_result($id,$name,$filepath,$userId,$price,$description,$projectImage);

			while ($qs->fetch()) {
				$project = new Project();
				$project->setId($id);
				$project->setName($name);
				$project->setFilePath($filepath);
				$project->setUserId($userId);
				$project->setPrice($price);
				$project->setDescription($description);
				$project->setProjectImage($projectImage);

				$allProjects[$allCount] = $project;
				$allCount++;
			}
		}

		$qs->free_result();
		$qs->close();

		return array($totalRows,$allProjects);

	}

	public static function createFolder($path){

		if( !file_exists($path) ){
			mkdir($path,0777,true);
		}

	}


	public static function getRandomString(){
		return substr(md5(rand()), 0, 7);;
	}


	public static function downloadFile($filepath){

		if( file_exists($filepath) ){

			header("Content-Description: File Transfer");
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=".basename($filepath));
			header("Expires:0");
			header("Cache-Control: must-revalidate");
			header("Pragma: public");
			header("Content-Length: ".filesize($filepath));
			readfile($filepath);
			exit();

		}

	}

}

?>