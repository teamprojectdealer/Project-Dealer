var xhtp = ajaxObj();
function ajaxObj() {
    if (typeof XMLHttpRequest !== 'undefined') {
        return new XMLHttpRequest();
    }
    var versions = [
        "MSXML2.XmlHttp.6.0",
        "MSXML2.XmlHttp.5.0",
        "MSXML2.XmlHttp.4.0",
        "MSXML2.XmlHttp.3.0",
        "MSXML2.XmlHttp.2.0",
        "Microsoft.XmlHttp"
    ];

    var xhr;
    for (var i = 0; i < versions.length; i++) {
        try {
            xhr = new ActiveXObject(versions[i]);
            break;
        } catch (e) {
        }
    }
    return xhr;
}

function ajax(obj) {
    //if(typeof obj == "object") {
        xhtp.onreadystatechange = function(){
                        
            if( xhtp.status == 500 ){
               if( obj.on505 == "f" ){
                 obj.on505();
               }else{
                 alert("Sorry, Something went wrong! (Internal error)"+xhtp.responseText);
               }
            }

            if (xhtp.readyState == 4 && xhtp.status == 200) {
                
                if ( obj.onsuccess == "t" ) {

                    var successEl = document.getElementById(obj.onsuccessElid);
                    successEl.innerHTML += xhtp.responseText;

                }else if( obj.onsuccess == "f" ){
                    obj.onsuccessFunc(xhtp.responseText);
                }else{

                    var successEl = document.getElementById(obj.onsuccessElid);
                    successEl.innerHTML += xhtp.responseText;

                    obj.onsuccessFunc();

                }

            }

        };

        

        xhtp.open(obj.meth.toUpperCase(),obj.url,true);
        if ( obj.meth.toLowerCase() == "get" ) {
            xhtp.send();
        }
        if( obj.meth.toLowerCase() == "post" ){
            xhtp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhtp.send(obj.params);
        }

    //}else{
        //alert("Pass object please!");
    //}
}

/*ajax({
    meth : "",
    url : "",
    params : "",
    loaderType : "text" || "loader" || "function",
    loaderElid : elemntId,
    loaderFunc : function(){
        //codes
    },
});
*/