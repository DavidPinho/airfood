<?php 

session_start();

@include_once '../model/Token.class.php';
@include_once '../model/TokenDB.class.php';
@include_once '../lang/lang_utils.php';
@include_once '../php_utils/user_validator.php';
@include_once '../model/User.class.php';

if(!validateUser()){
	echo 'inauthorized';
	return;
}

$lang=loadLang("../lang");

$list_erro_return=array();
$erroCount = 0;
$validator = 0;
$tokenDB = new TokenDB();

$tableAux =trim($_POST["numberMesa"]);

$token=NULL;

if(empty($tableAux)||$tableAux==''){
	$list_erro_return[$erroCount]="numberMesa;".$lang->empty_table;
	$erroCount++;
}else{

	$token = new Token();
	$token->setTable($_POST['numberMesa']);

	if($tokenDB->activeTable($token->getTable())){ // if table exist and is active{

		$list_erro_return[$erroCount]="numberMesa;".$lang->unavailable_table;
		$erroCount++;
	}
	
}



if($erroCount>0){

	$server_out["out"] = "erro";
	$server_out["erro_list"] = $list_erro_return;

	echo json_encode($server_out);

}else{



	$server_out = array("out"=>"success");
	do
	{
		$str="";
		$characters = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "L",
				"M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "X", "Z",
				0, 1, 2, 3, 4, 5, 6, 7, 8, 9);

		//generates aleatory code
		for($i=1; $i<7; $i++)
			$str = $str.($characters[mt_rand(0, 32)]);

		$token->setIdToken($str);

		if( $obj = $tokenDB->existsToken($token->getIdToken()) ) //if token exist
			$validator = 1;
		else
		{
			$token->setAvailable(1);
			$result = $tokenDB->insert($token);

			$server_out["token_idToken"] = $token->getIdToken();
			$server_out["token_table"] = $token->getTable();
			$server_out["token_available"] = $token->getAvailable();
			$server_out["result_insert"] = $result;
			echo json_encode($server_out); //return one string for use to at JSON.parse()
		}
	}while($validator);

}
?>
