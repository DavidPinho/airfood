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
<script src="../js/control_request/save_configuration.js"></script>
<script src="../js/utils/replace_all.js"></script>
<script src="../js/forms_erros/erro_utils.js"></script>
<script src="../js/bootstrap.js"></script>

<style type="text/css">
.form-signin {
	max-width: 300px;
	padding: 19px 29px 29px;
	margin: 80px auto 20px;
	background-color: rgb(255, 255, 255);
	border: 1px solid rgb(229, 229, 229);
	border-radius: 5px 5px 5px 5px;
	box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
}
</style>

</head>

<body>

	<?php require_once 'contents/top2.php';?>
	<div class="container">

		<div class="form-signin">
			<div id="sucess_message"
				style="display: none;">
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
			<h2>Inioma</h2>
			<select id="language" class="input-block-level">
				<option value="portugues">Portugues</option>
				<option value="english">Ingles</option>
			</select>
			<button class="btn btn-primary" onclick="save_configuration()">Salvar</button>
			<img src="../img/load.gif" style="display: none;" id="loading_image">
		</div>

	</div>
</body>
</html>
