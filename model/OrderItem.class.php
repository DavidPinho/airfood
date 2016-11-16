<?php

class OrderItem{
	
	private $idOrder;
	private $idItem;
	private $qtd;
	private $orderTime;
	private $status;
	private $comment;
	private $idToken;
	
	public function setIdOrder($value){
		$this->idOrder=$value;
	}
	
	public function getIdOrder(){
		return $this->idOrder;
	}
	
	public function setIdItem($value){
		$this->idItem=$value;
	}
	
	public function getIdItem(){
		return $this->idItem;
	}
	
	public function setQtd($value){
		$this->qtd=$value;
	}
	
	public function getQtd(){
		return $this->qtd;
	}
	
	public function setOrderTime($value){
		$this->orderTime=$value;
	}
	
	public function getOrderTime(){
		return $this->orderTime;
	}
	
	public function setStatus($value){
		$this->status=$value;
	}
	
	public function getStatus(){
		return $this->status;
	}
	
	public function setComment($value){
		$this->comment=$value;
	}
	
	public function getComment(){
		return $this->comment;
	}
	
	public function setIdToken($value){
		$this->idToken=$value;
	}
	
	public function getIdToken(){
		return $this->idToken;
	}
	
	public function getJSONFormat(){
		
		 
		$json=array("idOrder"=>$this->getIdOrder(),
				"item"=>$this->getIdItem(),
				"orderTime"=>$this->getOrderTime(),
				"status"=>$this->getStatus(),
				"qtd"=>$this->getQtd(),
				"comment"=>$this->getComment(),
				"idToken"=>$this->getIdToken());
	
		return json_encode($json);
	}
	
	
}

?>