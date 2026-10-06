<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

if(!defined('DON_STARTED')) exit('Site security activated !');

class don
{	
	/* acc name */
	function account_name()
	{
		mysql::openDB(MYSQL_DB1);
		$sql = "SELECT account_name FROM ". MYSQL_PREFIX ."game_r_info WHERE account_name = '". security::escapeStr(session::read('user_real')) ."'";
		$name = mysql::getArray($sql);
		foreach($name as $key => $set)
		{
			return $set['account_name'];
		}
	}
	
	/* acc points */
	function account_points()
	{
		mysql::openDB(MYSQL_DB1);
		$sql = "SELECT points FROM ". MYSQL_PREFIX ."game_r_info WHERE account_name = '". security::escapeStr(session::read('user_real')) ."'";
		$points = mysql::getArray($sql);
		foreach($points as $key => $set)
		{
			return $set['points'];
		}
	}
	
	/* acc choose link */
	function choose_account()
	{
		mysql::openDB(MYSQL_DB2);
	
		if(session::read('user_real')) 
		{
			$sql = "SELECT * FROM characters WHERE account_name = '". security::escapeStr(session::read('user_real')) ."'";
			$result = mysql::fetchRow($sql);
			$i = 0;
			foreach($result as $key => $myrow)
			{
				$i++;
				
				//myrow[47] = race id
				//myrow[30] = sex id
				
				if($myrow[47] == 0 && $myrow[30] == 0){$info[$i]['char_img'] = "<img src=".STATIC_IMAGE_PATH."human_m.png>";}
				if($myrow[47] == 1 && $myrow[30] == 0){$info[$i]['char_img'] = "<img src=".STATIC_IMAGE_PATH."elf_m.png>";}
				if($myrow[47] == 2 && $myrow[30] == 0){$info[$i]['char_img'] = "<img src=".STATIC_IMAGE_PATH."delf_m.png>";}
				if($myrow[47] == 3 && $myrow[30] == 0){$info[$i]['char_img'] = "<img src=".STATIC_IMAGE_PATH."orc_m.png>";}
				if($myrow[47] == 4 && $myrow[30] == 0){$info[$i]['char_img'] = "<img src=".STATIC_IMAGE_PATH."dwarf_m.png>";}
				
				if($myrow[47] == 0 && $myrow[30] == 1){$info[$i]['char_img'] = "<img src=".STATIC_IMAGE_PATH."human_f.png>";}
				if($myrow[47] == 1 && $myrow[30] == 1){$info[$i]['char_img'] = "<img src=".STATIC_IMAGE_PATH."elf_f.png>";}
				if($myrow[47] == 2 && $myrow[30] == 1){$info[$i]['char_img'] = "<img src=".STATIC_IMAGE_PATH."delf_f.png>";}
				if($myrow[47] == 3 && $myrow[30] == 1){$info[$i]['char_img'] = "<img src=".STATIC_IMAGE_PATH."orc_f.png>";}
				if($myrow[47] == 4 && $myrow[30] == 1){$info[$i]['char_img'] = "<img src=".STATIC_IMAGE_PATH."dwarf_f.png>";}
				
				$info[$i]['char_name'] = $myrow[2];
				$info[$i]['char_choose'] = "<form action='user.php' method='post'><input type='hidden' name='charObj' value='". $myrow[1] ."'><input type='submit' class='buttons' name='choose_char' value='Pasirinkti'></form>";
				$info[$i]['char_lvl'] = $myrow[3];
			}
		
			if (!empty($_POST['choose_char']))
			{
				session::remove('charObj');
				session::write('charObj', $_POST['charObj']);
				custom::redirect('user.php?don=main');
			}
			
			return $info;
		}
	}

	/* don shop */
	function shop()
	{
		mysql::openDB(MYSQL_DB1);
		$sql_check = "SELECT * FROM ". MYSQL_PREFIX ."product";
		$query = mysql::numRows($sql_check);
		if($query <= 0)
		{
			die("	
			<noscript>
			". __('product/no-product.') ."
			</noscript>
			
			<script type='text/javascript'>
			alert('". __('product/no-product') ."');
			history.go(-1);
			</script>
			");
		}
		
		$sql = "SELECT * FROM ". MYSQL_PREFIX ."product";
		$prod = mysql::fetchRow($sql);
		$i = 0;
		foreach($prod as $key => $row)
		{
		$i++;
			$pro[$i]['id'] = $row[0];
			$pro[$i]['item_id'] = $row[2];
			$pro[$i]['item_price'] = $row[3];
			$pro[$i]['item_sum'] = $row[4];
			$pro[$i]['buy_link'] = "<a href='user.php?don=buy&id=". $row[0] ."' class='lk'>". $row[1] ."</a>";
		}
	
		return $pro;
	}
	
	/* buying product info */
	function buy_info()
	{
		mysql::openDB(MYSQL_DB1);
		
		$sql = "SELECT ". MYSQL_PREFIX ."product.item_name, ". MYSQL_PREFIX ."product.item_price, ". MYSQL_PREFIX ."game_r_info.points FROM ". MYSQL_PREFIX ."product, ". MYSQL_PREFIX ."game_r_info WHERE ". MYSQL_PREFIX ."game_r_info.account_name = '". security::escapeStr(session::read('user_real')) ."' AND ". MYSQL_PREFIX ."product.id = '". security::escapeStr($_GET['id']) ."'";
		$dab = mysql::getArray($sql);
		foreach($dab as $key => $row)
		{
			$i++;
			$items[$i]['i_name'] = $row['item_name'];
			$items[$i]['i_price'] = $row['item_price'];
			$items[$i]['a_points'] = $row['points'];
			
			$rezultat = $row['item_price'] - $row['points'];
		
			if(($row['points'] - $row['item_price']) < 0)
			{
				$stat = "". __('lack_points') ." <font color='#b50101'>".$rezultat."</font>";
			}
			else
			{
				$stat = "". __('remain_points') ." <font color='#39d51b'>".$rezultat."</font>";
			}
			
			$final = preg_replace('/-/', ' ', $stat);
			
			$items[$i]['formul'] = $final;
			
			if($row['points'] >= $row['item_price'])
			{
				$items[$i]['buy_link'] = "<input type='button' class='buttons' onclick='javascript: window.location=\"user.php?don=buy-ok&id=".$_GET['id']."\"' value='". __('buy') ."'>";
			}
			else
			{
				$items[$i]['buy_link'] = "<input type='button' class='buttonsoff'  onclick=\"alert('". __('buy_closed') ."')\" value='". __('buy') ."'>";
			}
		}
		return $items;
	}
	
	/* weapon enchant */
	function choose_item_weapon()
	{
		mysql::openDB(MYSQL_DB1);
		
		$link[]['link'] = "
		<form action = 'user.php?don=enchant' method = 'post'>
		<select name='objid'>
		<option value='0'>". __('choose_weapon') ."</option>";
		
		$info3 = "SELECT maxpliusweapon FROM ". MYSQL_PREFIX ."config WHERE id = '1'";
		$row5 = mysql::fetchArray($info3);
		
		mysql::openDB(MYSQL_DB2);
		
		$rez1 = "SELECT * FROM items WHERE owner_id = '". security::escapeStr(session::read('charObj')) ."' AND enchant_level < '". security::escapeStr($row5['maxpliusweapon']) ."' AND enchant_level >= '0'";
		$rezultatas1 = mysql::query($rez1);
		while($row1 = mysql_fetch_row($rezultatas1)) {
		$rez2 = "SELECT * FROM weapon WHERE item_id = '". security::escapeStr($row1[2]) ."' AND crystal_type NOT LIKE 'none'";
		$rezultatas2 = mysql::query($rez2);
		while($row2 = mysql_fetch_row($rezultatas2)) {
		$link[]['link'] = "<option value='".$row1[1]."'>".$row2[1]." +".$row1[4]."</option>";
		}
		}
		
		$link[]['link'] = "
		</select>
		<input type='submit' class='buttons' name='plus1w' value='". __('plus_one') ."'>
		</form>
		";
		
		//1 +
		if(!empty($_POST['plus1w']))
		{	
			$objid = $_POST['objid'];
			
			mysql::openDB(MYSQL_DB2);
			
			$sql = "SELECT * FROM items WHERE object_id = '". security::escapeStr($objid) ."'";
			$num_rows = mysql::numRows($sql);
			$get_array = mysql::fetchArray($sql);
			
			$sql2 = "SELECT enchant_level, owner_id FROM items WHERE object_id = '". security::escapeStr($objid) ."'";
			$row4 = mysql::fetchArray($sql2);
			
			$owner_id = $row4['owner_id'];
			
			mysql::openDB(MYSQL_DB1);
			
			$sql3 = "SELECT * FROM ". MYSQL_PREFIX ."game_r_info WHERE account_name = '". security::escapeStr(session::read('user_real')) ."'";
			$row5 = mysql::fetchArray($sql3);
			
			$sql4 = "SELECT plius_for_points_1 FROM ". MYSQL_PREFIX ."config";
			$row6 = mysql::fetchArray($sql4);
			
			if ($num_rows <= 0)
			{
				custom::redirect('user.php?don=enchant');
			}
			elseif ($row5['points'] < $row6['plius_for_points_1'])
			{
				custom::redirect('user.php?don=enchant');
			}
			else
			{
				$enchant_pl = $row4['enchant_level']+1;
				$points_pl = $row5['points']-$row6['plius_for_points_1'];
				
				mysql::openDB(MYSQL_DB2);
				mysql::query("UPDATE items SET enchant_level = '".$enchant_pl."' WHERE object_id = '". security::escapeStr($objid) ."'");
				mysql::openDB(MYSQL_DB1);
				mysql::query("UPDATE ". MYSQL_PREFIX ."game_r_info SET points = '".$points_pl."' WHERE account_name = '". security::escapeStr(session::read('user_real')) ."'");
				custom::redirect('user.php?don=enchant');
			}
		}
		
		return $link;
	}
	
	/* armor enchant */
	function choose_item_armor()
	{
		mysql::openDB(MYSQL_DB1);
		
		$link[]['link'] = "
		<form action = 'user.php?don=enchant' method = 'post'>
		<select name='objid'>
		<option value='0'>". __('choose_armor') ."</option>";
		
		$info3 = "SELECT maxpliusarmor FROM ". MYSQL_PREFIX ."config WHERE id = '1'";
		$row5 = mysql::fetchArray($info3);
		
		mysql::openDB(MYSQL_DB2);
		
		$rezultatas1 = mysql::query("SELECT * FROM items WHERE owner_id = '". security::escapeStr(session::read('charObj')) ."' AND enchant_level < '". security::escapeStr($row5['maxpliusarmor']) ."' AND enchant_level >= '0'");
		while($row1 = mysql_fetch_row($rezultatas1)) {
		$rezultatas2 = mysql::query("SELECT * FROM armor WHERE item_id='". security::escapeStr($row1[2]) ."' AND crystal_type NOT LIKE 'none'");
		while($row2 = mysql_fetch_row($rezultatas2)) {
		$link[]['link'] = "<option value='".$row1[1]."'>".$row2[1]." +".$row1[4]."</option>";
		}
		}
		
		$link[]['link'] = "
		</select>
		<input type='submit' class='buttons' name='plus1a' value='". __('plus_one') ."'>
		</form>
		";
		
		//1 +
		if(!empty($_POST['plus1a']))
		{
			$objid = $_POST['objid'];
			
			mysql::openDB(MYSQL_DB2);
			$sql = "SELECT * FROM items WHERE object_id = '". security::escapeStr($objid) ."'";
			$num_rows = mysql::numRows($sql);
			$get_array = mysql::fetchArray($sql);
			
			$sql2 = "SELECT enchant_level, owner_id FROM items WHERE object_id = '". security::escapeStr($objid) ."'";
			$row4 = mysql::fetchArray($sql2);
			
			mysql::openDB(MYSQL_DB1);
			
			$sql3 = "SELECT * FROM ". MYSQL_PREFIX ."game_r_info WHERE account_name = '". security::escapeStr(session::read('user_real')) ."'";
			$row6 = mysql::fetchArray($sql3);
			
			$sql4 = "SELECT plius_for_points_1 FROM ". MYSQL_PREFIX ."config";
			$row7 = mysql::fetchArray($sql4);
			
			if ($num_rows <= 0)
			{
				custom::redirect('user.php?don=enchant');
			}
			elseif ($row6['points'] < $row7['plius_for_points_1'])
			{
				custom::redirect('user.php?don=enchant');
			}
			else
			{
				$enchant_pl = $row4['enchant_level']+1;
				$points_pl = $row6['points']-$row7['plius_for_points_1'];
				
				$sql8 = "UPDATE items SET enchant_level = '". $enchant_pl ."' WHERE object_id = '". security::escapeStr($objid) ."'";
				$sql9 = "UPDATE ". MYSQL_PREFIX ."game_r_info SET points = '". $points_pl ."' WHERE account_name = '". security::escapeStr(session::read('user_real')) ."'";
				mysql::openDB(MYSQL_DB2);
				mysql::query($sql8);
				mysql::openDB(MYSQL_DB1);
				mysql::query($sql9);
				custom::redirect('user.php?don=enchant');
			}
		}
		
		return $link;
	}
	
	/* nobless buy */
	function nobless_buy()
	{
	
		global $db;
		global $lang;
		global $prefix;
		
		$sql = "SELECT nobless_price, recommend_price FROM ".$prefix."config WHERE id = '1'";
		$row = $db->fetch_array($sql,$secur->db(2));
		
		$sql1 = "SELECT nobless, rec_have FROM characters WHERE obj_Id = '{$secur->escape_str($_GET['char'])}'";
		$row1 = $db->fetch_array($sql1,$secur->db(1));
		
		$link[]['table_start'] = 
		"
		<link rel='stylesheet' href='engine/static_style/static.css' type='text/css'/>
		<form action='kt_buy.php?char=".$_GET['char']."' method='post'>
		<table align='center' class='tbl3'>
		<tr><td align='center' width='200'><b><i>Pavadinimas</i></b></td><td align='center' width='60'><b><i>Kaina</i></b></td><td align='center' width='60'></td></tr>
		";
		
		if($row1['rec_have'] < 255)
		{
		$link[]['recommend'] =
		"
			<tr><td align='center'  width='200'><i>{$lang['user_ recommend 255']}</i></td><td align='center' width='60'><i>".$row['recommend_price']."</i></td><td align='center' width='60'><input type='submit' name='pirkti_recommend' class='admin' value='{$lang['user_ pirkti']}'></td></tr>
		";
		}
		
		if($row1['nobless'] == 0)
		{
		$link[]['noblesse'] = 
		"
			<tr><td align='center'  width='200'><i>{$lang['user_ nobless_status']}</i></td><td align='center' width='60'><i>".$row['nobless_price']."</i></td><td align='center' width='60'><input type='submit' name='pirkti_noblesse' class='admin' value='{$lang['user_ pirkti']}'></td></tr>
		";
		}
		
		$link[]['table_end'] = 
		"
		</table>
		</form>
		";
	
	return $link;
	
	}
	
	/* sms keywords */
	function keywords()
	{
		global $settings;
		
		if ($settings['mikro'] == 1)
		{
			$sql_check = "SELECT * FROM ". MYSQL_PREFIX ."sms_config";
			$check = mysql::numRows($sql_check);
			if ($check <= 0)
			{
				die("<center>". __('mikro/no_mikro') ."</center>");
			}
			else
			{
				$sql = "SELECT * FROM ". MYSQL_PREFIX ."sms_config";
				$keywords = mysql::getArray($sql);
				$i = 0;
				foreach($keywords as $key => $set)
				{
					$i++;
					
					$price = $set['price'];
					$all_price = $price / 100;
					
					$keyword[$i]['keyword'] = $set['keyword'];
					$keyword[$i]['price'] = $all_price;
					$keyword[$i]['number'] = $set['number'];
					$keyword[$i]['sms_points'] = $set['sms_points'];
					
				}
			}
		}
		else
		{
			die("<center>". __('mikro/mikro_off') ."</center>");
		}
		
		return $keyword;
	}
}

?>