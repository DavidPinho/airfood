function delete_itens_selected(list_item){

	
	if(!btRemoveEnabled){
		return;
	}
	
	var ids = "";
	
	for(var i=0; i<list_item.length;i++){
		ids += list_item[i];
		if(i<list_item.length - 1){
			ids += ",";
		}
	}
	
	$.ajax({
		url: "../control/remove_itens.php",
		data: "ids="+ids,
		type:"post",
		success : onSuccessToDeleteItens
	});	

}




function onSuccessToDeleteItens(response) {
	
	var rows_id=response.split(",");
	for(var i = 0;i < rows_id.length; i++){
		$("#row" + rows_id[i].trim()).remove();
		selecteds.splice(selecteds.indexOf(rows_id[i]),1);
	}	
	$('#deleteModal').modal('hide');
	$('#delete_message').show();
	
	notifyButtons();
}