<?php

Class User{
	
	private $idUser;
	private $name;
	private $userName;
	private $password;
	private $email;
	private $admin;
	
	public function getIdUser(){
		return $this->idUser;
	}
	
	public function setIdUser($id){
		$this->idUser = $id;
	}
	
	public function setAdmin($flag){
		$this->admin = $flag;
	}
	
	public function getAdmin(){
		return $this->admin;
	}

	public function getEmail(){
		return $this->email;
	}
	
	public function setEmail($email){
		$this->email = $email;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function getUserName(){
		return $this->userName;
	}
	
	public function setUserName($userName){
		$this->userName = $userName;
	}
	
	public function getPassword(){
		return $this->password;
	}
	
	public function setPassword($password){
		$this->password = $password;
	}
	
	public function getJSONFormat(){
		$json=array("id"=>$this->getIdUser(),"name"=>$this->getName(), "userName"=>$this->getUserName(), "password"=>$this->getPassword(), "email"=>$this->getEmail(), "admin"=>$this->getAdmin());
		return json_encode($json);
	}
	
	public static function createFromJson($json){
		$aux = json_decode($json);
		$user = new User();
	
		$user->setIdUser($aux->{'id'});
		$user->setName($aux->{'name'});
		$user->setUserName($aux->{'userName'});
		$user->setEmail($aux->{'email'});
		$user->setAdmin($aux->{'admin'});
	
		return $user;
	}	
}
?>