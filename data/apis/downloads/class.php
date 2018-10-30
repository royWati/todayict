<?php

include('../db.php');
global $db;

class Downloads{

	public static function addDownloadCategory($category){
		global $db;
			$data = array();
			$data['category']=$category;
			$data['created_on']=$db->GetOne('SELECT now()');
			$data['active_status']=1;
			$db->AutoExecute('download_categories',$data,'INSERT');
	}
}
?>