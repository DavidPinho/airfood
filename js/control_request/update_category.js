/*
 * Ajax implementation for load all created categories for the system
 */

function update_category() {

	$('#mainForm').ajaxForm({
		beforeSubmit : function() {
			$('#btn_cancel').hide();
			$('#btn_create').hide();
			$('#loading_image').show();
		},
		success : onSuccessToUpdate
	});
	$('#mainForm').attr('action', '../control/update_category.php');
	$('#mainForm').submit();

}

function onSuccessToUpdate(response) {

	var jsonResponse = JSON.parse(response);

	if (jsonResponse.op_code != 'erro') {
		var desc = document.getElementById("desc").value;
		var id = document.getElementById("id_category").value;
		var image = jsonResponse.image;

		$("#row" + id).attr("data-desc", desc);
		$("#row" + id).attr("data-id", id);
		$("#row" + id).attr("data-image", image);
		$("#row" + id).attr("onClick", 'toogleRow(event,\'row' + id + '\')');

		$("#row" + id).html(
				'<td>' + id + '</td>' + '<td>' + desc + '</td>' + '<td>0</td>');

		$('#categoryModal').modal('hide');
		$('#btn_cancel').show();
		$('#btn_create').show();
		$('#loading_image').hide();

		$('#sucess_message').show();
		setTimeout(function() {
			$('#sucess_message').hide();
		}, 5000);

		notifyButtons();

	} else {
		resetForm();

		$('#btn_cancel').show();
		$('#btn_create').show();
		$('#loading_image').hide();

		for ( var i = 0; i < jsonResponse.erro_list.length; i++) {
			var aux = jsonResponse.erro_list[i].split(";");

			reportErroField(aux[0], aux[1]);

		}

	}
}
