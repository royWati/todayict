<?php

include('../db.php');
global $db;

class Cars{

	public static function addCarsCategory($category){
		global $db;
			$data = array();
			$data['category']=$category;
			$data['created_on']=$db->GetOne('SELECT now()');
			$data['active_status']=1;
			$db->AutoExecute('cars_categories',$data,'INSERT');
	}
}
?>