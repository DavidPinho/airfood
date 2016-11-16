
var fCallBack;

function loadCompleteBillDetails(callBack,mURL){
	
	$.ajax({
		url: mURL,
		success: onSuccessToSelect
	});
	
	fCallBack=callBack;
}

function onSuccessToSelect(response) {
	var order_list=JSON.parse(response);
	
	for (var i = 0; i < order_list.length; i++) {
		fCallBack(order_list[i]);
	}
}