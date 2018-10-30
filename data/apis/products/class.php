<?php

include('../db.php');
global $db;

class Product{

	public static function addProduct($name,$sub_category_id){
			global $db;
			$data = array();
			$data['name']=$name;
			$data['created_on']=$db->GetOne('SELECT now()');
			$data['sub_category_id']=$sub_category_id;
			$data['active_status']=1;
			$db->AutoExecute('products',$data,'INSERT');

	}
}
?>