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
* confirm
*/
function confirmation(msg, url) {
	var answer = confirm(msg)
	if (answer){
		window.location = url;
	}
}


/*
* admin login
*/
function login () 
{
	xmlReq = req();
	xmlReq.onreadystatechange = function() {
		if (xmlReq.readyState == 1){
			document.getElementById("reload").innerHTML = "<center><img src='images/loader.gif' border='0'/></center>";
		}
		if (xmlReq.readyState == 4){
			var x = document.getElementById("reload").innerHTML = xmlReq.responseText;
		}
		var s = /ok/; // what search
		var y =  x.search(s); // search
		if (y != -1)
		{
			window.location = "admin.php";
		}
	}
	
	var admin_name = document.getElementById("admin_name").value;
	var admin_pass = document.getElementById("admin_pass").value;

	xmlReq.open("GET", "validation_system.php?admin_name="+admin_name+"&admin_pass="+admin_pass+"&adminLogin=1", true);
	xmlReq.send(null);
}

/*
* load file
*/
function loadFile (value) 
{
	xmlReq = req();
	
	document.getElementById("file").innerHTML = '';

	xmlReq.onreadystatechange = function() {
		if (xmlReq.readyState == 1){
			document.getElementById("file").innerHTML = "<center><img src='images/loader.gif' border='0'></center>";
		}
		if (xmlReq.readyState == 4){
			document.getElementById("file").innerHTML = xmlReq.responseText;
		}
	}
	
	xmlReq.open("GET", value, true);
	xmlReq.send(null);
}

function repair (value) 
{
	xmlReq = req();
	
	xmlReq.onreadystatechange = triggered;
	xmlReq.open("GET", value, true);
	xmlReq.send(null);
}

/*
* update main config
*/
function mainConfig () 
{
	xmlReq = req();
	
	var tpl = document.getElementById("theme").value;
	var lng = document.getElementById("language").value;
	var only_off = document.getElementById("only_off").value;
	var mikro = document.getElementById("mikro_onoff").value;
	var wmax = document.getElementById("wmax").value;
	var amax = document.getElementById("amax").value;
	var opp = document.getElementById("opp").value;
	var nobl = document.getElementById("nobless").value;
	var rec = document.getElementById("rec").value;

	xmlReq.onreadystatechange = triggered;
	xmlReq.open("GET", "main_config.php?tpl="+tpl+"&lng="+lng+"&only_off="+only_off+"&mikro="+mikro+"&wmax="+wmax+"&amax="+amax+"&opp="+opp+"&nobl="+nobl+"&rec="+rec+"&mainConfigUpdate=1", true);
	xmlReq.send(null);
}

/*
* add products
*/
function addProduct () 
{
	xmlReq = req();
	
	var item_name = document.getElementById("item_name").value;
	var item_id = document.getElementById("item_id").value;
	var item_price = document.getElementById("item_price").value;
	var item_sum = document.getElementById("item_sum").value;

	xmlReq.onreadystatechange = triggered;
	xmlReq.open("GET", "product_config.php?item_name="+item_name+"&item_id="+item_id+"&item_price="+item_price+"&item_sum="+item_sum+"&addProduct=1", true);
	xmlReq.send(null);
}

/*
* update products
*/
function updateProduct (id) 
{
	xmlReq = req();
	
	var item_name = document.getElementById("item_name").value;
	var item_id = document.getElementById("item_id").value;
	var item_price = document.getElementById("item_price").value;
	var item_sum = document.getElementById("item_sum").value;

	xmlReq.onreadystatechange = triggered;
	xmlReq.open("GET", "product_config.php?item_name="+item_name+"&item_id="+item_id+"&item_price="+item_price+"&item_sum="+item_sum+"&id="+id+"&updateProduct=1&updateProduct1=2", true);
	xmlReq.send(null);
}

/*
* add user points
*/
function addPoints (id) 
{
	xmlReq = req();
	
	var points = document.getElementById("points").value;

	xmlReq.onreadystatechange = triggered;
	xmlReq.open("GET", "users_config.php?page=addp&id="+id+"&points="+points+"&addPoints=1", true);
	xmlReq.send(null);
}

/*
* delete user points
*/
function deletePoints (id) 
{
	xmlReq = req();
	
	var points = document.getElementById("points").value;

	xmlReq.onreadystatechange = triggered;
	xmlReq.open("GET", "users_config.php?page=delp&id="+id+"&points="+points+"&deletePoints=1", true);
	xmlReq.send(null);
}

/*
* add sms
*/
function addSms () 
{
	xmlReq = req();
	
	var keyword = document.getElementById("keyword").value;
	var price = document.getElementById("price").value;
	var number = document.getElementById("number").value;
	var points = document.getElementById("points").value;

	xmlReq.onreadystatechange = triggered;
	xmlReq.open("GET", "mikro_config.php?keyword="+keyword+"&price="+price+"&number="+number+"&points="+points+"&mikroAddKeyword=1", true);
	xmlReq.send(null);
}

/*
* update sms
*/
function updateSms (id) 
{
	xmlReq = req();
	
	var keyword = document.getElementById("keyword").value;
	var price = document.getElementById("price").value;
	var number = document.getElementById("number").value;
	var points = document.getElementById("points").value;

	xmlReq.onreadystatechange = triggered;
	xmlReq.open("GET", "mikro_config.php?id="+id+"&keyword="+keyword+"&price="+price+"&number="+number+"&points="+points+"&updSms=1&updSms1=2", true);
	xmlReq.send(null);
}

/*
* delete sms data
*/
function deleteSmsData(id) { 
	xmlReq = req();
	
	xmlReq.onreadystatechange = triggered;
	xmlReq.open("GET", "mikro_config.php?id="+id+"&deleteSms=1", true);
	xmlReq.send(null);
}

/*
* delete product data
*/
function deleteProductData(id) { 
	xmlReq = req();
	
	xmlReq.onreadystatechange = triggered;
	xmlReq.open("GET", "product_config.php?id="+id+"&deleteProduct=1", true);
	xmlReq.send(null);
}

/*
* add makro payment
*/
function addMakroPayment() { 
	xmlReq = req();
	
	var price = document.getElementById("makro_price").value;
	var points = document.getElementById("makro_points").value;
	
	xmlReq.onreadystatechange = triggered;
	xmlReq.open("GET", "makro_config.php?price="+price+"&points="+points+"&makroAddPayment=1", true);
	xmlReq.send(null);
}

/*
* update makro payment
*/
function updateMakroPayment(id) { 
	xmlReq = req();
	
	var price = document.getElementById("makro_price").value;
	var points = document.getElementById("makro_points").value;
	
	xmlReq.onreadystatechange = triggered;
	xmlReq.open("GET", "makro_config.php?id="+id+"&price="+price+"&points="+points+"&updateMakroData=1&updateMakroData1=2", true);
	xmlReq.send(null);
}

/*
* delete makro data
*/
function deleteMakroData(id) { 
	xmlReq = req();
	
	xmlReq.onreadystatechange = triggered;
	xmlReq.open("GET", "makro_config.php?id="+id+"&deleteMakro=1", true);
	xmlReq.send(null);
}

/*
* reload page
*/
function reloadPage(url) { 
	xmlReq = req();

	xmlReq.onreadystatechange = triggered;
	xmlReq.open("GET", url);
	xmlReq.send(null);
}

function triggered() {
	if (xmlReq.readyState == 1)
	{
		document.getElementById("reload").innerHTML = "<center><img src='images/loader.gif' border='0'></center>";
	}
	if ((xmlReq.readyState == 4) && (xmlReq.status == 200)) 
	{
		document.getElementById("reload").innerHTML = xmlReq.responseText;
	}
}
/*
* reload page end
*/
