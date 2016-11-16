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

<?php require_once 'includes.php' ?>
<script type="text/javascript" src="../../js/control_request/load_categories.js"></script>
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

</head>
<body>

	<div data-role="page">

		<?php
		$title="Card&aacutepio";
		require_once '../contents/top.php' ?>

		<div data-role="content" style="margin-top: 40px;">
			<ul id="categories_list" data-role="listview" data-inset="true">

			</ul>
			<!-- /content -->

		</div>
		<!-- /page -->

</body>
</html>
