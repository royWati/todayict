<?php

include('../db.php');
global $db;

class News{

	public static function addNewsCategory($category){
		global $db;
			$data = array();
			$data['category']=$category;
			$data['created_on']=$db->GetOne('SELECT now()');
			$data['active_status']=1;
			$db->AutoExecute('news_categories',$data,'INSERT');
	}
}
?>