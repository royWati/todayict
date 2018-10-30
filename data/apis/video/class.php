<?php

include('../db.php');
global $db;

class Video{

	public static function addVideoCategory($category){
		global $db;
			$data = array();
			$data['category']=$category;
			$data['created_on']=$db->GetOne('SELECT now()');
			$data['active_status']=1;
			$db->AutoExecute('video_categories',$data,'INSERT');
	}
}
?>