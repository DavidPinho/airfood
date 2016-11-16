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

$nameAux = trim(strtolower($_POST['name']));
$itemDB=new ItemDB();
$itemComp = $itemDB->selectOneByDesc($nameAux);

if(empty($_POST['idItem'])){
	$list_erro_return[$erro_count]="idItem;Erro";
	$erro_count++;
}

if(empty($_POST['name'])||$_POST['name']==''){
	$list_erro_return[$erro_count]="name;".$lang->empty_name;
	$erro_count++;
}elseif(($itemComp->getIdItem()!=null) && ($_POST['name'] != $_POST['name_aux'])){
	$list_erro_return[$erro_count]="name;".$lang->duplicated_item;
	$erro_count++;
 }

if(empty($_POST['desc'])||$_POST['desc']==''){
	$list_erro_return[$erro_count]="desc;".$lang->empty_desc;
	$erro_count++;
}

if(empty($_POST['price'])||$_POST['price']==''){
	$list_erro_return[$erro_count]="price;".$lang->empty_price;
	$erro_count++;
}else if(!is_numeric($_POST['price'])){
	$list_erro_return[$erro_count]="price;".$lang->empty_price_invalid;
	$erro_count++;
}

if(empty($_POST['qtd'])||$_POST['qtd']==''){
	$list_erro_return[$erro_count]="qtd;".$lang->empty_qtd;
	$erro_count++;
}else if(!ctype_digit($_POST['qtd'])){
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


if($erro_count>0){

	$form_return=array("op_code"=>"erro","erro_list"=>$list_erro_return);
	echo json_encode($form_return);
	return;

}elseif(($icon_path != "none")&&($icon_path != $_POST['img_old'])&&(file_exists("../img/icons/".$_POST['img_old']))){
		unlink("../img/icons/".$_POST['img_old']);
}



$item=new Item();

$item->setName($_POST['name']);
$item->setDesc($_POST['desc']);
$item->setPrice($_POST['price']);
$item->setQtd_storage($_POST['qtd']);
$item->setIcon($icon_path);
$item->setImage("none");
$item->setIdCategory($_POST["categories"]);
$item->setIdItem($_POST['idItem']);
$item->setActive($_POST['active']);

$itemDB=new ItemDB();

$old_item=$itemDB->selectOne($item->getIdItem());

if($icon_path=="none"){
	$icon_path = $old_item->getIcon();
}

$item->setIcon($icon_path);

$result=$itemDB->update($item);


$form_return=array("op_code"=>"success","id"=>$item->getIdItem(),"icon"=>$icon_path,"status"=>$item->getActive());

echo json_encode($form_return);


?>