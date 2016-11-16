<?php
/*
 * This class is responsible for connection the database
 */
class Airfood
{
	#variables for make the connection
	private static $host = 'localhost';
	private static $user = 'root';
	private static $password = '';
	private static $database = 'airfood';
	private static $testConnection, $testFlag;
	
	public static function initTestMode(){
		Airfood::$testFlag=true;
		Airfood::$testConnection=mysqli_connect(self::$host, self::$user, self::$password, self::$database."_test");
		
		mysqli_autocommit(Airfood::$testConnection, FALSE);
	}
	
	#return link connection with the database airfood
	public static function getConnection()
	{
		#attempts to connect to the database and returns an object that represents this connection
		if(!Airfood::$testFlag){
			$link = mysqli_connect(self::$host, self::$user, self::$password, self::$database)
				or die('Failed on the connection with database');
		}else{
			if(Airfood::$testConnection!=NULL){
				$link=Airfood::$testConnection;
			}
		}
		
		return $link;		
	}
	
	#closes the connection to the database, through the parameter $link, which has the link to connect to the database
	public static function closeConnection($link){
		if(!Airfood::$testFlag)
			mysqli_close($link);
	}
	
	public static function finishTestMode(){
		
		Airfood::$testFlag=false;
		mysqli_rollback(Airfood::$testConnection);
		
		mysqli_close(Airfood::$testConnection);
		Airfood::$testConnection=NULL;
	}
	
}
?>
