<?php

session_start();

require_once '../php_utils/token_validator.php';
require_once '../model/TokenDigest.class.php';
require_once '../model/TokenDigestDB.class.php';
require_once '../model/TokenDB.class.php';
require_once '../model/Token.class.php';
require_once '../model/OrderItem.class.php';
require_once '../model/OrderItemDB.class.php';
require_once '../lang/lang_utils.php';

$response_server=array();

$lang=loadLang("../lang");

if(!validate_session_token()){
	$response_server["op_code"]="token_not_valid";
}else{
	
	$tokeDigest=new TokenDigest();
	$tokeDigest->createFromInput($_SESSION["customer"]);
	
	$order=new OrderItem();
	if(empty($_POST["comment"])||$_POST["comment"]=="")
		$order->setComment("");
	else
		$order->setComment($_POST["comment"]);
	
	$order->setIdItem($_POST["idItem"]);
	$order->setOrderTime(@date('Y-m-d H:i:s'));
	$order->setIdToken($tokeDigest->getToken());
	$order->setStatus(0);
	
	$orderDB=new OrderItemDB();
	for($i=0;$i<$_POST["qtd"];$i++){
		if($i!=0){
			$order->setComment("");
		}
		$result=$orderDB->insert($order);
	}
	
	
	if($result!="erro"){
		
		$response_server["op_code"]="success_in_order";
		$response_server["message"]=(string)$lang->success_on_order;
		
	}else{
		$response_server["op_code"]="erro_in_order";
		$response_server["message"]=(string)$lang->error_on_order;
	}
	
	
}

echo json_encode($response_server);

?>