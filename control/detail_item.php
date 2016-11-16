<?php

require_once '../model/Item.class.php';
require_once '../model/ItemDB.class.php';


$itemDB=new ItemDB();

if(empty($_GET["idItem"])){ 
	echo "invalid";
	return ;
}

$item=$itemDB->selectOne($_GET["idItem"]);

echo $item->getJSONFormat();

?>