<?php

require_once 'db/Airfood.class.php';
require_once 'Token.class.php';

class TokenDB
{
	#insert data in the table token, pass an object with the values ​​you want to insert
	public function insert(Token $data)
	{
		#link connection for database
		$link = Airfood::getConnection();

		#query
		$query = "INSERT INTO token (idToken, token.table, available) VALUES ('{$data->getIdToken()}', '{$data->getTable()}',
		'{$data->getAvailable()}')";

		//return $query; verificando erro na query

		#execute query in the database and return result da query
		$result = mysqli_query($link, $query)
		or die("erro na query insert");

		#close connection with database
		Airfood::closeConnection($link);

		#return result the query(true or false)
		return $result;
	}

	//return obj of token
	public function getOne($id)
	{
		$link = Airfood::getConnection();

		$query = "SELECT * FROM token WHERE idToken='{$id}' ";

		$result = mysqli_query($link, $query)
		or die("erro na query getOne");

		$token=null;
		while ($row = mysqli_fetch_array($result) )
		{
			$token = $this->createFromRow($row);

		}

		Airfood::closeConnection($link);

		return $token;
	}

	//if found, return 1
	public function existsToken($idToken)
	{
		$link = Airfood::getConnection();

		$query = "SELECT * FROM token WHERE idToken='{$idToken}'";

		$result = mysqli_query($link, $query)
		or die("erro na query getOne");

		$token = new Token();
		while ($row = mysqli_fetch_array($result) )
		{
				Airfood::closeConnection($link);
				return 1;
			
		}

		Airfood::closeConnection($link);

		return 0;
	}

	//verify if the table is active
	public function activeTable($table)
	{
		$link = Airfood::getConnection();

		$query = "SELECT * FROM token WHERE token.table='{$table}' AND available=1";

		$result = mysqli_query($link, $query);

		$token = new Token();
		while ($row = mysqli_fetch_array($result) )
		{
				Airfood::closeConnection($link);
				return 1;	
		}
			
		Airfood::closeConnection($link);
		return 0;
	}
	
	//verify if change in the register the table (table) is possible
	//???fazer testes com calma????????
	public function changeQueryTable($table)
	{
		$link = Airfood::getConnection();
	
		$query = "SELECT * FROM token WHERE token.table='{$table}' AND available='{$status}'";
	
		$result = mysqli_query($link, $query);
	
		$token = new Token();
		while ($row = mysqli_fetch_array($result) )
		{
			Airfood::closeConnection($link);
			if($status)
				return 0;
			else
				return 1;
		}
			
		Airfood::closeConnection($link);
		return 1;
	}

	//verify if change in the register the table (table) is possible
	//???fazer testes com calma????????
	public function isTableAvailable($table)
	{
		$link = Airfood::getConnection();
	
		$query = "SELECT * FROM token WHERE token.table='{$table}' AND available=1";
	
		$result = mysqli_query($link, $query);
	
		$token = new Token();
		if ($row = mysqli_fetch_array($result) ){
			Airfood::closeConnection($link);
			return false;
		}
			
		Airfood::closeConnection($link);
		return true;
	}

	//method to select all the data from the table according the search field
	public function selectForSearch($search, $only_act)
	{

		$db_connection = Airfood::getConnection();

		$query;
		if($only_act)
			$query = "SELECT * FROM token WHERE (idToken LIKE '%{$search}%' or token.table LIKE '%{$search}%') and available={$only_act}";
		else
			$query = "SELECT * FROM token WHERE idToken LIKE '%{$search}%' or token.table LIKE '%{$search}%'";
		
		$result = mysqli_query($db_connection, $query);

		$allToken = array();
		$i = 0;

		while($row = mysqli_fetch_array($result)){
			$allToken[$i] = $this->createFromRow($row);
			$i++;
		}

		Airfood::closeConnection($db_connection);

		return $allToken;
	}


	#return all register the table
	public function getAll()
	{
		$link = Airfood::getConnection();

		$query = "SELECT * FROM token";

		$result = mysqli_query($link, $query)
		or die("erro na query getAll");

		#created one array for salve the objects do tipo Token
		$allToken = array();

		#counter
		$i = 0;

		while ($row = mysqli_fetch_array($result) )
		{
			$allToken[$i] = $this->createFromRow($row);
			$i += 1;
		}

		Airfood::closeConnection($link);

		return $allToken;
	}

	#return all avaiable tables
	public function getAllAvailable()
	{
		$link = Airfood::getConnection();

		$query = "SELECT * FROM token WHERE available=1";

		$result = mysqli_query($link, $query)
		or die("erro na query getAll");

		#created one array for salve the objects do tipo Token
		$allToken = array();

		#counter
		$i = 0;

		while ($row = mysqli_fetch_array($result) )
		{
			$allToken[$i] = $this->createFromRow($row);
			$i++;
		}

		Airfood::closeConnection($link);

		return $allToken;
	}


	#delete one register the table
	public function deleteOne($idToken)
	{
		$link = Airfood::getConnection();

		$query = "DELETE FROM token WHERE idToken='{$idToken}' ";

		$result = mysqli_query($link, $query)
		or die("erro na query deleteOne");

		Airfood::closeConnection($link);

		return $result;
	}


	#update register the table token, pass an object with the values ​​you want to upgrade
	public function update(Token $data){
		$link = Airfood::getConnection();

		$query = "UPDATE token SET token.table='{$data->getTable()}', available={$data->getAvailable()} WHERE idToken='{$data->getIdToken()}' ";
		
		$result = mysqli_query($link, $query);

		Airfood::closeConnection($link);

		return $result;
	}

	public function getActiveTokens(){

		$db_connection = Airfood::getConnection();

		$query = "SELECT * FROM token WHERE available=1";
		$result = mysqli_query($db_connection, $query);

		$allToken = array();
		$i = 0;

		while($row = mysqli_fetch_array($result)){
			$allToken[$i] = $this->createFromRow($row);
			$i++;
		}

		Airfood::closeConnection($db_connection);

		return $allToken;
	}

	private function createFromRow($row){
		$token = new Token();
			
		$token->setAvailable($row["available"]);
		$token->setIdToken($row["idToken"]);
		$token->setTable($row["table"]);

		return $token;
	}

}
?>