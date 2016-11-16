<?php
//Created by David Pinho on December 02 2012
//Login Page
session_start();

require_once '../lang/lang_utils.php';

$lang=loadLang("../lang");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html lang="en">

<head>
<meta charset="utf-8">
<title><?php echo $lang->airfood_manager ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/bootstrap.css" rel="stylesheet" media="screen">
<link href="../css/b5kXG9qfH3h.css" rel="stylesheet" media="screen">
<link href="../css/o7qf8v3_t9P.css" rel="stylesheet" media="screen">
<link href="../css/stlehehA4Ny.css" rel="stylesheet" media="screen">
<script src="../js/-t5QmeR2LyE.js"></script>
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/jquery.form.js"></script>
<script src="../js/control_request/authenticate.js"></script>
<script src="../js/forms_erros/erro_utils.js"></script>

<script type="text/javascript">


function resetForm(){
    $("#control_userName").removeClass("error");
	$("#control_password").removeClass("error");

}

function clickConfirm(){
  	authenticate_user();
}

</script>

<?php

if(!(empty($_SESSION['user'])))
	header("Location: dashboard.php")

?>
</head>



<body class="login_page UIPage_LoggedOut webkit win Locale_pt_BR">
	<div id="FB_HiddenContainer" style="position:absolute; top:-10000px; width:0px; height:0px;"></div>
	<div class="_li">
		<div id="pagelet_bluebar" data-referrer="pagelet_bluebar">
			<div id="blueBarHolder">
				<div id="blueBar">
					<div>
						<div class="loggedout_menubar_container" style="background-color: #000000;">
							<div class="clearfix loggedout_menubar">
								<a class="lfloat" href="/"	title="Ir para a página inicial do Airfood">
									<i class="fb_logo img sp_38839k sx_127aa9">
										<u><?php echo $lang->airfood_logo ?></u>
									</i>
								</a>
							</div>
						</div>

		  		</div>
	  		</div>
  		</div>
  	</div>
  	<div id="globalContainer"	class="uiContextualLayerParent">
  		<div id="content" class="fb_content clearfix">
  			<div class="UIFullPage_Container">
  				<div class="mvl ptm uiInterstitial login_page_interstitial uiInterstitialLarge uiBoxWhite">
  					<div class="uiHeader uiHeaderBottomBorder mhl mts uiHeaderPage interstitialHeader">
  						<div class="clearfix uiHeaderTop">
  							<div class="rfloat">
  								<div class="uiHeaderActions"></div>
  							</div>
  							<div>
  								<h2 class="uiHeaderTitle" style="font-family:arial"	aria-hidden="true"><?php echo $lang->airfood_enter ?></h2>
  							</div>
  						</div>
  					</div>
  					<div class="phl ptm uiInterstitialContent">
  						<div class="login_form_container">
  							<form  id="mainForm" class="form-horizontal" method="post" >
  								<div id="control_userName" class="control-group">
    								<label class="control-label" style="font-family:arial" for="userName"><?php echo $lang->navbar_user ?></label>
    								<div class="controls">
      									<input type="text" id="userName"  name="userName">
    								</div>
  								</div>
  								<div  id="control_password" class="control-group">
    								<label class="control-label" style="font-family:arial" for="password"><?php echo $lang->password ?></label>
    								<div class="controls">
      									<input type="password" id="password" name="password" >
    								</div>
  								</div>
  								<div class="control-group">
    								<div class="controls">
      							      <button type="submit" class="btn" onclick="clickConfirm()"><?php echo $lang->enter ?></button>
      							      <a href="recover_password.php" style="font-size: 13; margin-left: 2;"><?php echo $lang->forgot_password ?></a>
</div>
</div>

</form>

</div>
</div>
</div>
</div>
</div>

</div>
</div>



</body>




</html>