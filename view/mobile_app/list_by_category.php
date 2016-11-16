<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>My Page</title>

<?php require_once 'includes.php'; 
require_once '../../lang/lang_utils.php';
require_once '../../php_utils/token_validator.php';
require_once '../../model/TokenDigest.class.php';
require_once '../../model/TokenDigestDB.class.php';
require_once '../../model/TokenDB.class.php';
require_once '../../model/Token.class.php';

$lang=loadLang("../../lang");

$popUp="#popupBasic";
if(!validate_session_token()){
	$popUp= "#tokenPopup";
}

?>

<script type="text/javascript"
	src="../../js/control_request/list_itens.js"></script>
<script src="../../js/jquery.form.js"></script>
<script type="text/javascript"
	src="../../js/control_request/oder_item.js"></script>
<script src="../../js/utils/random.js"></script>
<script type="text/javascript"
	src="../../js/control_request/auth_token.js"></script>

<script type="text/javascript">

var selectedItem={};

function addItem(id,name,desc,price,qtd,idCategory,icon){

	var float_price=parseFloat(price);
	var linkToFood="detail_food.php?idItem="+id+"&title="+name;
	var onClickText="openOrderPopup("+id+")";
	
	$("#item_list").append("<li id=\"item"+id+"\" data-name=\""+name+"\" data-desc=\""+desc+"\" data-price=\""+price+"\" data-qtd=\""+qtd+"\" data-idCategory=\""+idCategory+"\" data-icon=\""+icon+"\"> <table><tr><td><a data-ajax=\"false\" href=\""+linkToFood+"\"><img class=\"img-polaroid\" src=\"../../img/icons/"+icon+"\" width=\"100px\" height=\"100px\" /></a></td><td style=\"padding-left:15px;\"><a data-ajax=\"false\" href=\""+linkToFood+"\"><span style=\"color:#000000; font-size: 18px\">"+name+"</span></a><br/><br/><button onclick=\""+onClickText+"\" class=\"btn btn-info\">R$ "+parseFloat(price).toFixed(2)+"</button><td></tr></table></li>");

	$('#item_list').listview('refresh');
}

$(document).ready(function() {
	load_itens(addItem,"../../control/list_item_by_category.php?idCategory=<?php echo $_GET["idCategory"]?>");

	$("#popupBasic").bind({
		popupbeforeposition: function(event, ui) {
			   $("#price").text(parseFloat(selectedItem.price).toFixed(2));
				document.getElementById("idItem").value=selectedItem.id;
				document.getElementById("iPrice").value=selectedItem.price;
				$("#titleOrderRow").show();
				$("#titleOrder").text(selectedItem.name);
			}
		});
});

function authCompleted(response){

	if(response.op_code=="success"){
		$('#auth_alert_message').addClass("alert-success");
	
		
		$("#popupToOpen").attr("value","#popupBasic");
	}else{
		$('#auth_alert_message').addClass("alert-error");
	}
	
	$('#auth_alert_message').text(response.message);
	$("#auth_message").show();
	$("#auth_details").hide();
	
}

function openOrderPopup(id){

	selectedItem.id=id;
	
	selectedItem.name=$("#item"+id).attr("data-name");
	selectedItem.desc=$("#item"+id).attr("data-desc");
	selectedItem.price=$("#item"+id).attr("data-price");
	selectedItem.idCategory=$("#item"+id).attr("data-idCategory");
	selectedItem.icon=$("#item"+id).attr("data-icon");

	var popupToOpen=$("#popupToOpen").val();
	$(popupToOpen).popup("open",{transition: "pop"});
	
}

function sendOrder(){
	id_item=$("#idItem").val();
	qtd=$("#qtd").val();
	comment=$("#comment").val();
	
	order_item(id_item,qtd,comment,orderResponse);
}

function orderResponse(response){

	if(response.op_code=="success_in_order"){
		$("#order_alert_message").addClass("alert-success");
	}else{
		$("#order_alert_message").addClass("alert-error");
	}
	$("#order_alert_message").text(response.message);
	$("#order_message").show();
	$("#order_details").hide();
	
}

mFuncCallBack=authCompleted;

</script>

</head>
<body>

	<?php $title=$_GET["description"];  include_once "../contents/top.php"?>

	<div data-role="page">

		<div data-role="content" style="margin-top: 40px;">
			<form data-ajax="false" id="search_form" action="search_result.php"
				method="get" class="form-search">
				<div class="input-append" style="width: 100%">
					<input name="search" placeholder="Pesquise aqui..." style=" width:80%; height: 30px; margin: 0px"
						type="text" class="span2 search-query"> <input name="idCategory"
						value="<?php echo $_GET["idCategory"]?>" type="hidden" />
					<button style="width: 20%;" type="submit" class="btn"><i class="icon-search"></i></button>
				</div>
				<input type="hidden" id="popupToOpen" value="<?php echo $popUp; ?>" />
			</form>


			<ul id="item_list" data-role="listview" data-inset="true">

			</ul>
			<!-- /content -->

		</div>
		<!-- /page -->

		<?php require_once 'popup.php';?>

</body>

</html>
