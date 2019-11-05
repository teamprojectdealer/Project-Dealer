<?php 

if( isset($_POST["uploadProjectBtn"]) ){

	$name = $_POST["projectName"];
	$price = $_POST["price"];
	$description = $_POST["description"];
	$uid = $_SESSION["id"];

	$projectImage = $_FILES["projectImage"]["tmp_name"];
	$projectImageType = $_FILES["projectImage"]["type"];

	$allowedImageTypes = array("image/jpeg","image/gif","image/png");

	if ( !in_array($projectImageType, $allowedImageTypes) ) {
		header("Location: index.php?msg=invalidImg");
			exit();
	}

	$projectImageName = Statics::getRandomString().$_FILES["projectImage"]["name"];
	$projectFile = $_FILES["projectFile"]["tmp_name"];
	$projectFileName = Statics::getRandomString().$_FILES["projectFile"]["name"];

	$totalProjectNum = Statics::getProject(true,"",$conn)[0];

	$projectMainFodler = "projects";
	$currentFolderName = $projectMainFodler."/project".($totalProjectNum+1);
	$currentFoldersProjectFile = $currentFolderName."/files";
	$currentFoldersProjectImage = $currentFolderName."/images";

	Statics::createFolder($currentFolderName);
	Statics::createFolder($currentFoldersProjectFile);
	Statics::createFolder($currentFoldersProjectImage);

	move_uploaded_file($projectFile, $currentFoldersProjectFile."/".$projectFileName);
	move_uploaded_file($projectImage, $currentFoldersProjectImage."/".$projectImageName);


	$q = "INSERT INTO `project`(`name`, `filepath`, `userId`, `priceInPound`, `description`, `projectImage`) VALUES (?,?,?,?,?,?)";
	$qs = $conn->prepare($q);
	$qs->bind_param("ssiiss",$name,$projectFileName,$uid,$price,$description,$projectImageName);
	$qs->execute();
	$qs->close();

	header("Location: index.php?msg=uploaded");
	exit();
}

?>