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
<title><?php echo $lang->titleToken ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<!-- Le styles -->
<link href="../css/bootstrap-responsive.css" rel="stylesheet">
<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/my_style.css" rel="stylesheet">
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.js"></script>

<script src="../js/control_request/generate_token.js"></script>
<script src="../js/control_request/load_tokens.js"></script>
<script src="../js/control_request/search_tokens.js"></script>
<script src="../js/control_request/update_token.js"></script>
<script src="../js/forms_erros/erro_utils.js"></script>

<script type="text/javascript">

/*
 * Global variables to control the select action in the category table
 * 
 * 	btUpdateEnabled and btRemoveEnabled are flags to control the click on button Edit 
 * and remove
 *
 */
var selecteds = new Array();//array for selected rows
var btUpdateEnabled=false;
var btRemoveEnabled=false;
var flagUpdate=false;
var flagSearch=false;

var currentSearch="";



function resetForm(){
	$("#control_table").removeClass("error");
}


//Function to toogle the row clicked
function toogleRow(event,click){
	
	var id=$("#"+click).attr("data-token");

	//Verify if the row is already selected.
	if($.inArray(id, selecteds)==-1){

		//Report the selection for user
		$("#"+click).addClass("toggle-row-selected");
		$("#"+click).removeClass("toggle-row");

		selecteds.push(id);
		
	}else{

		//Report the selection for user
		$("#"+click).removeClass("toggle-row-selected");
		$("#"+click).addClass("toggle-row");
		
		
		selecteds.splice(selecteds.indexOf(id),1);	//remove the selection from array
	}

	
	notifyButtons();
	
}

//function to add the row
function addRow(table, token, status){

	outStatus="";
	if(status==1){
		outStatus="<span class=\"label label-success\"><?php echo $lang->token_active;?></span>";
	}else{
		outStatus="<span class=\"label label-important\"><?php echo $lang->token_deactive;?></span>";
	}
	
	$("#tableList tr:last").after('<tr class="toggle-row" id="row'+token+'" data-table="'+table+'" data-token="'+token+'" data-status="'+status+'" onclick="toogleRow(event,\'row'+token+'\')"> <td>'
			  + table + '</td><td>' + token + '</td><td>'+ outStatus + '</td>');
}

function deletePerfomed(){

	if(!btRemoveEnabled)
		return false;

	$('#deleteModal').modal("show");
	
}

//function to reajust the state of buttons
function notifyButtons(){
	if(selecteds.length==0){
		$("#btn-remove").addClass("disabled");
		btRemoveEnabled=false;
	}else{ 
		$("#btn-remove").removeClass("disabled");
		btRemoveEnabled=true;
	}
	if(selecteds.length==1){
		$("#btn-edit").removeClass("disabled");
		btUpdateEnabled=true;
	}else{
		$("#btn-edit").addClass("disabled");
		btUpdateEnabled=false;
	}
}

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

}

function clickSave(){	
	if(flagUpdate){
		update_token();
	}else{
		generate_token(showToken);
	}
}

function refresh(){
	$("#tableList").find("tr:not(:eq(0))").remove();
	selecteds.length=0;//clear the array
	notifyButtons();

	$("#search_box").val("");
	
	
	var only_act=0;
	if($('#chk_only_active').is(':checked')){
		only_act=1;
	}
	load_tokens(addRow,"../control/list_tokens.php?only_act="+only_act);

	flagSearch=false;	
	$("#sucess_message").hide();
}

$(document).ready(function() { 
	
	load_tokens(addRow,"../control/list_tokens.php?only_act=1");
	
  	$('#generateModal').on('hidden', function () {
	  flagUpdate=false;
	  $('#btn_cancel').show();
	  $('#btn_generate').show();
	  document.getElementById("numberMesa").value="";
	  $("#control_numberMesa").removeClass("error");
		document.getElementById("numberMesa").setAttribute("placeholder", "identificação de mesa");
    });
     
    $('#editModal').on('hidden', function () {
	  flagUpdate=false;
	  $('#btn_cancel').show();
	  $('#btn_update').show();
	  $("#control_editTable").removeClass("error");
	});

    $('#mainForm').keypress(function(e){
        if ( e.which == 13 ){ 
            clickSave();
            return false;
        };
    });//código para impelmentar o enter para enviar o formulário
    
     $('#updateForm').keypress(function(e){
        if ( e.which == 13 ){ 
            clickSave();
            return false;
        };
    });

    $('#search_box').keypress(function(e){
        if ( e.which == 13 ){ 
        	if (document.getElementById("search_box").value != ""){
        		selecteds.length=0;//clear the array
        		notifyButtons();

        		flagSearch=true;
            	search_tokens();
            
            	return false;
        	}else
            	return false;
         };
    });

    $('#chk_only_active').click(function() {      
    	$("#tableList").find("tr:not(:eq(0))").remove();
    	selecteds.length=0;//clear the array
    	notifyButtons();
    	if(flagSearch){
            search_tokens();

            return;
    	}
    	var only_act=0;
    	if($('#chk_only_active').is(':checked')){
    		only_act=1;
    	}
    	load_tokens(addRow,"../control/list_tokens.php?only_act="+only_act);	
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

		<span style="font-size: 20px;"><?php echo $lang->typeToken ?> </span>
		<div class="btn-group" style="float: right;">
			<button class="btn btn-info" href="#generateModal" role="button"
				data-toggle="modal">
				<i class="icon-plus icon-white"></i>
			</button>
			<button id="btn-edit" class="btn btn-info disabled"
				onclick="openUpdateDialog()">
				<i class="icon-edit icon-white"></i>
			</button>
			<button id="btn-refresh" class="btn btn-info" onclick="refresh()">
				<i class="icon-refresh icon-white"></i>
			</button>

		</div>
		<br /> <br /> <input id="search_box" type="text" class="search-query"
			placeholder="<?php echo $lang->search ?>"> <br /> <br />
			<label class="checkbox"><input id="chk_only_active" type="checkbox" checked="ture" name="only_active"/> Mostrar somente mesas ativas </label>

	</div>

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
				onclick="clickSave()">
				<?php echo $lang->generate ?>
			</button>
		</div>
	</div>
	<!-- End Modal -->
	
		<!-- Modal Sucess Message-->
		<div id="sucessMessageModal" class="modal hide fade" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="alert alert-block alert-success fade in">
				<h3 align="center" id="sucess_m" class="alert-heading">
				</h3>
			</div>
			<p align="center">
				<button type="button" class="btn btn-large btn-primary"
				onclick="$('#sucessMessageModal').modal('hide');">OK</button>
			</p>
		</div>
	<!-- End Modal -->


	<!-- Modal Edit-->
	<div id="editModal" class="modal hide fade" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-hidden="true">×</button>
			<h3 id="myModalLabel">
				<?php echo $lang->update ?></h3>
		</div>
		<div id="control_table" class="modal-body">
			<form action="#" id="updateForm">
				<label><?php echo $lang->table ?> </label>

				<div id="control_editTable" class="control-group">
					<div class="controls">
						<input id="editTable" name="editTable" type="text"
							placeholder="<?php echo $lang->msg_addToken ?>" />
					</div>
				</div>
				<label><?php echo $lang->token ?></label>
				<input id="editToken" name="editToken" type="text"
					readonly="readonly" placeholder="" /> <label><?php echo $lang->status ?></label> <input
					id="editStatus1" name="editStatus" type="radio" value="1"
					placeholder="Novo Status" /> <span class="label label-success"><?php echo $lang->token_active ?></span> <input id="editStatus0"
					name="editStatus" type="radio" value="0" placeholder="Novo Status" />
				<span class="label label-important"><?php echo $lang->token_deactive ?></span>
			</form>

		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" id="btn_cancel"
				aria-hidden="true">
				<?php echo $lang->cancel ?>
			</button>
			<button class="btn btn-primary" id="btn_update"
				onclick="clickSave()">
				Atualizar
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
			<button id="btn_confirm" class="btn btn-primary"
				onclick="delete_users_selected(selecteds)"><?php echo $lang->continue ?></button>
		</div>
	</div>
	<!-- End Modal -->
	
		<?php require_once 'contents/top2.php';?>

	<div style="padding-left: 315px; padding-right: 315px;"
		id="divPrincipalAddRow">
		<table class="table table-striped table-hover" id="tableList">
			<thead>
				<tr class="top-table">
					<th width="25%"><?php echo $lang->table ?></th>
					<th width="60%"><?php echo $lang->token ?></th>
					<th width="15%"><?php echo $lang->status ?></th>
				</tr>
			</thead>
		</table>
	</div>
	
	
	
	
	
	
	



	<!--/.fluid-container-->

	<!-- Le javascript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

</body>
</html>
