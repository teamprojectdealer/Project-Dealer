<?php
include_once 'php/sessionCheck.php';
include_once 'php/classes/statics.php';
//this variable is used for navigation active purpose
$activePage = "";

$currentId = 0;
if ( !isset($_GET["id"]) || !$userLogin ) {
	header("Location: index.php");
	exit();
}

$currentId = intval(trim($_GET["id"]));

$projectsDetail = Statics::getProject(false,"id = $currentId ",$conn);

$projectCount = $projectsDetail[0];
$thisProject = $projectsDetail[1][0];

//bought project ids
$myBoughtProjectIds = array();
$mybpcount = 0;

$b = "SELECT projectId FROM buy WHERE userId = ?";
$bs = $conn->prepare($b);
$bs->bind_param("i",$_SESSION["id"]);
$bs->execute();
$bs->bind_result($dbPid);
while ($bs->fetch()) {
	$myBoughtProjectIds[$mybpcount] = $dbPid;
	$mybpcount++;
}
$bs->close();


//my projects
$myAllProjects = array();
$myallcount = 0;

$myAllProjectsNames = array();

$b = "SELECT id,name FROM project WHERE userId = ?";
$bs = $conn->prepare($b);
$bs->bind_param("i",$_SESSION["id"]);
$bs->execute();
$bs->bind_result($dbPmid,$dbPname);
while ($bs->fetch()) {
	$myAllProjects[$myallcount] = $dbPmid;
	$myAllProjectsNames[$myallcount] = $dbPname;
	$myallcount++;
}
$bs->close();


?>

<!DOCTYPE html>
<html>
<head>
	<title>View Project | Online Project Dealer</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<?php include 'htmlIncludes/headIncludes.php'; ?>

	<style type="text/css">
		.downloadFile,.downloadFile a{
			background-color: #6ca768;
			color: #fff;
			width: 100%;
			font-weight: bold;
			padding: 5px;
			box-sizing: border-box;
			border-radius: 4px;
		}
		.downloadFile img{
			float: right;
			width: 25px;
			height: 25px;
			background-color: #6ca768;
			padding: 4px;
			box-sizing: border-box;
			border-radius: 50%;
		}

		#exchangeChooser{
			position: fixed;
			top: 10%;
			width: 30%;
			left: 35%;
			padding: 10px;
			box-sizing: border-box;
			background-color: #fff;
			border-radius: 4px;
			z-index: 15000;
			font-family: 'abel',arial,serif;
			box-shadow: 0 0 100px #999;
			transition: all 0.4s;
			transform: scale(0);
		}
		#exchangeChooser select{
			width: 100%;
			padding: 10px;
			box-sizing: border-box;
		}
		#btnExchange,#btnCancelExchange{
			display: block;
			margin-top: 10px;
			width: 100%;
			padding: 5px;
			box-sizing: border-box;
			background-color: #6ca768;
			color: #fff;
			text-align: center;
			cursor: pointer;
		}
		#btnCancelExchange{
			background-color: #e25e5e;
		}
	</style>
</head>
<body>

	<div id="exchangeChooser">
		<div class="fam1 center small">Choose the project which you want to exchange with:</div>
		<br/>
		<select id="selectedExchangeId">
			<?php 
				for ($i=0; $i < count($myAllProjectsNames); $i++) { 
					echo '<option value="'.$myAllProjects[$i].'">'.$myAllProjectsNames[$i].'</option>';
				}
			?>
		</select>
		<div id="btnExchange">Proceed Exchange</div>
		<div id="btnCancelExchange">Cancel</div>
	</div>

	<div id="main">
		
		<?php include_once 'htmlIncludes/headerNav.php'; ?>

		<div id="themePic"></div>
		<div id="showCase">


			<?php 

				if ( $projectCount == 0 ) {
					echo '<div class="dark fam1 small center">The project may have been deleted or not found!</div>	';
				}else{

					$currentProjectOwner = Statics::getUser("id","i",$thisProject->getUserId(),$conn);

					echo '

						<div class="dark center fam1 fs2">Project Name : '.$thisProject->getName().'</div>	
						<div class="clear"></div>
						<div class="hrow"></div>

						<div class="projectBody">
							
							<div class="dark fam1">Description</div>	
							<div class="desc"> &rarr; '.$thisProject->getDescription().'</div>	
							<br/>

							<div class="dark fam1">Price</div>	
							<div class="desc"> &rarr; &pound;'.$thisProject->getPrice().'</div>	
							<br/>

							<div class="dark fam1">Project Image</div>	
							<div class="images" style="background-image:url(projects/project'.$currentId.'/images/'.$thisProject->getProjectImage().');"></div>	
							<br/>

							<div class="hrow dark"></div>
							<div class="dark fam1 center">Project Owner</div>	
							<br/>
							<div class="owner"> '.

								'<img class="profile" src="profiles/'.$currentProjectOwner->getProfilePic().'"/>'.
								'<br/> &rarr; Username : '.$currentProjectOwner->getUsername().
								'<br/> &rarr; Full Name : '.$currentProjectOwner->getFullName()

							.'</div>	
							<br/>

							<div class="hrow dark"></div>
							<div class="dark fam1 center">Project File</div>	
							<br/>
							<div class="owner"> ';

								if( in_array($thisProject->getId(), $myBoughtProjectIds)  
									|| 
									in_array($thisProject->getId(), $myAllProjects)
								){
									echo '<div class="downloadFile" title="Download">
									<a href="downloadFile.php?fileName='.$thisProject->getFilePath().'&projectId='.$currentId.'">'.$thisProject->getFilePath().'<img src="img/download.png" alt="Download"/></a>
									</div>';
								}else{
									echo '<br/> &rarr; To access this project\'s file, either it must be your project or you must buy it :)';
								}

							echo '</div>	
							<br/>

							<div class="hrow dark"></div>
							';
							if(in_array($thisProject->getId(), $myBoughtProjectIds) || 
									in_array($thisProject->getId(), $myAllProjects) ){
								echo '<a class="actionBtn bought">Bought &#10003; </a>
								<a class="actionBtn exchanged">Send Exchange Request<img src="img/exchange.png" /></a>';
							}else{
								echo '<a id="buyProjectBtn" class="actionBtn">Buy <img src="img/buy.png" /></a>
								<a id="exchangeProjectBtn" class="actionBtn exchange">Send Exchange Request<img src="img/exchange.png" /></a>';
							}
							echo '
							<br/>
							<br/>

						</div>

					';

				}
			?>

			

		<?php include_once 'htmlIncludes/footer.php'; ?>

		</div>


	</div>


	<script type="text/javascript" src="js/nav.js"></script>

	<script type="text/javascript">

		function buyProject(){
 
 			if ( confirm("Are you sure to proceed? <?php echo $thisProject->getPrice(); ?> pound is going to be charged.") ) {
 				var params = "&projectId=<?php echo $thisProject->getId(); ?>";
				ajax({
				    meth : "POST",
				    url : "php/projectActions.php",
				    params : "buy=yes"+params,
				    onsuccess: "f",
				    onsuccessFunc : function(rtxt){
				    	if ( rtxt == "bought" ) {
				    		addFixedNotif("Project Bought Sucessfully!");
				    		document.getElementById("buyProjectBtn").className += " bought"; 
				    		document.getElementById("exchangeProjectBtn").className = "actionBtn exchanged"; 
				    		document.getElementById("exchangeProjectBtn").id = ""; 
				    		document.getElementById("buyProjectBtn").innerHTML = "Bought &#10003;"; 
				    	}
				    	if ( rtxt == "own project" ) {
				    		addFixedNotif("No need to buy your own project.");
				    	}
				    	if ( rtxt == "buy-error" ) {
				    		addFixedNotif("An error occured while buying the Project. Please try again! Maybe you have already bought this project.");
				    	}
				    	if ( rtxt == "lowamount" ) {
				    		addFixedNotif("You dont have enough amount to buy this project.");
				    	}
				    }
				});
 			}

		}

		document.getElementById("buyProjectBtn").onclick = buyProject;


		var exchangeChooser = document.getElementById("exchangeChooser");
		function showExchangeChooser(){
			exchangeChooser.style.transform = "scale(1)";
		}
		function hideExchangeChooser(){
			exchangeChooser.style.transform = "scale(0)";
		}

		document.getElementById("btnCancelExchange").onclick = hideExchangeChooser;
		document.getElementById("btnExchange").onclick = exchangeProject;

		function exchangeProject(){
			var currentProjectId = <?php echo $thisProject->getId(); ?>,
			currentProjectOwnerId = <?php echo $currentProjectOwner->getId(); ?>,
			toBeExchangedWithProjectId = document.getElementById('selectedExchangeId').value;

			if ( confirm("Are you sure to exchange?") ) {
 				var params = "&projectOwnersId="+currentProjectOwnerId+"&requestedProjectId="+currentProjectId+"&toBeExchangedWithProjectId="+toBeExchangedWithProjectId;
				ajax({
				    meth : "POST",
				    url : "php/projectActions.php",
				    params : "exchange=yes"+params,
				    onsuccess: "f",
				    onsuccessFunc : function(rtxt){
				    	if ( rtxt == "success" ) {
				    		addFixedNotif("Project exchange request has neen sent. If the owner accpets your request, the projects will be exchanged then.");
				    	}
				    	if ( rtxt == "error" ) {
				    		addFixedNotif("An error occured while exchanging the Project. You may have already sent request for this project!");
				    	}
			    		hideExchangeChooser();
				    }
				});
 			}

		}

		document.getElementById('exchangeProjectBtn').onclick = showExchangeChooser;

		window.scroll(0,388);
	</script>

</body>
</html>