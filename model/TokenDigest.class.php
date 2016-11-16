<?php

class TokenDigest{
	
	private $token;
	private $hash;
	
	public function TokenDigest(){	
	}
	
	public function createFromInput($input){
		
		$values=explode("-", $input);
		$this->token=$values[0];
		$this->hash=$values[1];
		
	}
	
	public function setToken($value){
		$this->token = $value;
	}
	
	public function getToken(){
		return $this->token;
	}
	
	public function setHash($value){
		$this->hash=value;
	}
	
	public function getHash(){
		return $this->hash;
	}
	
	#end setters and getters
	
}

?>