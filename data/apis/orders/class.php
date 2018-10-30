<?php

include ('../db.php');

global $db;

class Orders{

	public static function addOrder($customer_id,$product_id){
			global $db;

		// adding data you use arrays
		$order_no = strtotime(date('h:i:s'));	
		$data = array();
		$data['order_no'] = $order_no;
		$data['active_status']=1;
		$data['created_on']= $db->GetOne('Select now()');
		$data['customer_id']=$customer_id;
		$data['complete_status']=0;
		// AUTO EXECUTE INSERT -> TABLENAME,ARRAY_DATA, INSERT/UPDATE
		$db->AutoExecute('orders',$data,'INSERT');
		
		$order_id = $db->GetOne("SELECT id FROM orders where order_no ='$order_no'");

		$d = array();
		$d['product_id'] =  $product_id;
		$d['order_id'] = $order_id;
		$d['active_status'] = 1;

		$db->AutoExecute('order_items',$d,'INSERT');	

	}

	public static function selectAllOrders(){
		global $db;
		$all = $db->GetArray('SELECT * FROM orders');
		return json_encode($all);
	}

	public static function selectOneOrder($id) {
		global $db;
		$row = $db->GetArray("SELECT * FROM orders where id=$id limit 1");
		return json_encode($row);
	}
}

class OrderItems{

	public static function viewCart($orderId){

	}

}
?>