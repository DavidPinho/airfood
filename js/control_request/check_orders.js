function onSuccessToCheckOrders(response) {
	
	var rows_id=response.split(",");
	for(var i = 0;i < rows_id.length; i++){
		var id="#row" + rows_id[i].trim();
		
		$(id).remove();
		selecteds.splice(selecteds.indexOf(rows_id[i]),1);
	}	
	
	$('#success_message').show();
	
	$('#checkModal').modal('hide');
	
	
	
	notifyButtons();
}

function check_orders_selected(list_order){

	if(!btCheckEnabled){
		return;
	}	
	var ids = "";
	
	for(var i=0; i<list_order.length;i++){
		ids += list_order[i];
		if(i<list_order.length - 1){
			ids += ",";
		}
	}
	
	$.ajax({
		url: "../control/check_orders.php",
		data: "ids="+ids,
		type:"post",
		success : onSuccessToCheckOrders
	});
}


