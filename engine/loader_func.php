<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

function loadLib()
{
    foreach (func_get_args() as $core_name) {
        $_core_file = DON_CORE ."/". $core_name . ".lib.php";
        if (file_exists($_core_file)) {
            require_once($_core_file);
        } else {
            die("Neįmanoma vygdyti tolimesnių veiksmų, kol nerastas <b>" . $core_name . ".lib.php</b> failas.");
        }
    }
}

function loadConf($config_file)
{
    if (file_exists($config_file . ".php")) {
        require_once($config_file . ".php");
    }
	else
	{
		die("Neįmanoma vygdyti tolimesnių veiksmų, kol neegzistuoja <b>$config_file.php</b> failas.");
	}
}

?>