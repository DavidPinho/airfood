/*
 * Ajax implementation for load serach users for the system
 */


function search_tokens() {

	var search_value = document.getElementById("search_box").value;
	var only_act=0;
	if($('#chk_only_active').is(':checked')){
		only_act=1;
	}
	
	if(search_value==""){
		flagSearch=false;
	}
	
	$("#tableList").find("tr:not(:eq(0))").remove();

	$.ajax({
		type: "post",
		url: "../control/search_tokens.php",
		data: "search="+search_value+"&only_act="+only_act,
		dataType: "json",
		success: onSuccessToSearch
	});

}

function onSuccessToSearch(tokens) {
	
		for (var i = 0; i < tokens.length; i++) {
			var token = JSON.parse(tokens[i]);
			addRow(token.table, token.idToken, token.available);
		}
	
}