<?php

function validate_session_token(){
	
	if(!empty($_SESSION["customer"])){
		
		$tokenDigest=new TokenDigest();
		$tokenDigest->createFromInput($_SESSION["customer"]);
		
		$tokenDigestDB=new TokenDigestDB();
		$tokenDB=new TokenDB();
		
		$token=$tokenDB->getOne($tokenDigest->getToken());
		
		if($token!=null&&$token->getAvailable()){
			return true;
			
		}else{
			$_SESSION["customer"]=NULL;
		}
		
	}else if(!empty($_COOKIE["customer"])){

		$tokenDigestDB=new TokenDigestDB();
		$tokenDB=new TokenDB();
		
		$tokenDigest=new TokenDigest();
		$tokenDigest->createFromInput($_COOKIE["customer"]);
		
		$token=$tokenDB->getOne($tokenDigest->getToken());
		
		
		if($tokenDigestDB->validate($_COOKIE["customer"])&&$token->getAvailable()){

			$_SESSION["customer"]=$_COOKIE["customer"];
			
			return true;
		}else{
			$_COOKIE["customer"]=NULL;
		}
		
	}
	
	return false;
}

?>