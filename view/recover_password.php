<?php session_start();
if(empty($_SESSION['user'])){
	header("Location: login.php");
}?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" ">
<html lang="en">

<head>
<meta charset="utf-8">
<title><?php echo $lang->recover_password ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/my_style.css" rel="stylesheet">
		<script src="../js/jquery.js"></script>
		<script src="../js/bootstrap.js"></script>
		<script src="../js/jquery.form.js"></script>
		<script src="../js/control_request/recover_password.js"></script>
		<script src="../js/forms_erros/erro_utils.js"></script>


<script type="text/javascript">


function resetForm(){
    $("#control_userNamePassword").removeClass("error");
    $('#alert-success').hide();

}

function recoverPassword(){
	recover_password();
}





</script>

</head>



<body>

	<?php require_once 'contents/top2.php';?>

	<div class="container">
	
		<div class="alert alert-info"
			style="margin-top: 180; margin-left: 320; width: 250; background-color: rgb(252, 255, 223);">
			<?php echo $lang->msg_showPassword ?></div>


		<form id="mainForm" method="post" class="form-horizontal"
			style="margin-left: 320; background-color: rgb(245, 245, 245); width: 300; border: 1px solid #bce8f1; border-radius: 4px;">
			<div class="control-group" style="margin-bottom: 8;">
				<label class="control-label" for="inputEmail"
					style="text-align: left; padding-left: 20; padding-top: 15;"><strong><?php echo $lang->username_email ?></strong> </label>
			</div>
			<div id="control_userNamePassword" class="control-group"
				style="margin-bottom: 8;">
				<div class="controls" style="margin-left: 0;"> 
					<input id="userNamePassword"  name="userNamePassword" type="text"
						placeholder="User name or Email"
						style="margin-left: 20; height: 30;">
				
				</div>
			</div>
			<div class="control-group">

				<button type="submit" class="btn btn-info"
					style="margin-left: 20; height: 28; margin-top: 8;"
					onclick="recoverPassword()"><?php echo $lang->recover ?></button>

			</div>
		</form>

		<div id="alert-success" class="alert alert-success"
			style="margin-top: 10; line-height: 8px; width: 250; margin-left: 320; display: none; ">
			
			</div>


	</div>


</body>




</html>
