<?php

include('../db.php');
global $db;

class Sub_category{
	public static function addSubcategory($name,$category_id){
		global $db;

		$data = array();
		$data['name']=$name;
		$data['category_id']=$category_id;
		$data['created_on']= $db->GetOne('Select now()');
		$db->AutoExecute('sub_categories',$data,'INSERT');

	}
}
?>