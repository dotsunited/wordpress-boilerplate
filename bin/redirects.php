<?php

// Example csv data
// https://www.test.de/auto/,https://www.newtest.de/auto
// https://www.test.de/blog/,https://www.newtest.de/news/blog

$source = dirname( __FILE__ ) . '/301.csv';
$output = dirname( __FILE__ ) . '/301.txt';

// grab the contents of the source file as an array, prepare the output file for writing
$sourceArray = file($source);
$handleOutput = fopen($output, "w");

// Set the strings we want to replace in an array. The first array are the original lines and the second are the strings to be replaced
$originalLines = array(
	'https://test.de',
	','
);
$replacementStrings = array(
	'',
	' '
);

// Split each item from the array into two strings, one which occurs before the comma and the other which occurs after
function setContent($sourceArray, $originalLines = array(), $replacementStrings = array()){
	$outputArray = array();
	$text = 'RedirectMatch 301 ';
	foreach ($sourceArray as $number => $item){
		$pattern = '/[,]/';
		$item = preg_split($pattern, $item);
		
		// Replace original urls
		$item[0] = str_replace($originalLines, $replacementStrings, $item[0]);
		
		// Add trailing slash if missed
		if ($item[0][strlen($item[0]) - 1] !== '/') {
			$item[0] = $item[0] . '/';
		}
		
		$item = array(
			'^' . $item[0] . '?$',
			preg_replace('#"#', '', $item[1])
		);
		$item = implode(' ', $item);
		$item = str_replace(',', ' ', $item);
		array_push($outputArray,$text,$item);
	}
	$outputString = implode('', $outputArray);
	return $outputString;
}


// Invoke the set content function
$outputString = setContent($sourceArray, $originalLines, $replacementStrings);

// Finally, write to the text file!
fwrite($handleOutput, $outputString);
