<?php

session_start();

@include_once '../php_utils/ImageUtils.class.php';
@include_once '../model/Item.class.php';
@include_once '../model/ItemDB.class.php';
@include_once '../lang/lang_utils.php';
@include_once '../php_utils/user_validator.php';
@include_once '../model/User.class.php';

if(!validateUser()){
	echo 'unauthorized';
	return;
}

$lang=loadLang("../lang");

$list_erro_return=array();
$erro_count=0;
$itemDB=new ItemDB();

$nameAux = trim(strtolower($_POST['name']));
$nameAuxToInsert = trim($_POST['name']);
$priceAux = trim($_POST['price']);
$qtdAux = trim($_POST['qtd']);
$descAux = trim($_POST['desc']);

$itemAux = $itemDB->selectOneByDesc($nameAux);

if($itemAux->getIdItem()!=null){
	$list_erro_return[$erro_count]="name;".$lang->duplicated_item;
	$erro_count++;
}

if(empty($nameAuxToInsert)||$nameAuxToInsert==''){
	$list_erro_return[$erro_count]="name;".$lang->empty_name;
	$erro_count++;
}

if(empty($descAux)||$descAux==''){
	$list_erro_return[$erro_count]="desc;".$lang->empty_desc;
	$erro_count++;
}

if(empty($priceAux)||$priceAux==''){
	$list_erro_return[$erro_count]="price;".$lang->empty_price;
	$erro_count++;
}else if(!is_numeric($priceAux)){
	$list_erro_return[$erro_count]="price;".$lang->empty_price_invalid;
	$erro_count++;
}

if(empty($qtdAux)||$qtdAux==''){
	$list_erro_return[$erro_count]="qtd;".$lang->empty_qtd;
	$erro_count++;
}else if(!ctype_digit($qtdAux)){
	$list_erro_return[$erro_count]="qtd;".$lang->empty_price_invalid;
	$erro_count++;
}

if(empty($_POST['categories'])||$_POST['categories']==''){
	$list_erro_return[$erro_count]="categories;".$lang->empty_categories;
	$erro_count++;
}

$icon_path="none";

if(!empty($_FILES['icon'])){
	$icon_path=ImageUtils::createAndValidateIcon($_FILES['icon']);
	if($icon_path=="denied"){
		$list_erro_return[$erro_count]="icon;erro";
		$erro_count++;
	}
}
if(empty($_FILES['icon']))
	$icon_path= "AAAAAA.gif";



if($erro_count>0){

	$form_return=array("op_code"=>"erro","erro_list"=>$list_erro_return);
	echo json_encode($form_return);
	return;

}



$item=new Item();

$item->setName($_POST['name']);
$item->setDesc($_POST['desc']);
$item->setPrice($_POST['price']);
$item->setQtd_storage($_POST['qtd']);
$item->setIcon($icon_path);
$item->setImage("none");
$item->setIdCategory($_POST["categories"]);
$item->setActive($_POST["active"]);

$result=$itemDB->insert($item);

$form_return=array("op_code"=>"success","new_id"=>$result,"icon"=>$icon_path,"status"=>$item->getActive());

echo json_encode($form_return);


?>