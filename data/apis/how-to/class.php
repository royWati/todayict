<?php

include('../db.php');
global $db;

class How_to{

	public static function addHowCategory($category){
		global $db;
			$data = array();
			$data['category']=$category;
			$data['created_on']=$db->GetOne('SELECT now()');
			$data['active_status']=1;
			$db->AutoExecute('how_to_categories',$data,'INSERT');
	}
}
?>