/*
 * Ajax implementation for update a new item
 */

function updateToken(response)
{
	var jsonResponse = JSON.parse(response);
	
	
	if (jsonResponse.out=="success") //if was updated
	{		
		var id = jsonResponse.token;
		var table = jsonResponse.table;
		var status = jsonResponse.status;
		var token = jsonResponse.token;
		
		var outStatus=jsonResponse.out_status;
		
		/*
		document.getElementById("row" + id).innerHTML = '<tr class="toggle-row" id="row'+id+'" '
			+'data-table="'+table+ '" '
			+'data-token="'+token+ '" '
			+'data-status="'+status+ '" '
			+'onclick="toogleRow(event,\'row'+id+'\')">'
			+'<td>'+ table+'</td>'
			+'<td>'+ token+'</td>'
			+'<td>'+outStatus+'</td></tr>';
		*/
		
	 document.getElementById("row" + id).setAttribute("data-table", table);
    document.getElementById("row" + id).setAttribute("data-token", token);
    document.getElementById("row" + id).setAttribute("data-status", status);
    document.getElementById("row" + id).setAttribute("onclick", 'toogleRow(event,\'row'+id+'\')');
    
    
    document.getElementById("row" + id).innerHTML ='<td>'+ table	+'</td>'
    +'<td>'+ token+'</td>'
    +'<td>'+ outStatus+'</td>';
	 

		$('#editModal').modal('hide');
		$('#sucess_message').show();
		
		notifyButtons();
	}else {
		for(var i=0;i<jsonResponse.erro_list.length;i++){
			var aux=jsonResponse.erro_list[i].split(";");
			
			reportErroField(aux[0],aux[1]);
		}	
	}	
}

function update_token()
{
	var table = document.getElementById("editTable").value;
	var status;
	if($('#editStatus1').is(':checked'))
		status = 1;
	else 
		status = 0;
		
	var token = document.getElementById("editToken").value;

	var changedTable=0;
	if($("#row"+token).attr("data-table")!=table)
		changedTable=1;
	
	$.ajax({
		type: "post",
		url: "../control/update_token.php",
		data: "table="+table+"&status="+status+"&token="+token+"&changed_table="+changedTable,
		success: updateToken //this function receive the echo php
	});
}
