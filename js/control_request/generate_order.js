function generate_order()
{
	var item = document.getElementById("item").value;
	var qtd = document.getElementById("qtd").value;
	var token = document.getElementById("token").value;
	
	$.ajax({
			type: "POST",
			url: "../control/generate_order.php",
			data: "item="+item+"&qtd="+qtd+"&token="+token,
			success: function(result) {
				jsonOrders=JSON.parse(result);
				if(jsonOrders.op_code == "sucess"){
					$('#newOrderModal').modal('hide');

					for (var i = 0; i < jsonOrders.order_list.length; i++) {
						var order=JSON.parse(jsonOrders.order_list[i]);
						addRow(order.idOrder, order.item, order.orderTime, order.comment, order.status)
					}
					$('#sucess_message').show();
					setTimeout(function() {
							$('#sucess_message').hide();
					}, 5000);
				}
				else{
					resetForm();
					for(var i=0;i<jsonOrders.erro_list.length;i++){
						var aux=jsonOrders.erro_list[i].split(";");

						if(aux[0] == "item")
							document.getElementById("item").value = "";
						else //if(aux[0] == "qtd")
							document.getElementById("qtd").value = "";

						reportErroField(aux[0],aux[1]);
					}
				}
			}
	});
}