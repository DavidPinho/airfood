/*
 * Ajax implementation for create a new Category
 * 
 */

//function called when the user click the button create
function create_category() {
	

	$('#mainForm').ajaxForm({
		beforeSubmit : function() {
			$('#btn_cancel').hide();
			$('#btn_create').hide();
			$('#loading_image').show();
		},
		success : onSuccessToCreate
	});
	$('#mainForm').attr('action','../control/create_category.php');
	
	$('#mainForm').submit();
}

function onSuccessToCreate(response){
	
   
	var jsonResponse=JSON.parse(response);
	
	if(jsonResponse.op_code!='erro'){
		$('#categoryModal').modal('hide');
		$('#btn_cancel').show();
		$('#btn_create').show();
		$('#loading_image').hide();
		
		var desc=$("#desc").val();
		addRow(jsonResponse.new_id,desc,0,jsonResponse.image);
		$('#categoryModal').modal('hide');		
		$('#sucess_message').show();
		setTimeout(function() {
				$('#sucess_message').hide();	
		}, 5000);
		
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