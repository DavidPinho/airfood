/*
 * Ajax implementation for load serach categories for the system
 * 
 */


function search_categories() {

	var search_value=document.getElementById("search_box").value;
	
	$("#category_content").find("tr:not(:eq(0))").remove();

	$.ajax({
		type: "post",
		url: "../control/search_categories.php",
		data: "search="+search_value,
		dataType: "json",
		success: onSuccessToSearch
	});

}

function onSuccessToSearch(categories) {

	
	for (var i = 0; i < categories.length; i++) {
		var category=JSON.parse(categories[i]);
		addRow(category.id,category.description, category.qtdeItens);
	}
}