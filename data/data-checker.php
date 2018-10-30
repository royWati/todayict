<?php

include('./db.php');
@session_start();
global $db;

$user_id=$_SESSION['user']['userid'];

$shop_count=0;

$shop_count=$db->GetOne("SELECT COUNT(tb_shop_id) FROM `tb_shops` WHERE client_id=$user_id");

if((int)$shop_count*1 > 0){

	//shop exists

	$category_count=$db->GetOne("SELECT COUNT(category_id) FROM `tb_categories` WHERE client_id=$user_id");

	if($category_count !="0"){

		//category exists
		$measure_count=$db->GetOne("SELECT COUNT(measurement_id) FROM `tb_measurements` WHERE client_id=$user_id");

		if($measure_count !="0"){
			//measure exists
			$tax_count=$db->GetOne("SELECT COUNT(tb_tax_id) FROM tb_tax_margins WHERE client_id=$user_id and active_status=1");

			if($tax_count !="0"){
				$response['success']=4;
				$response['message']="awesome";

				echo json_encode($response);
			}else{
				$response['success']=5;
				$response['message']="Create A Tax Margin";

				echo json_encode($response);
			}

			
				
		}else{
			$response['success']=3;
			$response['message']="Create a measurement unit first";

			echo json_encode($response);
		}

	}else{
		$response['success']=2;
		$response['message']="Create a category first";

		echo json_encode($response);
	}
}else{
	$response['success']=1;
	$response['message']="Create an outlet first";

	echo json_encode($response);
}



?>