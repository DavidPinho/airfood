<?php 
/*
 * Created by David Pinho January 24 of 2013 for Ajax support
* This controller returns all users saved on data base
* in json format for the serach action
*
*
*/

session_start();

@include_once '../model/User.class.php';
@include_once '../model/UserDB.class.php';
@include_once '../php_utils/user_validator.php';
@include_once '../model/User.class.php';

if(!validateUser(true)){
	echo 'unauthorized';
	return;
}


$user_bd = new UserDB();
$list = $user_bd->selectForSearch($_POST['search']);

$list_return=array();

$i = 0;
foreach($list as $user){
	$list_return[$i]=$user->getJSONFormat();

	$i++;
}

echo json_encode($list_return);
?>