<?php session_start();?>
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
<script src="../../js/control_request/load_categories.js"></script>
<script type="text/javascript"
	src="../../js/control_request/oder_item.js"></script>
<script src="../../js/utils/random.js"></script>
<script type="text/javascript"
	src="../../js/control_request/auth_token.js"></script>
<script type="text/javascript">

function addOption(id,description){
	 $('#categories').append("<option value=\""+id+"\">"+description+"</option>"); 
}

var selectedItem={};

function addItem(id,name,desc,price,qtd,idCategory,icon){

	var float_price=parseFloat(price);
	var linkToFood="detail_food.php?idItem="+id+"&title="+name;
	var onClickText="openOrderPopup("+id+")";
	
	$("#item_list").append("<li id=\"item"+id+"\" data-name=\""+name+"\" data-desc=\""+desc+"\" data-price=\""+price+"\" data-qtd=\""+qtd+"\" data-idCategory=\""+idCategory+"\" data-icon=\""+icon+"\"> <table><tr><td><a data-ajax=\"false\" href=\""+linkToFood+"\"><img class=\"img-polaroid\" src=\"../../img/icons/"+icon+"\" width=\"100px\" height=\"100px\" /></a></td><td style=\"padding-left:15px;\"><a data-ajax=\"false\" href=\""+linkToFood+"\"><span style=\"color:#000000; font-size: 18px\">"+name+"</span></a><br/><br/><button onclick=\""+onClickText+"\" class=\"btn btn-info\">R$"+parseFloat(price).toFixed(2)+"</button><td></tr></table></li>");

	$('#item_list').listview('refresh');
}


function onSearchComplete(response){

	var jsonResponse=JSON.parse(response);

	$('#item_list').text("");
	if(jsonResponse.length>0){
		
		for(var i=0;i<jsonResponse.length;i++){
			var item=JSON.parse(jsonResponse[i]);

			addItem(item.id, item.name, item.desc, item.price, item.qtd, item.idCategory, item.icon);
		}

		$('#item_list').listview('refresh');
	}else{
		$("#alert_message").text("<?php echo $lang->no_result ?>");
		$("#alert_message").show();
	}
	
}

function onSuccessToLoadCategories(categories){

	for (var i = 0; i < categories.length; i++) {
		var category=JSON.parse(categories[i]);
		addOption(category.id,category.description);
	}

	$('#categories').val(<?php if(!(empty($_GET["idCategory"])||$_GET["idCategory"]=="")){ echo $_GET["idCategory"];} else echo -1?>);
	$('#categories').selectmenu("refresh");
}

function search_item(){
	
	$('#search_form').ajaxForm({
		beforeSubmit : function() {
			$("#alert_message").hide();
		},
		success : onSearchComplete
	});
	if($("#txt_search").val()!="")
		$('#search_form').submit();
	else{
		$("#alert_message").text("<?php echo $lang->search_empty ?>");
		$("#alert_message").show();
	}
}

function itensLoaded(itens){
	if(itens.length<1){
		$("#alert_message").text("<?php echo $lang->search_empty ?>");
		$("#alert_message").show();
	}
}

$(document).ready(function() {
	$.ajax({
		url: "../../control/list_categories.php",
		dataType: "json",
		success: onSuccessToLoadCategories
	});
	
	if($("#txt_search").val()!=""){
		
		load_itens(addItem, "../../control/search_item.php?idCategory=<?php if(!(empty($_GET["idCategory"])||$_GET["idCategory"]=="")){ echo $_GET["idCategory"];}else{ echo "-1";}?>&search=<?php echo $_GET["search"]?>", itensLoaded);
		
	}

	$("#popupBasic").bind({
		popupbeforeposition: function(event, ui) {
			   $("#price").text(parseFloat(selectedItem.price).toFixed(2));
				document.getElementById("idItem").value=selectedItem.id;
				document.getElementById("iPrice").value=selectedItem.price;
				$("#titleOrderRow").show();
				$("#titleOrder").text(selectedItem.name);
			}
		});	
}
);

//logic to order
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

	<div data-role="page" style="margin-top: 40px;">

		<?php $title="Pesquisa"; require_once '../contents/top.php' ?>

		<div data-role="content">
			<form data-ajax="false" id="search_form"
				action="../../control/search_item.php" method="get"
				class="form-search">
				<div class="input-append" style="width: 100%">
					<input id="txt_search" placeholder="Pesquise aqui" name="search" style="width:80%; height: 30px; margin: 0px"
						type="text" class="span2 search-query" value="<?php echo $_GET["search"];?>"> 
					<button style="width: 20%;" onclick="search_item()" class="btn">Search</button>
				</div>
				<select id="categories" name="idCategory">
					<option value="-1"><?php echo $lang->all ?></option>
					
				</select>
				<input type="hidden" id="popupToOpen" value="<?php echo $popUp; ?>"/>
			</form>

			
			<div id="alert_message" class="alert alert-block" <?php if(!(empty($_GET["search"])||$_GET["search"]=="")){?> style="display: none;" <?php }?>>
				<?php echo $lang->search_empty;?>
			</div>
			
			<ul id="item_list" data-role="listview" data-inset="true">

			</ul>
			<!-- /content -->

			<?php require_once 'popup.php';?>
		</div>
		<!-- /page -->
		
</body>
</html>
