<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>My Page</title>

<?php 

require_once '../../php_utils/token_validator.php';
require_once '../../model/TokenDigest.class.php';
require_once '../../model/TokenDigestDB.class.php';
require_once '../../model/TokenDB.class.php';
require_once '../../model/Token.class.php';
require_once 'includes.php';
require_once '../../lang/lang_utils.php';

$lang=loadLang("../../lang");

$popUp="#popupBasic";
if(!validate_session_token()){
	$popUp= "#tokenPopup";
}


?>
<script type="text/javascript"
	src="../../js/control_request/load_categories.js"></script>
<script type="text/javascript"
	src="../../js/control_request/oder_item.js"></script>
<script src="../../js/utils/random.js"></script>
<script type="text/javascript"
	src="../../js/control_request/auth_token.js"></script>

<script type="text/javascript">
function fillData(item){
	$("#name").text(item.name);
	$("#price").text(parseFloat(item.price).toFixed(2));
	
	$("#desc").text(item.desc);
	document.getElementById("idItem").value=item.idItem;
	document.getElementById("iPrice").value=item.price;
	$("#icon").attr("src","../../img/icons/"+item.icon);

	$("#myContent").refresh();
}

function sendOrder(){

	id_item=$("#idItem").val();
	qtd=$("#qtd").val();
	comment=$("#comment").val();
	
	order_item(id_item,qtd,comment,orderResponse);
	
}

$(document).ready(function() {
	$.ajax({
		url: "../../control/detail_item.php?idItem=<?php echo $_GET["idItem"]?>",
		dataType: "json",
		success: fillData
	});	

	
});

function authCompleted(response){

	if(response.op_code=="success"){
		$('#tokenPopup').popup('close');
		$("#do_order").attr("href","#popupBasic");
	}
	
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

function mOrderCallback(response){

	alert(response);
	
}

mFuncCallBack=authCompleted;

</script>


</head>
<body>


	<div data-role="page">

		<?php $title=$_GET["title"]; require_once '../contents/top.php' ?>

		<div data-role="content" style="margin-top: 40px;">

			<ul id="myContent" data-role="listview" data-inset="true">
				<li>
					<table border="0px" style="width: 100%">
						<tr>
							<td colspan="2" align="center"><div id="name"
									style="font-size: 25px;"></div> <br />
							</td>
						</tr>
						<tr>
						<tr>
							<td colspan="2"><img id="icon" width="100%" class="img-rounded" />
							</td>

						</tr>

						<td colspan="2" align="center"><h1>
								<?php echo $lang->food_description;?>
							</h1></td>
						</tr>
						<tr>
							<td colspan="2"><div style="font-size: 12px;" id="desc"></div></td>
						</tr>
						<tr>
							<td><a id="do_order" data-transition="pop" style="color: #ffffff"
								class="btn btn-large btn-block btn-info" href="<?php echo $popUp; ?>"
								data-rel="popup" data-position-to="window" type="button"> <?php echo $lang->order; ?>

									<?php require_once 'popup.php'; ?>
							</a>
							</td>
						</tr>
					</table>
				</li>

			</ul>

		</div>

</body>