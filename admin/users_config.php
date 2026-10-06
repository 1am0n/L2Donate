<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

include_once('../core.php');
admin::check();
$page = $_GET['page'];

if ($page == "")
{
	$sql = "SELECT * FROM ". MYSQL_PREFIX ."game_r_info";
	$rez = mysql::numRows($sql);
	if ($rez != 0) 
	{
?>
	<div id='reload'>
	
		<table class='content'>
		<tr>
		<td align='center' width='200'><?php echo __('user/list_title/acc_name'); ?></td>
		<td align='center' width='100'><?php echo __('user/list_title/points'); ?></td>
		<td align='center' width='200'><?php echo __('user/list_title/last_visit'); ?></td>
		<td align='center' width='150'><?php echo __('user/list_title/ip_address'); ?></td>
		<td align='center' width='130'></td>
		<td align='center' width='130'></td>
		</tr>
<?php
		$sql = "SELECT * FROM ". MYSQL_PREFIX ."game_r_info";
		$info = mysql::getArray($sql);
		foreach($info as $key => $row)
		{
			echo "
			<tr>
			<td align='center'>". $row['account_name'] ."</td>
			<td align='center'>". $row['points'] ."</td>
			<td align='center'>". $row['last_visit'] ."</td>
			<td align='center'>". $row['ip'] ."</td>
			<td align='center'>";
			echo "<input type='button' class='button' style='width: 100px;' onclick=\"javascript: repair('users_config.php?page=addp&id=". $row['id'] ."');\" value='". __('button/add_points') ."'>";
			echo "</td>
			<td align='center'>";
			echo "<input type='button' class='button' style='width: 100px;' onclick=\"javascript: repair('users_config.php?page=delp&id=". $row['id'] ."');\" value='". __('button/remove_points') ."'>";
			echo "</td>
			</tr>
			";
		}
?>
		</table>
	</div>
<?php 
	}
	else
	{
		echo __('user/no_users');
	}
}
elseif ($page == "addp")
{
	if ($_GET['addPoints'] == 1) 
		{
			$error = false;
			$sql2 = "SELECT points FROM ". MYSQL_PREFIX ."game_r_info WHERE id = '". security::escapeStr($_GET['id']) ."'";
			$row = mysql::fetchArray($sql2);

			$pffr = security::safeInput($_GET['points']);
			$points = $row['points'] + $pffr;

		if(!empty($pffr))
		{
			if(security::isNum($pffr) != false)
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
			$sql = "UPDATE ". MYSQL_PREFIX ."game_r_info SET points = '$points' WHERE id = '". security::escapeStr($_GET['id']) ."'";
			mysql::query($sql);
			echo "<div id='success'>". __('user/points_added') ."</div>";
		}
	}
?>
    <table cellpadding="0" cellspacing="5" class='content'>  
		<tr>
            <td><?php echo __('user/input_title/add_points_sum'); ?> </td><td><input type="text" id="points"/></td>
        </tr>			
        <tr>
            <td></td>
            <td> 
				<input class='button' type="button" onclick="javascript: addPoints('<?php echo $_GET['id']; ?>');" value="<?php echo __('button/submit'); ?>"/>
            </td>
        </tr>
    </table>
	
<?php
}
elseif ($page == "delp")
{
	if($_GET['deletePoints'] == 1) 
	{
		$error = false;
		$sql2 = "SELECT points FROM ". MYSQL_PREFIX ."game_r_info WHERE id = '". security::escapeStr($_GET['id']) ."'";
		$row = mysql::fetchArray($sql2);

		$pffr = security::safeInput($_GET['points']);
		$points = $row['points'] - $pffr;

		if(!empty($pffr))
		{
			if(security::isNum($pffr) != false)
			{
				if($pffr < $row['points'])
				{
					$error = false;
				}
				else
				{
					$error = true;
					echo "<div id='error'>". __('user/bad_remove_points_sum') ."</div>";
				}
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
			$sql = "UPDATE ". MYSQL_PREFIX ."game_r_info SET points = '$points' WHERE id = '". security::escapeStr($_GET['id']) ."'";
			mysql::query($sql);
			echo "<div id='success'>". __('user/points_removed') ."</div>";
		}
	}
?>
	<div id='reload'>
		<table cellpadding="0" cellspacing="5" class='content'>  
			<tr>
				<td><?php echo __('user/input_title/remove_points_sum'); ?> </td><td><input type="text" id="points" /></td>
			</tr>			
			<tr>
				<td></td>
				<td> 
				  <br><input class='button' type="button" onclick="javascript: deletePoints('<?php echo $_GET['id']; ?>');" value="<?php echo __('button/submit'); ?>"/>
				</td>
			</tr>
		</table>
	</div>
<?php
}
else
{
	custom::redirect("admin.php");
}
?>

</center>
</body>
</html>