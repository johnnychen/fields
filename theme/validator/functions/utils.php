<?php

setlocale(LC_ALL, 'en_US.UTF-8');

/* From: http://www.php.net/manual/en/function.str-getcsv.php#88773 and http://www.php.net/manual/en/function.str-getcsv.php#91170 */
function cq_putcsv($input, $delimiter = ',', $enclosure = '"') {
	// Open a memory "file" for read/write...
	$fp = fopen('php://temp', 'r+');
	// ... write the $input array to the "file" using fputcsv()...
	fputcsv($fp, $input, $delimiter, $enclosure);
	// ... rewind the "file" so we can read what we just wrote...
	rewind($fp);
	// ... read the entire line into a variable...
	$data = fgets($fp);
	// ... close the "file"...
	fclose($fp);
	// ... and return the $data to the caller, with the trailing newline from fgets() removed.
	return rtrim( $data, "\n" );
}

function cq_getcsv($input, $delimiter = ',', $enclosure = '"')
{
	// Open a memory "file" for read/write...
	$fp = fopen('php://temp', 'a+');
	
	$len = fwrite($fp, ltrim(rtrim($input)));
	
	rewind($fp);
	
	$data = array();
	
	while(! feof($fp)){
		array_push($data, fgetcsv($fp));
	}
	// ... close the "file"...
	fclose($fp);
	// ... and return the $data to the caller, with the trailing newline from fgets() removed.
	return $data;
}

function camel_to_strike($word) {
  return preg_replace(
    '/(^|[a-z])([A-Z])/e', 
    'strtolower(strlen("\\1") ? "\\1-\\2" : "\\2")',
    $word 
  ); 
}

function strike_to_camel($word) { 
	$str = preg_replace('/(^|-)([a-z])/e', 'strtoupper("\\2")', $word); 
	// return $str;
	$str = preg_replace('/^([A-Z])/e','strtolower("\\1")', $str);
	return $str;
}


?>