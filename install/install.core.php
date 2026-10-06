<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

header("Content-type: text/html; charset=utf-8"); 
session_start();
ob_start();

if(file_exists('installed.txt'))
{
	die('Sistema jau įdiegta !');
}

define('style', "<link rel='stylesheet' href='style/css.css' type='text/css'>");
define('js', "<script type='text/javascript' src='js/ajax.js'></script>");

?>