/*
 * Ajax implementation for save configurations
 */

function save_configuration() {
	
	language=$("#language").val();
	
	$.ajax({
		url : "../control/save_configuration.php",
		data : "language=" + language,
		type : "get",
		success : onSuccessToSave
	});
	
}

function onSuccessToSave(response){
	
	response=$.trim(response);
	if(response=="success"){
		$('#sucess_message').show();
	}
	
}