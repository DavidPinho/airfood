<?php session_start();
include_once '../lang/lang_utils.php';
$lang=loadLang("../lang");
if(empty($_SESSION['user'])){
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $lang->title_item?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<!-- Le styles -->
<link href="../css/bootstrap-responsive.css" rel="stylesheet">
<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/my_style.css" rel="stylesheet">
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/jquery.form.js"></script>
<script src="../js/control_request/load_categories.js"></script>
<script src="../js/control_request/list_itens.js"></script>
<script src="../js/control_request/search_itens.js"></script>
<script src="../js/control_request/create_item.js"></script>
<script src="../js/control_request/update_item.js"></script>
<script src="../js/control_request/delete_item.js"></script>
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

function resetForm(){

	$("#control_name").removeClass("error");
	$("#control_desc").removeClass("error");
	$("#control_price").removeClass("error");
	$("#control_qtd").removeClass("error");
	$("#control_categories").removeClass("error");
	
}

//Function to toogle the row clicked
function toogleRow(event,click){
	
	var id=$("#"+click).attr("data-id");

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


function delete_performed(){

	var idRow="#row"+selecteds;
	var status=$(idRow).attr("data-status");

	if(!btRemoveEnabled)
		return false;
	
	if(status == 0){
		$('#deactivated_message').show();
		return false;
	}
	$('#deleteModal').modal('show');
}


function addOption(id,description){
	 $('#categories').append("<option value=\""+id+"\">"+description+"</option>"); 
}


function refresh(){
	$("#category_content").find("tr:not(:eq(0))").remove();
	var only_act=0;
	if($('#chk_only_active').is(':checked')){
		only_act=1;
	}
	load_itens(addItemRow,"../control/list_itens.php?only_act="+only_act);
	flagSearch=false;	
}

$(document).ready(function() {
	load_itens(addItemRow,"../control/list_itens.php?only_act=1");
	load_categories(addOption, "../control/list_categories.php");
	
	$('#itemModal').on('hidden', function () {
       	flagUpdate=false;

      $('#btn_cancel').show();
		$('#btn_create').show();
		$('#loading_image').hide();
		$('#wrongImgType_message').hide();

		
      document.getElementById("desc").value="";
      document.getElementById("desc").setAttribute("placeholder", "<?php echo $lang->empty_desc ?>");
    	document.getElementById("name").value="";
    	document.getElementById("name").setAttribute("placeholder", "<?php echo $lang->empty_name ?>");
    	document.getElementById("price").value="";
    	document.getElementById("price").setAttribute("placeholder", "<?php echo $lang->empty_price ?>");
    	document.getElementById("qtd").value="";
    	document.getElementById("qtd").setAttribute("placeholder", "<?php echo $lang->empty_qtd ?>");
    	
    	var select = document.getElementById("categories");
    	var selectLength = document.getElementById("categories").length;

    	for(var i = 0;i<selectLength;i++){
			if(select.options[i]!=null)
    			select.options[i].selected = false;
    	}
		
    	$('#removeBt').click();//Empty the file chooser camp.

    	resetForm();
      });	

    $('#search_box').keypress(function(e){ //funçao que busca ao apertar enter no serach box
    	if (e.which == 13) {
			if (document.getElementById("search_box").value != ""){
        		flagSearch=true;
        		search_itens();
            	return false;
            }else
                return false;
		};
    });

    $('#chk_only_active').click(function() {      
    	$("#category_content").find("tr:not(:eq(0))").remove();
    	selecteds.length=0;//clear the array
    	notifyButtons();

    	if(flagSearch){
            search_itens();

            return;
    	}
    	
    	var only_act=0;
    	if($('#chk_only_active').is(':checked')){
    		only_act=1;
    	}
    	load_itens(addItemRow,"../control/list_itens.php?only_act="+only_act);	
    });   
    
});

function clickSave(){

	if($('#editStatus1').is(':checked'))
		document.getElementById("active").value=1;
	else
		document.getElementById("active").value=0;

	
	if(flagUpdate){
		updateItem();
	}
	else
		createItem();		
}


function closeWarning(){

	$('#delete_message').hide();
	$('#sucess_message').hide();
	$('#deactivated_message').hide();
}


function openUpdateDialog(){

	if(!btUpdateEnabled)
		return;

	var idRow="#row"+selecteds[0];
	
	var idItem=$(idRow).attr("data-id");
	var name=$(idRow).attr("data-name");
	var desc=$(idRow).attr("data-desc");
	var price=$(idRow).attr("data-price");
	var qtd=$(idRow).attr("data-qtd");
	var idCategory=$(idRow).attr("data-idCategory");
	var icon=$(idRow).attr("data-icon");
	var status=$(idRow).attr("data-status");
	
	
	document.getElementById("name").value=name;
	document.getElementById("name_aux").value=name;
	document.getElementById("desc").value=desc;
	document.getElementById("price").value=price;
	document.getElementById("qtd").value=qtd;
	document.getElementById("idItem").value=idItem;
	document.getElementById("img_old").value=icon;
	
	document.getElementById("img_icon").setAttribute("src","../img/icons/"+icon);

	if(status == 0)
		$("#editStatus0").attr('checked', true);
	else
		$("#editStatus1").attr('checked', true);

	$('select').val(idCategory);

	flagUpdate=true;
	$('#myModalLabel').text('<?php echo $lang->update_item ?>');
	$('#itemModal').modal('show');

	
}


function openItemModal() {

	document.getElementById("img_icon").setAttribute("src","../img/icons/AAAAAA.gif");
	$("#editStatus1").attr('checked', true);
	
	$('#myModalLabel').text('<?php echo $lang->addItem ?>');
	$('#itemModal').modal('show');
	

}

function addItemRow(id,name,desc,price,qtd,idCategory,icon,active){

	outStatus="";
	if(active==1){
		outStatus="<span class=\"label label-success\"><?php echo $lang->token_active;?></span>";
	}else{
		outStatus="<span class=\"label label-important\"><?php echo $lang->token_deactive;?></span>";
	}

	$("#category_content tr:last").after('<tr class="toggle-row" id="row'+id+'" data-id="'+id+'" data-icon="'+icon+'" data-name="'+name+'"  data-status="'+active+'"  data-price="'+price+'" data-qtd="'+qtd+'" data-desc="'+desc+'" data-idCategory="'+idCategory+'"  onclick="toogleRow(event,\'row'+id+'\')"><td>'+ id +'</td><td>'+ name +'</td><td>'+desc +'</td><td>'+ price+'</td><td>'+qtd+'</td><td>'+ outStatus + '</td></tr>');
	
}

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

		<span style="font-size: 20px;"><?php echo $lang->title_item ?></span>
		<div class="btn-group" style="float: right;">
			<button id="btn-add" class="btn btn-info" onclick="closeWarning();openItemModal();" role="button"
				class="btn" data-toggle="modal">
				<i class="icon-plus icon-white"></i>
			</button>
			<button id="btn-edit" class="btn btn-info disabled"
				onclick="closeWarning();openUpdateDialog();">
				<i class="icon-edit icon-white"></i>
			</button>
			<button id="btn-remove" class="btn btn-info disabled"
				 role="button" class="btn" data-toggle="modal" onclick="closeWarning();delete_performed();">
				<i class="icon-remove icon-white"></i>

			</button>
			<button id="btn-update" class="btn btn-info"  onclick="closeWarning();refresh();">
				<i class="icon-refresh icon-white"></i>
			</button>

		</div>
		<br /> <br /> <input type="text" id="search_box" class="search-query"
			placeholder="<?php echo $lang->search ?>"> <br /> <br />
		<label class="checkbox"><input id="chk_only_active" type="checkbox" checked="true" name="only_active"/> Mostrar somente itens ativos </label>

	</div>

	<!-- Modal -->
	<div id="itemModal" class="modal hide fade" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-hidden="true">x</button>
			<h3 id="myModalLabel"><?php echo $lang->addItem ?></h3>
		</div>
		
		<div id="wrongImgType_message"
			style="padding-left: 15px; padding-right: 30px; display: none;">
			<div class="alert alert-error fade in">
				<button type="button" class="close"
					onclick="$('#wrongImgType_message').hide();">x</button>
				<h4 class="alert-heading">
					<?php echo $lang->msg_wrongImgType ?>
				</h4>
				<p>
					<?php echo $lang->msg_succes_op ?>
				</p>
			</div>
		</div>
		
		<div class="modal-body">

			<form method="post" id="mainForm">
				<div class="row-fluid">
					<div class="span6">
						<input id="img_old" type="hidden" name="img_old" />
						<input id="idItem" type="hidden" name="idItem" />
						<input id="active" type="hidden" name="active"/>
						
						<label><?php echo $lang->name ?></label>
						<div id="control_name" class="control-group">
							<div class="controls">
								<input id="name" name="name" type="text"
									placeholder="Digite um nome">
							</div>
						</div>

						<label><?php echo $lang->price ?></label>
						<div id="control_price" class="control-group">
							<div class="controls">
								<input id="price" name="price" type="text"
									placeholder="Digite um preço">
							</div>
						</div>
						<label><?php echo $lang->quantity ?></label>
						<div id="control_qtd" class="control-group">
							<div class="controls">
								<input id="qtd" name="qtd" type="text"
									placeholder="Digite uma quantidade">
							</div>
						</div>
						
						<label> <?php echo $lang->description ?> </label>
						<div id="control_desc" class="control-group">
							<div class="controls">
								<textarea id="desc" name="desc" rows="5" cols="20"
									placeholder="Digite uma descrição"></textarea>
							</div>
						</div>


					</div>
					<div class="span6">
						<label><?php echo $lang->category ?></label>
						<div id="control_categories" class="control-group">
							<div class="controls">
								<select name="categories" id="categories" multiple="multiple">
								</select>
							</div>
						</div>
						<label><?php echo $lang->image ?></label>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail"
								style="width: 50px; height: 50px;">
								<img id="img_icon" src="../img/icons/AAAAAA.gif" />
							</div>

							<div class="fileupload-preview fileupload-exists thumbnail"
								style="width: 50px; height: 50px;"></div>
							<span class="btn btn-file"><span class="fileupload-new"><?php echo $lang->select_image ?></span>
									<span class="fileupload-exists"><?php echo $lang->change ?></span><input
								type="file" name="icon" /> </span> <a id="removeBt" href="#"
								class="btn fileupload-exists" data-dismiss="fileupload"><?php echo $lang->remove ?></a>
						</div>
						
						<label><?php echo $lang->status ?></label> 
						<input id="editStatus1"	name="editStatus" type="radio" value="1" placeholder="Novo Status" /> <span class="label label-success"><?php echo $lang->token_active ?></span>
					    <input id="editStatus0"	name="editStatus" type="radio" value="0" placeholder="Novo Status" /> <span class="label label-important"><?php echo $lang->token_deactive ?></span>
										
					</div>

				</div>
				<input id="name_aux" name="name_aux" type="hidden" />
				
			</form>

		</div>

		<div class="modal-footer">
			<button id="btn_cancel" class="btn" data-dismiss="modal"
				aria-hidden="true"><?php echo $lang->cancel ?></button>
			<button id="btn_create" class="btn btn-primary" onClick="clickSave()"><?php echo $lang->save ?></button>
			<img src="../img/load.gif" style="display: none;" id="loading_image">
		</div>
	</div>
	<!-- End Modal -->

	<!-- Modal -->
	<div id="deleteModal" class="modal hide fade" tabindex="-1"
		role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-hidden="true">x</button>
			<h3 id="myModalLabel" class="text-warning"><?php echo $lang->attention ?></h3>
		</div>
		<div class="modal-body">
			<h4><?php echo $lang->msg_attention ?></h4>

		</div>

		<div class="modal-footer">
			<button id="btn_cancel_delete" class="btn" data-dismiss="modal"
				aria-hidden="true"><?php echo $lang->cancel ?></button>
			<button id="btn_confirm" class="btn btn-primary"
				onclick="delete_itens_selected(selecteds);"><?php echo $lang->continue ?></button>
		</div>
	</div>
	<!-- End Modal -->
	
	<div id="sucess_message"
		style="padding-left: 315px; padding-right: 30px; display: none;">
		<div class="alert alert-block alert-success fade in">
			<button type="button" class="close"
				onclick="$('#sucess_message').hide();">x</button>
			<h4 class="alert-heading">
				<?php echo $lang->success ?>
			</h4>
			<p>
				<?php echo $lang->msg_succes_op ?>
			</p>
		</div>
	</div>
	
	<div id="delete_message"
		style="padding-left: 315px; padding-right: 30px; display: none;">
		<div class="alert alert-block alert-delete fade in">
			<button type="button" class="close"
				onclick="$('#delete_message').hide();">x</button>
			<h4 class="alert-heading">
				<?php echo $lang->msg_delSuccess ?>
				!
			</h4>
			<p>
				<?php echo $lang->msg_succes_op ?>
			</p>
		</div>
	</div>
	
	<div id="deactivated_message"
		style="padding-left: 315px; padding-right: 30px; display: none;">
		<div class="alert alert-block alert-delete fade in">
			<button type="button" class="close"
				onclick="$('#deactivated_message').hide();">x</button>
			<h4 class="alert-heading">
				<?php echo $lang->attention ?>
				!
			</h4>
			<p>
				<?php echo $lang->msg_deactivatedItem ?>
			</p>
		</div>
	</div>
	
	<div style="padding-left: 315px; padding-right: 30px;">
		<table id="category_content" class="table">
			<thead>
				<tr class="top-table">
					<th width="7%"><?php echo $lang->id ?></th>
					<th width="23%"><?php echo $lang->name ?></th>
					<th width="39%"><?php echo $lang->description ?></th>
					<th width="10%"><?php echo $lang->price ?></th>
					<th width="9%"><?php echo $lang->quantity ?></th>
					<th width="12%"><?php echo $lang->status ?></th>
				</tr>
			</thead>
			<tbody id="category_content_body">

			</tbody>

		</table>


	</div>
	<!--/.fluid-container-->

	<!-- Le javascript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->


</body>
</html>
