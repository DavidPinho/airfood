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
<title><?php echo $lang->titleCategory ?></title>
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
<script src="../js/control_request/create_category.js"></script>
<script src="../js/control_request/load_categories.js"></script>
<script src="../js/control_request/delete_categories.js"></script>
<script src="../js/control_request/search_categories.js"></script>
<script src="../js/control_request/update_category.js"></script>
<script src="../js/forms_erros/erro_utils.js"></script>
<script type="text/javascript">
/*
 * Global variables to control the select action in the category table
 *
 * btUpdateEnabled and btRemoveEnabled are flags to control the click on button Edit
 * and remove
 *
 */
var selecteds = new Array();// array for selected rows
var btUpdateEnabled = false;
var btRemoveEnabled = false;
var flagUpdate = false;

function resetForm(){

	$("#control_desc").removeClass("error");
	
	
}

// Function to toogle the row clicked
function toogleRow(event, click) {
	var id = $("#" + click).attr("data-id");

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

// function to add the row//????
function addRow(id, description, qtdeItens,image) {
	$("#category_content tr:last").after(
			'<tr class="toggle-row" id="row' + id + '" data-id="' + id
					+ ' "data-image="'+image+'" data-desc="' + description + '" data-qtdeItens="' + qtdeItens
					+ '" onclick="toogleRow(event,\'row' + id + '\')"><td>'
					+ id + '</td><td>' + description + '</td><td>' + qtdeItens + '</td></tr>');
}

// function to delete the row
function deletePerfomed() {

	if (!btRemoveEnabled)
		return false;

	$('#deleteModal').modal("show");
}

// function to reajust the state of buttons
function notifyButtons() {
	if (selecteds.length == 0) {
		$("#btn-remove").addClass("disabled");
		btRemoveEnabled = false;
	} else {
		$("#btn-remove").removeClass("disabled");
		btRemoveEnabled = true;
	}

	if (selecteds.length == 1) {
		$("#btn-edit").removeClass("disabled");
		btUpdateEnabled = true;
	} else {
		$("#btn-edit").addClass("disabled");
		btUpdateEnabled = false;
	}
}

function openUpdateDialog() {

	if (!btUpdateEnabled)
		return;

	var id = $("#row" + selecteds[0]).attr("data-id");
	var description = $("#row" + selecteds[0]).attr("data-desc");
	var image = $("#row" + selecteds[0]).attr("data-image");

	document.getElementById("desc").value = description;
	document.getElementById("id_category").value = id;
	document.getElementById("desc_aux").value = description;
	if(image==null)
		document.getElementById("img_icon").setAttribute("src","../img/icons/AAAAAA.gif");
	else
		document.getElementById("img_icon").setAttribute("src","../img/icons/"+image);
	

	flagUpdate = true;
	$('#myModalLabel').text('<?php echo $lang->update_category ?>');
	$('#categoryModal').modal('show');
	

}

function openCategoryModal() {

	
	$('#myModalLabel').text('<?php echo $lang->addCategory ?>');
	$('#categoryModal').modal('show');
	

}

function clickSave() {

	if (flagUpdate) {
		update_category(document.getElementById("id_category").value, document.getElementById("img_icon").value);
	} else {
		create_category();
	}
}

function closeWarning(){

	$('#delete_message').hide();
	$('#sucess_message').hide();
	$('#erro_message').hide();
}

function cofirmDelete() {

	delete_selected_categories(selecteds);
}

function refresh() {
	$("#category_content").find("tr:not(:eq(0))").remove();
	load_categories(addRow, "../control/list_categories.php");
}

$(document).ready(function() {
	load_categories(addRow, "../control/list_categories.php");
	$('#categoryModal').on('hidden', function() {
		flagUpdate = false;
		document.getElementById("desc").value = "";
		document.getElementById("id_category").value = "";
		document.getElementById("img_icon").value="";
		$("#control_desc").removeClass("error");
		document.getElementById("desc").setAttribute("placeholder", "Digite um nome para a categoria");
		$('#removeBt').click();//Empty the file chooser camp.
	});

	$('#mainForm').keypress(function(e) {
		if (e.which == 13) {
			clickSave();
			return false
		}
		;
	});

	$('#search_box').keypress(function(e){ //funçao que busca ao apertar enter no serach box
    	if (e.which == 13) {
			if (document.getElementById("search_box").value != ""){
        		flagSearch=true;
        		search_categories();
            	return false;
            }else
                return false;
		};
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

		<span style="font-size: 20px;"><?php echo $lang->typeCategory ?> </span>
		<div class="btn-group" style="float: right;">
			<button id="btn-add" class="btn btn-info" onclick="openCategoryModal();closeWarning();"
				role="button" class="btn" data-toggle="modal">
				<i class="icon-plus icon-white"></i>
			</button>
			<button id="btn-edit" class="btn btn-info disabled"
				onclick="openUpdateDialog();closeWarning();">
				<i class="icon-edit icon-white"></i>
			</button>
			<button id="btn-remove" class="btn btn-info disabled"
				onclick="deletePerfomed();closeWarning();">
				<i class="icon-remove icon-white"></i>

			</button>
			<button id="btn-update" class="btn btn-info" onclick="refresh();closeWarning();">
				<i class="icon-refresh icon-white"></i>
			</button>

		</div>
		<br /> <br /> <input type="text" id="search_box" class="search-query"
			placeholder="<?php echo $lang->search ?>"> <br /> <br />

	</div>

	<!-- Modal -->
	<div id="categoryModal" class="modal hide fade" tabindex="-1"
		role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-hidden="true">x</button>
			<h3 id="myModalLabel">
				<?php echo $lang->addCategory ?>
			</h3>
		</div>
		<div class="modal-body">
			<form id="mainForm" method="post" >
				<div class="row-fluid">
					<div class="span6">
						<label><?php echo $lang->name ?> </label>
						<div id="control_desc" class="control-group">
							<div class="controls">
								<input id="desc" name="desc" type="text"
									placeholder="<?php echo $lang->msg_addCategory ?>" /> 
									<input id="id_category" name="id_category" type="hidden" />
									<input id="desc_aux" name="desc_aux" type="hidden" />
							</div>
						</div>
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
					</div>
				</div>


			</form>

		</div>

		<div class="modal-footer">
			<button id="btn_cancel" class="btn" data-dismiss="modal"
				aria-hidden="true">
				<?php echo $lang->cancel ?>
			</button>
			<button id="btn_create" class="btn btn-primary" onclick="clickSave()">
				<?php echo $lang->save ?>
			</button>
			<img src="../img/load.gif" style="display: none;" id="loading_image">
		</div>
	</div>
	<!-- End Modal -->

	<!-- Modal -->
	<div id="deleteModal" class="modal hide fade" tabindex="-1"
		role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-hidden="true">×</button>
			<h3 id="myModalLabel" class="text-warning">
				<?php echo $lang->attention ?>
			</h3>
		</div>
		<div class="modal-body">
			<h4>
				<?php echo $lang->msg_attention ?>
			</h4>

		</div>

		<div class="modal-footer">
			<button id="btn_cancel_delete" class="btn" data-dismiss="modal"
				aria-hidden="true">
				<?php echo $lang->cancel ?>
			</button>
			<button id="btn_confirm" class="btn btn-primary"
				onclick="delete_selected_categories(selecteds)">
				<?php echo $lang->continue ?>
			</button>
		</div>
	</div>
	<!-- End Modal -->

	<div id="erro_message"
		style="padding-left: 315px; padding-right: 30px; display: none;">
		<div class="alert alert-block alert-error fade in">
			<button type="button" class="close"
				onclick="$('#erro_message').hide();">×</button>
			<h4 class="alert-heading">
				<?php echo $lang->attention; ?>
				!
			</h4>
			<p>
				<?php echo $lang->msg_erro_cat_delete; ?>
			</p>
		</div>
	</div>
	
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
	
	<div style="padding-left: 315px; padding-right: 30px;">
		<table id="category_content" class="table">
			<thead>
				<tr class="top-table">
					<th width="17%"><?php echo $lang->id ?></th>
					<th width="60%"><?php echo $lang->name ?></th>
					<th width="23%"><?php echo $lang->quantity ?></th>
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
