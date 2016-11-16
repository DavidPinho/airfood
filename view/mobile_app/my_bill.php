<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>My Page</title>


<?php

require_once '../../php_utils/token_validator.php';
require_once '../../model/TokenDigest.class.php';
require_once '../../model/TokenDigestDB.class.php';
require_once '../../model/TokenDB.class.php';
require_once '../../model/Token.class.php';
require_once 'includes.php';
require_once '../../lang/lang_utils.php';

$lang=loadLang("../../lang");


?>


<script type="text/javascript">

function addItemDetail(itemBill){

	var item=JSON.parse(itemBill.item);
	var currentPrice=parseFloat(item.price)*parseFloat(itemBill.qtd);
	$("#my_bill").append("<li><div class=\"ui-grid-a\" style=\"padding-top: 5px\"><div class=\"ui-block-a\"><p style=\"font-size:15px;\">"+item.name+" <b>x"+itemBill.qtd+"</b></p></div><div class=\"ui-block-b\" align=\"right\"><p style=\"font-size:15px;\">"+currentPrice+"</p></div></div></li>");
	
	$('#my_bill').listview('refresh');
	
}

function billDetails(response){

	
	jsonReponse=JSON.parse(response);
	
	if(jsonReponse.op_code=="success"){
		var billItens=jsonReponse.bill;
		
		for(var i=0;i<billItens.length;i++){
			addItemDetail(billItens[i]);
		}

		$('#total').text(parseFloat(jsonReponse.total).toFixed(2));
		
	}
	
}

$(document).ready(function() {
	$.ajax({
		url: "../../control/get_my_bill.php",
		success: billDetails
	});	

	
});

function okClick(){
	window.location = "index.php";
}

</script>

</head>
<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<i onclick="okClick()"
				style="position: absolute; margin-left: 15px; margin-top: 13px;"
				class="icon-home icon-white"></i>
			<div style="width: 100%; text-align: center;">
				<h4 style="color: #ffffff;">
					<?php echo $lang->my_bill; ?>
				</h4>
			</div>
		</div>


	</div>


	<div data-role="page" style="margin-top: 40px;">
	
		<div data-role="content">
			<?php if(validate_session_token()){?>
			<ul id="my_bill" data-role="listview" data-inset="true">

				<li>
					<div class="ui-grid-a">
						<div class="ui-block-a">
							<?php echo $lang->product_name;?>
						</div>
						<div class="ui-block-b" align="right">$</div>

					</div>
				</li>




			</ul>

			<ul data-role="listview" data-inset="true">

				<li>
					<div class="ui-grid-a">
						<div class="ui-block-a">
							<?php echo $lang->total;?>
						</div>
						<div class="ui-block-b" align="right">
							$ <span id="total"></span>
						</div>

					</div>
				</li>
			</ul>
			<button class="btn btn-large btn-block btn-info" type="button">
				<?php echo $lang->close_bill; ?>
			</button>
			<?php }else{?>
			<div class="alert alert-block">
				<h4>
					<?php echo $lang->attention;?>
					!
				</h4>
				<?php echo $lang->no_token;?>

			</div>
			<button class="btn btn-large btn-block btn-info" type="button"
				onclick="okClick()">
				<?php echo $lang->ok; ?>
			</button>
			<?php }?>
		</div>
	</div>
</body>
</html>
