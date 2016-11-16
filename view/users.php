<?php session_start();
require_once '../lang/lang_utils.php';
require_once '../model/User.class.php';
require_once '../model/UserDB.class.php';

$lang=loadLang("../lang");


if(empty($_SESSION['user'])){
	header("Location: login.php");
}
else{
	$user = User::createFromJson($_SESSION['user']);
	if($user->getAdmin()==0){
		header("Location: dashboard.php");
	}
}

	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $lang->title_user?></title>
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
<script src="../js/control_request/load_users.js"></script>
<script src="../js/control_request/create_user.js"></script>
<script src="../js/control_request/delete_user.js"></script>
<script src="../js/control_request/update_user.js"></script>
<script src="../js/control_request/search_users.js"></script>
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



function resetForm(){

	$("#control_name").removeClass("error");
	$("#control_userName").removeClass("error");
	$("#control_password").removeClass("error");
	$("#control_email").removeClass("error");
	$("#control_confirmPassword").removeClass("error");

	document.getElementById("name").setAttribute("placeholder", '<?php echo $lang->nameOfTheUser ?>');
	document.getElementById("email").setAttribute("placeholder", '<?php echo $lang->user_email ?>');
	document.getElementById("userName").setAttribute("placeholder", '<?php echo $lang->user_userName ?>');
	document.getElementById("password").setAttribute("placeholder", '<?php echo $lang->user_password ?>');
	document.getElementById("confirmPassword").setAttribute("placeholder", '<?php echo $lang->user_confirmPass ?>');
	
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

//function to add the row
function addRow(id,name,username,password,email,admin){
	 $("#user_content tr:last").after('<tr class="toggle-row" id="row'+id+'" data-id="'+id+'" data-name="'+name+'" data-userName="'+username+'" data-email="'+email+'" data-password="'+password+'" data-admin="'+admin+'"  onclick="toogleRow(event,\'row'+id+'\')"><td>' + id + '</td><td>'
				+ name + '</td><td>'+ username + '</td><td>'+ email + '</td><td><button id="btn-password" class="btn btn-info" onclick="openPasswordDialog(\''+password+'\')"><i class="icon-tag icon-white"></i></button></td></tr>');
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

	var id=$("#row"+selecteds[0]).attr("data-id");
	var name=$("#row"+selecteds[0]).attr("data-name");
	var userName=$("#row"+selecteds[0]).attr("data-userName");
	var password=$("#row"+selecteds[0]).attr("data-password");
	var email=$("#row"+selecteds[0]).attr("data-email");
	var admin=$("#row"+selecteds[0]).attr("data-admin");
	
	document.getElementById("id_user").value=id;
	document.getElementById("name").value=name;
	document.getElementById("email").value=email;
	document.getElementById("email_aux").value=email;
   	document.getElementById("userName").value=userName;
   	document.getElementById("userName_aux").value=userName;
   	document.getElementById("password").value=password;
   	document.getElementById("confirmPassword").value=password;
    if(admin==1)
    	$('#chk_admin').attr('checked',true);
    else
    	$('#chk_admin').attr('checked',false);  
   	
	

	flagUpdate=true;
	$('#myModalLabel').text('<?php echo $lang->edt_user ?>');
	$('#userModal').modal('show');

	
}

function openPasswordDialog(password){

	document.getElementById("password_alert").value=password;
	flagUpdate=true;
	$('#passwordModal').modal('show');
	
}

function clickSave(){


	if($('#chk_admin').is(':checked'))
		document.getElementById("is_adm").value=1;
	else
		document.getElementById("is_adm").value=0;
	
	
	if(flagUpdate){
		updateUser();
	}else{
		create_user();
	}
	
}

function refresh(){
	$("#user_content").find("tr:not(:eq(0))").remove();
	load_users(addRow,"../control/list_users.php");	
}

function closeWarning(){

	$('#delete_message').hide();
	$('#sucess_message').hide();
}

function openUserModal() {

	$('#chk_admin').attr('checked',false); 
	$('#myModalLabel').text('<?php echo $lang->addUser ?>');
	$('#userModal').modal('show');

	resetForm();
	

}

$(document).ready(function() { 
	load_users(addRow,"../control/list_users.php");
    $('#userModal').on('hidden', function () {
       	flagUpdate=false;
     	$('#btn_cancel').show();
		$('#btn_create').show();
		$('#loading_image').hide();
       	document.getElementById("name").value="";
       	document.getElementById("userName").value="";
       	document.getElementById("password").value="";
       	document.getElementById("confirmPassword").value="";
    	document.getElementById("id_user").value="";
    	document.getElementById("email").value="";
    	document.getElementById("is_adm").value=0;
      });

    $('#mainForm').keypress(function(e){
        if ( e.which == 13 ){ clickSave(); return false};
    });

    $('#search_box').keypress(function(e){ //funçao que busca ao apertar enter no serach box
    	if (e.which == 13) {
			if (document.getElementById("search_box").value != ""){
        		flagSearch=true;
        		search_users();
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

		<span style="font-size: 20px;"><?php echo $lang->title_user ?></span>
		<div class="btn-group" style="float: right;">
			<button class="btn btn-info" onclick="openUserModal();closeWarning();" role="button"
				class="btn" data-toggle="modal">
				<i class="icon-plus icon-white"></i>
			</button>
			<button id="btn-edit" class="btn btn-info disabled" onclick="openUpdateDialog();closeWarning();">
				<i class="icon-edit icon-white"></i>
			</button>
			<button id="btn-remove" class="btn btn-info disabled" onclick="deletePerfomed();closeWarning();">
				<i class="icon-remove icon-white"></i>
			</button>
			<button id="btn-edit" class="btn btn-info" onclick="refresh();closeWarning();">
				<i class="icon-refresh icon-white"></i>
			</button>

		</div>
		<br /> <br /> <input type="text" id="search_box" class="search-query"
			placeholder="Search"> <br /> <br />

	</div>

	<!-- Modal -->
	
	<div id="passwordModal" class="modal hide fade" tabindex="-1"
		role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-hidden="true">x</button>
			<h3 id="PasswordModal"><?php echo $lang->password ?></h3>
		</div>
		<div class="modal-body">
			<div id="control_password2" class="control-group">
				<div class="controls">
					<input id="password_alert" = name="password_alert" type="text">
				</div>
			</div>
		</div>
	</div>
	<div id="userModal" class="modal hide fade" tabindex="-1"
		role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-hidden="true">x</button>
			<h3 id="myModalLabel"><?php $lang->addUser?></h3>
		</div>
		<div class="modal-body">
			<form id="mainForm" method="post">
				<div class="row-fluid">
					<div class="span6">
						<input id="id_user" type="hidden" name="id_user" /> 
						<label><?php echo $lang->name ?></label>
						<div id="control_name" class="control-group">
							<div class="controls">
								<input id="name" name="name" type="text"
									placeholder="Type a name for user">
							</div>
						</div>
						
						<label><?php echo $lang->email ?></label>
						<div id="control_email" class="control-group">
							<div class="controls">
								<input id="email" name="email" type="text"
									placeholder="Type a email for user">
							</div>
						</div>

						<label><?php echo $lang->username ?></label>
						<div id="control_userName" class="control-group">
							<div class="controls">
								<input id="userName" name="userName" type="text"
									placeholder="Type a userName for user">
							</div>
						</div>
						<label><?php echo $lang->password ?></label>
						<div id="control_password" class="control-group">
							<div class="controls">
								<input id="password" name="password" type="password"
									placeholder="Type a password for user">
							</div>
						</div>
						<label><?php echo $lang->confirm_password ?></label>
						<div id="control_confirmPassword" class="control-group">
							<div class="controls">
								<input id="confirmPassword" name="confirmPassword" type="password"
									placeholder="Type a confirmPassword for user">
							</div>
						</div>
						<label class="checkbox"><input id="chk_admin" type="checkbox"  name="chk_admin"/> <?php echo $lang->is_admin ?> </label>


					</div>
				</div>
			<input id="userName_aux" name="userName_aux" type="hidden" />
			<input id="email_aux" name="email_aux" type="hidden" />	
			<input id="is_adm" name="is_adm" type="hidden" />	
			</form>

		</div>

		<div class="modal-footer">
			<button id="btn_cancel" class="btn" data-dismiss="modal"
				aria-hidden="true"><?php echo $lang->cancel ?></button>
			<button id="btn_create" class="btn btn-primary"
				onclick="clickSave()"><?php echo $lang->save ?></button>
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
		<table id="user_content" class="table">
			<thead>
				<tr class="top-table">
					<th width="15%"><?php echo $lang->id ?></th>
					<th width="21%"><?php echo $lang->name ?></th>
					<th width="22%"><?php echo $lang->username ?></th>
					<th width="22%"><?php echo $lang->email ?></th>
					<th width="20%"><?php echo $lang->password ?></th>
				</tr>
			</thead>
			<tbody id="user_content_body">

			</tbody>

		</table>


	</div>
	<!--/.fluid-container-->

	<!-- Le javascript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->


</body>
</html>
