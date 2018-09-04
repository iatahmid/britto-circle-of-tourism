<?php
	// Delimiters may be slash, dot, or hyphen
	$date = "4-3-1973";
	list($day, $month, $year) = split('[/.-]', $date);
	if($day < 10){
		$day = '0'.$day;
	}
	if($month < 10){
		$month = '0'.$month;
	}
	
	echo $date;
	$date = $year . '-' . $month . '-' . $day;
	echo $date;
	/*echo "Month: $month; Day: $day; Year: $year<br />\n";*/
?> 