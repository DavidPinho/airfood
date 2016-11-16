<?php

require_once '../model/TokenDB.class.php';
require_once '../model/Token.class.php';
require_once '../model/OrderItem.class.php';
require_once '../model/OrderItemDB.class.php';
require_once '../model/Item.class.php';

$orderItemDB=new OrderItemDB();

$jsonResponse=Array();

if(empty($_GET["ids"])||$_GET["ids"]==""){
	$jsonResponse["op_code"]="erro";
}else{
	$orders = explode(",", $_GET['ids']);
	
	foreach ($orders as $order){
		$orderItemDB->confirmOrder($order);
	}
	
	$jsonResponse["op_code"]="success";
}

echo json_encode($jsonResponse);

?>