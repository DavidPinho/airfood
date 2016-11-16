/*
 * Ajax implementation for load all created itens for the system
 */
var fCallBack;

function load_itens(callBack,mURL) {

	$.ajax({
		url: mURL,
		dataType: "json",
		success: onSuccessToSelect
	});
	fCallBack=callBack;

}

function onSuccessToSelect(itens) {

	for (var i = 0; i < itens.length; i++) {
		var item=JSON.parse(itens[i]);
		fCallBack(item.idItem,item.name,item.desc,item.price,item.qtd);
	}
}