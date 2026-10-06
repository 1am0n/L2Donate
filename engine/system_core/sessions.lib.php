<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

if(!defined('DON_STARTED')) exit('Site security activated !');

class session  
{
	/*
    * Session start
    */
    function start()
    {
        session_start();
    }

	/*
	* session write
	*/
    function write($key, $value)
    {
        $_SESSION[$key] = $value;
    }

	/*
	* session read
	*/
    function read($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }
    
	/*
	* session destroy
	*/
    function destroy()
    {
        session_destroy();
    }
    
	/*
	* session unset
	*/
    function remove($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }    
}

?>