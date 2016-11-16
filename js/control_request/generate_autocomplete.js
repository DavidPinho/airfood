function generate_autocomplete(inputString) {
	if(inputString.length >= 2) {
		$.ajax({
			type: "POST",
			url: "../control/autocomplete_orderDetail.php",
			data: "search="+inputString,
			success: function(itens) {
				if(itens.length > 0){
					jsonItens=JSON.parse(itens);
					var array_source = [];
					var cont = 0;

					for (var i = 0; i < jsonItens.length; i++) {
						var item=JSON.parse(jsonItens[i]);
						array_source[cont] = item.name;
						cont++;
					}
					$( "#item" ).autocomplete({
						source: array_source,
					});
				}
			}
		});
	}
}