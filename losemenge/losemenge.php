<?php 

require("../admin/cfg/config.inc.php");
include("../lib/functions.global.inc.php");
require("../lib/decompat.inc.php");
require("../lib/mysql.class.inc.php");

$db = new MySQL($dbconfig);

require("../admin/sys.vars.inc.php");
include("../lib/".$config_exports.".export.class.inc.php");

$export = new Trans($sysconfig);

function log_action($action,$extra) {
	$string = $action."|1|".$extra."|".time()."\r\n";
	touch("../admin/logs/".date("d.m.Y",time()).".log");
	$fp = fopen("../admin/logs/".date("d.m.Y",time()).".log","a");
	fputs($fp,$string);
	fclose($fp);
}

if(array_key_exists('check', $_GET)){
	if(	empty($sysconfig['losemenge_klammid']) ||
		empty($sysconfig['losemenge_klammpw']) ||
		empty($sysconfig['losemenge_buffer']) ||
		$config_exports != 'kl' ||
		!file_exists('./temp') ||
		!is_writable('./temp') )
	{
		log_action('losemenge.de check', 'false');
		die('false');
	}
		
	log_action('losemenge.de check', 'true');
	die('true');
}
if(!array_key_exists('act', $_GET)){
	log_action('losemenge.de', 'false');
	die('false');
}

if($_GET['act'] == 1) {
	
	$loseAmount = $db->Select(Array("amount"),"stats","WHERE `type` = 3",1);
        
        $loseAmount[0] *= (100-$sysconfig['losemenge_buffer']) / 100;
        $loseAmount[0] = floor($loseAmount[0]);
	
	if($loseAmount[0] < 100){
		log_action('losemenge.de act1', '<100');
		die('false');
	}
        
	$return = $export->Send($sysconfig['losemenge_klammid'],$sysconfig['losemenge_klammpw'],$loseAmount[0], "Losemenge.de Auslesung");
	if($return[0] != "0") {
		log_action('losemenge.de act1', $return[0]);
		die('false');
	}
	
	log_action('losemenge.de act1', $loseAmount[0]);
        
	// save temp
	$fp = fopen('./temp', 'w');
	fwrite($fp, base64_encode(serialize(array('time' => time(), 'ef' => $loseAmount[0]))));
	fclose($fp);
	
} elseif($_GET['act'] == 2 || $_GET['act'] == 3) {

	// get temp
	$temp = file_get_contents('./temp');
	if(empty($temp)) die();
    
	$temp = unserialize( base64_decode($temp) );
    
	if($_GET['act'] == 3 && $temp['time']>(time()-60)) die();
    
	// truncate file
	fopen('./temp', 'w');
    
	$return = $export->Get($sysconfig['losemenge_klammid'],$sysconfig['losemenge_klammpw'],$temp['ef'], "Losemenge.de Rueckbuchung");
	if($return[0] != "0") {
		log_action('losemenge.de act'.$_GET['act'], $return[0]);
		die('false');
	}
	
	log_action('losemenge.de act'.$_GET['act'], $temp['ef']);

}
