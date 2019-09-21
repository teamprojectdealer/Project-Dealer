<?php 
include_once 'php/sessionCheck.php';
include_once 'php/classes/statics.php';

if ( isset($_GET["fileName"]) && isset($_GET["projectId"]) ) {
	$projectId = $_GET["projectId"];
	$fileName = $_GET["fileName"];
	$filePath = "projects/project$projectId/files/$fileName";

	Statics::downloadFile($filePath);
}

?>