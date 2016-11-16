<div data-role="popup" style="padding: 25px 25px 15px 25px;"
	id="popupBasic" data-overlay-theme="a">
	<div data-role="button" data-theme="a" data-icon="delete"
		data-iconpos="notext" class="ui-btn-right"
		onclick="$('#popupBasic').popup('close');">Close</div>
	<table id="order_details" border="0px" style="width: 220px;">
		<tr id="titleOrderRow" style="display: none;">
			<td align="center">
				<span style="font-size: 20px;" id="titleOrder"></span>
			</td>
		</tr>
		<tr>
			<td><?php echo $lang->qtd; ?><br /> <select onselect="changeQtd()" id="qtd">
					<?php for($i=1;$i<11;$i++){?>
						<option><?php echo $i;?></option>
					<?php }?>
				
			</select> <input id="idItem" type="hidden" />
			<input id="iPrice" type="hidden" /></td>
		</tr>
		<tr>
			<td><?php echo $lang->comment; ?><br /> <textarea id="comment"
					rows="3" placeholder="<?php echo $lang->comment_placeholder; ?>"></textarea>
			</td>
		</tr>
		<tr>
			<td><?php echo $lang->total; ?> $<span id="price"></span></td>
		</tr>
		<tr>
			<td align="center">
				<button id="bt_order" class="btn btn-large btn-block btn-info" type="button"
					onclick="startLoading('order'); sendOrder()">
					<?php echo $lang->confirm; ?>
				</button>
				<img id="order_loader" src="../../img/m_loader.gif" style="display: none;"/>

			</td>
		</tr>
	</table>


	<table id="order_message" border="0px"
		style="width: 220px; display: none;">
		<tr>
			<td>
				<div id="order_alert_message" class="alert alert-success"></div>

				<button class="btn btn-large btn-block btn-info" type="button"
					onclick="$('#popupBasic').popup('close');">
					<?php echo $lang->ok; ?>
				</button>

			</td>
		</tr>

	</table>

</div>

<div data-role="popup" style="padding: 25px 25px 15px 25px;"
	id="tokenPopup" data-overlay-theme="a">
	<div data-role="button" data-theme="a" data-icon="delete"
		data-iconpos="notext" class="ui-btn-right"
		onclick="$('#tokenPopup').popup('close');">Close</div>
	<table id="auth_details" border="0px" style="width: 220px;">
		<tr>
			<td align="center">
				<form class="form-signin">
					<div id="alert_message" class="alert alert-info">
						<?php echo $lang->token_invalid;?>
					</div>

					<input id="token" type="text" class="input-block-level input-large"
						style="height: 40px; -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);"
						placeholder="<?php echo $lang->insert_toke_here ?>"> </label>
					<button id="bt_auth"
						style="-webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);"
						class="btn btn-large btn-block btn-info" type="button"
						onclick="startLoading('auth'); validate_token(mFuncCallBack)">
						<?php echo $lang->use ?>
					</button>
					<img id="auth_loader" src="../../img/m_loader.gif" style="display: none;"/>
				</form>
			</td>
		</tr>

	</table>
	
	<table id="auth_message" border="0px"
		style="width: 220px; display: none;">
		<tr>
			<td>
				<div id="auth_alert_message" class="alert"></div>

				<button class="btn btn-large btn-block btn-info" type="button"
					onclick="$('#tokenPopup').popup('close');">
					<?php echo $lang->ok; ?>
				</button>

			</td>
		</tr>

	</table>
</div>


<script type="text/javascript">
$("#popupBasic").on({
	   popupafterclose: function(event, ui) {
		   $("#order_details").show();
		   $("#order_message").hide();
		   $("#bt_order").show();
		   $("#order_loader").hide();

		   $("#order_alert_message").remoceClass("alert-success");
		   $("#order_alert_message").remoceClass("alert-error");
	}
});

$("#tokenPopup").on({
	   popupafterclose: function(event, ui) {
		   $("#auth_details").show();
		   $("#auth_message").hide();
		   $("#bt_auth").show();
		   $("#auth_loader").hide();

		   $("#auth_alert_message").remoceClass("alert-success");
		   $("#auth_alert_message").remoceClass("alert-error");
		   
	}
});

function startLoading(btToHide){

	$("#bt_"+btToHide).hide();
	$("#"+btToHide+"_loader").show();
	
	
}

$('#qtd').change(function() {
	qtd=$("#qtd").val();
	price=$("#iPrice").val();
	newTotal=parseFloat(qtd)*parseFloat(price);

	$("#price").text(parseFloat(newTotal).toFixed(2));
});

$('#token').keypress(function(e){ //funçao que busca ao apertar enter no serach box
	if (e.which == 13) {
		if (document.getElementById("token").value != ""){
			startLoading('auth');
			validate_token(mFuncCallBack);

        	return false;
        }else
            return false;
	};
});
</script>

