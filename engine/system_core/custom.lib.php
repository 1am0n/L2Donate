<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

if(!defined('DON_STARTED')) exit('Site security activated !');

class custom
{
	/* redirect */
	function redirect($location, $script = false) {
		if (!$script) {
			header("Location: ".str_replace("&amp;", "&", $location));
			exit;
		} else {
			echo "<script type='text/javascript'>document.location.href='".str_replace("&amp;", "&", $location)."'</script>\n";
			exit;
		}
	}
	
	function ifOnline()
	{
		global $settings;

		if($settings['buy_only_off'] == 1)
		{
			mysql::openDB(MYSQL_DB2);
			$check_sql = "SELECT online FROM characters WHERE obj_Id = '". security::escapeStr($_GET['char']) ."'";
			$check = mysql::fetchArray($check_sql);
			$online = $check['online'];
			
			if($online == 1)
			{
				die("
				<script type='text/javascript'>
				alert('". __('gamer_online') ."');
				history.go(-1);
				</script><noscript><center>". __('gamer_online') ."</center></noscript>
				");
			}
		}
	}
}

?>