<?php

require_once 'User.class.php';
require_once 'db/Airfood.class.php';

Class UserDB{
	

	public function getUser($userName,$password){
		
		$userName = addslashes($userName);
		$password = addslashes($password);
	
		
		$db_connection = Airfood::getConnection();
		
		$query = "SELECT * FROM user WHERE (username='".$userName."' or email='".$userName."') and password = '".$password."'";
		
		$result = mysqli_query($db_connection, $query);
		
		$user = new User();
		//$user = null;
		while ($row = mysqli_fetch_array($result)){
			$user->setIdUser($row["idUser"]);
			$user->setName($row["name"]);
			$user->setPassword($row["password"]);
			$user->setUserName($row["username"]);
			$user->setEmail($row["email"]);
			$user->setAdmin($row["admin"]);
		}
		
		Airfood::closeConnection($db_connection);
		
		return $user;		
		
	}
	
	public function getUserById($id){
	
		$id = addslashes($id);
		
	
	
		$db_connection = Airfood::getConnection();
	
		$query = "SELECT * FROM user WHERE idUser=".$id;
	
		$result = mysqli_query($db_connection, $query);
	
		$user = new User();
		while ($row = mysqli_fetch_array($result)){
			$user->setIdUser($row["idUser"]);
			$user->setName($row["name"]);
			$user->setPassword($row["password"]);
			$user->setUserName($row["username"]);
			$user->setEmail($row["email"]);
			$user->setAdmin($row["admin"]);
		}
	
		Airfood::closeConnection($db_connection);
	
		return $user;
	
	}
	
	public function getUserByUserName($userName){
	
			
		
		$userName = addslashes($userName);
	
	
	
		$db_connection = Airfood::getConnection();
	
		$query = "SELECT * FROM user WHERE username='".$userName."' or email='".$userName."'";
	
		$result = mysqli_query($db_connection, $query);
	
		$user = new User();
		while ($row = mysqli_fetch_array($result)){
			$user->setIdUser($row["idUser"]);
			$user->setName($row["name"]);
			$user->setPassword($row["password"]);
			$user->setUserName($row["username"]);
			$user->setEmail($row["email"]);
			$user->setAdmin($row["admin"]);
		}
	
		Airfood::closeConnection($db_connection);
	
		return $user;
	
	}
	
	public function getAllUsers(){
	
			
	
		$db_connection = Airfood::getConnection();
	
		$query = "SELECT * FROM user";
	
		$result = mysqli_query($db_connection, $query);
	
		$list = array();
		$i=0;
		
		while ($row = mysqli_fetch_array($result)){
			$user = new User();
			$user->setIdUser($row["idUser"]);
			$user->setName($row["name"]);
			$user->setPassword($row["password"]);
			$user->setUserName($row["username"]);
			$user->setEmail($row["email"]);
			$user->setAdmin($row["admin"]);
			$list[$i] = $user;
			$i++;
		}
	
		Airfood::closeConnection($db_connection);
	
		return $list;
	
	}
	
	public function insert(User $data){
	
		$connection_db=AirFood::getConnection();
	
		$query = "INSERT INTO user (name, username, password, email,admin) VALUES ('{$data->getName()}','{$data->getUserName()}', '{$data->getPassword()}','{$data->getEmail()}', {$data->getAdmin()})";
	
		$result=mysqli_query($connection_db, $query) or die ('Query failed!');
	
		if($result==1){
			$result=mysqli_insert_id($connection_db);
		}else{
			$result="erro";
		}
	
		AirFood::closeConnection($connection_db);
	
		return $result;
	}
	
	public function remove($id){
	
		$connection_db=AirFood::getConnection();
	
		$query = "DELETE FROM user WHERE idUser = $id";
	
		$result = mysqli_query($connection_db, $query) or die ('Query failed!');
	
		AirFood::closeConnection($connection_db);
	
		return $result;
	}
	
	
	public function update(User $user){
		
		$connection_db = Airfood::getConnection();
		
		$query = "UPDATE user set name = '{$user->getName()}' , username = '{$user->getUserName()}', password = '{$user->getPassword()}', email = '{$user->getEmail()}', admin = {$user->getAdmin()} where idUser = {$user->getIdUser()}";
		
		$result=mysqli_query($connection_db, $query) or die ('Query failed!');
		
		if($result==1){
			$result=mysqli_insert_id($connection_db);
		}else{
			$result="erro";
		}
		
		AirFood::closeConnection($connection_db);
		
		return $result;
	}
	
	
	//method to select all the data from the table
	public function selectForSearch($search){
	
		$db_connection = Airfood::getConnection();
	
		$query = "SELECT * FROM user where name LIKE '%{$search}%' or username LIKE '%{$search}%' or email LIKE '%{$search}%'";
		$result = mysqli_query($db_connection, $query);
	
		$allUser = array();
		$i = 0;
	
		while($row = mysqli_fetch_array($result)){
			$user = new User();
	
			$user->setIdUser($row["idUser"]);
			$user->setName($row["name"]);
			$user->setPassword($row["password"]);
			$user->setUserName($row["username"]);
			$user->setEmail($row["email"]);
			$user->setAdmin($row["admin"]);
			$allUser[$i] = $user;
			$i++;
		}
	
		Airfood::closeConnection($db_connection);
	
		return $allUser;
	}
	
	
	
	
}




?>