<?php
class ItemInfo {
	private $dbh = null;
	private $p1 = null;
	private $p2 = null;
	private $p3 = null;
	private $p4 = null;
	private $p5 = null;
	function __construct($dbh)
	{
		$this->dbh = $dbh;
		# 錯誤的話, 就不做了
		$this->dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$this->p1 = $this->dbh->prepare("select * from item_info where item_type in ('Sets','Gears') and 
			packagingType is null order by year desc");
		$this->p2 = $this->dbh->prepare("update item_info set UKRetailPrice=:uk_price,USRetailPrice=:us_price,
			CARetailPrice=:ca_price,EURetailPrice=:eu_price,packagingType=:package_type where id=:id");
		$this->p3 = $this->dbh->prepare("select * from item_info");
		$this->p4 = $this->dbh->prepare("select * from item_info where item_type in ('Sets','Gears') and 
			(UKRetailPrice is null or USRetailPrice is null or CARetailPrice is null or EURetailPrice is null)
			 order by year desc");
		$this->p5 = $this->dbh->prepare("update item_info set UKRetailPrice=:uk_price,USRetailPrice=:us_price,
			CARetailPrice=:ca_price,EURetailPrice=:eu_price,packagingType=:package_type where legoID=:legoID");
		
	}

	function __destruct()
	{
		unset($this->dbh);
		unset($this->p1);
		unset($this->p2);
		unset($this->p3);
		unset($this->p4);
		unset($this->p5);
	}
	
	function getItemID()
	{
		try {
			$this->p1->execute();
			return $this->p1->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			error_log('['.date('Y-m-d H:i:s').'] '.__METHOD__.' Error: ('.$e->getLine().') ' . $e->getMessage()."\n",3,"./log/ItemInfo.txt");
			error_log('['.date('Y-m-d H:i:s').'] '.__METHOD__.' Error: ('.$e->getLine().') ' . $e->getMessage()."\n");
			return null;
		}
	}

	function confirmItemID()
	{
		try {
			$this->p4->execute();
			return $this->p4->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			error_log('['.date('Y-m-d H:i:s').'] '.__METHOD__.' Error: ('.$e->getLine().') ' . $e->getMessage()."\n",3,"./log/ItemInfo.txt");
			error_log('['.date('Y-m-d H:i:s').'] '.__METHOD__.' Error: ('.$e->getLine().') ' . $e->getMessage()."\n");
			return null;
		}
	}

	function updateItemPrice($update_data)
	{
		try {
			$this->p2->execute($update_data);
			if($this->p2->rowCount() === 1)
				return true;
			return false;
		} catch(PDOException $e) {
			error_log('['.date('Y-m-d H:i:s').'] '.__METHOD__.' Error: ('.$e->getLine().') ' . $e->getMessage()."\n",3,"./log/ItemInfo.txt");
			error_log('['.date('Y-m-d H:i:s').'] '.__METHOD__.' Error: ('.$e->getLine().') ' . $e->getMessage()."\n");
			return false;
		}
	}

	function updateItemPrice2($update_data)
	{
		try {
			$this->p5->execute($update_data);
			if($this->p5->rowCount() === 1)
				return true;
			return false;
		} catch(PDOException $e) {
			error_log('['.date('Y-m-d H:i:s').'] '.__METHOD__.' Error: ('.$e->getLine().') ' . $e->getMessage()."\n",3,"./log/ItemInfo.txt");
			error_log('['.date('Y-m-d H:i:s').'] '.__METHOD__.' Error: ('.$e->getLine().') ' . $e->getMessage()."\n");
			return false;
		}
	}
	
	function dumpData()
	{
		try {
			$this->p3->execute();
			return $this->p3->fetchAll(PDO::FETCH_OBJ);
		} catch(PDOException $e) {
			error_log('['.date('Y-m-d H:i:s').'] '.__METHOD__.' Error: ('.$e->getLine().') ' . $e->getMessage()."\n",3,"./log/ItemInfo.txt");
			error_log('['.date('Y-m-d H:i:s').'] '.__METHOD__.' Error: ('.$e->getLine().') ' . $e->getMessage()."\n");
			return null;
		}
	}
}
?>
