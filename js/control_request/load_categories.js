/*
 * Ajax implementation for load all created categories for the system
 */
var categoryFCallBack;

function load_categories(callBack,mURL) {
	
	$.ajax({
		url: mURL,
		
		success: onSuccessToSelectCategories
	});
		
	
	categoryFCallBack=callBack;
	

}

function onSuccessToSelectCategories(response) {
	categories=JSON.parse(response);
	
	for (var i = 0; i < categories.length; i++) {
		var category=JSON.parse(categories[i]);
		categoryFCallBack(category.id,category.description, category.qtdeItens,category.image);
	}
}