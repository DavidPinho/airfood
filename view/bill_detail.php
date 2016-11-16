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
<script src="../js/forms_erros/erro_utils.js"></script>
<script src="../js/view/bill_detail.js"></script>
<script src="../js/control_request/complete_bill_detail.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	loadCompleteBillDetails(addOrder,"../control/complete_bill_detail.php?idToken=<?php if(!empty($_GET['idToken'])){echo $_GET['idToken'];}else{echo "0";} ?>");
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

		<span style="font-size: 20px;"><?php echo $lang->typeorder ?></span>
		<div class="btn-group" style="float: right;">
			<button class="btn btn-info" onclick="openItemModal()" role="button"
				class="btn" data-toggle="modal">
				<i class="icon-plus icon-white"></i>
			</button>
			<button id="btn-remove" class="btn btn-info disabled"
				 role="button" class="btn" data-toggle="modal" onclick="delete_performed()">
				<i class="icon-remove icon-white"></i>

			</button>
			<button id="btn-edit" class="btn btn-info"  onclick="refresh()">
				<i class="icon-refresh icon-white"></i>
			</button>

		</div>
		<br /> <br /> <input type="text" id="search_box" class="search-query"
			placeholder="Search"> <br /> <br />

	</div>

	<!-- Modal -->
	<div id="itemModal" class="modal hide fade" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-hidden="true">×</button>
			<h3 id="myModalLabel"><?php echo $lang->addItem ?></h3>
		</div>
		<div class="modal-body">

			<form method="post" id="mainForm">
				<div class="row-fluid">
					<div class="span6">
						<input id="idItem" type="hidden" name="idItem" /> <label><?php echo $lang->name ?></label>
						<div id="control_name" class="control-group">
							<div class="controls">
								<input id="name" name="name" type="text"
									placeholder="Type a name for item">
							</div>
						</div>

						<label><?php echo $lang->price ?></label>
						<div id="control_price" class="control-group">
							<div class="controls">
								<input id="price" name="price" type="text"
									placeholder="Type a price for item">
							</div>
						</div>
						<label><?php echo $lang->quantity ?></label>
						<div id="control_qtd" class="control-group">
							<div class="controls">
								<input id="qtd" name="qtd" type="text"
									placeholder="Type a qtd for item">
							</div>
						</div>


					</div>
					<div class="span6">
						<label><?php echo $lang->empty_categories ?></label>
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
								<img src="../img/AAAAAA.gif" />
							</div>

							<div class="fileupload-preview fileupload-exists thumbnail"
								style="width: 50px; height: 50px;"></div>
							<span class="btn btn-file"><span class="fileupload-new"><?php echo $lang->select_image ?></span><span class="fileupload-exists">Change</span><input
								type="file" name="icon" /> </span> <a id="removeBt" href="#"
								class="btn fileupload-exists" data-dismiss="fileupload"><?php echo $lang->remove ?></a>
						</div>
					</div>

				</div>
				<div class="row-fluid">
					
					<label> <?php echo $lang->description ?></label>
						<div id="control_desc" class="control-group">
							<div class="controls">
								<textarea id="desc" name="desc" rows="5" cols="20"
									placeholder="Type a description for item"></textarea>
							</div>
						</div>
					
					
				</div>


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
				onclick="delete_itens_selected(selecteds)"><?php echo $lang->continue ?></button>
		</div>
	</div>
	<!-- End Modal -->
	
	<div id="sucess_message"
		style="padding-left: 315px; padding-right: 30px; display: none;">
		<div class="alert alert-block alert-success fade in">
			<button type="button" class="close"
				onclick="$('#sucess_message').hide();">×</button>
			<h4 class="alert-heading">
				<?php echo $lang->success ?>
				!
			</h4>
			<p>
				<?php echo $lang->msg_succes_op ?>
			</p>
		</div>
	</div>

	<div style="padding-left: 315px; padding-right: 30px;">
		<table id="order_content" class="table">
			<thead>
				<tr class="top-table">
					<th><?php echo $lang->product ?></th>
					<th><?php echo $lang->request_date ?></th>
					<th><?php echo $lang->comment ?></th>
					<th><?php echo $lang->status ?></th>
				
				</tr>
			</thead>
			<tbody id="order_content_body">

			</tbody>

		</table>


	</div>
	<!--/.fluid-container-->

	<!-- Le javascript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	

</body>
</html>
