/*
 * Ajax implementation for load all created tokens for the system
 */
var tokenFCallBack;

function load_tokens(callBack, mURL)
{

	
	$.ajax({
		url: mURL,
		success: onSuccessToSelectTokens
	});
	tokenFCallBack=callBack;

}

function onSuccessToSelectTokens(response)
{
	var tokens=JSON.parse(response);
	for (var i = 0; i < tokens.length; i++)
	{
		var token = JSON.parse(tokens[i]);
		tokenFCallBack(token.table, token.idToken, token.available);
	}
}