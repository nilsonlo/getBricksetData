#!/usr/bin/php -q
<?php
require './autoload.php';
error_reporting(E_ALL);
ini_set("display_errors",true);
ini_set("html_errors",false);
date_default_timezone_set("Asia/Taipei");

$logFileName = './log/'.basename($argv[0]).'.log'; 
CheckLock($argv[0],$logFileName);
$dbh = new PDO($DB['DSN'],$DB['DB_USER'], $DB['DB_PWD'],
	array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
	PDO::ATTR_PERSISTENT => false));
$ItemInfoDB = new ItemInfo($dbh);
define('BRICKSET_API_KEY',$ini_array['BRICKSET']['APIKEY']);
$url = "http://brickset.com/api/v2.asmx";
$ws = new SoapClient("http://brickset.com/api/v2.asmx?WSDL",array('soap_version'=>SOAP_1_2,'trace'=>1));
#var_dump($ws->checkKey(array('apiKey'=>$Brickset_apiKey)));
$itemArray = $ItemInfoDB->getItemID();
foreach($itemArray as $item)
{
	if($item->sub_name == '') continue;
	$bricklink_id = $item->sub_name;
	echo $item->id . '['.$bricklink_id.'] ... ';
	$resXML = WebService::GetWebService($url.'/getSets','brickset_cookie.txt',
		array(
			'apiKey'=>BRICKSET_API_KEY,
			'userHash'=>'',
			'query'=>'',
			'theme'=>'',
			'subtheme'=>'',
			'setNumber'=>$bricklink_id,
			'year'=>'',
			'owned'=>'',
			'wanted'=>'',
			'orderBy'=>'',
			'pageSize'=>'',
			'pageNumber'=>'',
			'userName'=>'',
			));
	$resObj = json_decode(json_encode(simplexml_load_string($resXML)));
	if(property_exists($resObj,'sets'))
	{
		$updateItem = array(
			'id'=>$item->id,
				'uk_price'=>(property_exists($resObj->sets,'UKRetailPrice') and 
					!is_object($resObj->sets->UKRetailPrice))?
					$resObj->sets->UKRetailPrice:null,
				'us_price'=>(property_exists($resObj->sets,'USRetailPrice') and 
					!is_object($resObj->sets->USRetailPrice))?
					$resObj->sets->USRetailPrice:null,
				'ca_price'=>(property_exists($resObj->sets,'CARetailPrice') and 
					!is_object($resObj->sets->CARetailPrice))?
					$resObj->sets->CARetailPrice:null,
				'eu_price'=>(property_exists($resObj->sets,'EURetailPrice') and 
					!is_object($resObj->sets->EURetailPrice))?
					$resObj->sets->EURetailPrice:null,
				'package_type'=>property_exists($resObj->sets,'packagingType')?
					$resObj->sets->packagingType:null,
			);
		if(!$ItemInfoDB->updateItemPrice($updateItem))
			echo "Failed\n";
		else
			echo "Success\n";
		unset($updateItem);
	}
	else
		echo "Failed\n";
	unset($bricklink_id);
	unset($resObj);
	unset($resXML);
}
unset($itemArray);
unset($ws);
