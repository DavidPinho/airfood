/*
 * Ajax implementation for load all created itens for the system
 */

var fItensCallBack;
var fEndCalback;

function load_itens(callBackAdd,mURL,endCalback) {

	$.ajax({
		url: mURL,
		dataType: "json",
		success: onSuccessToList
	});
	fItensCallBack=callBackAdd;
	fEndCalback=endCalback;
	
}

function onSuccessToList(itens) {
	
	for (var i = 0; i < itens.length; i++) {
		var item=JSON.parse(itens[i]);
		
		fItensCallBack(item.idItem,item.name,item.desc,item.price,item.qtd,item.idCategory,item.icon, item.active);
	}
	if(fEndCalback!=null){
		fEndCalback(itens);
	}
}