/*
 * Ajax implementation for update a new item
 */

function onUserUpdated(response) {

	var jsonResponse = JSON.parse(response);
	
	if (jsonResponse.op_code != 'erro') {
		$('#sucess_message').show();
		
		var name = $("#name").val();
		var userName = $("#userName").val();
		var password = $("#password").val();
		var email = $("#email").val();
		var admin = $("#is_adm").val();
		var id=jsonResponse.new_id;
		
		document.getElementById("row"+id).setAttribute("data-id", id);
		document.getElementById("row"+id).setAttribute("data-name", name);
		document.getElementById("row"+id).setAttribute("data-userName", userName);
		document.getElementById("row"+id).setAttribute("data-email", email);
		document.getElementById("row"+id).setAttribute("data-password", password);
		document.getElementById("row"+id).setAttribute("data-admin", admin);
		document.getElementById("row"+id).setAttribute("onClick", 'toogleRow(event,\'row'+ id+'\')');
		
		document.getElementById("row" + id).innerHTML = 
				'<td>'+ id+ '</td>'
				+'<td>'+ name+'</td>'
				+'<td>'+ userName+'</td>'
				+'<td>'+ email+'</td>'
				+'<td><button id="btn-password" class="btn btn-info" onclick="openPasswordDialog(\''+password+'\')"><i class="icon-tag icon-white"></i></button></td></tr>';

		
		$('#userModal').modal('hide');
		$('#sucess_message').show();
		
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

function updateUser() {

	$('#mainForm').ajaxForm({
		beforeSubmit : function() {
			$('#btn_cancel').hide();
			$('#btn_create').hide();
			$('#loading_image').show();
		},
		success : onUserUpdated
	});
	$('#mainForm').attr('action', '../control/update_user.php');
	$('#mainForm').submit();
}
