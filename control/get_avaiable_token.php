<?php

session_start();

@include_once '../model/Token.class.php';
@include_once '../model/TokenDB.class.php';
@include_once '../php_utils/user_validator.php';
@include_once '../model/User.class.php';

if(!validateUser()){
	echo 'unauthorized';
	return;
}

$token_DB = new TokenDB();

$list = $token_DB->getAllAvailable();

$list_return=array();

$i = 0;
foreach($list as $token){
	$list_return[$i]=$token->getJSONFormat();

	$i++;
}

echo json_encode($list_return);

?>