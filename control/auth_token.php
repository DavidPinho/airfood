<?php

require_once '../model/TokenDB.class.php';
require_once '../model/Token.class.php';
require_once '../model/TokenDigest.class.php';
require_once '../model/TokenDigestDB.class.php';
require_once '../lang/lang_utils.php';

session_start();

$lang=loadLang("../lang");

if(empty($_POST['auth_token']))
	return;
	
$token_parts=explode("-", $_POST['auth_token']);

$tokenDB=new TokenDB();
$token=$tokenDB->getOne($token_parts[0]);


$json_response=array();
$json_response["op_code"]="erro";
$json_response["message"]=(string)$lang->token_unavailable;

if($token!=null){
	if($token->getAvailable()==1){
		
		
		
		$tokenDigestDB=new TokenDigestDB();
		$tokenDigest=new TokenDigest();
		
		$tokenDigest->createFromInput($_POST['auth_token']);
		
		$result_digest=$tokenDigestDB->getOne($tokenDigest->getToken());
		if($result_digest==null){
			$tokenDigestDB->insert($tokenDigest);
			
			$json_response["op_code"]="success";
			$json_response["message"]=(string)$lang->token_available;
			
			//start the session of the customer
			$_SESSION["customer"]=$_POST['auth_token'];
			
			$json_response["token"]=$_SESSION["customer"];
			
		}	
	}	
}



echo json_encode($json_response);


?>