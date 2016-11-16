<?php 

session_start();

@include_once '../model/Token.class.php';
@include_once '../model/TokenDB.class.php';
@include_once '../lang/lang_utils.php';
@include_once '../php_utils/user_validator.php';
@include_once '../model/User.class.php';

if(!validateUser()){
	echo 'unauthorized';
	return;
}

$lang=loadLang("../lang");


$list_erro_return=array();
$erroCount = 0;

$tableAux = trim($_POST['table']);

if(empty($tableAux)||$tableAux==''){
	$list_erro_return[$erroCount]="editTable;".$lang->empty_table;
	$erroCount++;
}

if($erroCount>0){
	$server_out["out"]="erro";
	$server_out["erro_list"]=$list_erro_return;

	echo json_encode($server_out);
	return;

}

$token = new Token();
$tokenDB = new TokenDB();

$token->setTable($_POST['table']);
$token->setAvailable($_POST['status']);
$token->setIdToken($_POST['token']);

$update_return = array("out"=>"erro");

if($token->getAvailable()){
	if($tokenDB->isTableAvailable($token->getTable())){
		$tokenDB->update($token);

		$update_return["out"] = "success";
		$update_return["table"] = $token->getTable();
		$update_return["status"] = $token->getAvailable();
		$update_return["token"] = $token->getIdToken();

		if($update_return["status"]){
			$update_return["out_status"]="<span class=\"label label-success\">".$lang->token_active."</span>";
		}else{
			$update_return["out_status"]="<span class=\"label label-important\">".$lang->token_deactive."</span>";
		}

		echo json_encode($update_return);
	}else{
		$erro_list=array();

		$erro_list[$erroCount]="editTable;".$lang->unavailable_table;
		$erroCount++;

		$update_return["erro_list"] = $erro_list;

		echo json_encode($update_return);
	}
}else{
	if(!$_POST["changed_table"]){
		$tokenDB->update($token);
		
		$update_return["out"] = "success";
		$update_return["table"] = $token->getTable();
		$update_return["status"] = $token->getAvailable();
		$update_return["token"] = $token->getIdToken();
		if($update_return["status"]){
			$update_return["out_status"]="<span class=\"label label-success\">".$lang->token_active."</span>";
		}else{
			$update_return["out_status"]="<span class=\"label label-important\">".$lang->token_deactive."</span>";
		}
		
		echo json_encode($update_return);
		return;
	}
	
	if($tokenDB->isTableAvailable($token->getTable())){
		$tokenDB->update($token);

		$update_return["out"] = "success";
		$update_return["table"] = $token->getTable();
		$update_return["status"] = $token->getAvailable();
		$update_return["token"] = $token->getIdToken();
		if($update_return["status"]){
			$update_return["out_status"]="<span class=\"label label-success\">".$lang->token_active."</span>";
		}else{
			$update_return["out_status"]="<span class=\"label label-important\">".$lang->token_deactive."</span>";
		}

		echo json_encode($update_return);
	}else{
		$erro_list=array();

		$erro_list[$erroCount]="editTable;".$lang->unavailable_table;
		$erroCount++;

		$update_return["erro_list"] = $erro_list;

		echo json_encode($update_return);
	}
}
?>