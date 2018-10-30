<?php
 require_once 'Classes/PHPExcel.php';
 require_once 'Classes/PHPExcel/IOFactory.php';

 require_once("dbconfig.php");

 $from_date=$_REQUEST['from'];
 $to_date=$_REQUEST['to'];
 $cashier_id=$_REQUEST['cashier_id'];
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Atfortech Dynamics")
        ->setLastModifiedBy("Atfortech Dynamics")
        ->setTitle("Reports")
        ->setSubject("Mauzo Africa Reports")
        ->setDescription("Report sheets")
        ->setKeywords("Excel")
        ->setCategory("Reports");
        
// Create a first sheet, representing sales data
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ORDER NO');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'SHOP NAME');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'TRANSCATION TYPE');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'TRANSCATION CODE');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'TOTAL AMOUNT');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'VAT');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'NET PROFIT');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'DATE OF SALE');

$n=2;

$TOTAL_AMOUNT_SOLD=0;
$TOTAL_VAT=0;
$TOTAL_NET_PROFIT=0;

$query_command='SELECT tb_app_sales.order_id,tb_app_sales.amount_total,tb_app_sales.transaction_type,tb_app_sales.transaction_code,tb_employees.employee_name,tb_shops.tb_shop_name,tb_app_sales.date_of_sale FROM `tb_app_sales` INNER JOIN tb_employees ON tb_app_sales.employee_id=tb_employees.id INNER JOIN tb_shops ON tb_shops.tb_shop_id=tb_employees.outlet_posted WHERE 
tb_app_sales.date_of_sale>="'.$from_date.'" AND tb_app_sales.date_of_sale<="'.$to_date.'" AND tb_employees.id="$cashier_id" ORDER BY tb_app_sales.date_of_sale DESC';

$qry= mysqli_query($open_database_stream,$query_command);
while($d= mysqli_fetch_array($qry)){

	$order_no=$d['order_id'];
	$tax_query='SELECT tb_app_stock_movement.product_id,tb_app_stock_movement.count,tb_product_prices.selling_price,tb_products.tax_mode,tb_tax_margins.tax_margin FROM tb_app_stock_movement INNER JOIN tb_product_prices ON tb_product_prices.product_id=tb_app_stock_movement.product_id INNER JOIN tb_products ON tb_products.product_id=tb_app_stock_movement.product_id INNER JOIN tb_tax_margins ON tb_tax_margins.tb_tax_id=tb_products.tax_mode WHERE tb_app_stock_movement.sale_id='."$order_no";
 $objPHPExcel->getActiveSheet()->setCellValue('A'.$n, $d['order_id']);
 $objPHPExcel->getActiveSheet()->setCellValue('B'.$n, $d['tb_shop_name']);
 $objPHPExcel->getActiveSheet()->setCellValue('C'.$n, $d['transaction_type']);
 $objPHPExcel->getActiveSheet()->setCellValue('D'.$n, $d['transaction_code']);
 $objPHPExcel->getActiveSheet()->setCellValue('E'.$n, $d['amount_total']);

 	$TOTAL_AMOUNT_SOLD=$TOTAL_AMOUNT_SOLD+$d['amount_total'];
 	$total_tax=0;
 	$query_exec_tax=mysqli_query($open_database_stream,$tax_query);
 	while($row= mysqli_fetch_array($query_exec_tax)){
 		$item_count=$row['count'];
 		$selling_price=$row['selling_price'];
 		$tax_margin=$row['tax_margin'];


 		$total_item_tax=$item_count*$selling_price*($tax_margin/100);

 		$total_tax=$total_tax+$total_item_tax;
 		$TOTAL_VAT+=$total_tax;
 	}
 	$objPHPExcel->getActiveSheet()->setCellValue('F'.$n,$total_tax);

 	$grand_total=$d['amount_total'];
 	$net_profit=$grand_total-$total_tax;
 	$TOTAL_NET_PROFIT += $net_profit;
 	$objPHPExcel->getActiveSheet()->setCellValue('G'.$n,$net_profit);

 	$dater=strtotime($d['date_of_sale']);
 	$objPHPExcel->getActiveSheet()->setCellValue('H'.$n,date('d-m-Y',$dater));
   $n++;
}  

$total_cell=$n+2;
 $objPHPExcel->getActiveSheet()->setCellValue('A'.$total_cell, 'TOTAL');
 $objPHPExcel->getActiveSheet()->setCellValue('E'.$total_cell, $TOTAL_AMOUNT_SOLD);
 $objPHPExcel->getActiveSheet()->setCellValue('F'.$total_cell, $TOTAL_VAT);
 $objPHPExcel->getActiveSheet()->setCellValue('G'.$total_cell, $TOTAL_NET_PROFIT);              
                
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('SALE ORDERS');

// Create a new worksheet, after the default sheet
$objPHPExcel->createSheet();

// Add some data to the second sheet, resembling some different data types
$objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'PRODUCT NAME');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'CATEGORY');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'PRODUCT SOLD');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'MEASUREMENT TYPE');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'BUYING PRICE');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'BUYING TOTAL');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'SELLING PRICE');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'SELLING TOTAL');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'VAT');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'NET PROFIT');

$TOTAL_BUY=0;
$TOTAL_SELL=0;
$TOTAL_VAT_PRODCUTS=0;
$TOTAL_NET_PRODUCTS=0;

$n=2;
$product_query='SELECT tb_app_stock_movement.product_id,SUM(tb_app_stock_movement.count) as total_count,tb_product_prices.buying_price,tb_product_prices.selling_price,tb_products.tax_mode,tb_tax_margins.tax_margin,tb_products.product_name,tb_categories.category_name,tb_measurements.measurement_name FROM tb_app_stock_movement INNER JOIN tb_product_prices ON tb_product_prices.product_id=tb_app_stock_movement.product_id INNER JOIN tb_products ON tb_products.product_id=tb_app_stock_movement.product_id INNER JOIN tb_tax_margins ON tb_tax_margins.tb_tax_id=tb_products.tax_mode INNER JOIN tb_categories ON tb_products.category_id=tb_categories.category_id INNER JOIN tb_measurements ON tb_products.measurement_type=tb_measurements.measurement_id WHERE tb_app_stock_movement.date_of_movement>="'.$from_date.'" AND tb_app_stock_movement.date_of_movement<="'.$to_date.'" AND tb_app_stock_movement.employee_id='."$cashier_id".' GROUP BY tb_app_stock_movement.product_id';


$qry=mysqli_query($open_database_stream,$product_query);
while($d= mysqli_fetch_array($qry)){
 $objPHPExcel->getActiveSheet()->setCellValue('A'.$n, $d['product_name']);
 $objPHPExcel->getActiveSheet()->setCellValue('B'.$n, $d['category_name']);
 $objPHPExcel->getActiveSheet()->setCellValue('C'.$n, $d['total_count']);
 $objPHPExcel->getActiveSheet()->setCellValue('D'.$n, $d['measurement_name']);
 $objPHPExcel->getActiveSheet()->setCellValue('E'.$n, $d['buying_price']);


 $b_pr=$d['buying_price'];
 $pr_count=$d['total_count'];
 $s_pr=$d['selling_price'];
 $buy_total=$b_pr*$pr_count;
 $sel_total=$s_pr*$pr_count;
 $tax_mar=$d['tax_margin'];

 $tax=$sel_total*($tax_mar/100);
 $objPHPExcel->getActiveSheet()->setCellValue('F'.$n, $buy_total);
 $objPHPExcel->getActiveSheet()->setCellValue('G'.$n, $d['selling_price']);
 $objPHPExcel->getActiveSheet()->setCellValue('H'.$n, $sel_total);
 $objPHPExcel->getActiveSheet()->setCellValue('I'.$n, $tax);
 $objPHPExcel->getActiveSheet()->setCellValue('J'.$n, $sel_total-$buy_total-$tax);



 $TOTAL_BUY += $buy_total;
 $TOTAL_SELL += $sel_total;
 $TOTAL_VAT_PRODCUTS += $tax;
 $TOTAL_NET_PRODUCTS +=$sel_total-$buy_total-$tax;

$n++;
}  
$to_product=$n+2;



 $objPHPExcel->getActiveSheet()->setCellValue('A'.$to_product,'TOTAL');  
 $objPHPExcel->getActiveSheet()->setCellValue('F'.$to_product,$TOTAL_BUY);  
 $objPHPExcel->getActiveSheet()->setCellValue('H'.$to_product,$TOTAL_SELL);  
 $objPHPExcel->getActiveSheet()->setCellValue('I'.$to_product,$TOTAL_VAT_PRODCUTS);  
 $objPHPExcel->getActiveSheet()->setCellValue('J'.$to_product,$TOTAL_NET_PRODUCTS);  

 
     

// Rename 2nd sheet
$objPHPExcel->getActiveSheet()->setTitle('PRODUCT INFORMATION');

// Redirect output to a client’s web browser (Excel5)
$title="Report: ".$from_date." to ".$to_date.".xls";
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$title);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>