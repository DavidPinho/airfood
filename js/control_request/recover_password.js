/*
 * Created by David Pinho on 06/01/2012
 * Ajax implementation for create a new User
 * 
 */


function onRecoverPassword(response){
	   
	var jsonResponse=JSON.parse(response);
       	
	if(jsonResponse.op_code!='erro'){
		
		
		$("#alert-success").html("Your password is "+jsonResponse.pass);
		$("#alert-success").show();
		document.getElementById("userNamePassword").value="";
		
	}else{		

		resetForm();
		
		for(var i=0;i<jsonResponse.erro_list.length;i++){
			var aux=jsonResponse.erro_list[i].split(";");
			
			reportErroField(aux[0],aux[1]);
			
			
		}
		
	}
}


//function called when the user want recover your password
function recover_password() {
	
	
	$('#mainForm').ajaxForm({
	
		success : onRecoverPassword
	});
	

	
	$('#mainForm').attr('action','../control/recover_pass.php');
	
	$('#mainForm').submit();
	
}