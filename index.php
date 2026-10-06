<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

include_once('core.php');

$tpl->set_file('login'		, DONATE_TEMPLATE_PATH.'/login.html');
$tpl->set_var('action'		, 'index.php');
$tpl->set_var('username'	, __('username'));
$tpl->set_var('password'	, __('password'));
$tpl->set_var('login_in'	, __('loggin_in'));

	if(!empty($_POST['jungtis']))
	{
		$arrErrors = array();
		$login = security::safeInput($_POST['login']);
		$password = security::safeInput($_POST['password']);
		$last_visit = date("Y-m-d");
		$ip = $_SERVER['REMOTE_ADDR'];
		
		mysql::openDB(MYSQL_DB2);
		
		$sql = "SELECT * FROM accounts WHERE login = '". security::escapeStr($login) ."' AND password = '". base64_encode(pack("H*", sha1(utf8_encode(security::escapeStr($password))))) ."'";
		$check = mysql::numRows($sql);
		
		$i++;
		if(!empty($login) && !empty($password))
		{
			if($check != 0)
			{
			
			mysql::openDB(MYSQL_DB1);
			
			$sql2 = "SELECT * FROM ". MYSQL_PREFIX ."game_r_info WHERE account_name = '". security::escapeStr($login) ."'";
			$check2 = mysql::numRows($sql2);
			
			if($check2 == 0)
			{
				$sql3 = "INSERT INTO ". MYSQL_PREFIX ."game_r_info SET account_name = '". $login ."', points = '0', last_visit = '$last_visit', ip = '$ip'";
				mysql::query($sql3);
				session::write('user_real', $login);
				custom::redirect('user.php');
			}
			else
			{
				$sql4 = "UPDATE ". MYSQL_PREFIX ."game_r_info SET last_visit = '$last_visit', ip = '$ip'";
				mysql::query($sql4);
				session::write('user_real', $login);
				custom::redirect('user.php');
			}
			}
			else
			{
				$arrErrors[]['error'] = "". __("bad_login") ."";
			}
		}
		else
		{
			$arrErrors[]['error'] = "". __("empty_fields") ."";
		}
			
		security::error_handling($arrErrors);
	
	}
		$tpl->set_loop('error', $arrErrors);
		
		echo $tpl->process('','login', 1)

?>