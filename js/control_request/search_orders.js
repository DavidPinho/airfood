function search_orders() {
	
	
	var search_value=document.getElementById("search_box").value;
	var only_act=0;
	if($('#chk_only_active').is(':checked')){
		only_act=1;
	}
	$("#tableList").find("tr:not(:eq(0))").remove();
	 
	var token= document.getElementById("token").value;
	
	$.ajax({
		type: "get",
		url: "../control/search_orders.php",
		data: "search="+search_value+"&only_act="+only_act+"&idToken="+token,
		success: onSuccessToSearchOrders
	});

	
}

function onSuccessToSearchOrders(orders) {
	
		jsonOrders=JSON.parse(orders);
		
		for (var i = 0; i < jsonOrders.length; i++) {
			var order=JSON.parse(jsonOrders[i]);
			addRow(order.idOrder,order.item,order.orderTime,order.comment,order.status);
		}
		
	
}