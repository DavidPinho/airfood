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
<title><?php echo $lang->title_contact?></title>
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

	<div style="padding-left: 30px;padding-top: 70px;">
		<label class="control-label"
			style="font-size:18px;  left; padding-left: 20; padding-top: 15;">
				<?php echo $lang->message_contact1?> <a href="http://www.fiveits.com/">http://www.fiveits.com</a> <?php echo $lang->message_contact2?>
		</label>
	</div>


</body>
</html>
