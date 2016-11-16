<?php
/*
* This controller returns all itens saved on data base
* in json format based on search value
*/

require_once '../model/Item.class.php';
require_once '../model/ItemDB.class.php';

$itemDB=new ItemDB();
$list;

if(empty($_GET['idCategory'])||$_GET['idCategory']==-1)
	$list=$itemDB->selectForSearch($_GET['search'], $_GET['only_act']);
else																			
	$list=$itemDB->selectForSearchForCateogry($_GET['search'],$_GET['idCategory'], $_GET['only_act']);//coloquei aspas simples em idCategory
	

// $list = $itemDB->selectForSearch($_POST['search']);
$json_response=array();
$i=0;
foreach($list as $item){
	$json_response[$i]=$item->getJSONFormat();
	$i++;
}

echo json_encode($json_response);

?>