<?php session_start();
require_once '../lang/lang_utils.php';
require_once '../model/OrderItem.class.php';
require_once '../model/OrderItemDB.class.php';

$lang=loadLang("../lang");
if(empty($_SESSION['user'])){
	header("Location: login.php");
}

if(empty($_GET['token'])||$_GET['token']=='')
	header("Location: dashboard.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Pedidos</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<!-- Le styles -->
<link href="../css/bootstrap-responsive.css" rel="stylesheet">
<link href="../css/jquery-ui-1.10.3.custom.css" rel="stylesheet">
<link href="../css/my_style.css" rel="stylesheet">
<link href="../css/bootstrap.css" rel="stylesheet">
<script src="../js/jquery.js"></script>
<script src="../js/jquery.form.js"></script>
<script src="../js/jquery-1.9.1.js"></script>
<script src="../js/jquery-ui-1.10.3.custom.js"></script>

<script src="../js/bootstrap.js"></script>

<script src="../js/control_request/load_orders.js"></script>
<script src="../js/control_request/search_orders.js"></script>
<script src="../js/control_request/check_orders.js"></script>
<script src="../js/control_request/delete_orders.js"></script>
<script src="../js/forms_erros/erro_utils.js"></script>
<script src="../js/control_request/generate_autocomplete.js"></script>
<script src="../js/control_request/generate_order.js"></script>


<script type="text/javascript">

var selecteds = new Array();//array for selected rows
var btUpdateEnabled=false;
var btRemoveEnabled=false;
var btCheckEnabled=false;
var flagUpdate=false;
var flagSearch=false;

var currentSearch="";

function addRow(id,itemName,hour,comment,status){

	outStatus="";
	if(status==1){
		outStatus="<span class=\"label label-success\"><?php echo $lang->order_closed;?></span>";
	}else{
		outStatus="<span class=\"label label-important\"><?php echo $lang->order_pendent;?></span>";
	}

	$("#tableList tr:last").after('<tr class="toggle-row" id="row'+id+'" data-id="'+id+'" data-itemName="'+itemName+'" data-hour="'+hour+'"  data-comment="'+comment+'"  data-status="'+status+'"  onclick="toogleRow(event,\'row'+id+'\')"><td>'+ itemName +'</td><td>'+hour +'</td><td>'+ comment+'</td><<td>'+ outStatus + '</td></tr>');
	
}



//Function to toogle the row clicked
function toogleRow(event,click){
	
	var id=$("#"+click).attr("data-id");

	// Verify if the row is already selected.
	if ($.inArray(id, selecteds) == -1) {

		// Report the selection for user
		$("#" + click).addClass("toggle-row-selected");
		$("#" + click).removeClass("toggle-row");

		selecteds.push(id);
	} else {

		// Report the selection for user
		$("#" + click).removeClass("toggle-row-selected");
		$("#" + click).addClass("toggle-row");
		selecteds.splice(selecteds.indexOf(id), 1); // remove the selection from
													// array
	}

	notifyButtons();
}

function deletePerfomed(){

	if(!btRemoveEnabled)
		return false;

	$('#deleteModal').modal("show");
	
}

function checkPeformed(){

	if(!btCheckEnabled)
		return false;

	$('#checkModal').modal("show");
	
}

//function to reajust the state of buttons
function notifyButtons(){
	if(selecteds.length==0){
		$("#btn-remove").addClass("disabled");
		$("#btn-checkOrder").addClass("disabled");
		btRemoveEnabled=false;
		btCheckEnabled=false;
	}else{ 
		$("#btn-remove").removeClass("disabled");
		$("#btn-checkOrder").removeClass("disabled");
		btRemoveEnabled=true;
		btCheckEnabled=true;
	}
	if(selecteds.length==1){
		$("#btn-edit").removeClass("disabled");
		btUpdateEnabled=true;
	}else{
		$("#btn-edit").addClass("disabled");
		btUpdateEnabled=false;
	}
}

/*
function openUpdateDialog(){

	if(!btUpdateEnabled)
		return;

	var table=$("#row"+selecteds[0]).attr("data-table");
	var token=$("#row"+selecteds[0]).attr("data-token");
	var status=$("#row"+selecteds[0]).attr("data-status");
	
	document.getElementById("editTable").value=table;
	
	if(status == 0)
		$("#editStatus0").attr('checked', true);
	else
		$("#editStatus1").attr('checked', true);
	
	document.getElementById("editToken").value=token;
			
	flagUpdate=true;
	$('#editModal').modal('show');

}*/


function refresh(){
	$("#tableList").find("tr:not(:eq(0))").remove();
	selecteds.length=0;//clear the array
	notifyButtons();

	$("#search_box").val("");
	
	var only_act=0;
	if($('#chk_only_active').is(':checked')){
		only_act=1;
	}
	load_orders(addRow,"../control/list_orders.php?only_act="+only_act+"&idToken=<?php echo $_GET['token'];?>");			
	flagSearch=false;	
	$("#sucess_message").hide();
}

function resetForm(){
	$("#control_item").removeClass("error");
	$("#control_qtd").removeClass("error");
}




$(document).ready(function() { 
	
	load_orders(addRow,"../control/list_orders.php?only_act=1&idToken=<?php echo $_GET['token'];?>");		

    $('#search_box').keypress(function(e){
        if ( e.which == 13 ){ 
        	selecteds.length=0;//clear the array
        	notifyButtons();

        	flagSearch=true;
            search_orders();
            
            return false;
         };
    });

    $('#chk_only_active').click(function() {      
    	$("#tableList").find("tr:not(:eq(0))").remove();
    	selecteds.length=0;//clear the array
    	notifyButtons();
    	if(flagSearch){
            search_orders();

            return;
    	}
    	var only_act=0;
    	if($('#chk_only_active').is(':checked')){
    		only_act=1;
    	}
    	load_orders(addRow,"../control/list_orders.php?only_act="+only_act+"&idToken=<?php echo $_GET['token'];?>");
    }); 
    
    /*
    $('#item').keypress(function(e){
        if ( e.which == 13 ){ 
            generate_order();
            return false;
        };
    });
    */
		
		
	$('#newOrderModal').on('hidden', function () {
		resetForm();
		document.getElementById("item").value="";
		document.getElementById("item").setAttribute("placeholder", "informar o nome do item");
		document.getElementById("qtd").value="1";
    });
        
});


</script>

<style type="text/css">
body {
	padding-top: 60px;
	padding-bottom: 40px;
}

.sidebar-nav {
	padding: 9px 0;
}
</style>


</head>

<body>
	<?php require_once 'contents/top2.php';?>

	<div
		style="position: fixed; width: 260px; left: 15px; right: 10px; border: 1px solid #e3e3e3; -webkit-border-radius: 14px; -moz-border-radius: 14px; border-radius: 14px; -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); padding: 15px;">

		<span style="font-size: 20px;"><?php echo "Pedidos" ?> </span>
		<div class="btn-group" style="float: right;">
			<button class="btn btn-info" href="#newOrderModal" role="button"
				data-toggle="modal">
				<i class="icon-plus icon-white"></i>
			</button>
			<button id="btn-checkOrder" class="btn btn-info disabled"
				 role="button" class="btn" data-toggle="modal" onclick="checkPeformed();">
				<i class="icon-ok icon-white"></i>

			</button>
			<button id="btn-remove" class="btn btn-info disabled"
				 role="button" class="btn" data-toggle="modal" onclick="deletePerfomed();">
				<i class="icon-remove icon-white"></i>

			</button>
			<button id="btn-refresh" class="btn btn-info" onclick="refresh()">
				<i class="icon-refresh icon-white"></i>
			</button>

		</div>
		<br /> <br /> <input id="search_box" type="text" 
			placeholder="<?php echo $lang->search ?>"> <br /> <br />
			<label class="checkbox"><input id="chk_only_active" type="checkbox" checked="ture" name="only_active"/> Mostrar somente pedidos pendentes </label>
			
	</div>

	<!-- Modal Generate-->
	<div id="newOrderModal" class="modal hide fade" tabindex="-1"
		role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-hidden="true">×</button>
			<h3 id="myModalLabel">
				<?php echo "Novo pedido" ?>
			</h3>
		</div>
		<div id="control_table" class="modal-body">
			<form action="#" id="mainForm">
				<label><?php echo "Token Atual: " ?> </label>
				<span class="label label-success" style="font-size: 16px;"><?php echo $_GET['token'];?></span>
				<br/>
				<br/>
				
				<label><?php echo "Item" ?> </label>
				<div id="control_item" class="control-group">
					<div class="controls">
						<input id="item" name="item" type="text" value="" onkeyup="generate_autocomplete(this.value);"
							placeholder="<?php echo "informar o nome do item" ?>" />
						<input id="idItem" name="idItem" type="hidden"/>
					</div>
				</div>
				<label><?php echo "Quantidade" ?> </label>
				<div id="control_qtd" class="control-group">
					<div class="controls">
						<input id="qtd" name="qtd" type="text"
							value="1"
							placeholder="<?php echo "informar quantidade" ?>" />
					</div>
				</div>
				
				<input type="hidden" id="token" name="token" value="<?php echo $_GET['token']; ?>">

			</form>

		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" id="btn_cancel"
				aria-hidden="true">
				<?php echo $lang->cancel ?>
			</button>
			<button class="btn btn-primary" id="btn_save" onclick="generate_order()">
				<?php echo $lang->save ?>
			</button>
		</div>
	</div>
	<!-- End Modal -->

	<!-- Modal -->
	<div id="deleteModal" class="modal hide fade" tabindex="-1"
		role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-hidden="true">×</button>
			<h3 id="myModalLabel" class="text-warning"><?php echo $lang->attention ?></h3>
		</div>
		<div class="modal-body">
			<h4><?php echo $lang->msg_attention ?></h4>

		</div>

		<div class="modal-footer">
			<button id="btn_cancel_delete" class="btn" data-dismiss="modal"
				aria-hidden="true"><?php echo $lang->cancel ?></button>
			<button id="btn_confirm" onclick="delete_orders_selected(selecteds)" class="btn btn-primary"><?php echo $lang->continue ?></button>
		</div>
	</div>
	<!-- End Modal -->

	<!-- Modal -->
	<div id="checkModal" class="modal hide fade" tabindex="-1"
		role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-hidden="true">×</button>
			<h3 id="myModalLabel" class="text-warning"><?php echo $lang->attention ?></h3>
		</div>
		<div class="modal-body">
			<h4><?php echo "Deseja mudar o status desses pedidos para Conclu�do?" ?></h4>

		</div>

		<div class="modal-footer">
			<button id="btn_cancel_delete" class="btn" data-dismiss="modal"
				aria-hidden="true"><?php echo $lang->cancel ?></button>
			<button id="btn_confirm" class="btn btn-primary" onclick="check_orders_selected(selecteds)"><?php echo $lang->continue ?></button>
		</div>
	</div>
	<!-- End Modal -->

<div id="sucess_message"
		style="padding-left: 315px; padding-right: 30px; display: none;">
		<div class="alert alert-block alert-success fade in">
			<button type="button" class="close"
				onclick="$('#sucess_message').hide();">×</button>
			<h4 class="alert-heading">
				<?php echo $lang->msg_addSuccess ?>
			</h4>
		</div>
	</div>
	<div style="padding-left: 315px; padding-right: 15px;">
		<table class="table table-striped table-hover" id="tableList">
			<thead>
				<tr class="top-table">
					<th width="25%"><?php echo "Item" ?></th>
					<th width="30%"><?php echo "Hora do pedido" ?></th>
					<th width="30%"><?php echo "Coment&aacute;rio" ?></th>
					<th width="15%"><?php echo "Status" ?></th>
				</tr>
			</thead>
		</table>
	</div>

</body>
</html>
