<?php

function loadLang($path_folder){
	$path=@simplexml_load_file($path_folder."/current_language.xml");
	$xml = @simplexml_load_file($path_folder."/".$path->current.".xml");
	return $xml->strings;
}

?>