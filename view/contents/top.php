<script type="text/javascript">
function openBill(){
	window.location = "my_bill.php";
}
</script>

<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<i onclick="openBill()" style="position: absolute; margin-left: 15px; margin-top: 13px;" class="icon-list icon-white"></i>
		<div style="width: 100%; text-align: center;">
			<h4 style="color: #ffffff;">
				<?php if(!empty($title)) echo $title; ?>
			</h4>
		</div>
	</div>

	
</div>


