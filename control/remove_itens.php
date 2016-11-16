<?php

session_start();

@include_once '../model/Item.class.php';
@include_once '../model/ItemDB.class.php';
@include_once '../php_utils/user_validator.php';
@include_once '../model/User.class.php';

if(!validateUser()){
	echo 'unauthorized';
	return;
}

if(empty($_POST['ids']) || $_POST['ids']==''){
	echo 'erro';
	return;
}

$list_itens = explode(",", $_POST['ids']);
$deleted_itens = array();
$deleted_itens_index = 0;


foreach ($list_itens as $item){
	$itemDB = new ItemDB();
	$itemDB->disable($item);
}

echo $_POST['ids'];

?>