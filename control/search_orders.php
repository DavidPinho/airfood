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

$orderDB=new OrderItemDB();
$list;

$list=$orderDB->selectForSearch($_GET['search'], $_GET['only_act'], $_GET['idToken']);

$json_response=array();
$i=0;
foreach($list as $order){
	$json_response[$i]=$order->getJSONFormat();
	$i++;
}

echo json_encode($json_response);

?>