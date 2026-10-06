<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

if(!defined('DON_STARTED')) exit('Site security activated !');

class mysql
{
	function openConn($host, $user, $pass)
	{
		$mysqlConnect = mysql_connect($host, $user, $pass) or die(mysql_error());
		return $mysqlConnect;
	}
	
	function closeConn()
	{
		global $mysqlConnect;
		
		mysql_close($mysqlConnect) or die(mysql_error());
	}
	
	function openDB($db)
	{
		global $mysqlConnect;
		
		mysql_select_db($db, $mysqlConnect) or die(mysql_error());
		mysql::query("SET NAMES 'utf8'");
	}
	
	function query($sql)
	{
		$query = mysql_query($sql) or die(mysql_error());
		return $query;
	}
	
	function fetchArray($sql)
	{
		$fetch_array = mysql_fetch_array(mysql_query($sql));
		return $fetch_array;
	}
	
	function fetchRow($sql)
	{
		$query = mysql_query($sql);
		while($row = mysql_fetch_row($query))
		{
			$array[] = $row;
		}
		return $array;
	}
	
	function getArray($sql)
	{
		$query = mysql_query($sql);
		while($row = mysql_fetch_assoc($query))
		{
			$array[] = $row;
		}
		return $array;
	}
	
	function numRows($sql)
	{
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		return $count;
	}
}

?>