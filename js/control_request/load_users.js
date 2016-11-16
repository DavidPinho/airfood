/*
 * Created by David Pinho on 21/12/2012
 * Ajax implementation for load all created users for the system
 * 
 */
var fCallBack;

function load_users(callBack,mURL) {

	$.ajax({
		url: mURL,
		dataType: "json",
		success: onSuccessToSelectUsers
	});
	fCallBack=callBack;

}

function onSuccessToSelectUsers(users) {

	for (var i = 0; i < users.length; i++) {
		var user=JSON.parse(users[i]);
		fCallBack(user.id,user.name,user.userName,user.password,user.email, user.admin);
	}
}