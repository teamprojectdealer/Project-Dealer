<?php 

echo '
	
	<form method="GET" action="search.php">
		<div class="dark fam1 fs2">Search Projects</div>	
		<div class="dark small fam2">Search keywords are matched through project\'s title or description... </div>	
		<input type="text" name="query" placeholder="Search keyword..." />
		<input type="submit" value="Search"/>
	</form>
	<br/>
	<div class="hrow"></div>
	<br/>
	<div class="dark center fam1 fs2">Latest Projects</div>	
	<div class="hrow"></div>

	';

		$projectsDetail = Statics::getProject(true,"",$conn);

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


	echo '

	<div class="clear"></div>
	<br/>
	
	<div id="projectUploadDivExact"></div>

	<div class="clear"></div>
	<br/>
	<br/>
	<br/>

	<div id="projectUploadDiv">

		<form action="index.php" method="POST" enctype="multipart/form-data">

			<div class="dark fam1 fs2 left">Upload Project</div>	
			<div class="right" title="Dismiss" onclick="hideUploadDiv();"><img src="img/close.png" height="20" width="20" style="background:#666;border-radius:50%;padding:5px;cursor:pointer;/></div>

			<div class="clear"></div>
			<br/>
			<br/>
			<div class="hrow dark"></div>

			<div class="clear"></div>
			<br/>
			<div class="dark left fam2">Project title</div>
			<input type="text" name="projectName" placeholder="Project Title or Name..."/>

			<div class="clear"></div>
			<br/>
			<div class="dark left fam2">Project Price (&pound;)</div>
			<input type="number" name="price" placeholder="Project price in pound..."/>

			<div class="clear"></div>
			<br/>
			<div class="dark left fam2">Project Description</div>
			<textarea name="description"></textarea>

			<div class="clear"></div>
			<br/>
			<div class="dark left fam2">Project File </div>
			<div class="clear"></div>
			<input type="file" name="projectFile" />

			<div class="clear"></div>
			<br/>
			<div class="dark left fam2">Project Image</div>
			<input type="file" name="projectImage" />
			<input type="submit" value="Upload" name="uploadProjectBtn" />

		</form>

	</div>



';

?>