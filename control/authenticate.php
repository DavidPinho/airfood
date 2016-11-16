<?php

session_start();

require_once '../model/User.class.php';
require_once '../model/UserDB.class.php';

$userName = $_POST['userName'];
$password = $_POST['password'];

$user = new User();
$userDb = new UserDB();

$list_erro_return=array();
$erro_count=0;

if(empty($userName)|| $userName==''){
	$list_erro_return[$erro_count]="userName;Please, type a userName";
	$erro_count++;
}else 
	if(empty($password)|| $password==''){
		$list_erro_return[$erro_count]="password;Please, type a password";
		$erro_count++;
	  }else{

	     $user = $userDb->getUser($userName, $password);

		 if($user->getUserName()==null){
			$list_erro_return[$erro_count]="userName;Wrong user name or password!";
			$erro_count++;
			$list_erro_return[$erro_count]="password;Wrong user name or password!";
			$erro_count++;

		 }
	  }


if($erro_count>0){
	$form_return=array("op_code"=>"erro","erro_list"=>$list_erro_return);
	echo json_encode($form_return);
	return;
}else{
	$_SESSION['user'] = $user->getJSONFormat();
	$form_return=array("op_code"=>"success");
	echo json_encode($form_return);

}












?>