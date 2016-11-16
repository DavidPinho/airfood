<?php

require_once '../model/OrderItem.class.php';
require_once '../model/db/Airfood.class.php';
require_once '../model/Item.class.php';

class OrderItemDB {

	public function insert(OrderItem $order){

		$connection_db=AirFood::getConnection();

		$query = "INSERT INTO order_item (idItem, order_time, status, comments, idToken) VALUES ({$order->getIdItem()},'{$order->getOrderTime()}',{$order->getStatus()},'{$order->getComment()}','{$order->getIdToken()}')";

		$result=mysqli_query($connection_db, $query) or die ('Query failed!');

		if($result==1){
			$result=mysqli_insert_id($connection_db);
		}else{
			$result=0;
		}
		AirFood::closeConnection($connection_db);

		return $result;
	}

	public function remove($id){

		$connection_db=AirFood::getConnection();

		$query = "DELETE FROM order_item WHERE idOrder =".$id;

		$result = mysqli_query($connection_db, $query) or die ('Query failed!');

		AirFood::closeConnection($connection_db);

		return $result;
	}

	public function selectAll(){

		$db_connection = Airfood::getConnection();

		$query = "SELECT * FROM order_item";
		$result = mysqli_query($db_connection, $query);

		$allItem = array();
		$i = 0;

		while($row = mysqli_fetch_array($result)){

			$allItem[$i]=loadOrderItem($row);

			$i++;
		}

		Airfood::closeConnection($db_connection);

		return $allItem;
	}

	public function selectFormToken($idToken){

		$db_connection = Airfood::getConnection();

		$query = "SELECT item.name,order_item.idOrder,order_item.idItem,order_item.order_time,order_item.status, order_item.comments,order_item.idToken FROM order_item inner join item on order_item.idItem = item.idItem WHERE idToken='$idToken'";
		$result = mysqli_query($db_connection, $query);

		$allItem = array();
		$i = 0;

		while($row = mysqli_fetch_array($result)){
			
			$order = new OrderItem();
			
			$order->setIdOrder($row["idOrder"]);
			$order->setIdItem($row["name"]);
			$order->setOrderTime($row["order_time"]);
			$order->setStatus($row["status"]);
			$order->setComment($row["comments"]);
			$order->setIdToken($row["idToken"]);

			$allItem[$i]= $order;

			$i++;
		}

		Airfood::closeConnection($db_connection);

		return $allItem;
	}
	
	public function selectFormTokenOnlyOpeneds($idToken){
	
		$db_connection = Airfood::getConnection();
	
		$query = "SELECT item.name,order_item.idOrder,order_item.idItem,order_item.order_time,order_item.status, order_item.comments,order_item.idToken FROM order_item inner join item on order_item.idItem = item.idItem WHERE idToken='$idToken' and status = 0";
		$result = mysqli_query($db_connection, $query);
	
		$allItem = array();
		$i = 0;
	
		while($row = mysqli_fetch_array($result)){
				
			$order = new OrderItem();
				
			$order->setIdOrder($row["idOrder"]);
			$order->setIdItem($row["name"]);
			$order->setOrderTime($row["order_time"]);
			$order->setStatus($row["status"]);
			$order->setComment($row["comments"]);
			$order->setIdToken($row["idToken"]);
	
			$allItem[$i]= $order;
	
			$i++;
		}
	
		Airfood::closeConnection($db_connection);
	
		return $allItem;
	}
	

	public function selectForSearch($search,$act,$token){
	
		$db_connection = Airfood::getConnection();
		$query;
		if($act)
			$query = "SELECT item.name,order_item.idOrder,order_item.idItem,order_item.order_time,order_item.status, order_item.comments,order_item.idToken FROM order_item inner join item on order_item.idItem = item.idItem where ((order_item.comments LIKE '%{$search}%' or item.name LIKE '%{$search}%' or order_item.order_time LIKE '%{$search}%') and (idToken='$token') and (status=0))";
		else
			$query = "SELECT item.name,order_item.idOrder,order_item.idItem,order_item.order_time,order_item.status, order_item.comments,order_item.idToken FROM order_item inner join item on order_item.idItem = item.idItem where ((comments LIKE '%{$search}%'  or item.name LIKE '%{$search}%' or order_time LIKE '%{$search}%') and (idToken='$token'))";
			
	
     	$result = mysqli_query($db_connection, $query);
	
		$allItem = array();
		$i = 0;
	
		while($row = mysqli_fetch_array($result)){
				
			$order = new OrderItem();
				
			$order->setIdOrder($row["idOrder"]);
			$order->setIdItem($row["name"]);
			$order->setOrderTime($row["order_time"]);
			$order->setStatus($row["status"]);
			$order->setComment($row["comments"]);
			$order->setIdToken($row["idToken"]);
	
			$allItem[$i]= $order;
	
			$i++;
		}
	
		Airfood::closeConnection($db_connection);
	
		return $allItem;
	}
	
	
	private function loadOrderItem($row){
		$order = new OrderItem();

		$order->setIdOrder($row["idOrder"]);
		$order->setIdItem($row["idItem"]);
		$order->setOrderTime($row["order_time"]);
		$order->setStatus($row["status"]);
		$order->setComment($row["comments"]);
		$order->setIdToken($row["idToken"]);

		return $order;
	}


	public function consultBillFrom($token){
		$db_connection = Airfood::getConnection();

		$query="SELECT order_item.idItem,item.name,item.description,item.price,item.qtd_storage,item.idCategory,item.icon,item.images, count(order_item.idItem) as qtd FROM order_item INNER JOIN item ON order_item.idItem=item.idItem  WHERE order_item.idToken='$token' GROUP BY order_item.idItem";

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
				
			$allItem[$i]=array("item"=>$item, "qtd"=>$row["qtd"]);
				
			$i++;
				
		}

		Airfood::closeConnection($db_connection);

		return $allItem;
	}
	
	public function consultCompleteBillFrom($token){
		$db_connection = Airfood::getConnection();
	
		$query="SELECT order_item.idItem, item.name, item.description, order_item.order_time, order_item.status, order_item.comments, order_item.idOrder FROM order_item INNER JOIN item ON order_item.idItem=item.idItem  WHERE order_item.idToken='$token'";
	
		$result = mysqli_query($db_connection, $query);
	
		$allItem = array();
		$i = 0;
	
		while($row = mysqli_fetch_array($result)){
		
			$order_row=array();
			
			$order_row["idItem"]=$row[0];
			$order_row["name"]=$row[1];
			$order_row["description"]=$row[2];
			$order_row["order_time"]=$row[3];
			$order_row["status"]=$row[4];
			$order_row["comments"]=$row[5];
			$order_row["idOrder"]=$row[6];
			
			
			$allItem[$i]=$order_row;
			$i++;
		}
	
		Airfood::closeConnection($db_connection);
	
		return $allItem;
	}

	public function getOpenOrdersForToken($token){

		$db_connection = Airfood::getConnection();

		$query="SELECT order_item.idOrder, order_item.idItem, order_item.order_time, order_item.status,order_item.comments,order_item.idToken,item.name,item.description,item.price,item.qtd_storage,item.idCategory,item.icon,item.images FROM order_item INNER JOIN item ON order_item.idItem=item.idItem WHERE order_item.idToken='$token' AND order_item.status=0;";
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

			$orderItem=$this->loadOrderItem($row);
			
			$allItem[$i]=array("item"=>$item, "order"=>$orderItem);

			$i++;
			

		}

		Airfood::closeConnection($db_connection);
		
		if($i==0)
			return NULL;
		
		return $allItem;

	}
	
	public function getCountItemOrder($token,$idItem){
		
		$db_connection = Airfood::getConnection();
		
		$query="select count(idItem) as qtd from order_item where idItem=$idItem and idToken='$token' and order_item.status=0;";		
		$result = mysqli_query($db_connection, $query);
		
		$row = mysqli_fetch_array($result);
		
		Airfood::closeConnection($db_connection);
		
		return $row["qtd"];
		
	}
	
	public function confirmOrder($idOrder){
		
		$db_connection = Airfood::getConnection();
		
		$query="UPDATE order_item SET order_item.status=1 WHERE idOrder=$idOrder";
		$result = mysqli_query($db_connection, $query);
		
		Airfood::closeConnection($db_connection);
		
	}


}

?>
