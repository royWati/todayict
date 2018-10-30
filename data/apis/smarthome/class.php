<?php

include('../db.php');
global $db;

class Smarthome{

	public static function addSmartCategory($category){
		global $db;
			$data = array();
			$data['category']=$category;
			$data['created_on']=$db->GetOne('SELECT now()');
			$data['active_status']=1;
			$db->AutoExecute('smart_home_categories',$data,'INSERT');
	}
}
?>