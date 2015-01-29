#!/usr/bin/php -q
<?php
require_once("../PHPExcel/Classes/PHPExcel.php");
require './autoload.php';
error_reporting(E_ALL);
ini_set("display_errors",true);
ini_set("html_errors",false);
date_default_timezone_set("Asia/Taipei");


function GenerateExcel($resData,$filename,$useTemplate=false)
{
	try {
		// Load Files
		if($useTemplate)
			$objPHPExcel = PHPExcel_IOFactory::load("./BricksetTemplate.xlsx");
		else
			$objPHPExcel = PHPExcel_IOFactory::load($filename);

		$objPHPExcel->setActiveSheetIndex(0);

		GetRawDataFromBrickset($resData,$objPHPExcel);
		// Save File
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
		$objWriter->save($filename);
	}catch (Exception $e) {
		echo "PHPExcel Error : ".$e->getMessage()."<BR>";
		return;
	}
	return ;
}

function GetRawDataFromBrickset($resData,&$objPHPExcel)
{
	$rows = 2;
	foreach($resData as $item)
	{
		(property_exists($item,'setID') and !is_object($item->setID))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("A$rows",$item->setID,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		(property_exists($item,'number') and !is_object($item->number))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("B$rows",$item->number,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'numberVariant') and !is_object($item->numberVariant))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("C$rows",$item->numberVariant,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		(property_exists($item,'name') and !is_object($item->name))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("D$rows",$item->name,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'year') and !is_object($item->year))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("E$rows",$item->year,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'theme') and !is_object($item->theme))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("F$rows",$item->theme,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'themeGroup') and !is_object($item->themeGroup))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("G$rows",$item->themeGroup,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'subtheme') and !is_object($item->subtheme))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("H$rows",$item->subtheme,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'pieces') and !is_object($item->pieces))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("I$rows",$item->pieces,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'minifigs') and !is_object($item->minifigs))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("J$rows",$item->minifigs,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'image') and !is_object($item->image))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("K$rows",$item->image,
				PHPExcel_Cell_DataType::TYPE_BOOL):false;
		(property_exists($item,'imageFilename') and !is_object($item->imageFilename))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("L$rows",$item->imageFilename,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'thumbnailURL') and !is_object($item->thumbnailURL))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("M$rows",$item->thumbnailURL,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'largeThumbnailURL') and !is_object($item->largeThumbnailURL))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("N$rows",$item->largeThumbnailURL,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'imageURL') and !is_object($item->imageURL))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("O$rows",$item->imageURL,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'bricksetURL') and !is_object($item->bricksetURL))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("P$rows",$item->bricksetURL,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'owned') and !is_object($item->owned))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("Q$rows",$item->owned,
				PHPExcel_Cell_DataType::TYPE_BOOL):false;
		(property_exists($item,'wanted') and !is_object($item->wanted))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("R$rows",$item->wanted,
				PHPExcel_Cell_DataType::TYPE_BOOL):false;
		(property_exists($item,'qtyOwned') and !is_object($item->qtyOwned))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("S$rows",$item->qtyOwned,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		(property_exists($item,'ACMDataCount') and !is_object($item->ACMDataCount))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("T$rows",$item->ACMDataCount,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		(property_exists($item,'ownedByTotal') and !is_object($item->ownedByTotal))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("U$rows",$item->ownedByTotal,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		(property_exists($item,'wantedByTotal') and !is_object($item->wantedByTotal))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("V$rows",$item->wantedByTotal,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		(property_exists($item,'UKRetailPrice') and !is_object($item->UKRetailPrice))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("W$rows",$item->UKRetailPrice,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'USRetailPrice') and !is_object($item->USRetailPrice))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("X$rows",$item->USRetailPrice,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'CARetailPrice') and !is_object($item->CARetailPrice))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("Y$rows",$item->CARetailPrice,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'EURetailPrice') and !is_object($item->EURetailPrice))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("Z$rows",$item->EURetailPrice,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'rating') and !is_object($item->rating))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AA$rows",$item->rating,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'reviewCount') and !is_object($item->reviewCount))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AB$rows",$item->reviewCount,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		(property_exists($item,'packagingType') and !is_object($item->packagingType))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AC$rows",$item->packagingType,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'availability') and !is_object($item->availability))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AD$rows",$item->availability,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'instructionsCount') and !is_object($item->instructionsCount))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AE$rows",$item->instructionsCount,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		(property_exists($item,'additionalImageCount') and !is_object($item->additionalImageCount))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AF$rows",$item->additionalImageCount,
				PHPExcel_Cell_DataType::TYPE_NUMERIC):0;
		(property_exists($item,'EAN') and !is_object($item->EAN))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AG$rows",$item->EAN,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'UPC') and !is_object($item->UPC))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AH$rows",$item->UPC,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'description') and !is_object($item->description))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AI$rows",$item->description,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		(property_exists($item,'lastUpdated') and !is_object($item->lastUpdated))?
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("AJ$rows",$item->lastUpdated,
				PHPExcel_Cell_DataType::TYPE_STRING):'';
		$rows++;
	}
}

$logFileName = './log/'.basename($argv[0]).'.log'; 
CheckLock($argv[0],$logFileName);
define('BRICKSET_API_KEY',$ini_array['BRICKSET']['APIKEY']);
$url = "http://brickset.com/api/v2.asmx";
$prefix_filename = 'Brickset-';
for($i=2000; $i<=2015 ; $i++)
{
	echo 'get '.$i. 'sets';
	$filename = $prefix_filename . $i . '.xlsx';
	$resXML = WebService::GetWebService($url.'/getSets','brickset_cookie.txt',
		array(
			'apiKey'=>BRICKSET_API_KEY,
			'userHash'=>'',
			'query'=>'',
			'theme'=>'',
			'subtheme'=>'',
			'setNumber'=>'',
			'year'=>$i,
			'owned'=>'',
			'wanted'=>'',
			'orderBy'=>'',
			'pageSize'=>'2000',
			'pageNumber'=>'',
			'userName'=>'',
		));
	$resObj = json_decode(json_encode(simplexml_load_string($resXML)));
	
	if(!is_array($resObj->sets))
		GenerateExcel(array(0=>$resObj->sets),$filename,true);
	else
		GenerateExcel($resObj->sets,$filename,true);
	#var_dump($resObj);
}
exit;
$filename = "./UpdatedBrickset.xlsx";

$currentDate = new DateTime();

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
