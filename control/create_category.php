<?php 

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

 
$category2 = new Category();
$category_bd = new CategoryDB();
$aux = trim(strtolower($_POST['desc']));
$aux = ltrim($aux);
$aux = rtrim($aux);

$category2 = $category_bd->selectOneByDesc($aux);

if($category2->getId()!=null){
	$list_erro_return[$erro_count]="desc;This category already exists.";
	$erro_count++;
}

if($_POST['desc']==""){
	$list_erro_return[$erro_count]="desc;Field Empty";
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

$category = new Category();
$category->setDesc($_POST['desc']);
$category->setImage($icon_path);

$category_bd = new CategoryDB();

$result = $category_bd->insert($category);

$form_return=array("op_code"=>"success","new_id"=>$result,"image"=>$icon_path);

echo json_encode($form_return);