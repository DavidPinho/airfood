<?php

session_start();

require_once '../model/TokenDigest.class.php';
require_once '../model/TokenDigestDB.class.php';
require_once '../model/TokenDB.class.php';
require_once '../model/Token.class.php';
require_once '../model/OrderItem.class.php';
require_once '../model/OrderItemDB.class.php';
require_once '../lang/lang_utils.php';

$response_server=array();

$lang=loadLang("../lang");

$tokeDigest=new TokenDigest();
$tokeDigest->createFromInput($_SESSION["customer"]);

$orderDB=new OrderItemDB();
$result=$orderDB->consultCompleteBillFrom($_GET["idToken"]);

$bill_content=array();

echo json_encode($result);

?>