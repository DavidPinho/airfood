<?php

class Token
{
	private $idToken;
	private $table;
	private $available; //reference for table,  active or no
	
	#setters and getters
	public function setIdToken($value)
	{
		$this->idToken = $value;
	}
	
	public function getIdToken()
	{
		return $this->idToken;
	}
	
	
	public function setTable($value)
	{
		$this->table = $value;
	}
	
	public function getTable()
	{
		return $this->table;
	}
	
	
	public function setAvailable($value)
	{
		$this->available = $value;
	}
	
	public function getAvailable()
	{
		return $this->available;
	}
	#end setters and getters
	
	public function getAvailableToName()
	{
		if($this->getAvailable())
			return "OCUPADA";
		else
			return "LIVRE";
	}
	
	//return one string who can be transformed at JSON
	public function getJSONFormat()
	{
		$json=array
		( 
				"table"=>$this->table,
				"idToken"=>$this->idToken,
				"available"=>$this->getAvailable()
		);
	
		return json_encode($json);//transform one array to string for use at JSON.parse
	}
	
}

?>