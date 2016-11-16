<?php 
@include_once '../model/Category.class.php';
@include_once '../model/CategoryDB.class.php';
@include_once '../model/ItemDB.class.php';

$category_bd = new CategoryDB();
$itemDB = new ItemDB();

$list = $category_bd->selectAll();

$list_return=array();



$i = 0;
foreach($list as $category){

	$list_return[$i]=$category->getJSONFormat();

	$i++;
}

echo json_encode($list_return);

?>