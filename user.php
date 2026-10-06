<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

include_once('core.php');
security::user();
	
$page = $_GET['don'];

$tpl->set_file('user'			, DONATE_TEMPLATE_PATH.'/user.html', 1);
$tpl->set_var('hello'			, __('hello_txt'));
$tpl->set_var('player_points'	, __('gamer_points'));
$tpl->set_var('player_nr'		, __('gamer_number'));
$tpl->set_var('player_name'		, __('gamer_name'));
$tpl->set_var('player_lvl'		, __('gamer_lvl'));
$tpl->set_var('choose_nr'		, __('choose_nr'));
$tpl->set_var('choose_name'		, __('choose_name'));
$tpl->set_var('choose_char'		, __('choose_chr'));

$tpl->set_var('prod_price'	, __('product_price'));
$tpl->set_var('prod_name'	, __('product_name'));
$tpl->set_var('prod_sum'	, __('product_sum'));

$tpl->set_var('nick'		, don::account_name()); //acc vardas
$tpl->set_var('points'		, don::account_points()); //acc taskai
$tpl->set_var('addpoint'	, buttons::add_points()); //tasku pridejimas
$tpl->set_var('logout'		, buttons::logout()); //atsijungimas
$tpl->set_var('char_choose'	, buttons::rechoose_char()); //char pasirinkimas
	
if($page == '')
{	
	$tpl->set_loop('player'	, don::choose_account());
	$tpl->process('output'	, 'users', 1, 0, 1);
}
elseif($page == "sms")
{
	$tpl->set_var('sms_txt'		, __('mikro/sms_text'));
	$tpl->set_var('sms_price'	, __('mikro/sms_price'));
	$tpl->set_var('sms_number'	, __('mikro/sms_number'));
	$tpl->set_var('sms_points'	, __('mikro/sms_points'));
	$tpl->set_var('nick'		, session::read('user_real'));
	$tpl->set_loop('keywords'	, don::keywords());
	$tpl->process('output'		, 'sms_method', 1, 0, 1);
}
elseif($page == "main")
{
	$tpl->set_loop('item_choose'	, buttons::item_link());
	$tpl->set_var('back'			, buttons::back('user.php')); //atgal
	$tpl->process('output'			, 'shop', 1, 0, 1);
}
elseif($page == "shop")
{
	custom::ifOnline();
	
	$tpl->set_loop('shop_shop'	, don::shop());
	$tpl->set_var('back'		, buttons::back('user.php?don=main')); //atgal
	$tpl->process('output'		, 'shopr', 1, 0, 1);
}
elseif($page == "buy")
{
	custom::ifOnline();
	
	$tpl->set_var('back'		, buttons::back('user.php?don=shop')); //atgal
	$tpl->set_loop('buy_info'	, don::buy_info());
	$tpl->process('output'		, 'buying', 1, 0, 1);
}
elseif($page == "enchant")
{
	custom::ifOnline();
	
	$tpl->set_var('weapons'	, __('weapons'));
	$tpl->set_var('armors'	, __('armors'));
	
	$tpl->set_var('back'	, buttons::back('user.php?don=main')); //atgal
	$tpl->set_loop('cwitem'	, don::choose_item_weapon());
	$tpl->set_loop('caitem'	, don::choose_item_armor());
	$tpl->process('output'	, 'enchant', 1, 0, 1);
}
elseif($page == "logout")
{
	if(isset($_SESSION['user_real'])) {
		unset($_SESSION['user_real']);
		custom::redirect('index.php');
	}
	else
	{
		custom::redirect('index.php');
	}
}
elseif($page == "buy-ok")
{
	custom::ifOnline();

	mysql::openDB(MYSQL_DB1);

	$rezultatas1 = "SELECT points FROM ". MYSQL_PREFIX ."game_r_info WHERE account_name = '". security::escapeStr(session::read('user_real')) ."'";  
	$row1 = mysql::fetchArray($rezultatas1);

	mysql::openDB(MYSQL_DB2);

	$rezultatas2 = "SELECT MAX(object_id) FROM items";
	$row2 = mysql::fetchArray($rezultatas2);

	mysql::openDB(MYSQL_DB1);

	$rezultatas3 = "SELECT * FROM ".MYSQL_PREFIX."product WHERE id='".security::escapeStr($_GET['id'])."'";
	$row3 = mysql::fetchArray($rezultatas3);

	if($_GET['id'] == "" || security::isNum(session::read('charObj')) == false) {
		custom::redirect('user.php?page=buy&id='.$_GET['id'].'');
	}
	elseif($row1['points'] < $row3['item_price']) {
		custom::redirect('user.php?page=buy&id='.$_GET['id'].'');
	} 
	else
	{
		$point = $row1['points'] - $row3['item_price'];
		$item = $row2['MAX(object_id)']+1;
		mysql::openDB(MYSQL_DB2);
		mysql::query("INSERT INTO items (owner_id, object_id, item_id, count, enchant_level, loc, loc_data, price_sell, price_buy, time_of_use, custom_type1, custom_type2, mana_left) VALUES('".session::read('charObj')."', '$item', '".$row3['item_id']."', '".$row3['item_sum']."', '0', 'INVENTORY', '0', '0', '0', '0', '0', '0', '-1');");
		mysql::openDB(MYSQL_DB1);
		mysql::query("UPDATE ".MYSQL_PREFIX."game_r_info SET points='$point' WHERE account_name='".security::escapeStr(session::read('user_real'))."'");
		die(
			"
			<script type='text/javascript'>
			alert('".__('product_buy_success')."');
			history.go(-1);
			</script>
			<noscript>
			".__('product_buy_success')."
			</noscript>
			"
			);
	}
}
else
{
	custom::redirect('user.php');
}

echo $tpl->process('','user', 1)
?>