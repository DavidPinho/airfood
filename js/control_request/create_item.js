/*
 * Ajax implementation for create a new Category
 * 
 */



function onItemCreated(response) {
	

	var jsonResponse=JSON.parse(response);
	
	if(jsonResponse.op_code!='erro'){
		var name=$("#name").val();
		var desc=$("#desc").val();
		var price=$("#price").val();
		var qtd=$("#qtd").val();
		var idCategory=$("#categories").val();
		
		addItemRow(jsonResponse.new_id,name,desc,price,qtd,idCategory,jsonResponse.icon,jsonResponse.status);
		$('#itemModal').modal('hide');
		$('#sucess_message').show();
	}else{
		resetForm();
		
		$('#btn_cancel').show();
		$('#btn_create').show();
		$('#loading_image').hide();
		
		for(var i=0;i<jsonResponse.erro_list.length;i++){
			var aux=jsonResponse.erro_list[i].split(";");
			
			if ((aux[0]=="icon")&&(aux[1]=="erro")){
				$('#wrongImgType_message').show();
			}else{
				reportErroField(aux[0],aux[1]);
			}
			
			
		}
	}
	
}

function createItem() {
	
		
	$('#mainForm').ajaxForm({
		beforeSubmit : function() {
			$('#btn_cancel').hide();
			$('#btn_create').hide();
			$('#loading_image').show();
		},
		success : onItemCreated
	});
	$('#mainForm').attr('action','../control/create_item.php');
	
	$('#mainForm').submit();
	
}

