<?php

include('../db.php');
global $db;

class Shop{

	public static function addShopCategory($category){
		global $db;
			$data = array();
			$data['category']=$category;
			$data['created_on']=$db->GetOne('SELECT now()');
			$data['active_status']=1;
			$db->AutoExecute('shop_categories',$data,'INSERT');
	}
}
?>