var notifDiv = document.getElementById('notification');

function hideNotification(){;
	notifDiv.style.top = "-1000px";
	notifDiv.className = "hidden";
	clearHash();
}

function showNotification(val){
	notifDiv.getElementByClassName("value")[0].innerHTML = val;
	notifDiv.style.top = 0;
	notifDiv.className = "seen";
}
var hna;
function hideNotifAnim(){
	clearTimeout(hna);
	hna = setTimeout(hideNotification,5000);
	clearHash();
}

// showNotification();

if ( notifDiv.className == "seen" ) {
	hideNotifAnim();
}

document.getElementById("notifCancel").onclick = hideNotification;


var notificationSec = document.createElement("div");
notificationSec.id = "fixedNotif";
notificationSec.onclick = removeFixedNotif;
document.body.appendChild(notificationSec);

var slkdhf;
function addFixedNotif(text){
	clearTimeout(slkdhf);
	notificationSec.innerHTML = text;
	notificationSec.style.top = 0;
	slkdhf = setTimeout(removeFixedNotif,6000);
}

function removeFixedNotif(){
	notificationSec.style.top = "-100px";
	clearHash();
}


function clearHash(){
	history.pushState("",document.title,window.location.pathname);
}