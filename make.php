<?php

$fp = fopen("losemenge.fwx","w");

fwrite($fp,"<?\r\n//jpw|1.0|".time()."|addon|0\r\n");

$files = array(
	'admin/mods/addon.losemenge.inc.php',
	'admin/mods/losemenge.inc.php',
	'admin/templates/losemenge_home.tpl',
	'cronjob/losemenge.inc.php',
	'losemenge/.htaccess',
	'losemenge/losemenge.php',
	'losemenge/temp',
	'mods/losemenge.addon.inc.php',
);

$i=0;
foreach($files AS $file) {
	$content = implode("",file($file));
	$content = base64_encode($content);
	fputs($fp,"\$data[".$i."]['data'] = \"".$content."\";\r\n\$data[".$i."]['name'] = \"".$file."\";\r\n\r\n");
	$i++;
}

fputs($fp,"\$sql = \"\";\r\n");
fputs($fp,"\$usql = \"\";\r\n");

fputs($fp,"?>");

fclose($fp);