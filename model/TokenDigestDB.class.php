<?php

require_once 'db/Airfood.class.php';

class TokenDigestDB
{
	
	public function insert(TokenDigest $digest){

		$link = Airfood::getConnection();
	
		$query = "INSERT INTO token_digest(token,token_digest.hash)VALUES('{$digest->getToken()}','{$digest->getHash()}');";		
		$result = mysqli_query($link, $query);
		
		Airfood::closeConnection($link);
		
		return $result;
	}
	
	public function getOne($token){
		$link = Airfood::getConnection();

		$query = "SELECT * FROM token_digest WHERE token='{$token}' ";

		$result = mysqli_query($link, $query)
			or die("erro na query getOne");
		
		$tokenDigest = null;
		while ($row = mysqli_fetch_array($result) ){		
			
			$tokenDigest=new TokenDigest();
			
			$tokenDigest->setToken($row["token"]);
			$tokenDigest->setHash($row["hash"]);
			
		}
		
		Airfood::closeConnection($link);
		
		return $tokenDigest;
	}
	
	#delete one register the table
	public function deleteOne($token){
		$link = Airfood::getConnection();
		
		$query = "DELETE FROM token_digest WHERE token='{$token}' ";
		
		$result = mysqli_query($link, $query)
			or die("erro na query deleteOne");
		
		Airfood::closeConnection($link);
		
		return $result;
	}
	
	public function validate($token_digest){
		
		$token_parts=explode("-", $token_digest);
		
		$link = Airfood::getConnection();
		
		$query = "SELECT * FROM token_digest WHERE token='{$token_parts[0]}' and  token_digest.hash='{$token_parts[1]}'";
		
		$result = mysqli_query($link, $query);
		
		if(mysqli_num_rows($result)>0){
			return true;
		}
		
		return false;
		
	}
	
}
?>