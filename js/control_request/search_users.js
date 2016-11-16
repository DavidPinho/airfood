/*
 * Created by David Pinho on 24/01/2013
 * Ajax implementation for load serach users for the system
 * 
 */


function search_users() {

	var search_value=document.getElementById("search_box").value;
	
	$("#user_content").find("tr:not(:eq(0))").remove();

	$.ajax({
		type: "post",
		url: "../control/search_users.php",
		data: "search="+search_value,
		dataType: "json",
		success: onSuccessToSearch
	});

}

function onSuccessToSearch(users) {
	
		for (var i = 0; i < users.length; i++) {
			var user=JSON.parse(users[i]);
			addRow(user.id,user.name, user.userName, user.password, user.email, user.admin);
		}
	
}