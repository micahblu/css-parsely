<?php
/**
 * CSS Parsely
 * 
 * extracts css from within style tags and returns a array with style values with selectors as keys
 * @author Micah Blu
 * @version 0.5
 */


function fetchCSS($file){

	$html = file($file);

	$css = '';
	$collect = false;

	foreach($html as $line => $str){

		if(preg_match('/<style.+(.*)[^\<]/', $str, $match)){
			 //echo "Beginning of the css";
			 $collect = true;
		}elseif(preg_match('/\<\/style\>/', $str)){
			//return $css;
			$collect = false;
		}else{
			if($collect) $css .= trim($str);
		}
	}
	
	$stylelines = explode("}", $css);

	$styles = array();

	foreach($stylelines as $lines => $line){
		$selector = substr($line, 0, strpos($line, "{"));
		$stylelines = substr($line, strpos($line, "{") + 1, strlen($line));
		
		$rulelines = explode(";", $stylelines);

		foreach($rulelines as $ruleline => $set){
			list($stylename, $stylevalue) = explode(":", $set);
		
			$styles[$selector][trim($stylename)] = trim($stylevalue);
		}
		//echo $selector . " = " . $rules . "\n";
	}

	return $styles;
}
?>