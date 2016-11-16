<?php

class Category{
		
	private $id;
	private $desc;
	private $qtd;
	private $image;
	
	
	
	public static function withIDAndDesc($id,$desc){
		$category=new Category();
		
		$category->setId($id);
		$category->setDesc($desc);
		
		return $category;
	}
	
	public function setId($value){
		$this->id=$value;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getImage(){
		return $this->image;
	}
	
	public function setImage($value){
		$this->image = $value;
	}
	
	public function setQtd($value){
		$this->qtd=$value;
	}
	
	public function getQtd(){
		return $this->qtd;
	}
	
	public function setDesc($value){
		$this->desc=$value;
	}
	
	public function getDesc(){
		return $this->desc;
	}
	
	public function getJSONFormat(){
		
		$json=array("id"=>$this->id,"description"=>$this->desc, "qtdeItens"=>$this->qtd, "image"=>$this->image);
		return json_encode($json);
	}
	
	
}

?>