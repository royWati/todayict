<?php

include('../db.php');
global $db;

class Reviews{

	public static function addCategory($category){
		global $db;
			$data = array();
			$data['category']=$category;
			$data['created_on']=$db->GetOne('SELECT now()');
			$data['active_status']=1;
			$db->AutoExecute('reviews_categories',$data,'INSERT');
	}
}
?>