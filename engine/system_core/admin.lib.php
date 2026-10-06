<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

if(!defined('DON_STARTED')) exit('Site security activated !');

class admin
{
	function loginValidation($username, $password)
	{
		$sql = "SELECT admin_pass FROM ". MYSQL_PREFIX ."config WHERE admin_name = '". security::escapeStr($username) ."' AND admin_pass = '". security::escapeStr(admin::passEncode($password)) ."'";
		return  mysql::numRows($sql);
	}
	
	function passEncode($password)
	{
		$salt = '1dasd1ad90HO0ASdlsad168d413';
		$password = md5($password.$salt);
		return $password;
	}
	
	//tikrina ar prisijunges zmogus yra administratorius
	function check()
	{	
		if(!isset($_SESSION['administrator']) || isset($_SESSION['administrator']) != 'ba846s59d4869d4j' || isset($_SESSION['administrator_ip']) != $_SERVER['REMOTE_ADDR'])
		{
			custom::redirect("index.php");
		}
	}
}
	
?>