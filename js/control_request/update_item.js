/*
 * Ajax implementation for update a new item
 */

function onItemUpdated(response) {

	var jsonResponse = JSON.parse(response);

	if (jsonResponse.op_code == 'success') {
		var name = $("#name").val();
		var desc = $("#desc").val();
		var price = $("#price").val();
		var qtd = $("#qtd").val();
		var idCategory=$("#categories").val();
		var id=jsonResponse.id;
		var active = jsonResponse.status;
		var icon = jsonResponse.icon;
		
		outStatus="";
		if(active==1){
			outStatus="<span class=\"label label-success\">Ativado</span>";
		}else{
			outStatus="<span class=\"label label-important\">Desativado</span>";
		}
		
		document.getElementById("row" + id).setAttribute("data-id", id);
		document.getElementById("row" + id).setAttribute("data-name", name);
		document.getElementById("row" + id).setAttribute("data-price", price);
		document.getElementById("row" + id).setAttribute("data-qtd", qtd);
		document.getElementById("row" + id).setAttribute("data-status", active);
		document.getElementById("row" + id).setAttribute("data-desc", desc);
		document.getElementById("row" + id).setAttribute("data-idCategory", idCategory);
		document.getElementById("row" + id).setAttribute("data-icon", icon);
		
		document.getElementById("row" + id).setAttribute("onClick",'toogleRow(event,\'row'+id+'\')' );
		
		document.getElementById("row" + id).innerHTML ='<td>'+ id+'</td>'
		+'<td>'+ name+'</td>'
		+'<td>'+ desc+'</td>'
		+'<td>'+ price+'</td>'
		+'<td>' + qtd + '</td>'
		+'<td>'+ outStatus+'</td></tr>';
		
		$('#itemModal').modal('hide');
		$('#sucess_message').show();
		
		notifyButtons();
	} else if(jsonResponse.op_code == 'erro') {

		resetForm();

		$('#btn_cancel').show();
		$('#btn_create').show();
		$('#loading_image').hide();

		for ( var i = 0; i < jsonResponse.erro_list.length; i++) {
			var aux = jsonResponse.erro_list[i].split(";");

			if ((aux[0]=="icon")&&(aux[1]=="erro")){
				$('#wrongImgType_message').show();
			}else{
				reportErroField(aux[0],aux[1]);
			}

		}
	}

}

function updateItem() {
	
	
	$('#mainForm').ajaxForm({
		beforeSubmit : function() {
			$('#btn_cancel').hide();
			$('#btn_create').hide();
			$('#loading_image').show();
		},
		success : onItemUpdated
	});
	$('#mainForm').attr('action', '../control/update_item.php');
	$('#mainForm').submit();
}
