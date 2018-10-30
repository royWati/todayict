<?php

include ('../db.php');

global $db;

class Category{

	public static function addCategory($name){
			global $db;

		// adding data you use arrays
		$data = array();
		$data['name'] = $name;
		$data['active_status']=1;
		$data['created_on']= $db->GetOne('Select now()');
		// AUTO EXECUTE INSERT -> TABLENAME,ARRAY_DATA, INSERT/UPDATE
		$db->AutoExecute('categories',$data,'INSERT');

	}

	public static function selectAllCategories(){
		global $db;
		$all = $db->GetArray('SELECT * FROM categories where active_status=1 order by name asc');
		return json_encode($all);
	}

	public static function selectOneCategory($id) {
		global $db;
		$row = $db->GetArray("SELECT * FROM categories where id=$id limit 1");
		return json_encode($row);
	}
}
?>