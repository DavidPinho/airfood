<?php
require_once '../model/Item.class.php';
require_once '../model/ItemDB.class.php';

$itemDB=new ItemDB();
$list = null;

if(empty($_GET["only_act"])||$_GET["only_act"]==""){
	$list = $itemDB->selectAll();
}else{
	if($_GET["only_act"]==1)
		$list = $itemDB->selectAllActives();
	else
		$list = $itemDB->selectAll();
}


$json_response=array();
$i=0;
foreach($list as $item){
	$json_response[$i]=$item->getJSONFormat();
	$i++;
}

echo json_encode($json_response);

?>