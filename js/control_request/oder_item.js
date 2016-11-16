/*
 * Use AJAX for order a item
 */

funcOrderItemCallBack;
function order_item(id_item,qtd,comment,callBack){

	sendData="idItem="+id_item+"&qtd="+qtd;
	if(comment!="")
		sendData+="&comment="+comment;
	
	$.ajax({
		type: "post",
		url: "../../control/order_item_a.php",
		data: sendData,
		success: responseCalback
	});
	funcOrderItemCallBack=callBack;
}


function responseCalback(response){	
	
	jsonResponse=JSON.parse(response);
	
	funcOrderItemCallBack(jsonResponse);
	
	
}

