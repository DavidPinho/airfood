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

$list_erro_return=array();
$erro_count=0;

if(empty($_POST['name'])||$_POST['name']==''){
	$list_erro_return[$erro_count]="name;Please, type a name";
	$erro_count++;
}

if(empty($_POST['email'])||$_POST['email']==''){
	$list_erro_return[$erro_count]="email;Please, type a email";
	$erro_count++;
}else{
	$user3 = new User();
	$userDB3 = new UserDB();
	$user3 = $userDB3->getUserByUserName($_POST['email']);

	if(($user3->getIdUser()!=null) && ($_POST['email'] != $_POST['email_aux'])){
		$list_erro_return[$erro_count]="email;This email already exists!";
		$erro_count++;
	}
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	$list_erro_return[$erro_count]="email;Please, type a valid email";
	$erro_count++;
}

if(empty($_POST['userName'])||$_POST['userName']==''){
	$list_erro_return[$erro_count]="userName;Please, type a userName";
	$erro_count++;
}else if (strlen($_POST['userName'])<4){
	$list_erro_return[$erro_count]="userName; Type four or more characters";
	$erro_count++;
} else{

	$user2 = new User();
	$userDB2 = new UserDB();
	$user2 = $userDB2->getUserByUserName($_POST['userName']);

	if(($user2->getIdUser()!=null) && ($_POST['userName'] != $_POST['userName_aux'])){
		$list_erro_return[$erro_count]="userName;This userName already exists!";
		$erro_count++;
	}
}


if(empty($_POST['password'])||$_POST['password']==''){
	$list_erro_return[$erro_count]="password;Please, type a password";
	$erro_count++;
}else if (strlen($_POST['password'])<6){
	$list_erro_return[$erro_count]="password; Type six or more characters";
	$erro_count++;
}else if($_POST['password']!=$_POST['confirmPassword']){
	$list_erro_return[$erro_count]="confirmPassword; Wrong Password.";
	$erro_count++;
}

if(empty($_POST['confirmPassword'])||$_POST['confirmPassword']==''){
	$list_erro_return[$erro_count]="confirmPassword;Please, type a password";
	$erro_count++;
}




if($erro_count>0){

	$form_return=array("op_code"=>"erro","erro_list"=>$list_erro_return);
	echo json_encode($form_return);
	return;

}

$user=new User();


$user->setName($_POST['name']);
$user->setUserName($_POST['userName']);
$user->setPassword($_POST['password']);
$user->setIdUser($_POST['id_user']);
$user->setEmail($_POST['email']);
$user->setAdmin($_POST['is_adm']);

$userDB=new userDB();
$result=$userDB->update($user);

$form_return=array("op_code"=>"success","new_id"=>$user->getIdUser());

echo json_encode($form_return);


?>