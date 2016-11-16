function GetrequestHttpObject() {
	var myRequest = null;
	try {
		// Firefox, Opera 8.0+, Safari
		myRequest = new XMLHttpRequest();
	} catch (e) {
		// Internet Explorer
		try {
			myRequest = new ActiveXObject("Msxml2.requestHttp");
		} catch (e) {
			myRequest = new ActiveXObject("Microsoft.requestHttp");
		}
	}
	return myRequest;
}



