<?php

//fuly decode a particular string
function full_decode($string)
{
	return html_entity_decode($string, ENT_QUOTES);
}

//decode anything we throw at it
function form_decode(&$x)
{
	//loop through objects or arrays
	if(is_array($x) || is_object($x))
	{
		foreach($x as &$y)
		{
			$y = form_decode($y);
		}
	}
	
	if(is_string($x))
	{
		$x	= full_decode($x);
	}
	
	return $x;
}

function my_character_limiter($str, $n = 500, $end_char = '&#8230;')
{
	$output = substr($str, 0, $n);
	if(strlen($str)>$n){
		$output.=$end_char;
	}

	return $output;
}

function generate_alphaid()
{
	return generate_code(3).date("is").generate_code(3);
}

function split_lines($arr)
{
	$lines = preg_split( '/\r\n|\r|\n/', $arr );


	foreach($lines as $line_k=>$option)
	{
		$option = trim($option);				
		$options[] = $option;							
	}
	
	$field_option = serialize($options);
	return $field_option;
}

function generateSlug($phrase,$delimeter='-')
{
    $result = strtolower($phrase);

    $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
    $result = trim(preg_replace("/[\s-]+/", " ", $result));
    //$result = trim(substr($result, 0, $maxLength));
    $result = preg_replace("/\s/", $delimeter, $result);

    return $result;
}

function mask_characters($string)
{
	$length = strlen($string); 
	if($length>=4)
	{
		return $string[0].str_repeat('*', $length - 4) . $string[$length-3].$string[$length-2].$string[$length-1]; 
	}else
	{
		return $string[0].str_repeat('*', $length - 2) . $string[$length-1]; 
	}
	
	#return preg_replace('/(?!^.?).(?!.{0}$)/', '*', $string);
}

function cleanHTMLfromDB($content)
{
	$content = htmlspecialchars_decode($content,ENT_QUOTES);
	$content = html_entity_decode($content);

	$content = str_replace(array("\r\n", "\r", "\n"), "", $content);
	$content = trim(preg_replace('/\s\s+/', '', $content));
	$content = preg_replace( "/\r\n/", "", $content);
	$content = preg_replace( "/\r\t/", "", $content);
	$content = preg_replace( "/\r/", "", $content);
	$content = preg_replace( "/\t/", "", $content);
	$content = preg_replace( "/\n/", "", $content);
	$content = preg_replace( "/\xA0/", "", $content);
	$content = preg_replace( "/\x0B/", "", $content);
	#$content = preg_replace( '/"/', '""', $content);
	$content = utf8_decode($content);
	//echo $content;
	return $content;
}

function cleanHTMLforDB($content)
{
	$content = str_replace(array("\r\n", "\r", "\n"), "", $content);
	$content = trim(preg_replace('/\s\s+/', '', $content));
	$content = htmlspecialchars($content);
	return $content;
}

function addslashes_js($var) {
    if (is_string($var)) {
        $var = str_replace('\\', '\\\\', $var);
        $var = str_replace(array('\'', '"', "\n", "\r", "\0"), array('\\\'', '\\"', '\\n', '\\r', '\\0'), $var);
        $var = str_replace('</', '<\/', $var);   // XHTML compliance
    } else if (is_array($var)) {
        $var = array_map('addslashes_js', $var);
    } else if (is_object($var)) {
        $a = get_object_vars($var);
        foreach ($a as $key=>$value) {
          $a[$key] = addslashes_js($value);
        }
        $var = (object)$a;
    }
    return $var;
}

function is_mobile()
{
	$mobile_browser = '0';
 
	if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
	    $mobile_browser++;
	}
	 
	if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
	    $mobile_browser++;
	}    
	 
	$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
	$mobile_agents = array(
	    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
	    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
	    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
	    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
	    'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
	    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
	    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
	    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
	    'wapr','webc','winw','winw','xda ','xda-');
	 
	if (in_array($mobile_ua,$mobile_agents)) {
	    $mobile_browser++;
	}
	
	if(isset($_SERVER['ALL_HTTP']))
	{
		if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini') > 0) {
		    $mobile_browser++;
		}
	}
	
	if(isset($_SERVER['HTTP_USER_AGENT']))
	{
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') > 0) {
		    $mobile_browser = 0;
		}
	}
	if ($mobile_browser > 0) {
	   $is_mobile = 1;
	}
	else {
	 	$is_mobile = 0;
	}   
	 

}

function helper_array_search($array, $key, $value)
{
    $results = array();

    if (is_array($array))
    {
    	
        foreach ($array as $k=>$subarray)
        {
        	if(isset($subarray[$key]))
        	{
	        	if ($subarray[$key] == $value)
		        {
		            $results[] = $k;
		        }
	        }

        
        }
    }

    return $results;
}

if ( ! function_exists('file_extension'))
{
	function file_extension($path)
	{
		$extension = substr(strrchr($path, '.'), 1);
		return $extension;
	}
}

function helper_time2seconds($time='0000:00:00')
{
    list($hours, $mins, $secs) = explode(':', $time);
    return ($hours * 3600 ) + ($mins * 60 ) + $secs;
}
function  helper_roundUpTo($number, $increments) { 
    $increments = 1 / $increments; 
    return (ceil($number * $increments) / $increments); 
} 

function format_tin_number($str) {
    return implode("-", str_split($str, 3));
}