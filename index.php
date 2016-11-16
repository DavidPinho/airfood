<?php 
	session_start();

	if(isset($_SESSION['user']))		
		header("Location: view/dashboard.php");
	else 
		header("Location: view/login.php");
		
			
?>

<!DOCTYPE html>
<html>
<head>
<title>My Page</title>
<meta name="viewport"
	content="width=device-width, initial-scale=1, user-scaleable=no">
<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.2.0.css" />
<link rel="stylesheet" href="docs/_assets/css/jqm-docs.css" />
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

<script src="js/jquery.js"></script>
<script src="docs/_assets/js/jqm-docs.js"></script>
<script src="js/jquery.mobile-1.2.0.js"></script>
<script src="js/bootstrap.min.js"></script>


</head>
<body>

	<div data-role="page">

		<div data-role="header">
			<h5>Restaurante</h5>
		</div>
		<!-- /header -->

		<div data-role="content">
			<a class="btn" href="teste.php" data-transition="fade">Button</a>
		</div>
		<!-- /content -->

	</div>
	<!-- /page -->

</body>
</html>
