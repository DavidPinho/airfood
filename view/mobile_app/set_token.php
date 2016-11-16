<?php session_start();
require_once '../../lang/lang_utils.php';

$lang=loadLang("../../lang");
?>
<!DOCTYPE html>
<html>
<head>
<title>My Page</title>

<?php require_once 'includes.php' ?>

<script type="text/javascript"
	src="../../js/control_request/list_itens.js"></script>
<script src="../../js/jquery.form.js"></script>
<script src="../../js/utils/random.js"></script>
<script src="../../js/control_request/auth_token.js"></script>
<script type="text/javascript">



</script>

</head>
<body>

	<div data-role="page">

		<?php $title=$lang->set_token; require_once '../contents/top.php' ?>


		<div class="well">

			<form class="form-signin">
				
				<input id="token" type="text" class="input-block-level input-large"   style="height:40px; -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);"
					placeholder="<?php echo $lang->insert_toke_here ?>"> 
				</label>
				<button  style="-webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);" class="btn btn-large btn-block btn-success" type="button" onclick="validate_token()" ><?php echo $lang->use ?></button>
			</form>

		</div>
		<!-- /container -->

	</div>
	<!-- /page -->

</body>
</html>
