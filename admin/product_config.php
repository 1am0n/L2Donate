<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

include_once('../core.php');
admin::check();

if ($_GET['deleteProduct'])
{
	$sql = "DELETE FROM ". MYSQL_PREFIX ."product WHERE id = '". security::escapeStr($_GET['id']) ."'";
	mysql::query($sql);
	unset($_GET['deleteProduct']);
}

if($_GET['addProduct'] == 1)
{
	$error = false;

	$name = security::safeInput($_GET['item_name']);
	$id = security::safeInput($_GET['item_id']);
	$price = security::safeInput($_GET['item_price']);
	$sum = security::safeInput($_GET['item_sum']);

	if(!empty($name) && !empty($id) && !empty($price) && !empty($sum))
	{
		if(security::isNum($id) != false && security::isNum($price) != false && security::isNum($sum) != false)
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

	if ($error == false) 
	{
		$sql = "INSERT INTO ". MYSQL_PREFIX ."product SET item_name = '$name', item_id = '$id', item_price = '$price', item_sum = '$sum'";
		mysql::query($sql);	
		unset($_GET['addProduct']);
		unset($_GET['item_name']);
		unset($_GET['item_id']);
		unset($_GET['item_price']);
		unset($_GET['item_sum']);
		echo "<div id='success'>". __('product/add/success') ."</div>";
	}
	
}

if($_GET['updateProduct'] == 1)
{
	$error = false;
		
	$name = security::safeInput($_GET['item_name']);
	$id = security::safeInput($_GET['item_id']);
	$price = security::safeInput($_GET['item_price']);
	$sum = security::safeInput($_GET['item_sum']);

	if(security::isNum($id) != false && security::isNum($price) != false && security::isNum($sum) != false)
	{
		$error = false;
	}
	else
	{
		$error = true;
		echo "<div id='error'>". __('all/only_numeric') ."</div>";
	}

	if ($error == false) {
		$sql2 = "UPDATE ". MYSQL_PREFIX ."product SET item_name = '$name', item_id = '$id', item_price = '$price', item_sum = '$sum' WHERE id = '". security::escapeStr($_GET['id']) ."'";
		mysql::query($sql2);
		echo "<div id='success'>". __('product/update/success') ."</div>";
	}
}

?>
<div id="reload">
    <table cellpadding="0" cellspacing="5" class='content'>
		<tr>
         
            <td><?php echo __('product/input_title/item_name'); ?> </td><td><input type="text" id="item_name" value="<?php if (isset($_GET['item_name'])){ echo $_GET['item_name']; } ?>"/></td>
       
        </tr>  
		<tr>
         
            <td><?php echo __('product/input_title/item_id'); ?> </td><td><input type="text" id="item_id" value="<?php if (isset($_GET['item_id'])){ echo $_GET['item_id']; } ?>"/></td>
       
        </tr>
		<tr>
         
            <td><?php echo __('product/input_title/item_price'); ?> </td><td><input type="text" id="item_price" value="<?php if (isset($_GET['item_price'])){ echo $_GET['item_price']; } ?>"/></td>
       
        </tr>
		<tr>
         
            <td><?php echo __('product/input_title/item_sum'); ?> </td><td><input type="text" id="item_sum" value="<?php if (isset($_GET['item_sum'])){ echo $_GET['item_sum']; } ?>"/></td>
       
        </tr>			
        <tr>
         
            <td>
            </td>
            <td> 
			<?php if ($_GET['updateProduct1'] == 2) { ?>
            <br><input class='button' type="button" onclick="javascript: updateProduct('<?php echo $_GET['id']; ?>');" value="<?php echo __('button/submit'); ?>"/>
			<?php } else { ?>
			<br><input class='button' type="button" onclick="javascript: addProduct();" value="<?php echo __('button/submit'); ?>"/>
			<?php } ?>
            </td>
       
        </tr>
    </table>

<?php

$sql = "SELECT * FROM ". MYSQL_PREFIX ."product";
$rez = mysql::numRows($sql);
if($rez != 0) {
?>
<table class='content'>
<tr>
<td align='center' width='250'><?php echo __('product/list_name/item_name'); ?></td>
<td align='center' width='150'><?php echo __('product/list_name/item_id'); ?></td>
<td align='center' width='180'><?php echo __('product/list_name/item_price'); ?></td>
<td align='center' width='150'><?php echo __('product/list_name/item_sum'); ?></td>
<td align='center' width='150'></td>
<td align='center' width='150'></td>
</tr>
<?php
$sql = "SELECT * FROM ". MYSQL_PREFIX ."product";
$info = mysql::getArray($sql);
foreach($info as $key => $row)
{
	echo "
	<tr>
	<td align='center'>".$row['item_name']."</td>
	<td align='center'>".$row['item_id']."</td>
	<td align='center'>".$row['item_price']."</td>
	<td align='center'>".$row['item_sum']."</td>
	<td align='center'>";
	echo "<input type='button' class='button' style='width: 50px;' onclick=\"javascript: repair('product_config.php?id=". $row['id'] ."&item_name=". $row['item_name'] ."&item_id=". $row['item_id'] ."&item_price=". $row['item_price'] ."&item_sum=". $row['item_id'] ."&updateProduct1=2');\" value='". __('button/repair') ."'>";
	echo "</td>
	<td align='center'>";
	echo "<input type='button' class='button' style='width: 50px;' onclick=\"javascript: deleteProductData('". $row['id'] ."');\" value='". __('button/delete') ."'>";
	echo "</td>
	</tr>
	";
}
?>
</table>
<?php
}
else
{
	echo __('product/no_products');
}
?>
</div>
<?php 

?>

</center>
</body>
</html>