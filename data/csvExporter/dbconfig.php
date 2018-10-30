<?php

$server='localhost';
$username='root';
$password='';
$database_name='mobipos';

$open_database_stream=mysqli_connect($server,$username,$password) or die(mysql_error());

$dbconnect=mysqli_select_db($open_database_stream,$database_name);

if(!$dbconnect){
	$result['error']='database not found';
	echo json_encode($result);
}

?>