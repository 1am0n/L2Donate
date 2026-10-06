<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

include_once('../core.php');
admin::check();

if(isset($_SESSION['administrator']))
{
	unset($_SESSION['administrator']);
	if(isset($_SESSION['administrator_ip']))
	{
		unset($_SESSION['administrator_ip']);
		custom::redirect("index.php");
	}
	else
	{
		custom::redirect("index.php");
	}
}
else
{
	custom::redirect("index.php");
}

?>