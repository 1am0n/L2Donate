<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

require_once("../core.php");

if($_GET['adminLogin'] == 1)
{
	$error = false;
	$pass = security::safeInput($_GET['admin_pass']);
	$name = security::safeInput($_GET['admin_name']);

	if(!empty($pass) && !empty($name)) 
	{
		if(admin::loginValidation($name, $pass) != 0)
		{
			$error = false;
		}
		else
		{
			$error = true;
			echo "<div id='error'>". __('login/bad_username_or_password') ."</div>";
		}
	}
	else
	{
		$error = true;
		echo "<div id='error'>". __('all/empty_fields') ."</div>";
	}



	if ($error == false) 
	{
		session::write('administrator', 'ba846s59d4869d4j'); 
		session::write('administrator_ip', $settings['admin_ip']); 
		echo "<span class='hidden'>ok</span>";	
	}
}

?>