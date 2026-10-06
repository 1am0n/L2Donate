<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

if(!defined('DON_STARTED')) exit('Site security activated !');

class buttons
{
	/* back button */
	function back($value)
	{
		return "<input type='button' class='buttons' value='". __('back') ."' onclick=\"location.href='$value'\">";
	}
	
	/* add points button */
	function add_points()
	{
		return "<input type='button' class='buttons' value='". __('add_points') ."' onclick=\"return popitup('user.php?don=sms','". __('add_points') ."')\">";
	}
	
	/* logout button */
	function logout()
	{
		return "<input type='button' class='buttons' value='". __('logout') ."' onclick=\"return confirm_leave('". __('logout_confirm') ."', 'user.php?don=logout')\">";
	}
	
	/* re-choose char button */
	function rechoose_char()
	{
		return "<input type='button' class='buttons' onclick=\"javascript: location.href='user.php'\" value='". __('char_rechoose') ."'>";
	}
	
	//shop, nobles, rec, enchant links
	function item_link()
	{
		$link[0]['shop'] = "<input type='button' class='buttons' onclick=\"javascript: location.href='user.php?don=shop'\" value='". __('shop') ."'>";
		$link[0]['enchant'] = "<input type='button' class='buttons' onclick=\"javascript: location.href='user.php?don=enchant'\" value='". __('enchant') ."'>";
	
		return $link;
	}

	/* lang change buttons */
	function lang_change()
	{
		global $lang_choose;
		global $static_image_path;
		
		if($lang_choose == 1)
		{
			return "
			<a href=\"\" onclick=\"javascript: createCookie('don546_lang','LT','365');\"><img src='".STATIC_IMAGE_PATH."/lt.gif' border='0'/></a> 
			<a href=\"\" onclick=\"javascript: createCookie('don546_lang','EN','365');\"><img src='".STATIC_IMAGE_PATH."/en.gif' border='0'/></a> 
			";
		}
		else
		{
			return "";
		}
	}
}

?>