<?php 
/*
* This controller returns all categories saved on data base
* in json format for the serach action
*
*
*/
require_once '../model/Category.class.php';
require_once '../model/CategoryDB.class.php';

if(empty($_POST['search'])||$_POST['search']==''){
	echo 'erro';
	return;
}

$category_bd = new CategoryDB();
$list = $category_bd->selectForSearch($_POST['search']);

$list_return=array();

$i = 0;
foreach($list as $category){
	$list_return[$i]=$category->getJSONFormat();

	$i++;
}

echo json_encode($list_return);
?>