<?php 
/*
* This controller returns all users saved on data base
* in json format for the serach action
*
*
*/

session_start();

@include_once '../model/Token.class.php';
@include_once '../model/TokenDB.class.php';
@include_once '../php_utils/user_validator.php';
@include_once '../model/User.class.php';

if(!validateUser()){
	echo 'unauthorized';
	return;
}

$token_bd = new TokenDB();


if(empty($_POST['search'])||$_POST['search']==""){
	return;
}

if(empty($_POST['only_act'])){
	$_POST['only_act']=0;
}

$list = $token_bd->selectForSearch($_POST['search'], $_POST['only_act']);

$list_return=array();

$i = 0;
foreach($list as $token){
	$list_return[$i]=$token->getJSONFormat();

	$i++;
}

echo json_encode($list_return);
?>