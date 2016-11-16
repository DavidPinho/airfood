<?php 
session_start();

@include_once '../model/Category.class.php';
@include_once '../model/CategoryDB.class.php';
@include_once '../php_utils/user_validator.php';
@include_once '../model/User.class.php';

if(!validateUser()){
	echo 'unauthorized';
	return;
}

if(empty($_POST['ids'])||$_POST['ids']==''){
	echo 'erro';
	return;
}

$list_categories=explode(",", $_POST['ids']);
$deleted_itens=array();
$not_deleted_itens=array();
$deleted_index=0;
$not_deleted_index=0;

foreach($list_categories as $category){
	$categoryDB=new CategoryDB();
	
	if($categoryDB->remove($category)){
		$deleted_itens[$deleted_index]=$category;
		$deleted_index++;
	}else{
		$not_deleted_itens[$not_deleted_index]=$category;
		$not_deleted_index++;
	}
	
	
}


$response_json;
if($not_deleted_index>0){
	$response_json=array("op_code"=>"not_all_deleted","deleteds"=>$deleted_itens,"not_deleteds"=>$not_deleted_itens);
}else
	$response_json=array("op_code"=>"all_deleted","deleteds"=>$deleted_itens);
echo json_encode($response_json);

?>