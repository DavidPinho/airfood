function search_itens() {
	
	
	var search_value=document.getElementById("search_box").value;
	var only_act=0;
	if($('#chk_only_active').is(':checked')){
		only_act=1;
	}
	$("#category_content").find("tr:not(:eq(0))").remove();
	
	
	$.ajax({
		type: "get",
		url: "../control/search_item.php",
		data: "search="+search_value+"&only_act="+only_act+"&idCategory=-1",
		success: onSuccessToSearch
	});

	
}

function onSuccessToSearch(itens) {
		
		jsonItens=JSON.parse(itens);
		
		for (var i = 0; i < jsonItens.length; i++) {
			var item=JSON.parse(jsonItens[i]);
			addItemRow(item.idItem,item.name,item.desc,item.price,item.qtd, item.idCategory, item.icon,item.active);
		}
		
	
}