<?php session_start();
require_once '../lang/lang_utils.php';

$lang=loadLang("../lang");
if(empty($_SESSION['user'])){
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $lang->dashboard ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<!-- Le styles -->
<link href="../css/bootstrap-responsive.css" rel="stylesheet">
<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/my_style.css" rel="stylesheet">
<script src="../js/jquery.js"></script>
<script src="../js/jquery.form.js"></script>
<script src="../js/control_request/generate_token.js"></script>
<script src="../js/utils/replace_all.js"></script>
<script src="../js/forms_erros/erro_utils.js"></script>
<script src="../js/bootstrap.js"></script>


<script type="text/javascript">

var orderHash= new Array();
var selectedOrder;
//function to add the row
function addRowOrder(table, order, obs, time,token){
	 var onClickFunction="openOrderDetail('"+token+"')";
	 $("#orderListContent").append('<tr onclick=\"'+onClickFunction+'\"><td>'+table+'</td><td>'+order+'</td><td>'+obs+'</td><td>'+time+'</td></tr>');
}

//function to add the row
function addRowToken(table, token){
	 $("#tokenListContent").append('<tr onclick="openOrderDetailPage(\''+token+'\', \''+table+'\')"><td>'+table+'</td><td>'+token+'</td></tr>');
}

function openOrderDetailPage(token, table){
	document.location.href = "orderDetail.php?token="+token+"&table="+table;
}

function getOpenOrders(){
	$.ajax({
		url: "../control/get_open_orders.php",
		success: openOrdersReciver
	});

	
}

function getAvaiableToken(){
	$.ajax({
		url: "../control/get_avaiable_token.php",
		success: avaiableTokenReciever
	});
}

function openOrdersReciver(response){
	alert(response);
	var jsonReponse=JSON.parse(response);	
	
	for(var i=0;i<jsonReponse.length;i++){
		token=JSON.parse(jsonReponse[i].token);
		orderHash[token.idToken]=jsonReponse[i];
		addRowOrder(token.table,jsonReponse[i].itens_text,jsonReponse[i].comments,jsonReponse[i].first_order,token.idToken);
	}
	
}

function avaiableTokenReciever(response){

	
	var jsonReponse=JSON.parse(response);

	for(var i=0;i<jsonReponse.length;i++){
		token=JSON.parse(jsonReponse[i]);
		
		addRowToken(token.table,token.idToken);
	}
	
}

function confirmOrders(){

	
	if(!$('#confirmOrder').is(':checked')){
		$('#orderDetail').modal('hide');
		
		return;
	}
	var ordersToConfirm=selectedOrder.id_orders;
	
	$.ajax({
		url: "../control/confirm_orders.php",
		data: "ids="+ordersToConfirm,
		success: ordersConfirmed
	});
	
}

$(document).ready(function() { 
	
	getOpenOrders();
	getAvaiableToken();
    $('#orderDetail').on('show', function () {

		var token=JSON.parse(selectedOrder.token);
    	$("#table").text(token.table);
    	
    	var jsonItens=selectedOrder.itens;
    	var item_text="<ul>";
    	
    	for(var i=0;i<jsonItens.length;i++){
    		
			var item=JSON.parse(jsonItens[i].item);

			
			var comments=replaceAll(jsonItens[i].obs,"\n","; ");
			
			
			item_text+="<li>"+jsonItens[i].qtd+"x "+item.name+": "+comments+"</li>";
			
        }
    	item_text+="</ul>";
		document.getElementById("itens").innerHTML=item_text;

		$('#confirmOrder').attr('checked', false);
     });

    $('#generateModal').on('hide', function () {
    	$("#control_numberMesa").removeClass("error");
    	$("#numberMesa").val("");
    	$("#numberMesa").attr("placeholder","<?php echo $lang->msg_addToken ?>")
     });
	
});

function refreshOrderTable(){
	$("#orderList").find("tr:not(:eq(0))").remove();
	getOpenOrders();
}

function openOrderDetail(token){

	selectedOrder=orderHash[token];
	
	$('#orderDetail').modal('show');
}

function tokenAdded(response){	
	

	var jsonResponse=JSON.parse(response);
	if(jsonResponse.out==0){
		addRowToken(jsonResponse.token_table,jsonResponse.token_idToken);
		$('#generateModal').modal('hide');
	}else{
	
		for(var i=0;i<jsonResponse.erro_list.length;i++){
			var aux=jsonResponse.erro_list[i].split(";");
			reportErroField(aux[0],aux[1]);
		}
	}
	
}

function ordersConfirmed(response){

	var jsonResponse=JSON.parse(response);
	if(jsonResponse.op_code=="success"){

		refreshOrderTable();
		
		$('#orderDetail').modal('hide');
		
	}
}

</script>


<style type="text/css">
#dashboard {
	background-color: rgb(229, 229, 229);
	border-radius: 4px 4px 4px 4px;
	margin-left: 40px;
	margin-right: 40px;
	margin-top: 80px;
	padding-top: 20px;
	padding-bottom: 20px;
	box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.05) inset;
}

.dash_header {
	background-color: rgb(136, 136, 136) !important;
	border-radius: 4px 4px 0px 0px !important;
	display: block;
	padding: 15px 15px !important;
	margin: 0px !important;
	color: rgb(245, 245, 245);
	border: medium none;
}

.dash_content {
	background-color: rgb(255, 255, 255);
	height: 546px;
	overflow: hidden;
	width: 48.5%;
	padding: 0px !important;
	float: left;
	border-radius: 4px 4px 4px 4px;
	border: medium none;
}

.dash_subtop {
	height: 30px;
	display: inline-block;
	width: 100%;
	background-color: rgb(204, 204, 204);
	padding-top: 10px;
	padding-left: 10px;
	padding-right: 10px;
	padding-bottom: 5px;
	box-shadow: 0px 3px 0px 1px rgb(204, 204, 204);
}

.dash_subtop2 {
	height: 30px;
	display: inline-block;
	width: 100%;
	background-color: rgb(136, 136, 136);
	color: rgb(245, 245, 245);
	padding-top: 10px;
	padding-left: 10px;
	padding-right: 10px;
	padding-bottom: 5px;
	box-shadow: 0px 3px 0px 2px rgb(136, 136, 136);
}
</style>

</head>

<body>

	<?php require_once 'contents/top2.php';?>

	<div id="dashboard" class="container-fluid">
		<div class="row-fluid">
			<div class="span4 dash_content">
				<div class="dash_header">
					<span style="font-size: 18px"><?php echo $lang->active_desk ?></span>
				</div>
				<div class="row-fluid dash_subtop">
					<div class="span8">
						<form class="form-search">
							<div class="input-append">
								<input type="text" class="search-query"
									style="border: 1px solid rgb(174, 174, 174); width: 120px;">
								<button type="submit" class="btn"
									style="border: 1px solid rgb(174, 174, 174);"><?php echo $lang->search ?></button>
							</div>
						</form>
					</div>
					<div class="span4" style="float: right;">
						<button class="btn btn-info" href="#generateModal" role="button"
							data-toggle="modal"><?php echo $lang->addToken ?></button>
					</div>
				</div>
				<table class="table table-hover">
					<thead>
						<tr class="top-table">
							<td><?php echo $lang->table ?></td>
							<td><?php echo $lang->token ?></td>
						</tr>
					</thead>
					<tbody id="tokenListContent">
					</tbody>
				</table>
			</div>
			<div class="span8 dash_content">
				<div class="row-fluid dash_subtop2">
					<div class="span6" style="padding-top: 5px;">
						<span style="font-size: 18px;"><?php echo $lang->typeorder ?></span>
					</div>
					<div class="span6" style="float: right;">
						<form class="form-search">
							<div class="input-append">
								<input type="text" class="search-query"
									style="border: 1px solid rgb(84, 84, 84);">
								<button type="submit" class="btn"
									style="border: 1px solid rgb(84, 84, 84);"><?php echo $lang->search ?></button>
							</div>
						</form>
					</div>
				</div>
				<table class="table table-hover" id="orderList">
					<thead>
						<tr class="top-table">
							<td><?php echo $lang->table ?></td>
							<td><?php echo $lang->order ?></td>
							<td><?php echo $lang->observation ?></td>
							<td><?php echo $lang->time ?></td>
						</tr>
					</thead>
					<tbody id="orderListContent">

					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Modal Edit-->
	<div id="orderDetail" class="modal hide fade" tabindex="-1"
		role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-hidden="true">×</button>
			<h3 id="myModalLabel"><?php echo $lang->order_details ?></h3>
		</div>
		<div id="control_table" class="modal-body"><?php echo $lang->table ?>
			<span id="table"></span><br /> <br /><?php echo $lang->title_item ?>
			<div id="itens"></div>
			<br />
			<div class="row-fluid" style="display: inline-block;">
				<div class="span1">
					<input style="float: right;" type="checkbox" id="confirmOrder">
				</div>
				<div class="span11">
					<?php echo $lang->order_confirmed ?>
				</div>
			</div>


		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" id="btn_cancel"
				aria-hidden="true"><?php echo $lang->cancel ?></button>
			<button onclick="confirmOrders()" class="btn btn-primary"
				id="btn_generate"><?php echo $lang->ok ?></button>
		</div>
	</div>
	<!-- End Modal -->

	<!-- Modal Generate-->
	<div id="generateModal" class="modal hide fade" tabindex="-1"
		role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-hidden="true">×</button>
			<h3 id="myModalLabel">
				<?php echo $lang->addToken ?>
			</h3>
		</div>
		<div id="control_table" class="modal-body">
			<form action="#" id="mainForm">
				<label><?php echo $lang->table ?> </label>
				<div id="control_numberMesa" class="control-group">
					<div class="controls">
						<input id="numberMesa" name="numberMesa" type="text"
							placeholder="<?php echo $lang->msg_addToken ?>" />
					</div>
				</div>

				<input id="insert_table" name="table" type="hidden" />
			</form>

		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" id="btn_cancel"
				aria-hidden="true">
				<?php echo $lang->cancel ?>
			</button>
			<button class="btn btn-primary" id="btn_generate"
				onclick="generate_token(tokenAdded)">
				<?php echo $lang->generate ?>
			</button>
		</div>
	</div>
	<!-- End Modal -->

</body>
</html>
