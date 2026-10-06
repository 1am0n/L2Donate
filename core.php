<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

error_reporting(0);
header("Content-type: text/html; charset=utf-8"); 
ob_start();

if(file_exists("_config.php"))
{
	die("Sistema dar neirasyta, prasome tai padaryti jei norite naudotis sistema (install/ katalogas).");
}

$baselvl = ""; $i = 0;
while (!file_exists($baselvl."config.php")) {
	$baselvl .= "../"; $i++;
	if ($i == 5) { die("<center>Konfigūracijos failas (config.php) neegzistuoja</center>"); }
}
require_once($baselvl.'config.php');

define("DON_STARTED", true);

define("DON_REQUEST", isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != "" ? $_SERVER['REQUEST_URI'] : $_SERVER['SCRIPT_NAME']);

define("DON_ROOT", $baselvl); //root path

define("DON_ENGINE", DON_ROOT . "engine");

define("DON_CORE", DON_ENGINE . "/system_core");

define('STATIC_IMAGE_PATH', DON_ROOT.'engine/static_images/'); // static image path
define('STATIC_STYLE_PATH', DON_ROOT.'engine/static_style/'); // static style path
define('STATIC_JS_PATH', DON_ROOT.'engine/static_js/'); // static js path

if (file_exists(DON_ENGINE . "/loader.php"))
{
	require_once(DON_ENGINE . "/loader.php");
}
else
{
	echo "Nerastas loader_func.php failas";
}

define('DON_LNG', DON_ROOT.'language/');
define('DON_TPL', DON_ROOT.'templates/');

define('DONATE_TEMPLATE_PATH', DON_ROOT.'templates/'.$settings['template'].''); // donate template path
define('DONATE_IMAGE_PATH', DON_ROOT.'templates/'.$settings['template'].'/images'); // donate image path

?>