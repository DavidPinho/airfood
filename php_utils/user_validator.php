<?php 
function validateUser($isAdmin=false){
	
	if(isset($_SESSION['user'])){
		$user = User::createFromJson($_SESSION['user']);
	
		if($user==null)
			return false;
		
		
		if($isAdmin){
			if($user->getAdmin()==1)
				return true;
			else
				return false;
		}else{
			return true;
		}
	}else{
		return false;
	}
}
?> 