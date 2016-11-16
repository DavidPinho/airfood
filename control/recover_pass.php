<?php

require_once '../model/User.class.php';
require_once '../model/UserDB.class.php';


$list_erro_return=array();
$erro_count=0;

$user = new User();
$userDb = new UserDB();

if(empty($_POST['userNamePassword'])||$_POST['userNamePassword']==''){
	$list_erro_return[$erro_count]="userNamePassword;This field is empty";
	$erro_count++;
}else{
	$user = $userDb->getUserByUserName($_POST['userNamePassword']);
	if ($user->getEmail()==null){
		$list_erro_return[$erro_count]="userNamePassword;It was not found";
		$erro_count++;
	}
}

if($erro_count>0){

	$form_return=array("op_code"=>"erro","erro_list"=>$list_erro_return);
	echo json_encode($form_return);
	return;

}



$form_return=array("op_code"=>"success", "pass"=>$user->getPassword());

echo json_encode($form_return);


?>