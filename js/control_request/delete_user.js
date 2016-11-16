function delete_users_selected(list_user){

	
	if(!btRemoveEnabled){
		return;
	}
	
	var ids = "";
	
	for(var i=0; i<list_user.length;i++){
		ids += list_user[i];
		if(i<list_user.length - 1){
			ids += ",";
		}
	}
	
	$.ajax({
		url: "../control/remove_users.php",
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