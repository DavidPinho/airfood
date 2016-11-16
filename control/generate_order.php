<?php
session_start();

require_once '../model/OrderItem.class.php';
require_once '../model/OrderItemDB.class.php';
require_once '../model/Item.class.php';
require_once '../model/ItemDB.class.php';
@include_once '../php_utils/user_validator.php';
@include_once '../model/User.class.php';

if(!validateUser()){
	echo 'unauthorized';
	return;
}

$orderDB=new OrderItemDB();
$order=new OrderItem();
$itemDB=new ItemDB();
$list;
$id_item;

$list_erro_return=array();
$erro_count=0;

//verifica se variaveis foram passadas em branco
$item = trim($_POST['item']); 
$qtd = trim($_POST['qtd']);

if(empty($qtd)){
	$list_erro_return[$erro_count]="qtd;"."campo vazio";
	$erro_count++;
}else if($qtd < 0){
	$list_erro_return[$erro_count]="qtd;"."informar número positivo";
	$erro_count++;
}else if( !(is_numeric($qtd)) ){
	$list_erro_return[$erro_count]="qtd;"."isto não é um número válido";
	$erro_count++;
}else if($qtd>$itemDB->selectOne($itemDB->selectOneByName($item))->getQtd_storage()){
	$list_erro_return[$erro_count]="qtd;"."Quantidade Indisponivel";
	$erro_count++;
}

if(empty($item)){
	$list_erro_return[$erro_count]="item;"."campo vazio";
	$erro_count++;
}else if( !($id_item = $itemDB->selectOneByNameIsActive($_POST['item'])) ){ //verica se item nao existe ou se está desativado
	$list_erro_return[$erro_count]="item;"."item não existe";
	$erro_count++;
}

if($erro_count>0){
	$form_return=array("op_code"=>"erro","erro_list"=>$list_erro_return);
	echo json_encode($form_return);
	return;
}

$json_response = array();
$cont=0;
	for ($i = 1; $i <= $_POST['qtd']; $i++) {
		$order->setIdItem($id_item);
		$order->setStatus(0);
		$order->setComment("");
		$order->setIdToken($_POST['token']);
		$order->setOrderTime(@date('Y-m-d H:i:s'));
		$result=$orderDB->insert($order);
		if($result){
			$json=array("idOrder"=>$result,
				"item"=>$_POST['item'],
				"orderTime"=>$order->getOrderTime(),
				"status"=>$order->getStatus(),
				"qtd"=>$order->getQtd(),
				"comment"=>$order->getComment(),
				"idToken"=>$order->getIdToken());
					
				$json_response[$cont]= json_encode($json);
				$cont++;
		}
	}
	$form_return=array("op_code"=>"sucess","order_list"=>$json_response);
	echo json_encode($form_return);

?>