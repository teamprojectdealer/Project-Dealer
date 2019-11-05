<?php
include_once 'php/sessionCheck.php';
include_once 'php/classes/statics.php';
//this variable is used for navigation active purpose
$activePage = "";

?>

<!DOCTYPE html>
<html>
<head>
	<title>My Projects | Online Project Dealer</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<?php include 'htmlIncludes/headIncludes.php'; ?>
</head>
<body>

	<div id="main">
		
		<?php include_once 'htmlIncludes/headerNav.php'; ?>

		<div id="themePic"></div>

		<div id="showCase">

			<div class="dark center fam1 fs2">My Projects</div>	

			<?php 


				$projectsDetail = Statics::getProject(false,"userId = ".$_SESSION["id"],$conn);

				$projectCount = $projectsDetail[0];
				$projectsAll = $projectsDetail[1];

				if ( $projectCount == 0 ) {
					echo '<div class="dark fam1 small center">You have no projects uploaded for sell!</div><br/>';
				}else{

					for ($i=0; $i < count($projectsAll) ; $i++) { 
						
						$currentProj = $projectsAll[$i];

						$curProjectId = $currentProj->getId();
						$curProjectImage = $currentProj->getProjectImage();
						$curProjectName = $currentProj->getName();
						$curProjectDescription = $currentProj->getDescription();

						$curProjectDescription = preg_replace('/[\x00-\x1F\x7F-\xFF]/','',$curProjectDescription);

						echo '

							<div class="project" id="'.$curProjectId.'" style="background-image:url(projects/project'.$curProjectId.'/images/'.$curProjectImage.');">
								<div class="title">'.$curProjectName.'</div>
								<div class="description">'.$curProjectDescription.'</div>
								<a href="viewProject.php?id='.$curProjectId.'">View</a>
							</div>

						';	

					}

				}

			?>

			<div class="clear"></div>
			<div class="hrow"></div>

			<div class="dark center fam1 fs2">Bought Projects</div>	

			<?php 

				$q = "SELECT p.id,p.name,p.description,p.projectImage FROM buy b, users u, project p WHERE b.userId =  u.id AND p.id = b.projectId AND b.userId = ?";
				$qs = $conn->prepare($q);
				$qs->bind_param("i",$_SESSION["id"]);
				$qs->execute();
				$qs->bind_result($boughtPid,$boughtPName,$boughtPDescription,$boughtPImage);
				while ($qs->fetch()) {

					echo '
						<div class="project" id="'.$boughtPid.'" style="background-image:url(projects/project'.$boughtPid.'/images/'.$boughtPImage.');">
							<div class="title">'.$boughtPName.'</div>
							<div class="description">'.$boughtPDescription.'</div>
							<a href="viewProject.php?id='.$boughtPid.'">View</a>
						</div>

					';	

				}
				if ( $qs->num_rows == 0 ) {
					echo '<br/><div class="dark fam2 center">You have not bought any projects yet!</div><br/>';
				}
				$qs->close();

			?>
			<div class="clear"></div>


		<?php include_once 'htmlIncludes/footer.php'; ?>

		</div>


	</div>


	<script type="text/javascript" src="js/nav.js"></script>

</body>
</html>