/*
 * Created by David Pinho on 06/01/2012
 * Ajax implementation for create a new User
 * 
 */


function onUserAuthenticate(response){
    var jsonResponse=JSON.parse(response);
    	
	if(jsonResponse.op_code!='erro'){
		
		window.location="dashboard.php";
	
	}else{
		
		resetForm();
				
		for(var i=0;i<jsonResponse.erro_list.length;i++){
			var aux=jsonResponse.erro_list[i].split(";");
			
			reportErroField(aux[0],aux[1]);
			
			
		}
	}
}


//function called when the user click the button create
function authenticate_user() {
	
	
	$('#mainForm').ajaxForm({
	
		success : onUserAuthenticate
	});
	

	
	$('#mainForm').attr('action','../control/authenticate.php');
	
	$('#mainForm').submit();
	
}