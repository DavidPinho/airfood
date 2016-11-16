/*
 * Use AJAX for validate the token
 */

var mFCallBack;

function validate_token(fCallBack){

	
	token_input=$("#token").val();
	if(token_input==''){
		//TODO: Tratar input vazio do token
	}
	
	hash=randomString(20);
	
	mFCallBack=fCallBack;
	
	$.ajax({
		type: "post",
		url: "../../control/auth_token.php",
		data: "auth_token="+token_input.toUpperCase()+"-"+hash,
		success: serverAuthResponse
	});

	
	
}


function serverAuthResponse(response){	
	
	jsonResponse=JSON.parse(response);
	
	if(jsonResponse.op_code=="success"){
		
		var now = new Date();
		var time = now.getTime();
		time += 3*3600 * 1000;
		now.setTime(time);
		document.cookie="customer=" + jsonResponse.token+"; expires="+now.toGMTString();
	}
	
	if(mFCallBack!=null)
		mFCallBack(jsonResponse);

}

