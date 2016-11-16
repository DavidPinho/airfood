function reportErroField(id,message){
	
	$("#"+id).attr("placeholder", message);
	$("#"+id).attr("value", "");
	
	$("#control_"+id).addClass("error");
	
}