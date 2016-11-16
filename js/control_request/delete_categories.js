/*
 * Ajax implementation for delete the selecteds categories
 * 
 */

function delete_selected_categories(list_categories) {
	if (!btRemoveEnabled) {
		return;
	}

	var ids = "";
	for ( var i = 0; i < list_categories.length; i++) {
		ids += list_categories[i];
		if (i < list_categories.length - 1)
			ids += ",";
	}

	$.ajax({
		url : "../control/remove_categories.php",
		data : "ids=" + ids,
		dataType : "json",
		type : "post",
		success : onSuccessToDeleteCategories
	});
}

function onSuccessToDeleteCategories(response) {
	
	if (response.op_code == "all_deleted") {
		$('#delete_message').show();
	}else{
		$('#erro_message').show();		
	}
	
	var rows_id = response.deleteds;

	for ( var i = 0; i < rows_id.length; i++) {
		$("#row" + rows_id[i].trim()).remove();
		selecteds.splice(selecteds.indexOf(rows_id[i]), 1);
	}
	
	$('#deleteModal').modal('hide');

	notifyButtons();
	
}
