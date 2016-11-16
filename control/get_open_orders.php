<?php

session_start();

@include_once '../model/TokenDB.class.php';
@include_once '../model/Token.class.php';
@include_once '../model/OrderItem.class.php';
@include_once '../model/OrderItemDB.class.php';
@include_once '../model/Item.class.php';
@include_once '../php_utils/user_validator.php';
@include_once '../model/User.class.php';

if(!validateUser()){
	echo 'unauthorized';
	return;
}


$tokenDB=new TokenDB();
$orderItemDB=new OrderItemDB();

$activeTokens=$tokenDB->getActiveTokens();

$jsonResponse=array();

$countI=0;

foreach ($activeTokens as $activeToken){
	
	$token=$activeToken->getIdToken();
	$openOrders=$orderItemDB->getOpenOrdersForToken($token);
	
	
	if($openOrders==NULL)
		continue;
	
	$itensAdded=array();
	$itemArray=array();
	
	$jsonResponse[$countI]["token"]=$activeToken->getJSONFormat();
	$itemI=0;
	$comment_encoded="";
	$item_text="";
	$idOrders="";
	$contOrder=0;
	foreach($openOrders as $openOrder){
		$item=$openOrder["item"];
		$order=$openOrder["order"];
		
		$newItem=$itensAdded[$item->getIdItem()]["item"];
		if($newItem==NULL){
		
			$qtd=$orderItemDB->getCountItemOrder($token, $item->getIdItem());
			
			$itensAdded[$item->getIdItem()]["pos"]=$itemI;
			$itensAdded[$item->getIdItem()]["item"]=$item;
			$itemArray[$itemI]["item"]=$item->getJSONFormat();
			$itemArray[$itemI]["qtd"]=$qtd;
			$itemArray[$itensAdded[$item->getIdItem()]["pos"]]["obs"]="";
			$item_text.=$qtd."x ".$item->getName()."\n";
			
			
			$itemI++;
		}
		
		
		if($order->getComment()!="") {
			$comment_encoded.=$item->getName().": ".$order->getComment()."\n";
			$itemArray[$itensAdded[$item->getIdItem()]["pos"]]["obs"].=$order->getComment()."\n";
		}
		
		if($contOrder==0){
			$firstOrderTime=$order->getOrderTime();
		}else if($order->getOrderTime()<$firstOrderTime){
			$firstOrderTime=$order->getOrderTime();
		}
		$idOrders.=$order->getIdOrder().",";
		$contOrder++;
	}
	
	$idOrders = substr($idOrders, 0, -1);
	
	$jsonResponse[$countI]["itens"]=$itemArray;
	$jsonResponse[$countI]["first_order"]=$firstOrderTime;
	$jsonResponse[$countI]["comments"]=$comment_encoded;
	$jsonResponse[$countI]["itens_text"]=$item_text;
	$jsonResponse[$countI]["id_orders"]=$idOrders;
	$countI++;
}

//order by first_order time 
//TODO: Aletrar algoritmo de ordenacao para QuickSort.
for($i=0;$i<$countI-1;$i++){
	for($j=$i+1;$j<$countI;$j++){
		if($jsonResponse[$j]["first_order"]<$jsonResponse[$i]["first_order"]){
			$aux=$jsonResponse[$j];
			$jsonResponse[$j]=$jsonResponse[$i];
			$jsonResponse[$i]=$aux;
		}
	}
	
}
echo json_encode($jsonResponse);

?>