function addOrder(order){
	$("#order_content tr:last").after(
			'<tr class="toggle-row" id="row' + order.idOrder 
					+ '" data-id="' + order.idOrder
					+ '" data-desc="' + order.description 
					+ '" data-name="' + order.name
					+ '" data-order_time="' + order.order_time
					+ '" data-status="' + order.status
					+ '" data-comments="' + order.comments
					+ '" onclick="toogleRow(event,\'row' + order.idOrder + '\')"><td>'
					+ order.name + '</td><td>' + order.order_time + '</td><td>' + order.comments + '</td><td>' + order.status + '</td></tr>');
}