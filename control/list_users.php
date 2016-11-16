<?php

session_start();

@include_once '../model/UserDB.class.php';
@include_once '../php_utils/user_validator.php';
@include_once '../model/User.class.php';

if(!validateUser(true)){
	echo 'unauthorized';
	return;
}

$user_DB = new UserDB();

$list = $user_DB->getAllUsers();

$list_return=array();

$i = 0;
foreach($list as $user){
	$list_return[$i]=$user->getJSONFormat();

	$i++;
}

echo json_encode($list_return);


?>