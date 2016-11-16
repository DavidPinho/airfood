<?php
session_start();

require_once '../../php_utils/token_validator.php';
require_once '../../model/TokenDigest.class.php';
require_once '../../model/TokenDigestDB.class.php';
require_once '../../model/TokenDB.class.php';
require_once '../../model/Token.class.php';

?>

<!DOCTYPE html>
<html>
<head>
<title>My Page</title>

<meta name="viewport"
	content="width=device-width, initial-scale=1, user-scaleable=no">
<link href="../../css/bootstrap.min.css" rel="stylesheet" media="screen">

<script src="../../js/jquery.js"></script>
<script src="../../js/bootstrap.min.js"></script>

<script type="text/javascript"
	src="../../js/control_request/load_categories.js"></script>
<script type="text/javascript">

function addCategory(id,description){

	$("#categories_list").append("<li><a data-ajax=\"false\" href=\"list_by_category.php?idCategory="+id+"&description="+description+"\"><h5>"+description+"</h5></a></li>");

	$('#categories_list').listview('refresh');
}

$(document).ready(function() {
	load_categories(addCategory,"../../control/list_categories.php");
}
);

</script>
<style type="text/css">
.img_style {
	height: 100%;
	width: 100%;
}

.item_title {
	color: rgb(75, 92, 102);
	font-size: 15px;
	float: left;
}

.item_subtitle {
	color: rgb(137, 148, 155);
}

.button-order {
	border: 1px solid #b8c3c9;
	font-family: "lucida grande", "Open Sans", tahoma, verdana, arial,
		sans-serif;
	line-height: 26px;
	display: inline-block;
	padding: 0 10px;
	color: #4b5c66;
	cursor: pointer;
	outline: none;
	position: relative;
	border-radius: 4px;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	-moz-background-clip: padding;
	-webkit-background-clip: padding-box;
	background-clip: padding-box;
	background-color: #ffffff;
	background-image: -webkit-gradient(linear, left top, left bottom, color-stop(60%, #ffffff),
		color-stop(100%, #f5f7fa) );
	background-image: -webkit-linear-gradient(#ffffff 60%, #f5f7fa 100%);
	background-image: -moz-linear-gradient(center top, #ffffff 60%, #f5f7fa 100%);
	background-image: -moz-gradient(center top, #ffffff 60%, #f5f7fa 100%);
	box-shadow: 0px 1px 0 0px rgba(0, 0, 0, 0.07);
	-webkit-box-shadow: 0px 1px 0 0px rgba(0, 0, 0, 0.07);
	-moz-box-shadow: 0px 1px 0 0px rgba(0, 0, 0, 0.07);
	-o-box-shadow: 0px 1px 0 0px rgba(0, 0, 0, 0.07);
	text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-o-user-select: none;
	user-select: none;
	-webkit-font-smoothing: auto;
}
</style>

</head>
<body>
	<script type="text/javascript">
		function openBill(){
			window.location = "my_bill.php";
		}
	</script>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner" style="text-align: center;">
			<h4 style="color: #ffffff;">Boi na Brasa</h4>
		</div>
	</div>

	<div style="padding-top: 70px;">

		<div class="row-fluid">
			<div class="span6"
				style="height: 120px; padding-left: 5%; padding-right: 5px;">

				<div class="img_style"
					style="background: url('../../img/rodizio.jpg'); background-size: cover;"></div>
				<div style="width: 95%; padding-top: 5px;">
					<div class="item_title">
						Comida Baiana<br> <span class="item_subtitle">12 itens</span>
					</div>
					
				</div>
			</div>
			<div class="span6"
				style="height: 120px; padding-right: 5%; padding-left: 5px;">
				<div class="img_style"
					style="background: url('../../img/bebidas1.jpg'); background-size: cover;"></div>

				<div style="width: 95%; padding-top: 5px;">
					<div class="item_title">
						Comida Baiana<br> <span class="item_subtitle">12 itens</span>
					</div>
				</div>


			</div>
		</div>

	</div>

</body>
</html>
