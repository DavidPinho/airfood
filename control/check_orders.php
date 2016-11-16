<?php

session_start();

@include_once '../model/OrderItem.class.php';
@include_once '../model/OrderItemDB.class.php';
@include_once '../php_utils/user_validator.php';
@include_once '../model/User.class.php';

if(!validateUser()){
	echo 'unauthorized';
	return;
}

if(empty($_POST['ids']) || $_POST['ids']==""){
	echo 'erro';
	return;
}

$list_orders = explode(",", $_POST["ids"]);
$deleted_orders = array();

foreach ($list_orders as $order){
	$orderItemDb = new OrderItemDB();
	$orderItemDb->confirmOrder($order);
}

echo $_POST["ids"];

?>