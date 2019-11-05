<?php 
	
	echo '

		<script type="text/javascript">
		

		//project upload

		var projectUploadDiv = document.getElementById("projectUploadDiv");

		function showUploadDiv(){
			projectUploadDiv.style.display = "block";
		}
		function hideUploadDiv(){
			projectUploadDiv.style.display = "none";
			window.scroll(0,0);
			clearHash();
		}
		hideUploadDiv();

		</script>

	';

?>
