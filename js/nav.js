function checkNavForOffset(){
	if ( window.pageYOffset > 2 ) {
		document.getElementById("nav").style.top = 0;
	}else{
		document.getElementById("nav").style.top = "40px";
	}
}


window.onload = function(){
	checkNavForOffset();
}

window.onscroll = function(){
	checkNavForOffset();
}