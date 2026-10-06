<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

include_once('install.core.php');

$etap = $_GET['etap'];
?>
<html>
<head>
<title>Lineage2 donate sistema</title>
<?php echo style; ?>
<?php echo js; ?>
</head>
<body>
<center>
<div id='box'>

<?php
if($etap == "")
{

if(!empty($_POST['accept_rules']))
{
	$agree = $_POST['agree'];
	if($agree == 'on')
	{
		$_SESSION['accepted'] = 'agree';
		header('Location: index.php?etap=mysql');
	}
}
?>
<form action='index.php' method='post'>
<fieldset class='rules'>

<legend>Taisyklės</legend>

<?php echo file_get_contents("information/rules.info"); ?>

</fieldset>

<div style='margin: 10px 10px 10px 340px; font-size: 12px; font-family: verdana;'>Supratau ir sutinku su taisyklėmis <input type="checkbox" name="agree" > 
<input type='submit' name='accept_rules' class='install' value='Toliau'></div>
</form>
<?php 
}
elseif($etap == "mysql")
{
if(!isset($_SESSION['accepted']))
{
	header('Location: index.php');
}

$arrErrors = array();

if(file_exists("../_config.php"))
{
	$strError = "<div class='formerror'>Prašome pervardinti _config.php į config.php kad galėtumėte tęsti diegimą.</div>";
	$error = 1;
}
elseif(!is_writable('../config.php'))
{
	$strError = "<div class='formerror'>Pakeiskite failo mysql_config.php teises į 777 <a href='#' onclick=\"load('information/badchmod.info');\">Daugiau informacijos</a></div>";
	$error = 1;
}

if(!empty($_POST['submit_mysql']))
{

$host = $_POST['host'];
$user = $_POST['user'];
$pass = $_POST['pass'];
$db1 = $_POST['db1'];
$db2 = $_POST['db2'];
$prefix = $_POST['prefix'];

$_SESSION['host'] = $host;
$_SESSION['user'] = $user;
$_SESSION['pass'] = $pass;
$_SESSION['db1'] = $db1;
$_SESSION['db2'] = $db2;
$_SESSION['prefix'] = $prefix;

if(empty($host) || empty($user) || empty($db1) || empty($db2))
{
	$arrErrors['empty'] = "Būtina užpildyti laukelius su raudona žvaigždute";
}
else
{
	$connect = @mysql_connect($host, $user, $pass);
	$db_connect1 = @mysql_select_db($db1);
	
	
	if($connect)
	{ $connect = 1; } else { $connect = 0; }
	
	if($db_connect1)
	{ $db_connect1 = 1;
	$db_connect2 = @mysql_select_db($db2);
	} else { $db_connect1 = 0; }
	
	if($db_connect2)
	{ $db_connect2 = 1;} else { $db_connect2 = 0; }

	
	if($connect == 0)
	{
		$arrErrors['connect_fail'] = "Neįmanoma prisijungti prie MySQL <br/> <a href='#' onclick=\"load('information/badconnect.info');\">Daugiau informacijos</a>";
	}
	else
	{
		if($db_connect1 == 0)
		{
			$arrErrors['db_connect_fail'] = "Neįmanoma prisijungti prie MySQL DB [1]";
		}
		elseif($db_connect2 == 0)
		{
			$arrErrors['db_connect_fail'] = "Neįmanoma prisijungti prie MySQL DB [2]";
		}
	}
}

if (count($arrErrors) == 0) {
	
		$file = "../config.php";
		$fh = fopen($file, 'w');

		$start = "<?php\n\n";
		$data1 = "define(\"MYSQL_HOST\", \"$host\");\n";
		$data2 = "define(\"MYSQL_USER\", \"$user\");\n";
		$data3 = "define(\"MYSQL_PASS\", \"$pass\");\n";
		$data4 = "define(\"MYSQL_DB1\", \"$db1\");\n";
		$data5 = "define(\"MYSQL_DB2\", \"$db2\");\n\n";
		$data6 = "define(\"MYSQL_PREFIX\", \"$prefix\");\n\n";
		$end = "?>";
		
		fwrite($fh, $start);
		fwrite($fh, $data1);
		fwrite($fh, $data2);
		fwrite($fh, $data3);
		fwrite($fh, $data4);
		fwrite($fh, $data5);
		fwrite($fh, $data6);
		fwrite($fh, $end);
		
		fclose($fh);	
		
		header('Location: index.php?etap=admin');
	
} else {
		
$strError .= "<div class='formerror'>";
foreach ($arrErrors as $error) {
$strError .= "<li>$error</li>";
}
$strError .= "</div>";
			
}

}
?>

<form action='index.php?etap=mysql' method='post' class='form_cl'>
		
		<fieldset class='all'>
		<legend class='title'>Donate sistemos įdiegimas</legend>
		<fieldset>
		<legend>Informacijos pultas</legend>
		<div class='information' id='info'></div>
		</fieldset>
		<fieldset>
			<legend>Klaidų pultas</legend>
				<?php echo $strError; ?>
		</fieldset>
		<br>
		<fieldset>
			<legend>Prisijungimo prie MySQL duomenys</legend>
			<div>
				<label for="host">Hostas <font color='red'>*</font></label> <input type="text" id="host" name="host" class='install' value="<?php if(isset($_SESSION['host'])){ echo $_SESSION['host']; } ?>"> <img src='images/information.png' class='info_img' onclick="load('information/dbhost.info');">
			</div>
			<div>
				<label for="user">Slapyvardis <font color='red'>*</font></label> <input type="text" id="user" name="user" class='install' value="<?php if(isset($_SESSION['user'])){ echo $_SESSION['user']; } ?>"> <img src='images/information.png' class='info_img' onclick="load('information/dbuser.info');">
			</div>
			<div>
				<label for="pass">Slaptažodis <font color='#adadad'>*</font></label> <input type="password" id="pass" name="pass" class='install' value="<?php if(isset($_SESSION['pass'])){ echo $_SESSION['pass']; } ?>"> <img src='images/information.png' class='info_img' onclick="load('information/dbpass.info');">
			</div>
			<div>
				<label for="db">Duomenų bazė [1]<font color='red'>*</font></label> <input type="text" id="db1" name="db1" class='install' value="<?php if(isset($_SESSION['db1'])){ echo $_SESSION['db1']; } ?>"> <img src='images/information.png' class='info_img' onclick="load('information/db1.info');">
			</div>
			<div>
				<label for="db">Duomenų bazė [2]<font color='red'>*</font></label> <input type="text" id="db2" name="db2" class='install' value="<?php if(isset($_SESSION['db2'])){ echo $_SESSION['db2']; } ?>"> <img src='images/information.png' class='info_img' onclick="load('information/db2.info');">
			</div>
			<div>
				<label for="prefix">DB Prefixas <font color='red'>*</font></label> <input type="text" id="prefix" name="prefix" class='install' value="don_"> <img src='images/information.png' class='info_img' onclick="load('information/dbprefix.info');">
			</div>
		</fieldset>
		<br>
			<div>
				<?php
					if(count($arrErrors) != 0)
					{
						echo "<input type='submit' name='submit_mysql' class='submit_off' value='Tęsti'>";
					}
					elseif(count($error) != 0)
					{
						echo "<input type='submit' class='submit_off' value='Tęsti'>";
					}
					else
					{
						echo "<input type='submit' name='submit_mysql' class='submit_on' value='Tęsti'>";
					}
				?>
			</div>
		</fieldset>
	</form>
<?php
}
elseif($etap == "admin")
{
if(!isset($_SESSION['accepted']))
{
	header('Location: index.php');
}

$arrErrors = array();

if(!empty($_POST['submit_adm']))
{

	$adm_name = $_POST['adm_name'];
	$adm_pass = $_POST['adm_pass'];
	$adm_ip  = $_POST['adm_ip'];
	
	$_SESSION['adm_name'] =  $adm_name;
	$_SESSION['adm_pass'] =  $adm_pass;
	$_SESSION['adm_ip'] = $adm_ip;
	   
	if(empty($adm_pass) || empty($adm_name))
	{
		$arrErrors['empty'] = "Būtina užpildyti laukelius su raudona žvaigždute";
	}

if (count($arrErrors) == 0) {

$_SESSION['adm_name'] =  $adm_name;
$_SESSION['adm_pass'] =  $adm_pass;
$_SESSION['adm_ip'] = $adm_ip;

header('Location: index.php?etap=checkinfo');
	
} else {
		
$strError .= "<div class='formerror'>";
foreach ($arrErrors as $error) {
$strError .= "<li>$error</li>";
}
$strError .= "</div>";
			
}
}
?>
<form action='index.php?etap=admin' method='post' class='form_cl'>
		
		<fieldset class='all'>
		<legend class='title'>Donate sistemos įdiegimas</legend>
		<fieldset>
		<legend>Informacijos pultas</legend>
		<div class='information' id='info'></div>
		</fieldset>
		<fieldset>
			<legend>Klaidų pultas</legend>
				<?php echo $strError; ?>
		</fieldset>
		<br>
		<fieldset>
			<legend>Administratoriaus nustatymai</legend>
			<div>
				<label for="adm_pass">Slapyvardis <font color='red'>*</font></label> <input type="text" id="adm_name" name="adm_name" class="install" value="<?php if(isset($_SESSION['adm_name'])){ echo $_SESSION['adm_name']; } ?>"> <img src='images/information.png' class='info_img' onclick="load('information/admname.info');">
			</div>
			<div>
				<label for="adm_pass">Slaptažodis <font color='red'>*</font></label> <input type="password" id="adm_pass" name="adm_pass" class="install" value="<?php if(isset($_SESSION['adm_pass'])){ echo $_SESSION['adm_pass']; } ?>"> <img src='images/information.png' class='info_img' onclick="load('information/admpass.info');">
			</div>
			<div>
				<label for="adm_ip">IP adresas <font color='#adadad'>*</font></label> <input type="text" id="adm_ip" name="adm_ip" class="install" value="<?php if(isset($_SESSION['adm_ip'])){ echo $_SESSION['adm_ip']; } ?>"> <img src='images/information.png' class='info_img' onclick="load('information/admip.info');">
			</div>
		</fieldset>
		<br>
			<div>
				<?php
					if(count($arrErrors) != 0)
					{
						echo "<input type='submit' name='submit_adm' class='submit_off' value='Tęsti'>";
					}
					else
					{
						echo "<input type='submit' name='submit_adm' class='submit_on' value='Tęsti'>";
					}
				?>
			</div>
		</fieldset>
	</form>
<?php
}
elseif($etap == "checkinfo")
{
if(!empty($_POST['submit_fb']))
{
	if(isset($_SESSION['host'])){ unset($_SESSION['host']); } else {}
	if(isset($_SESSION['user'])){ unset($_SESSION['user']); } else {}
	if(isset($_SESSION['pass'])){ unset($_SESSION['pass']); } else {}
	if(isset($_SESSION['db1'])){ unset($_SESSION['db1']); } else {}
	if(isset($_SESSION['db2'])){ unset($_SESSION['db2']); } else {}
	if(isset($_SESSION['prefix'])){ unset($_SESSION['prefix']); } else {}
	if(isset($_SESSION['adm_name'])){ unset($_SESSION['adm_name']); } else {}
	if(isset($_SESSION['adm_pass'])){ unset($_SESSION['adm_pass']); } else {}
	if(isset($_SESSION['adm_ip'])){ unset($_SESSION['adm_ip']); } else {}
	header("Location: index.php?etap=mysql");
}

if(!empty($_POST['submit_bf']))
{
	header("Location: index.php?etap=finish");
}
?>
	<fieldset class='all'>
		<legend class='title'>Donate sistemos įdiegimas</legend>
		<fieldset class='checkinfo'>
			<legend>Informacijos tikrinimas</legend>
			Žemiau pateikiame jūsų informaciją, prašome pasitikrinti ar nėra klaidų ir paspausti mygtuką "Pabaiga",
			paspaudus šį mygtuką sistema bus galutinai įdiegta. Jei radote klaidų, galite diegimą pradėti iš naujo.
			<br><br>
			<?php
			
				echo "MySQL host -> "; if(isset($_SESSION['host'])){ echo $_SESSION['host']; } echo "<br>";
				echo "MySQL username -> "; if(isset($_SESSION['user'])){ echo $_SESSION['user']; } echo "<br>";
				echo "MySQL password -> "; if(isset($_SESSION['pass'])){ echo $_SESSION['pass']; } echo "<br>";
				echo "MySQL database [1] -> "; if(isset($_SESSION['db1'])){ echo $_SESSION['db1']; } echo "<br>";
				echo "MySQL database [2] -> "; if(isset($_SESSION['db2'])){ echo $_SESSION['db2']; } echo "<br>";
				echo "MySQL prefix -> "; if(isset($_SESSION['prefix'])){ echo $_SESSION['prefix']; } echo "<br><br>";
				
				echo "Admin username -> "; if(isset($_SESSION['adm_name'])){ echo $_SESSION['adm_name']; } echo "<br>";
				echo "Admin password -> "; if(isset($_SESSION['adm_pass'])){ echo $_SESSION['adm_pass']; } echo "<br>";
				echo "Admin IP -> "; if(isset($_SESSION['adm_ip'])){ echo $_SESSION['adm_ip']; } echo "<br>";
			
			?>
		</fieldset>
		<form action='index.php?etap=checkinfo' method='post'>
			<input type='submit' name='submit_fb' class='submit_off' value='Pradėti iš naujo'>
			<input type='submit' name='submit_bf' class='submit_on' value='Pabaiga'>
		</form>
	</fieldset>
<?php
}
elseif($etap == "finish")
{
if(!isset($_SESSION['accepted']))
{
	header('Location: index.php');
}

		include_once('../config.php');
		mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
		mysql_select_db(MYSQL_DB1);	
		
		$adm_name = $_SESSION['adm_name'];
		$adm_pass = $_SESSION['adm_pass'];
		$adm_ip = $_SESSION['adm_ip'];
		
		function pass_encode($password)
		{
			$salt = '1dasd1ad90HO0ASdlsad168d413';
			$password = md5($password.$salt);
			return $password;
		}
		
		$admin_pass = pass_encode($adm_pass);
		
		$fail = false;
			
		$rez = mysql_query("DROP TABLE IF EXISTS ". MYSQL_PREFIX ."config");
		$rez = mysql_query("
		CREATE TABLE IF NOT EXISTS `". MYSQL_PREFIX ."config` (
		  `id` int(11) NOT NULL,
		  `admin_name` varchar(255) NOT NULL,
		  `admin_ip` varchar(255) NOT NULL,
		  `admin_pass` varchar(255) NOT NULL,
		  `template` varchar(255) NOT NULL,
		  `language` varchar(255) NOT NULL,
		  `buy_only_off` int(11) NOT NULL,
		  `maxpliusweapon` int(11) NOT NULL,
		  `maxpliusarmor` int(11) NOT NULL,
		  `plius_for_points_1` int(11) NOT NULL,
		  `nobless_price` int(11) NOT NULL,
		  `recommend_price` int(11) NOT NULL,
		  `mikro` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;
		");
		
		if(!$rez){$fail = true;}
		
		$rez = mysql_query("DROP TABLE IF EXISTS ". MYSQL_PREFIX ."custom");
		$rez = mysql_query("
		CREATE TABLE IF NOT EXISTS `". MYSQL_PREFIX ."custom` (
		  `value` int(11) NOT NULL,
		  `status` varchar(40) NOT NULL,
		  PRIMARY KEY (`value`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;
		");
		
		if(!$rez){$fail = true;}
		
		$rez = mysql_query("DROP TABLE IF EXISTS ". MYSQL_PREFIX ."game_r_info");
		$rez = mysql_query("
		CREATE TABLE IF NOT EXISTS `". MYSQL_PREFIX ."game_r_info` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `account_name` varchar(255) NOT NULL,
		  `points` bigint(20) NOT NULL,
		  `last_visit` date NOT NULL,
		  `ip` varchar(255) NOT NULL,
		  UNIQUE KEY `id` (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
		");
		
		if(!$rez){$fail = true;}
		
		$rez = mysql_query("DROP TABLE IF EXISTS ". MYSQL_PREFIX ."product");
		$rez = mysql_query("
		CREATE TABLE IF NOT EXISTS `". MYSQL_PREFIX ."product` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `item_name` varchar(100) NOT NULL,
		  `item_id` int(11) NOT NULL,
		  `item_price` int(11) NOT NULL,
		  `item_sum` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
		");
		
		if(!$rez){$fail = true;}
		
		$rez = mysql_query("DROP TABLE IF EXISTS ". MYSQL_PREFIX ."sms_config");
		$rez = mysql_query("
		CREATE TABLE IF NOT EXISTS `". MYSQL_PREFIX ."sms_config` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `keyword` varchar(255) NOT NULL,
		  `price` int(11) NOT NULL,
		  `number` int(11) NOT NULL,
		  `sms_points` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
		");
		
		if(!$rez){$fail = true;}
		
		$rez = mysql_query("
		INSERT INTO `don_config` (`id`, `admin_name`, `admin_ip`, `admin_pass`, `template`, `language`, `buy_only_off`, `maxpliusweapon`, `maxpliusarmor`, `plius_for_points_1`, `nobless_price`, `recommend_price`, `mikro`) VALUES
		(1, '". $adm_name ."', '". $adm_ip ."', '". $admin_pass ."', 'new official', 'lt', 2, 0, 0, 0, 0, 0, 2);
		");
		
		if(!$rez){$fail = true;}
		
		$rez = mysql_query("
		INSERT INTO `don_custom` (`value`, `status`) VALUES
		(1, 'On'),
		(2, 'Off');
		");
		
		if(!$rez){$fail = true;}
		
		if($fail == false)
		{
			
			if(isset($_SESSION['accepted'])){unset($_SESSION['accepted']);}
			if(isset($_SESSION['host'])){unset($_SESSION['host']);}
			if(isset($_SESSION['user'])){unset($_SESSION['user']);}
			if(isset($_SESSION['pass'])){unset($_SESSION['pass']);}
			if(isset($_SESSION['db1'])){unset($_SESSION['db1']);}
			if(isset($_SESSION['db2'])){unset($_SESSION['db2']);}
			if(isset($_SESSION['prefix'])){unset($_SESSION['prefix']);}
			if(isset($_SESSION['adm_name'])){unset($_SESSION['adm_name']);}
			if(isset($_SESSION['adm_ip'])){unset($_SESSION['adm_ip']);}
			if(isset($_SESSION['adm_pass'])){unset($_SESSION['adm_pass']);}
			$installedFile = "installed.txt";
			$installed = fopen($installedFile, 'w');
			fclose($installed);
			
			echo "
			<fieldset class='finish'>
			<legend>Sistemos diegimas baigtas !</legend>
			Duomenų bazės lentelės sukurtos, sistemos diegimas sėkmingai baigtas. Dabar galite prisijungti į administracijos arba vartotojo zoną ir sėkmingai naudotis sistema.<br>
			Prieš tai <font color='red'>nepamirškite</font> sugrąžinti config.php failo teisių (iš 777 -> į 644) ir <font color='red'>ištrinti</font> install aplankalo, sėkmės !<br>
			Administracijos zona - <a href='../admin/'>Administracija</a><br>
			Vartotojo zona - <a href='../index.php'>Vartotojas</a>
			</fieldset>
			";
		}
		else
		{
			die("Kuriant duomenų bazės lenteles įvyko klaida, jei norite pakartoti lentelių kurimą, paspauskite <a href='index.php?etap=finish'>čia</a>");
		}
}
else
{
header('Location: index.php');
}
?>
</div>
</center>
</body>
</html>