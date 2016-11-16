/*
 * Created by David Pinho on 06/01/2012
 * Ajax implementation for create a new User
 * 
 */


function onUserCreated(response){
 	
    var jsonResponse=JSON.parse(response);
    	
	if(jsonResponse.op_code!='erro'){
		
		var name=$("#name").val();
		var userName=$("#userName").val();
		var password=$("#password").val();
		var email=$("#email").val();
		var admin = $("#is_adm").val();
		
		
		addRow(jsonResponse.new_id,name,userName,password,email,admin);
		$('#userModal').modal('hide');
		$('#sucess_message').show();
	}else{
		
		resetForm();
		$('#btn_cancel').show();
		$('#btn_create').show();
		$('#loading_image').hide();
		
		for(var i=0;i<jsonResponse.erro_list.length;i++){
			var aux=jsonResponse.erro_list[i].split(";");
			
			reportErroField(aux[0],aux[1]);
			
			
		}
	}
}


//function called when the user click the button create
function create_user() {
	
	
	$('#mainForm').ajaxForm({
	beforeSubmit : function() { 
			$('#btn_cancel').hide();			
			$('#btn_create').hide();
			$('#loading_image').show();
		},
		success : onUserCreated
	});
	

	
	$('#mainForm').attr('action','../control/create_user.php');
	
	$('#mainForm').submit();
	
}