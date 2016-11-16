<?php
require_once '../model/Item.class.php';
require_once '../model/ItemDB.class.php';

$itemDB=new ItemDB();
$list;
											
$list=$itemDB->selectForSearchAutocomplete($_POST['search']);
	
$json_response=array();
$i=0;
foreach($list as $item){
	$json_response[$i]=$item->getJSONFormat();
	$i++;
}

echo json_encode($json_response);

?>