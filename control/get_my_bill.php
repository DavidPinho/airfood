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
	$response_server["op_code"]="no_valid_token";
}else{
	$response_server["op_code"]="success";
	
	$tokeDigest=new TokenDigest();
	$tokeDigest->createFromInput($_SESSION["customer"]);
	
	$orderDB=new OrderItemDB();
	$result=$orderDB->consultBillFrom($tokeDigest->getToken());
	
	$bill_content=array();
	$i=0;
	$total=0;
	foreach($result as $consult){
		$bill_content[$i]["item"]=$consult["item"]->getJSONFormat();
		$bill_content[$i]["qtd"]=$consult["qtd"];
		
		$total+=$consult["item"]->getPrice()*$consult["qtd"];
		
		$i++;
	}
	$response_server["bill"]=$bill_content;
	$response_server["total"]=$total;
	
}

echo json_encode($response_server);

?>