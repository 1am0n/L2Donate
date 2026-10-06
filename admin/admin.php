<?php
/***********************************\
\  Autorius: Justas a.k.a CFC  		/
/  Lineage2 donate sistema   		\
\  Kontaktai: support@bqart.eu	    /
/  Visos teises saugomos 			\
\***********************************/

include_once('../core.php');
admin::check();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' href='style/style.css' type='text/css'/>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/custom.js"></script>

<script type="text/javascript">
$(document).ready(function()
{
	$("#firstpane input.menu_head").click(function()
    {
		$(this).next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
       	$(this).siblings();
	});
});
</script>

</head>
<body>
<center>

<div id='admin_box'>



<div id='panel'>
<div id='panel_outside'>
<div id='panel_title'><?php echo __('main/panel_1_title/menu'); ?></div>
<div id='txt'>
 <div id="firstpane">
		<li class='menu'><input type='button' class='nav_button_home' onclick="window.location='admin.php'" value="<?php echo __('main/button/home'); ?>"></li>
		<input type='button' class="menu_head" value="<?php echo __('main/button/config'); ?>">
		<div class="menu_body">
		<li class='menu'><input type='button' class='nav_button' onclick="javascript: loadFile('main_config.php');" value="<?php echo __('main/button/main_config'); ?>"></li>
        <li class='menu'><input type='button' class='nav_button' onclick="javascript: loadFile('product_config.php');" value="<?php echo __('main/button/product_config'); ?>"></li>
        <li class='menu'><input type='button' class='nav_button' onclick="javascript: loadFile('users_config.php', '<?php echo __('loader/loading'); ?>');" value="<?php echo __('main/button/user_config'); ?>"></li>	
		</div>
		<input type='button' class="menu_head" value="<?php echo __('main/button/pay'); ?>">
		<div class="menu_body">
		<li class='menu'><input type='button' class='nav_button' onclick="javascript: loadFile('mikro_config.php');" value="<?php echo __('main/button/mikro'); ?>"></li>	
		</div>
		<input type='button' class="menu_head" value="<?php echo __('main/button/other'); ?>">
		<div class="menu_body">
		<li class='menu'><input type='button' class='nav_button_logout' onclick="javascript: confirmation('<?php echo __('main/logout/message'); ?>', 'logout.php');" value="<?php echo __('main/button/logout'); ?>"></li>		
       </div>
  </div>
</div>
</div>
<div id='panel_footer'></div>
</div>


<div id='mpanel'>
<div id='mpanel_outside'>
<div id='mpanel_title'>Administracija</div>
<div id='txt'>
<div id='file'>

<?php

	$updateDownloadUrl = 'http://bqart.eu/donate';
	$latestVersionUrl = 'http://bqart.eu/donate/latestDonateVersion.txt';
	$currentVersionUrl = 'version/currentVersion.txt';
	
	$latestVersion = file_get_contents($latestVersionUrl);
	$currentVersion = file_get_contents($currentVersionUrl);
	if ($latestVersion && $currentVersion)
	{
		if ($latestVersion == $currentVersion)
		{
			echo "<div id='version'>". __('versionIsLatest') ."</div>";
		}
		elseif ($latestVersion > $currentVersion)
		{
			echo "<div id='version'><div class='badVersion'>". __('versionUpdateAvalaible') ."<br/></div><a href='". $updateDownloadUrl ."/". $latestVersion .".rar'>". __('downloadUpdate') ."</a></div>";
		}
	}
	else
	{
		echo "<div id='version'>". __('badConnToVersionServer') ."</div>";
	}
?>

</div>
</div>
</div>
<div id='mpanel_footer'></div>
</div>

</div>
</center>
</body>
</html>