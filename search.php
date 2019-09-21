<?php
include_once 'php/sessionCheck.php';
include_once 'php/classes/statics.php';
//this variable is used for navigation active purpose
$activePage = "home";

$searchQuery = "";
if ( isset($_GET["query"]) ) {
	$searchQuery = trim($_GET["query"]);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Search | Online Project Dealer</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<?php include 'htmlIncludes/headIncludes.php'; ?>
</head>
<body>

	<div id="main">
		
		<?php include_once 'htmlIncludes/headerNav.php'; ?>

		<div id="themePic"></div>

		<div id="showCase">

			<div class="dark center fam1 fs2">Search Results for '<?php echo $searchQuery; ?>'</div>	

			<div class="clear"></div>
			<div class="hrow"></div>

			<div style="height: auto;display: block;clear: both;width: 100%;overflow: auto;">

			<?php 


				$projectsDetail = Statics::getProject(false,"name LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%' ",$conn);

				$projectCount = $projectsDetail[0];
				$projectsAll = $projectsDetail[1];

				if ( $projectCount == 0 ) {
					echo '<div class="dark fam1 small center">No projects found!</div>	';
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

			</div>

		<?php include_once 'htmlIncludes/footer.php'; ?>

		</div>


	</div>


	<script type="text/javascript" src="js/nav.js"></script>

</body>
</html>