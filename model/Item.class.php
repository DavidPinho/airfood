<?php

class Item{
	private $idItem;
	private $name;
	private $desc;
	private $price;
	private $qtd_storage;
	private $icon;
	private $image;
	private $idCategory;
	private $active;

	//idItem
	public function getIdItem(){
		return $this->idItem;
	}
	public function setIdItem($value){
		$this->idItem = $value;
	}
	//name
	public function getName(){
		return $this->name;
	}

	public function setName($value){
		$this->name = $value;
	}
	//desc
	public function getDesc(){
		return $this->desc;
	}

	public function setDesc($value){
		$this->desc = $value;
	}

	public function setPrice($value){
		$this->price=$value;
	}

	public function getPrice(){
		return $this->price;
	}

	public function setQtd_storage($value){
		$this->qtd_storage=$value;
	}

	public function getQtd_storage(){
		return $this->qtd_storage;
	}
	//icon
	public function getIcon(){
		return $this->icon;
	}

	public function setIcon($value){
		$this->icon = $value;
	}
	//image
	public function getImage(){
		return $this->image;
	}

	public function setImage($value){
		$this->image = $value;
	}

	public function setIdCategory($id){
		$this->idCategory=$id;
	}

	public function getIdCategory(){
		return $this->idCategory;
	}
	
	public function setActive($active){
		$this->active=$active;
	}
	
	public function getActive(){
		return $this->active;
	}
	

	public function getJSONFormat(){
		$json=array("idItem"=>$this->getIdItem(),
				"name"=>$this->getName(),
				"desc"=>$this->getDesc(),
				"price"=>$this->getPrice(),
				"qtd"=>$this->getQtd_storage(),
				"icon"=>$this->getIcon(),
				"image"=>$this->getImage(),
				"idCategory"=>$this->getIdCategory(),
				"active"=>$this->getActive());
		
		return json_encode($json);
	}

	public static function creatWithValues($id,$name,$desc,$price,$qtd_store,$icon,$idCategory,$active){
		
		$item=new Item();
		
		$item->setIdItem($id);
		$item->setName($name);
		$item->setDesc($desc);
		$item->setPrice($price);
		$item->setQtd_storage($qtd_store);
		$item->setIcon($icon);
		$item->setIdCategory($idCategory);
		$item->setActive($active);
	
		return $item;
		
	}
}

?>