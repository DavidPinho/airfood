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

$tokenDB = new TokenDB();

$list=NULL;
if(empty($_GET["only_act"])||$_GET["only_act"]==""){
	$list = $tokenDB->getAll();
}else{
	if($_GET["only_act"]==1)
		$list = $tokenDB->getActiveTokens();
	else
		$list = $tokenDB->getAll();
}

$list_return=array();

$i = 0;
foreach($list as $token){
	$list_return[$i]=$token->getJSONFormat();
	$i++;
}

echo json_encode($list_return);
?>