<?php

include('./db.php');
@session_start();
global $db;

$user_id=$_SESSION['user']['userid'];

$page=$_REQUEST['page'];
$id=$_REQUEST['id'];

$results=$db->GetOne("SELECT tb_categories.category_id FROM `tb_categories` inner join tb_shops on tb_categories.shop_id=tb_shops.tb_shop_id WHERE tb_shops.client_id=1 AND tb_categories.active_status=1 order by tb_categories.category_id desc limit $page,5 ");

echo $results;

?>