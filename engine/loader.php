<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

if (file_exists(DON_ENGINE . "/loader_func.php"))
{
	require_once(DON_ENGINE . "/loader_func.php");
}

/* start loading system and config files */

loadLib("mysql");
loadLib("security");
loadLib("don");
loadLib("admin");
loadLib("custom");
loadLib("buttons");
loadLib("template");
loadLib("sessions");

$mysqlConnect = mysql::openConn(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
mysql::openDB(MYSQL_DB1);

$tpl = new template;

$settings = mysql::fetchArray("SELECT * FROM ". MYSQL_PREFIX ."config");

$tpl->set_var('donate_style', DON_ROOT."templates/".$settings['template']."/style.css");
$tpl->set_var('static_js', STATIC_JS_PATH);
$tpl->set_var('donate_js_path', "".DON_ROOT."templates/".$settings['template']."/js");
$tpl->set_var('lang', buttons::lang_change());

loadLib("language");
language::loadFromFile('website');
language::loadFromFile('admin');
language::setLanguage(DON_LANGUAGE);

session::start();
/* end loading system and config files */

/* prevent any possible XSS attacks via $_GET */
foreach ($_GET as $check_url) {
	if (!is_array($check_url)) {
		$check_url = str_replace("\"", "", $check_url);
		if ((preg_match("/<[^>]*script*\"?[^>]*>/i", $check_url)) || (preg_match("/<[^>]*object*\"?[^>]*>/i", $check_url)) ||
			(preg_match("/<[^>]*iframe*\"?[^>]*>/i", $check_url)) || (preg_match("/<[^>]*applet*\"?[^>]*>/i", $check_url)) ||
			(preg_match("/<[^>]*meta*\"?[^>]*>/i", $check_url)) || (preg_match("/<[^>]*style*\"?[^>]*>/i", $check_url)) ||
			(preg_match("/<[^>]*form*\"?[^>]*>/i", $check_url)) || (preg_match("/\([^>]*\"?[^)]*\)/i", $check_url)) ||
			(preg_match("/\"/i", $check_url))) {
		die ();
		}
	}
}
unset($check_url);

/* Sanitise $_SERVER globals */
$_SERVER['PHP_SELF'] 		= 	security::cleanUrl($_SERVER['PHP_SELF']);
$_SERVER['QUERY_STRING'] 	= 	isset($_SERVER['QUERY_STRING']) ? security::cleanUrl($_SERVER['QUERY_STRING']) : "";
$_SERVER['REQUEST_URI']	 	= 	isset($_SERVER['REQUEST_URI']) ? security::cleanUrl($_SERVER['REQUEST_URI']) : "";
$PHP_SELF 					= 	security::cleanUrl($_SERVER['PHP_SELF']);

?>