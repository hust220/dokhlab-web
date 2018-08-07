<?php
	date_default_timezone_set("America/New_York");
	include_once 'events/events.php';
?>
<html>
<head>
	<link rel=stylesheet type=text/css href=dokh.css>
</head>
<body>
<?php
	$tablestyle = 'style="align: center; font-family: arial, helvetica, sans-serif; font-size: 13px;"';
	$tdleft = 'style="width: 60%; text-align: left;"';
	$tdcenter = 'style="text-align: center;"';
	$tdright = 'style="text-align: right;"';
	echo '<table border=0 width=100% '.$tablestyle.'>';
	echo '<tr><td '.$tdright.'>Short Description</td><td '.$tdcenter.'>:</td><td '.$tdleft.'>'.$_GET[ 'edescription'].'</td></tr>';
	echo '<tr><td '.$tdright.'>Type</td><td '.$tdcenter.'>:</td><td '.$tdleft.'>'.(($_GET[ 'etype'] == "R") ? 'Repeating' : 'One-time' ).'</td></tr>';
	echo '<tr><td '.$tdright.'>Frequency</td><td '.$tdcenter.'>:</td><td '.$tdleft.'>'.ucfirst($_GET[ 'efrequency']).'</td></tr>';
	echo '<tr><td '.$tdright.'>Venue</td><td '.$tdcenter.'>:</td><td '.$tdleft.'>'.ucfirst($_GET[ 'evenue']).'</td></tr>';
	echo '<tr><td '.$tdright.'>Notes</td><td '.$tdcenter.'>:</td><td '.$tdleft.'>'.ucfirst($_GET[ 'enotes']).'</td></tr>';
	echo '<tr><td '.$tdright.'>Created By</td><td '.$tdcenter.'>:</td><td '.$tdleft.'>'.ucfirst($_GET[ 'ecreated_by']).'</td></tr>';
	echo '<tr><td '.$tdright.'>Created On</td><td '.$tdcenter.'>:</td><td '.$tdleft.'>'.ucfirst($_GET[ 'ecreated_on']).'</td></tr>';

	if($_GET[ 'edescription'] == "Group Meeting") {
		@list($m, $d, $y) = explode("-",$_GET[ 'edate']);
		echo '<tr><td '.$tdright.' valign=top>Upcoming Meetings</td><td '.$tdcenter.' valign=top>:</td><td '.$tdleft.'>'.getGM($m, $d, $y).'</td></tr>';
	}
	if($_GET[ 'edescription'] == "Journal Club") {
		@list($m, $d, $y) = explode("-",$_GET[ 'edate']);
		echo '<tr><td '.$tdright.' valign=top>Upcoming Meetings</td><td '.$tdcenter.' valign=top>:</td><td '.$tdleft.'>'.getJC($m, $d, $y).'</td></tr>';
	}
	echo '</table>';
?>
</body>
</html>
