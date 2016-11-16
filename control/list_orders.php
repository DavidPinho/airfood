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
$list = null;

if(empty($_GET["only_act"])||$_GET["only_act"]==""){
	$list = $orderDB->selectFormToken($_GET["idToken"]);
}else{
	if($_GET["only_act"]==1)
		$list = $orderDB->selectFormTokenOnlyOpeneds($_GET["idToken"]);
	else
		$list = $orderDB->selectFormToken($_GET["idToken"]);
}


$json_response=array();
$i=0;
foreach($list as $order){
	$json_response[$i]=$order->getJSONFormat();
	$i++;
}

echo json_encode($json_response);

?>