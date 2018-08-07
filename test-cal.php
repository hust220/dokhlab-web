<?php
	include_once 'calendar.php';
	$time = time();
	$pn = array('&laquo;'=>'echo generate_calendar(2009, 9, NULL, 3)', '&raquo;'=>'/weblog/archive/2004/Sep');
	echo generate_calendar(date('Y'), date('n'), NULL, 3, NULL, 0, $pn);
?>
