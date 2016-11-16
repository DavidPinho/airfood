<?php
/*
* This file handles the update action on the database
*/

session_start();

@include_once '../model/Category.class.php';
@include_once '../model/CategoryDB.class.php';
@include_once '../php_utils/user_validator.php';
@include_once '../model/User.class.php';
@include_once '../php_utils/ImageUtils.class.php';

if(!validateUser()){
	echo 'unauthorized';
	return;
}

$list_erro_return=array();
$erro_count=0;

$aux = trim(strtolower($_POST['desc']));
$aux = ltrim($aux);
$aux = rtrim($aux);

if(empty($_POST['desc'])||$_POST['desc']==''){
	$list_erro_return[$erro_count]="desc;Please, type a category";
	$erro_count++;
}else{
	$category2 = new Category();
	$category_bd2 = new CategoryDB();
	$category2 = $category_bd2->selectOneByDesc($aux);
	if(($category2->getId()!=null) && ($_POST['desc'] != $_POST['desc_aux'])){
		$list_erro_return[$erro_count]="desc;This category already exists.";
		$erro_count++;
	}
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

}

$category = new Category();
$category->setDesc($_POST['desc']);
$category->setId($_POST['id_category']);
$category->setImage($icon_path);

$category_bd = new CategoryDB();
$result = $category_bd->update($category);


$form_return=array("op_code"=>"success","new_id"=>$result,"image"=>$icon_path);

echo json_encode($form_return);


?>