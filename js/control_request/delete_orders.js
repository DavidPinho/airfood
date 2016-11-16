function delete_orders_selected(list_order) {

	if (!btRemoveEnabled) {
		return;
	}

	var ids = "";

	for ( var i = 0; i < list_order.length; i++) {
		ids += list_order[i];
		if (i < list_order.length - 1) {
			ids += ",";
		}
	}

	$.ajax({
		url : "../control/remove_orders.php",
		data : "ids=" + ids,
		type : "post",
		success : onSuccessToDeleteOrders
	});
}

function onSuccessToDeleteOrders(response) {

	var rows_id = response.split(",");
	for ( var i = 0; i < rows_id.length; i++) {
		$("#row" + rows_id[i].trim()).remove();
		selecteds.splice(selecteds.indexOf(rows_id[i].trim()), 1);
	}
	$('#deleteModal').modal('hide');

	notifyButtons();
}
