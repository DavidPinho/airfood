<?php

@include_once 'Category.class.php';
@include_once 'db/Airfood.class.php';

class CategoryDB {

	public function insert(Category $data){

		$connection_db=AirFood::getConnection();

		$query = "INSERT INTO category (description,images) VALUES ('{$data->getDesc()}', '{$data->getImage()}')";

		$result=mysqli_query($connection_db, $query) ;

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

		$query = "DELETE FROM category WHERE idCategory =".$id;

		
		$result=mysqli_query($connection_db, $query);

		AirFood::closeConnection($connection_db);
		
		
		return $result;
	}


	//method to select all the data from the table
	public function selectAll(){

		$db_connection = Airfood::getConnection();

		# $query = "SELECT COUNT( item.idCategory ) AS cont, category.description, category.idCategory , category.images FROM  `category` LEFT JOIN item ON category.idCategory = item.idCategory GROUP BY category.idCategory order by cont desc";
		$query = "SELECT COUNT( item.idCategory ) AS cont, category.description, category.idCategory FROM  `category` LEFT JOIN item ON category.idCategory = item.idCategory GROUP BY category.idCategory order by cont desc";
		$result = mysqli_query($db_connection, $query);

		$allCategory = array();
		$i = 0;

		while($row = mysqli_fetch_array($result)){
			$category = new Category();
				
			$category->setDesc($row["description"]);
			$category->setId($row["idCategory"]);
			$category->setQtd($row["cont"]);
			# $category->setImage($row["images"]);

			$allCategory[$i] = $category;
				
			$i++;
		}

		Airfood::closeConnection($db_connection);

		return $allCategory;
	}
	
	//method to select all the data from the table
	public function selectForSearch($search){
	
		$db_connection = Airfood::getConnection();
	
		$query = "SELECT count(item.idCategory) as cont, category.description, category.idCategory  FROM category LEFT JOIN item ON category.idCategory = item.idCategory where category.description LIKE '%{$search}%' GROUP BY category.idCategory order by cont desc";
		$result = mysqli_query($db_connection, $query);
	
		$allCategory = array();
		$i = 0;
	
		while($row = mysqli_fetch_array($result)){
			$category = new Category();
	
			$category->setDesc($row["description"]);
			$category->setId($row["idCategory"]);
			$category->setQtd($row["cont"]);
			$category->setImage($row["images"]);
	
			$allCategory[$i] = $category;
	
			$i++;
		}
	
		Airfood::closeConnection($db_connection);
	
		return $allCategory;
	}

	//method to select data from the table with the id as search paramether
	public function selectOne($idCategory){

		$db_connection = Airfood::getConnection();

		$query = "SELECT * FROM category WHERE idCategory={$idCategory}";
		$result = mysqli_query($db_connection, $query);
		$category=NULL;
		while ($row = mysqli_fetch_array($result)){
			$category = new Category();
				
			$category->setDesc($row["description"]);
			$category->setId($row["idCategory"]);
			$category->setImage($row["images"]);
		}

		Airfood::closeConnection($db_connection);

		return $category;
	}
	
	public function getQtdItensByCategory($idCategory){
	
		$db_connection = Airfood::getConnection();
	
		$query = "SELECT * FROM category inner join item on category.idcategory = item.idcategory where item.idcategory ={$idCategory}";
		$result = mysqli_query($db_connection, $query);
		$cont = 0;
		while ($row = mysqli_fetch_array($result)){
			$cont++;
		}
	
		Airfood::closeConnection($db_connection);
	
		return $cont;
	}
	
	
	
	public function selectOneByDesc($desc){
	
		$db_connection = Airfood::getConnection();
	
		$query = "SELECT * FROM category WHERE description ='{$desc}' limit 1";
		$result = mysqli_query($db_connection, $query);
	
		$category = new Category();
	
		while ($row = mysqli_fetch_array($result)){
			$category->setDesc($row["description"]);
			$category->setId($row["idCategory"]);
			$category->setImage($row["images"]);
		}
	
	
		Airfood::closeConnection($db_connection);
	
		return $category;
	}

	public function update(Category $data){

		$connection_db=AirFood::getConnection();

		$query = "UPDATE category SET description='{$data->getDesc()}', images='{$data->getImage()}' WHERE idCategory = '{$data->getId()}'";

		$result = mysqli_query($connection_db, $query) or die ('Query failed!');

		AirFood::closeConnection($connection_db);

		return $result;
	}

}

?>