<?php
include_once "model/Item.class.php";
include_once "model/db/Airfood.class.php";
include_once "model/ItemDB.class.php";
include_once "model/CategoryDB.class.php";
include_once "model/Category.class.php";

class ItemDBTest extends PHPUnit_Framework_TestCase{

	protected static $db;
	protected static $insertedIDs, $categoriesIDs;
	
	public static function setUpBeforeClass(){
		Airfood::initTestMode();
		self::$db = new ItemDB();
		self::$insertedIDs=array();
		self::$categoriesIDs=array();
		
		$dbCategory=new CategoryDB();
		self::$categoriesIDs[]=$dbCategory->insert(Category::withIDAndDesc(0, "Bebidas"));
		self::$categoriesIDs[]=$dbCategory->insert(Category::withIDAndDesc(0, "Comidas Bahiana"));
	}

	public static function tearDownAfterClass(){
		Airfood::finishTestMode();
		self::$db = NULL;
	}
	
	public function testSelectAll(){
		$this->assertNotNull(self::$db->selectAll());
	}
	
	/**
	 *@dataProvider insertProvider
	 *@depends testSelectAll
	 */
	public function testInsert($name, $desc, $price, $qtd_store, $icon, $idCategory, $expectedResult=true){
		$num=count(self::$db->selectAll());
		
		$newItem=Item::creatWithValues(0,$name, $desc, $price, $qtd_store, $icon, self::$categoriesIDs[$idCategory]);
	
		$newId=self::$db->insert($newItem);
	
		
		if(!$expectedResult){
			$this->assertEquals($num,count(self::$db->selectAll()));
		}else{
			$this->assertTrue(($newId>=0)==$expectedResult);
			self::$insertedIDs[]=$newId;
				
			$this->assertEquals($num+1,count(self::$db->selectAll()));
		}
	}
	
	/**
	 *@dataProvider selectByCategoryProvider
	 *@depends testInsert
	 */
	public function testSelectByCategory($idCategory, $expectedResult){
		$this->assertEquals($expectedResult,count(self::$db->selectByCategory(self::$categoriesIDs[$idCategory])));
	}
	
	/**
	 *@depends testInsert
	 */
	public function testSelectOne(){
		foreach(self::$insertedIDs as $id){
			$this->assertNotNull(self::$db->selectOne($id));
		}
	}
	
	/**
	 *@depends testInsert
	 *@dataProvider selectForSearchProvider
	 */
	public function testSelectForSearch($search,$expectedResult){
		
		$this->assertEquals(count(self::$db->selectForSearch($search)), $expectedResult);
		
	}
	
	/**
	 *@depends testInsert
	 *@dataProvider selectForSearchForCateogryProvider
	 */
	public function testSelectForSearchForCateogry($idCategory, $search, $expectedResult){
		
		$this->assertEquals(count(self::$db->selectForSearchForCateogry($search, self::$categoriesIDs[$idCategory])), $expectedResult);
		
	}
	
	/**
	 *@depends testSelectOne
	 */
	public function testUpdate(){
		
		$newName="Acarajé com camarao";
		$newDesc="Comida muito recomendada";
		$newPrice=8;
		$newQtd=300;
		$newIcon="my_image";
		$newIdCategory=self::$categoriesIDs[0];
		
		$id=self::$insertedIDs[0];
		$item=self::$db->selectOne($id);
		
		$item->setName($newName);
		$item->setDesc($newDesc);
		$item->setPrice($newPrice);
		$item->setQtd_storage($newQtd);
		$item->setIcon($newIcon);
		$item->setIdCategory($newIdCategory);
		
		$this->assertTrue(self::$db->update($item));
		
		$alteredItem=self::$db->selectOne($id);
		
		$this->assertEquals($alteredItem->getName(),$newName);
		$this->assertEquals($alteredItem->getDesc(),$newDesc);
		$this->assertEquals($alteredItem->getPrice(),$newPrice);
		$this->assertEquals($alteredItem->getQtd_storage(),$newQtd);
		$this->assertEquals($alteredItem->getIcon(),$newIcon);
		$this->assertEquals($alteredItem->getIdCategory(),$newIdCategory);
	}
	
	
	/**
	 *@depends testInsert
	 */
	public function testRemove(){
		
		$num=count(self::$db->selectAll());
		foreach(self::$insertedIDs as $id){
			
			$this->assertTrue(self::$db->remove($id));
			$this->assertEquals(--$num,count(self::$db->selectAll()));
			
		}
		
	}
	
	//providers
	public function insertProvider(){
		
		return array(
			array("Acarajé","Salvador para comer", 6, 320,"none",1,true),
			array("Cerveja","Bebida álcoolica muito famosa", 3.80, 100,"none",0,true),
			array("Vodka","Bebida álcoolica forte", 8, 200,"none",0,true),
			array("Barcadi","Bebida álcoolica boa", 15, 103,"none",0,true),
			array("Carurú","Comida com muito quiabo", 13, 30,"none",1,true),
			array("Vatapá","Amendoim e camarão", 15, 30,"none",1,true),
			array(" '); delete from items; --","Amendoim e camarão", 15, 30,"none",1,false),
		);
	}
	
	public function selectByCategoryProvider(){
		
		return array(
			array(0,3),
			array(1,3)		
		);
		
	}
	
	public function selectForSearchProvider(){
		return array(
			array("álcool", 3),
			array("BarCaDi",1),
			array(" %'; delete from itens;",0)
		);
	}
	
	public function selectForSearchForCateogryProvider(){
		return array(
			array(0,"álcool",3),
			array(0,"Ice",0),
			array(1,"carurú",1),
			array(1,"minha comida",0),
				
		);
	}
	
}