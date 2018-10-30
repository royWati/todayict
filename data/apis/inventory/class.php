<?php

include('../db.php');
global $db;

class Inventory{

	public static function stockIn($productId,$entries){
			global $db;

		// adding data you use arrays
		$data = array();
		$data['product_id'] = $productId;
		$data['entries']=$entries;
		$data['created_on']= $db->GetOne('Select now()');
		// AUTO EXECUTE INSERT -> TABLENAME,ARRAY_DATA, INSERT/UPDATE
		$db->AutoExecute('product_stock_in',$data,'INSERT');

	}

	}

?>