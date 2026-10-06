<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

include_once('../core.php');

if($settings['admin_ip'] != '')
{
	if($settings['admin_ip'] != $_SERVER['REMOTE_ADDR'])
	{
		die("<div style='
		border: 1px solid red;
		  background-color : #FFCCCC;
		  width: 450px;
		  padding: 5px 0;
		  font-size: 12px;
		  font-family: verdana;
		  margin: 50px 10px 10px 400px;
		  text-align: center;'>
		  ". __('not_admin') ."
		  </div>");
	}
}

?>
<html>
<head>
<link rel='stylesheet' href='style/login.css' type='text/css'/>
<script type="text/javascript" src="js/custom.js"></script>
</head>
<body>
<center>

<div id='login_box'>
<div id='login_top'>Prisijungimas</div>
<div id='txt'>
<div id='reload'></div>
<table cellpadding="0" cellspacing="5" class="content">
<tr>
	<td><?php echo __('login/button/username'); ?></td><td><input type="text" id="admin_name"></td>
</tr>
<tr>
	<td><?php echo __('login/button/password'); ?></td><td><input type="password" id="admin_pass"></td>
</tr>
<tr>
	<td></td><td><input type="button" class='button' onclick="javascript: login();" value="<?php echo __('login/button/login'); ?>"></td>
</tr>
</table>
<div id='login_bottom'></div>
</div>
</div>
</center>
</body>
</html>