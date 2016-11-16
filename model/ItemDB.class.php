<?php
@include_once '../model/Item.class.php';
@include_once '../model/db/Airfood.class.php';


class ItemDB{

	public function insert(Item $data){

		$connection_db=AirFood::getConnection();

		$query = "INSERT INTO item (name, description, price, qtd_storage, icon, images,idCategory,active) VALUES ('{$data->getName()}','{$data->getDesc()}', {$data->getPrice()}, {$data->getQtd_storage()}, '{$data->getIcon()}', '{$data->getImage()}', {$data->getIdCategory()}, {$data->getActive()})";

		$result=mysqli_query($connection_db, $query) or die ('Query failed!');

		if($result==1){
			$result=mysqli_insert_id($connection_db);
		}else{
			$result="erro";
		}

		AirFood::closeConnection($connection_db);

		return $result;
	}


	public function qtdeItensCategory($id_category)
	{
	  
		$connection_db=AirFood::getConnection();

		$query = "SELECT count(*) as c FROM item where idCategory=$id_category";

		$result=mysqli_query($connection_db, $query);
		
		$cont = 0;
		
		while ($row = mysqli_fetch_array($result))
			$cont =  $row["c"];		
		
		Airfood::closeConnection($connection_db);
		
		return $cont;
			
	}
	
	
	
	
	public function selectOneByDesc($desc){
	
		$db_connection = Airfood::getConnection();
	
		$query = "SELECT * FROM item WHERE name ='{$desc}' limit 1";
		$result = mysqli_query($db_connection, $query);
	
		$item = new Item();
	
		while ($row = mysqli_fetch_array($result)){
			$item->setName($row['name']);
			$item->setIdItem($row['idItem']);
		}
	
	
		Airfood::closeConnection($db_connection);
	
		return $item;
	}


	public function remove($id){

		$connection_db=AirFood::getConnection();

		$query = "DELETE FROM item WHERE idItem = $id";

		$result = mysqli_query($connection_db, $query) or die ('Query failed!');

		AirFood::closeConnection($connection_db);

		return $result;
		
	}
	
	public function disable($id){
	
		$connection_db=AirFood::getConnection();
	
		$query = "update item set active = false WHERE idItem = $id";
	
		$result = mysqli_query($connection_db, $query) or die ('Query failed!');
	
		AirFood::closeConnection($connection_db);
	
		return $result;
	
	}

	public function selectAll(){

		$db_connection = Airfood::getConnection();

		$query = "SELECT * FROM item";
		$result = mysqli_query($db_connection, $query);

		$allItem = array();
		$i = 0;

		while($row = mysqli_fetch_array($result)){
			$item = new Item();

			$item->setIdItem($row["idItem"]);
			$item->setName($row["name"]);
			$item->setDesc($row["description"]);
			$item->setPrice($row["price"]);
			$item->setQtd_storage($row["qtd_storage"]);
			$item->setIcon($row["icon"]);
			$item->setImage($row["images"]);
			$item->setIdCategory($row["idCategory"]);
			$item->setActive($row["active"]);
				

			$allItem[$i] = $item;

			$i++;
		}

		Airfood::closeConnection($db_connection);

		return $allItem;
	}
	
	public function selectAllActives(){
	
		$db_connection = Airfood::getConnection();
	
		$query = "SELECT * FROM item where active =true";
		$result = mysqli_query($db_connection, $query);
	
		$allItem = array();
		$i = 0;
	
		while($row = mysqli_fetch_array($result)){
			$item = new Item();
	
			$item->setIdItem($row["idItem"]);
			$item->setName($row["name"]);
			$item->setDesc($row["description"]);
			$item->setPrice($row["price"]);
			$item->setQtd_storage($row["qtd_storage"]);
			$item->setIcon($row["icon"]);
			$item->setImage($row["images"]);
			$item->setIdCategory($row["idCategory"]);
			$item->setActive($row["active"]);
	
	
			$allItem[$i] = $item;
	
			$i++;
		}
	
		Airfood::closeConnection($db_connection);
	
		return $allItem;
	}

	public function selectByCategory($idCategory){

		$db_connection = Airfood::getConnection();

		$query = "SELECT * FROM item WHERE idCategory={$idCategory} and active = true";
		$result = mysqli_query($db_connection, $query);

		$allItem = array();
		$i = 0;

		while($row = mysqli_fetch_array($result)){
			$item = new Item();

			$item->setIdItem($row["idItem"]);
			$item->setName($row["name"]);
			$item->setDesc($row["description"]);
			$item->setPrice($row["price"]);
			$item->setQtd_storage($row["qtd_storage"]);
			$item->setIcon($row["icon"]);
			$item->setImage($row["images"]);
			$item->setIdCategory($row["idCategory"]);
			$item->setActive($row["active"]);


			$allItem[$i] = $item;

			$i++;
		}

		Airfood::closeConnection($db_connection);

		return $allItem;
	}

	public function selectForSearch($search,$act){

		$db_connection = Airfood::getConnection();
		$query;
		if($act)
		  $query = "SELECT * FROM item where (description LIKE '%{$search}%' or name LIKE '%{$search}%') and (active = {$act})";
		else
			$query = "SELECT * FROM item where description LIKE '%{$search}%' or name LIKE '%{$search}%'";
		
		$result = mysqli_query($db_connection, $query);

		$allItem = array();
		$i = 0;

		while($row = mysqli_fetch_array($result)){
			$item = new Item();

			$item->setIdItem($row["idItem"]);
			$item->setName($row["name"]);
			$item->setDesc($row["description"]);
			$item->setPrice($row["price"]);
			$item->setQtd_storage($row["qtd_storage"]);
			$item->setIcon($row["icon"]);
			$item->setImage($row["images"]);
			$item->setIdCategory($row["idCategory"]);
			$item->setActive($row["active"]);

			$allItem[$i] = $item;

			$i++;
		}

		Airfood::closeConnection($db_connection);

		return $allItem;
	}

	public function selectForSearchForCateogry($search,$idCategory,$act){

		$db_connection = Airfood::getConnection();
		$query;
		if($act)
		  $query = "SELECT * FROM item where description LIKE '%{$search}%' or name LIKE '%{$search}%' and idCategory={$idCategory} and active = {$act}";
		else 
			$query = "SELECT * FROM item where description LIKE '%{$search}%' or name LIKE '%{$search}%' and idCategory={$idCategory}";
		$result = mysqli_query($db_connection, $query);

		$allItem = array();
		$i = 0;

		while($row = mysqli_fetch_array($result)){
			$item = new Item();

			$item->setIdItem($row["idItem"]);
			$item->setName($row["name"]);
			$item->setDesc($row["description"]);
			$item->setPrice($row["price"]);
			$item->setQtd_storage($row["qtd_storage"]);
			$item->setIcon($row["icon"]);
			$item->setImage($row["images"]);
			$item->setIdCategory($row["idCategory"]);
			$item->setActive($row["active"]);

			$allItem[$i] = $item;

			$i++;
		}

		Airfood::closeConnection($db_connection);

		return $allItem;
	}
	

	//nova funcao para autocomplete no adicionar pedidos
	public function selectForSearchAutocomplete($search){

		$db_connection = Airfood::getConnection();
		$query;
		
		$query = "SELECT * FROM item where name LIKE '{$search}%' and active='1' ";
		
		$result = mysqli_query($db_connection, $query);

		$allItem = array();
		$i = 0;

		while($row = mysqli_fetch_array($result)){
			$item = new Item();

			$item->setIdItem($row["idItem"]);
			$item->setName($row["name"]);
			$item->setDesc($row["description"]);
			$item->setPrice($row["price"]);
			$item->setQtd_storage($row["qtd_storage"]);
			$item->setIcon($row["icon"]);
			$item->setImage($row["images"]);
			$item->setIdCategory($row["idCategory"]);
			$item->setActive($row["active"]);

			$allItem[$i] = $item;

			$i++;
		}

		Airfood::closeConnection($db_connection);

		return $allItem;
	}
	
	
	
	

	public function selectOne($id){

		$db_connection = Airfood::getConnection();

		$query = "SELECT * FROM item WHERE idItem={$id}";
		$result = mysqli_query($db_connection, $query);

		while($row = mysqli_fetch_array($result)){
			$item = new Item();

			$item->setIdItem($row["idItem"]);
			$item->setName($row["name"]);
			$item->setDesc($row["description"]);
			$item->setPrice($row["price"]);
			$item->setQtd_storage($row["qtd_storage"]);
			$item->setIcon($row["icon"]);
			$item->setImage($row["images"]);
			$item->setIdCategory($row["idCategory"]);
			$item->setActive($row["active"]);
		}

		Airfood::closeConnection($db_connection);

		return $item;
	}
	
	//return id the item selected
	public function selectOneByName($name){

		$db_connection = Airfood::getConnection();

		$query = "SELECT idItem FROM item WHERE name='{$name}'";
		$result = mysqli_query($db_connection, $query);

		$item = new Item();//na logica só exite um unico ITEM de nome X 
		while($row = mysqli_fetch_array($result)){
			$item->setIdItem($row["idItem"]);
		}

		Airfood::closeConnection($db_connection);
		
		if($result)
			return $item->getIdItem();
		else
			return 0;
		
	}
	
	
	public function selectOneByNameIsActive($name){

		$db_connection = Airfood::getConnection();

		$query = "SELECT idItem FROM item WHERE name='{$name}' and active='1'";
		$result = mysqli_query($db_connection, $query);

		$item = new Item();//na logica só exite um unico ITEM de nome X 
		while($row = mysqli_fetch_array($result)){
			$item->setIdItem($row["idItem"]);
		}

		Airfood::closeConnection($db_connection);
		
		if($result)
			return $item->getIdItem();
		else
			return 0;
		
	}
	

	public function update(Item $data){

		$connection_db=AirFood::getConnection();

		$query = "UPDATE item SET name='{$data->getName()}', description='{$data->getDesc()}', idCategory={$data->getIdCategory()}, price={$data->getPrice()},
		qtd_storage={$data->getQtd_storage()}, icon='{$data->getIcon()}', images='{$data->getImage()}', active={$data->getActive()} WHERE idItem = {$data->getIdItem()}";

		$result = mysqli_query($connection_db, $query) or die ('Query failed!');

		AirFood::closeConnection($connection_db);

		return $result;
	}

}

?>