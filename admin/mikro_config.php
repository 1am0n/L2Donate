<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

include_once('../core.php');
admin::check();

if ($_GET['deleteSms'] == 1)
{
	$sql = "DELETE FROM ". MYSQL_PREFIX ."sms_config WHERE id = '". security::escapeStr($_GET['id']) ."'";
	mysql::query($sql);
}

if ($_GET['mikroAddKeyword'] == 1)
{
	$error = false;
	$keyword = security::safeInput($_GET['keyword']);
	$price = security::safeInput($_GET['price']);
	$number = security::safeInput($_GET['number']);
	$points = security::safeInput($_GET['points']);

	if(!empty($keyword) && !empty($price) && !empty($number) && !empty($points))
	{
		if(security::isNum($price) != false && security::isNum($points) != false && security::isNum($number) != false)
		{
			$error = false;
		}
		else
		{
			$error = true;
			echo "<div id='error'>". __('all/only_numeric') ."</div>";
		}
	}
	else
	{
		$error = true;
		echo "<div id='error'>". __('all/empty_fields') ."</div>";
	}

	if ($error == false) {
		$sql = "INSERT INTO ". MYSQL_PREFIX ."sms_config SET keyword = '$keyword', price = '$price', number = '$number', sms_points = '$points'";
		mysql::query($sql);
		echo "<div id='success'>". __('mikro/success') ."</div>";
	}
}

if ($_GET['updSms'] == 1)
{
	$error = false;
	$keyword = security::safeInput($_GET['keyword']);
	$price = security::safeInput($_GET['price']);
	$number = security::safeInput($_GET['number']);
	$points = security::safeInput($_GET['points']);

	if(security::isNum($price) != false && security::isNum($points) != false && security::isNum($number) != false)
	{
		$error = false;
	}
	else
	{
		$error = true;
		echo "<div id='error'>". __('all/only_numeric') ."</div>";
	}

	if ($error == false) {
		$sql2 = "UPDATE ". MYSQL_PREFIX ."sms_config SET keyword = '$keyword', price = '$price', number = '$number', sms_points = '$points' WHERE id = '". security::escapeStr($_GET['id']) ."'";
		mysql::query($sql2);
		echo "<div id='success'>". __('mikro/update/success') ."</div>";
	}
}

?>
<div id='reload'>
    <table cellpadding="0" cellspacing="5" class='content'>
		<tr>
         
            <td><?php echo __('mikro/input_title/sms_keyword'); ?> </td><td><input type="text" id="keyword" value="<?php if (isset($_GET['keyword'])){ echo $_GET['keyword']; } ?>"/></td>
       
        </tr>  
		<tr>
         
            <td><?php echo __('mikro/input_title/sms_price'); ?> </td><td><input type="text" id="price" value="<?php if (isset($_GET['price'])){ echo $_GET['price']; } ?>"/></td>
       
        </tr>
		<tr>
         
            <td><?php echo __('mikro/input_title/sms_number'); ?> </td><td><input type="text" id="number" value="<?php if (isset($_GET['number'])){ echo $_GET['number']; } ?>"/></td>
       
        </tr>
		<tr>
         
            <td><?php echo __('mikro/input_title/sms_get_points'); ?> </td><td><input type="text" id="points" value="<?php if (isset($_GET['points'])){ echo $_GET['points']; } ?>"/></td>
       
        </tr>			
        <tr>
            <td></td>
            <td>
				<?php if ($_GET['updSms1'] == 2) { ?>
				<input class='button' type="button" onclick="javascript: updateSms('<?php echo $_GET['id']; ?>');"  value="<?php echo __('button/submit'); ?>"/>
				<?php } else { ?>
				<input class='button' type="button" onclick="javascript: addSms();"  value="<?php echo __('button/submit'); ?>"/>
				<?php } ?>
            </td>
        </tr>
    </table>

<?php

$sql = "SELECT * FROM ". MYSQL_PREFIX ."sms_config";
$rez = mysql::numRows($sql);
if($rez != 0) 
{
?>
	<table class='content'>
	<tr>
	<td align='center' width='200'><?php echo __('mikro/list_title/sms_keyword'); ?></td>
	<td align='center' width='150'><?php echo __('mikro/list_title/sms_price'); ?></td>
	<td align='center' width='130'><?php echo __('mikro/list_title/sms_number'); ?></td>
	<td align='center' width='130'><?php echo __('mikro/list_title/sms_get_points'); ?></td>
	<td align='center' width='120'></td>
	<td align='center' width='120'></td>
	</tr>
<?php
	$sql = "SELECT * FROM ". MYSQL_PREFIX ."sms_config";
	$info = mysql::getArray($sql);
	foreach($info as $key => $row)
	{
	echo "
	<tr>
	<td align='center'>".$row['keyword']."</td>
	<td align='center'>".$row['price']."</td>
	<td align='center'>".$row['number']."</td>
	<td align='center'>".$row['sms_points']."</td>
	<td align='center'>";
	echo "<input type='button' class='button' style='width: 50px;' onclick=\"javascript: repair('mikro_config.php?id=". $row['id'] ."&keyword=". $row['keyword'] ."&price=". $row['price'] ."&number=". $row['number'] ."&points=". $row['sms_points'] ."&updSms1=2');\" value='". __('button/repair') ."'>";
	echo "</td>
	<td align='center'>";
	echo "<input type='button' class='button' style='width: 50px;' onclick=\"javascript: deleteSmsData('". $row['id'] ."');\" value='". __('button/delete') ."'>";
	echo "</td>
	</tr>";
	}
?>
	</table>
	</div>
<?php
}
	else
	{
		echo __('mikro/no_sms');
	}
?>

</center>
</body>
</html>