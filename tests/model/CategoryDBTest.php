<?php

include_once "model/Category.class.php";
include_once "model/db/Airfood.class.php";
include_once "model/CategoryDB.class.php";


class CategoryDBTest extends PHPUnit_Framework_TestCase{

	protected static $db;
	private static $insertedIDs;

	public static function setUpBeforeClass()
	{
		Airfood::initTestMode();
		self::$db = new CategoryDB();
		self::$insertedIDs=Array();
	}

	public static function tearDownAfterClass()
	{
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
	public function testInsert($expectedResult,$desc)
	{
		$num=count(self::$db->selectAll());

		$c=Category::withIDAndDesc(0, $desc);

		$newId=self::$db->insert($c);

		
		if(!$expectedResult){
			$this->assertEquals($num,count(self::$db->selectAll()));
		}else{
			$this->assertTrue(($newId>=0)==$expectedResult);
			self::$insertedIDs[]=$newId;
				
			$this->assertEquals($num+1,count(self::$db->selectAll()));
		}
	}

	/**
	 *@depends testInsert
	 */
	public function testSelectOne(){
		foreach(self::$insertedIDs as $id)
			$this->assertNotNull(self::$db->selectOne($id));
	}

	/**
	 *@depends testInsert
	 *@dataProvider searchProvider
	 */
	public function testSelectForSearch($search,$qtd)
	{
		$r_qtd=count(self::$db->selectForSearch($search));
		$this->assertEquals($r_qtd,$qtd);
	}

	/**
	 *@depends testSelectOne
	 */
	public function testUpdate(){

		$newContent="Petiscos Bahianos";
		$id=self::$insertedIDs[0];
		$c=Category::withIDAndDesc($id, $newContent);

		$this->assertTrue(self::$db->update($c));

		$category=self::$db->selectOne($id);
		$this->assertEquals($category->getDesc(),$newContent);


	}

	/**
	 *@depends testInsert
	 */
	public function testDelete()
	{
		foreach(self::$insertedIDs as $id){
			$num=count(self::$db->selectAll());
			$this->assertTrue(self::$db->remove($id));

			$this->assertEquals($num-1,count(self::$db->selectAll()));
		}
	}

	public function insertProvider()
	{
		return Array(
				Array(true,"Petiscos"),
				Array(true,"Bebidas"),
				Array(true,"Bebidas çlcoolicas"),
				Array(false,"'); delete from category; --"),
		);
	}

	public function searchProvider()
	{
		return Array(
				Array("bebidas",2),
				Array("Bebidas",2),
				Array("BEBIDAS",2),
				Array("BEbidAS",2),
				Array("petiscos",1),
				Array("PETISCOS",1),
				Array("çlcool",1),
				Array(" or 1=1; --",0)
		);
	}

}
?>