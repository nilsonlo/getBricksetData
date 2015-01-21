#!/usr/bin/php -q
<?php
require './autoload.php';
error_reporting(E_ALL);
ini_set("display_errors",true);
ini_set("html_errors",false);
date_default_timezone_set("Asia/Taipei");

$logFileName = './log/'.basename($argv[0]).'.log'; 
CheckLock($argv[0],$logFileName);
define('BRICKSET_API_KEY',$ini_array['BRICKSET']['APIKEY']);	
$ws = new SoapClient("http://brickset.com/api/v2.asmx?WSDL");
#var_dump($ws->checkKey(array('apiKey'=>$Brickset_apiKey)));
$bricklink_id= '10242-1';
$resObj = $ws->getSets(array('apiKey'=>BRICKSET_API_KEY,
			'setNumber'=>$bricklink_id));

var_dump($resObj);
unset($resObj);
unset($ws);
