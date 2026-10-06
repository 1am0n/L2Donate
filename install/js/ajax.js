/*
* ajax request
*/
function req()
{
	var req;
	try {
		req = new XMLHttpRequest();
	} catch (e) {
		try {
			req = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				req = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {
				alert("Your browser doesn't support the Ajax.");
				return false;
			}
		}
	}
	return req;
}

/*
* load file
*/
function load (value) 
{
	xmlReq = req();
	
	document.getElementById("info").innerHTML = '';

	xmlReq.onreadystatechange = function() {
		if (xmlReq.readyState == 1){
			document.getElementById("info").innerHTML = "<center><img src='images/loader.gif' border='0'></center>";
		}
		if (xmlReq.readyState == 4){
			document.getElementById("info").innerHTML = xmlReq.responseText;
		}
	}
	xmlReq.open("GET", value, true);
	xmlReq.send(null);
}