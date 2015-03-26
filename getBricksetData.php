#!/usr/bin/php -q
<?php
require_once("../PHPExcel/Classes/PHPExcel.php");
require './autoload.php';
error_reporting(E_ALL);
ini_set("display_errors",true);
ini_set("html_errors",false);
date_default_timezone_set("Asia/Taipei");

$dbh = new PDO($DB['DSN'],$DB['DB_USER'], $DB['DB_PWD'],
	array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
	PDO::ATTR_PERSISTENT => false));
$ItemInfoDB = new ItemInfo($dbh);

function GenerateExcel($itemInfoDB,$resData,$filename,$useTemplate=false)
{
	try {
		// Load Files
		if($useTemplate)
			$objPHPExcel = PHPExcel_IOFactory::load("./BricksetTemplate.xlsx");
		else
			$objPHPExcel = PHPExcel_IOFactory::load($filename);

		$objPHPExcel->setActiveSheetIndex(0);

		GetRawDataFromBrickset($itemInfoDB,$resData,$objPHPExcel);
		// Save File
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
		$objWriter->save($filename);
	}catch (Exception $e) {
		echo "PHPExcel Error : ".$e->getMessage()."<BR>";
		return;
	}
	return ;
}

function GetRawDataFromBrickset($itemInfoDB,$resData,&$objPHPExcel)
{
	$rows = 2;
	$updateItem = array(
		'legoID'=>'',
		'uk_price'=>null,
		'us_price'=>null,
		'ca_price'=>null,
		'eu_price'=>null,
		'packaging_type'=>null
		);
	foreach($resData as $item)
	{
		property_exists($item,'setID')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("A$rows",$item->setID,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		property_exists($item,'number')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("B$rows",$item->number,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'number')? $updateItem['legoID']=$item->number:$updateItem['legoID']='';
		property_exists($item,'numberVariant')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("C$rows",$item->numberVariant,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		property_exists($item,'name')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("D$rows",$item->name,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'year')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("E$rows",$item->year,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'theme')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("F$rows",$item->theme,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'themeGroup')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("G$rows",$item->themeGroup,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'subtheme')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("H$rows",$item->subtheme,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'pieces')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("I$rows",$item->pieces,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'minifigs')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("J$rows",$item->minifigs,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'image')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("K$rows",$item->image,
				PHPExcel_Cell_DataType::TYPE_BOOL):false;
		property_exists($item,'imageFilename')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("L$rows",$item->imageFilename,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'thumbnailURL')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("M$rows",$item->thumbnailURL,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'largeThumbnailURL')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("N$rows",$item->largeThumbnailURL,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'imageURL')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("O$rows",$item->imageURL,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'bricksetURL')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("P$rows",$item->bricksetURL,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'owned')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("Q$rows",$item->owned,
				PHPExcel_Cell_DataType::TYPE_BOOL):false;
		property_exists($item,'wanted')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("R$rows",$item->wanted,
				PHPExcel_Cell_DataType::TYPE_BOOL):false;
		property_exists($item,'qtyOwned')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("S$rows",$item->qtyOwned,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		property_exists($item,'ACMDataCount')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("T$rows",$item->ACMDataCount,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		property_exists($item,'ownedByTotal')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("U$rows",$item->ownedByTotal,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		property_exists($item,'wantedByTotal')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("V$rows",$item->wantedByTotal,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		property_exists($item,'UKRetailPrice')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("W$rows",$item->UKRetailPrice,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'UKRetailPrice')? $updateItem['uk_price']=$item->UKRetailPrice : $updateItem['uk_price']=null;
		property_exists($item,'USRetailPrice')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("X$rows",$item->USRetailPrice,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'USRetailPrice')? $updateItem['us_price']=$item->USRetailPrice : $updateItem['us_price']=null;
		property_exists($item,'CARetailPrice')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("Y$rows",$item->CARetailPrice,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'CARetailPrice')? $updateItem['ca_price']=$item->CARetailPrice : $updateItem['ca_price']=null;
		property_exists($item,'EURetailPrice')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("Z$rows",$item->EURetailPrice,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'EURetailPrice')? $updateItem['eu_price']=$item->EURetailPrice : $updateItem['eu_price']=null;
		property_exists($item,'rating')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AA$rows",$item->rating,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'reviewCount')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AB$rows",$item->reviewCount,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		property_exists($item,'packagingType')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AC$rows",$item->packagingType,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'packagingType')? $updateItem['packaging_type']=$item->packagingType : $updateItem['packaging_type']=null;
		property_exists($item,'availability')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AD$rows",$item->availability,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'instructionsCount')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AE$rows",$item->instructionsCount,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		property_exists($item,'additionalImageCount')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AF$rows",$item->additionalImageCount,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		property_exists($item,'EAN')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AG$rows",$item->EAN,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'UPC')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AH$rows",$item->UPC,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'description')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AI$rows",$item->description,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		property_exists($item,'lastUpdated')?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AJ$rows",$item->lastUpdated,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		if($itemInfoDB->updateItemPrice2($updateItem))
		{
			error_log('['.date('Y-m-d H:i:s').'] '.__METHOD__.' update '. $updateItem['legoID'] . ' Success'."\n",3,'./log/log.txt');
			error_log('['.date('Y-m-d H:i:s').'] '.__METHOD__.' update '. $updateItem['legoID'] . ' Success'."\n");
		}
		$rows++;
	}
}

$logFileName = './log/'.basename($argv[0]).'.log'; 
CheckLock($argv[0],$logFileName);
define('BRICKSET_API_KEY',$ini_array['BRICKSET']['APIKEY']);	
$ws = new SoapClient("http://brickset.com/api/v2.asmx?WSDL");
#var_dump($ws->checkKey(array('apiKey'=>$Brickset_apiKey)));
$resObj = $ws->getRecentlyUpdatedSets(array('apiKey'=>BRICKSET_API_KEY,'minutesAgo'=>1440));
#$resObj = $ws->getRecentlyUpdatedSets(array('apiKey'=>BRICKSET_API_KEY,'minutesAgo'=>2880));
$filename = "./UpdatedBrickset.xlsx";

$currentDate = new DateTime();

if(property_exists($resObj,'getRecentlyUpdatedSetsResult'))
{
	if(property_exists($resObj->getRecentlyUpdatedSetsResult,'sets'))
	{
		if(!is_array($resObj->getRecentlyUpdatedSetsResult->sets))
		{
			GenerateExcel($ItemInfoDB,array(0=>$resObj->getRecentlyUpdatedSetsResult->sets),$filename,true);
		}
		else
		{
			GenerateExcel($ItemInfoDB,$resObj->getRecentlyUpdatedSetsResult->sets,$filename,true);
		}
	}
}
unset($resObj);
unset($ws);
$MyGoogleDrive = new MyGoogleDrive();
$FolderArray = $MyGoogleDrive->FindFolderID("title='BricksetSync' and mimeType = 'application/vnd.google-apps.folder'");
if(count($FolderArray) == 1)
{
	$parentId = $FolderArray[0]->id;
	$mimeType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
	$title = 'BricksetRecentlyUpdate-'.$currentDate->format('Y-m-d').'.xlsx';
	$description = 'Brickset Recently Updated Sets Result List';
	$MyGoogleDrive->insertFile($title, $description, $parentId, $mimeType, $filename);
	error_log('['.date('Y-m-d H:i:s').'] '.__METHOD__.' upload '. $title . '.xlsx'."\n",3,'./log/log.txt');
	
}
unset($FolderArray);
unset($MyGoogleDrive);
unset($currentDate);
