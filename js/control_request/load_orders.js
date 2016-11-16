/*
 * Created by David Pinho on 23/05/2013
 * Ajax implementation for load all orders  
 */
var fCallBack;

function load_orders(callBack,mURL) {
	$.ajax({
		url: mURL,
		dataType: "json",
		success: onSuccessToSelectOrders
	});
	fCallBack=callBack;

}

function onSuccessToSelectOrders(orders) {
	
	for (var i = 0; i < orders.length; i++) {
		var order=JSON.parse(orders[i]);
		fCallBack(order.idOrder,order.item,order.orderTime,order.comment,order.status);
	}
}