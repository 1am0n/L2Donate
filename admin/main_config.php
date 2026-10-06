<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

include_once('../core.php');
admin::check();
mysql::openDB(MYSQL_DB1);

if($_GET['mainConfigUpdate'] == 1)
{
	$error = false;
	$theme = security::safeInput($_GET['tpl']);
	$lang = security::safeInput($_GET['lng']);
	$buying = security::safeInput($_GET['only_off']);
	$wmax = security::safeInput($_GET['wmax']);
	$amax = security::safeInput($_GET['amax']);
	$p1 = security::safeInput($_GET['opp']);
	$nobless = security::safeInput($_GET['nobl']);
	$rec = security::safeInput($_GET['rec']);
	$mikro_onoff = security::safeInput($_GET['mikro']);

	if(security::isNum($wmax) != false && security::isNum($amax) != false && security::isNum($p1) != false && security::isNum($nobless) != false && security::isNum($rec) != false)
	{	
		$error = false;
	}
	else
	{
		$error = true;
		echo "<div id='error'>". __('all/only_numeric') ."</div>";
	}

	if ($error == false) 
	{
		$sql = "UPDATE ". MYSQL_PREFIX ."config SET template = '$theme', language = '$lang', buy_only_off = '$buying', maxpliusweapon = '$wmax', maxpliusarmor = '$amax', plius_for_points_1 = '$p1', nobless_price = '$nobless', recommend_price = '$rec', mikro = '$mikro_onoff' WHERE id = '1'";
		mysql::query($sql);
		echo "<div id='success'>". __('mainc/update/success') ."</div>";
	}
}
?>
<div id='reload'>
<?php 
$settings = mysql::fetchArray("SELECT * FROM ". MYSQL_PREFIX ."config");
?>
    <table cellpadding="0" cellspacing="5" class='content'>
        <tr>
         
            <td><?php echo __('mainc/input_title/language'); ?></td>
			<td>
			<?php
			
			if (is_dir(DON_LNG)) {
				if ($dh = opendir(DON_LNG)) {
					echo "<select id='language'>";
					while (($file = readdir($dh)) !== false) {
						if(filetype(DON_LNG.$file) == "dir")
						{
						 if($file != ".." AND $file != ".")
						 {
						  echo '<option';
						  if($file == $settings['language'])
						  {
						   echo ' selected="selected"';
						  }
						  echo '>'.$file.'</option>'."\n";
						 }
						}
					}
					echo "</select>";
					closedir($dh);
				}
			}
			
			?>
			</td>
       
        </tr>
		<tr>
         
            <td><?php echo __('mainc/input_title/theme'); ?> </td>
			<td>
			<?php
			
			if (is_dir(DON_TPL)) {
				if ($dh = opendir(DON_TPL)) {
					echo "<select id='theme'>";
					while (($file = readdir($dh)) !== false) {
						if(filetype(DON_TPL.$file) == "dir")
						{
						 if($file != ".." AND $file != ".")
						 {
						  echo '<option';
						  if($file == $settings['template'])
						  {
							echo ' selected="selected"';
						  }
						  echo '>'.$file.'</option>'."\n";
						 }
						}
					}
					echo "</select>";
					closedir($dh);
				}
			}
			
			?>
			</td>
       
        </tr>
		<tr>
         
            <td><?php echo __('mainc/input_title/buy_only_off'); ?> </td>
			<td>
			<?php
				echo "<select id='only_off'>";
					$sql = mysql::getArray("SELECT * FROM ". MYSQL_PREFIX ."custom");
					foreach ($sql as $key => $row) 
					{
						$title = $row['status'];
						$value = $row['value'];
						
						if ($settings['buy_only_off'] == $value)
						{	
							$selected = "selected='selected'";
						}
						else
						{
							$selected = "";
						}
						
						echo "<option value='$value' $selected>$title</option>";
					}
				echo "</select>";
			?>
			</td>
       
        </tr>	
		<tr>
         
            <td><?php echo __('mainc/input_title/mikro'); ?> </td>
			<td>
			<?php
				echo "<select id='mikro_onoff'>";
					$sql = mysql::getArray("SELECT * FROM ". MYSQL_PREFIX ."custom");
					foreach ($sql as $key => $row) 
					{
						$title = $row['status'];
						$value = $row['value'];
						
						if ($settings['mikro'] == $value)
						{	
							$selected = "selected='selected'";
						}
						else
						{
							$selected = "";
						}
						
						echo "<option value='$value' $selected>$title</option>";
					}
				echo "</select>";
			?>
			</td>
       
        </tr>		
		<tr>
         
            <td><?php echo __('mainc/input_title/weapon_max'); ?> </td><td><input type="text" value="<?php echo $settings['maxpliusweapon']; ?>" id="wmax" /></td>
       
        </tr>
		<tr>
         
            <td><?php echo __('mainc/input_title/armor_max'); ?> </td><td><input type="text" value="<?php echo $settings['maxpliusarmor']; ?>" id="amax" /></td>
       
        </tr>
		<tr>
         
            <td><?php echo __('mainc/input_title/one_plius_price'); ?> </td><td><input type="text" value="<?php echo $settings['plius_for_points_1']; ?>" id="opp" /></td>
       
        </tr>
		<tr>
         
            <td><?php echo __('mainc/input_title/noblesse_price'); ?> </td><td><input type="text" value="<?php echo $settings['nobless_price']; ?>" id="nobless" /></td>
       
        </tr>
		<tr>
         
            <td><?php echo __('mainc/input_title/255_recommends_price'); ?> </td><td><input type="text" value="<?php echo $settings['recommend_price']; ?>" id="rec" /></td>
       
        </tr>		
        <tr>
            <td>
            </td>
            <td> 
				<input type="button" class='button' onclick="javascript: mainConfig();" value="<?php echo __('button/submit'); ?>"/>
            </td>
        </tr>
    </table>
</div>
</center>
</body>
</html>