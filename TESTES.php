<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>autocomplete demo</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
</head>
<body>
<label for="autocomplete">Select a programming language: </label>
<input id="autocomplete">
<script>
var tags = [ "c++", "java", "php", "coldfusion", "javascript", "asp", "ruby" ];
$( "#autocomplete" ).autocomplete({
source: function( request, response ) {
var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
response( $.grep( tags, function( item ){
return matcher.test( item );
}) );
}
});
</script>
</body>
</html>