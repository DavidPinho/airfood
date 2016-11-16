function generate_token(){
	var numberMesa = document.getElementById("numberMesa").value; //getElementById retrieves id tags in the html
	
	$.ajax({
		type: "post",
		url: "../control/generate_token.php",
		data: "numberMesa="+numberMesa,
		success: showToken
	});

}

function showToken(echos){	
	
	var jsonToken = JSON.parse(echos);
		
	if(jsonToken.out=="success"){		
		//after has generated token
		
		//generateModal will be closed
		$('#generateModal').modal('hide');
		addRow(jsonToken.token_table, jsonToken.token_idToken, jsonToken.token_available);
		
		$('#sucessMessageModal').modal('show');
		document.getElementById("sucess_m").innerHTML = "Gerado token "+jsonToken.token_idToken+" para a mesa "+jsonToken.token_table+".";

	}else{
		for(var i=0;i<jsonToken.erro_list.length;i++){
			var aux=jsonToken.erro_list[i].split(";");
			
			reportErroField(aux[0],aux[1]);
		}	
	}	
}

