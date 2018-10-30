<?php

include('../db.php');
global $db;

class Deals{

	public static function addDealsCategory($category){
		global $db;
			$data = array();
			$data['category']=$category;
			$data['created_on']=$db->GetOne('SELECT now()');
			$data['active_status']=1;
			$db->AutoExecute('deals_categories',$data,'INSERT');
	}
}
?>