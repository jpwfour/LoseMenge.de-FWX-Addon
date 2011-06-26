<?php

function log_action($action,$extra) {
	$string = $action."|1|".$extra."|".time()."\r\n";
	touch("./admin/logs/".date("d.m.Y",time()).".log");
	$fp = fopen("./admin/logs/".date("d.m.Y",time()).".log","a");
	fputs($fp,$string);
	fclose($fp);
}

// get temp
$temp = file_get_contents('./losemenge/temp');
if(empty($temp)) die();
    
$temp = unserialize( base64_decode($temp) );
    
if($temp['time']>(time()-60)) die();
    
// truncate file
fopen('./losemenge/temp', 'w');
    
$return = $export->Get($config_losemenge_klammid,$config_losemenge_klammpw,$temp['ef'], "Losemenge.de Rueckbuchung");
if($return[0] != "0") {
	log_action('losemenge.de act3', $return[0]);
	die('false');
}
	
log_action('losemenge.de act3', $temp['ef']);

$output = "OK";
$page = "done";
