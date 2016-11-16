<?php
session_start();

@include_once '../php_utils/user_validator.php';
@include_once '../model/User.class.php';

if(!validateUser()){
	echo 'unauthorized';
	return;
}

if(empty($_GET['language'])||$_GET['language']==''){
	echo 'error';
	return;
}

$handle = fopen("../lang/current_language.xml", "w+");

if($handle == NULL){
	echo 'error';
	return;
}

$content="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<lang>\n<current>".$_GET['language']."</current>\n</lang>";
if(fwrite($handle,$content)){
	echo 'success';
	return;
}
?>