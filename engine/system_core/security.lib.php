<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

if(!defined('DON_STARTED')) exit('Site security activated !');

class security
{
	
	/*
	* return given param length
	*/
	function length($str) 
	{
		$str = strlen($str);
		return $str;
	}
	
	/*
	* return true if ident else false
	*/
	function ident($first_word, $second_word)
	{
		$rezult = strcmp($first_word, $second_word);
		if ($rezult == 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*
	* if user not logged in redirect him to login.php file
	*/
	function user()
	{	
		if(!session::read('user_real'))
		{
			custom::redirect("index.php");
		}
	}
	
	/* 
	* return safe input 
	*/
	function safeInput($input)
	{
		$search = array("&", "\"", "'", "\\", "<", ">");
		$replace = array("&amp;", "&quot;", "&#39;", "&#92;", "&lt;", "&gt;");
		$input = str_replace($search, $replace, $input);
		return $input;
	}
	
	/*
	* return true if int else false
	*/
	function isNum($param)
	{
		if (preg_match("/^[0-9]+$/", $param)) 
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}
	
	function error_handling($arrErrors)
	{
		if (count($arrErrors) == 0) {
	   
			echo "OK";
			
		} else {
		
		$strError = '<ul>';
        foreach ($arrErrors as $error) {
            $strError .= "<li>$error</li>";
        }
        $strError .= '</ul>';
			
		}
	}

	function escapeStr($param)
	{
		if (is_array($param))
		{
			foreach($param as $key => $val)
	   		{
				$param[$key] = $this->escape_str($val);
	   		}
   		
	   		return $param;
	   	}

		if (function_exists('mysql_real_escape_string'))
		{
			return mysql_real_escape_string($param);
		}
		elseif (function_exists('mysql_escape_string'))
		{
			return mysql_escape_string($param);
		}
		else
		{
			return addslashes($param);
		}
	}
	
	/* 
	* clean server url
	*/
	function cleanUrl($url) 
	{
		$bad_entities = array("&", "\"", "'", '\"', "\'", "<", ">", "(", ")", "*");
		$safe_entities = array("&amp;", "", "", "", "", "", "", "", "", "");
		$url = str_replace($bad_entities, $safe_entities, $url);
		return $url;
	}
	
	/*
	function friendly_url($url_friendly='', $url_simple='', $title='', $status, $custom)
	{
		mysql::openDB(MYSQL_DB1);
		
		$sql = "SELECT friendly_url FROM ". MYSQL_PREFIX ."config WHERE id = '1'";
		$row = mysql::fetchArray($sql);
		$friendly_url = $row['friendly_url'];
		
		if($status == 1 && $custom == 0) //1,0 link
		{
			if($friendly_url == 1)
			{
				return "<a href='$url_friendly' class='lk'>$title</a>";
			}
			else
			{
				return "<a href='$url_simple' class='lk'>$title</a>";
			}
		}
		elseif($status == 1 && $custom == 1) //1,1 link with delete confirm
		{
			if($friendly_url == 1)
			{
				return "<a href='$url_friendly' onclick=\"return confirm('{$lang['admin-7']}')\">$title</a>";
			}
			else
			{
				return "<a href='$url_simple' onclick=\"return confirm('{$lang['admin-7']}')\">$title</a>";
			}
		}
		elseif($status == 2 && $custom == 0) //2,0 clean
		{
			if($friendly_url == 1)
			{
				return $url_friendly;
			}
			else
			{
				return $url_simple;
			}
		}
		elseif($status == 3 && $custom == 0) //3,0 clean header
		{
			if($friendly_url == 1)
			{
				return header("Location: $url_friendly");
			}
			else
			{
				return header("Location: $url_simple");
			}
		}
	}
	*/
	
}

?>