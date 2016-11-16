<?php

session_start();

@include_once '../model/User.class.php';
@include_once '../model/UserDB.class.php';
@include_once '../php_utils/user_validator.php';
@include_once '../model/User.class.php';

if(!validateUser(true)){
	echo 'unauthorized';
	return;
}




if(empty($_POST['ids']) || $_POST['ids']==''){
	echo 'erro';
	return;
}

$list_users = explode(",", $_POST['ids']);
//$deleted_users = array();
//$deleted_users_index = 0;


foreach ($list_users as $user){
	$userDB = new UserDB();
	$userDB->remove($user);
}

echo $_POST['ids'];


?>