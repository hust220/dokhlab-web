<html>
	<head>
		<link rel=stylesheet href=dokh.css type=text/css>
		<script language="Javascript" type=text/javascript src=pubs.js></script>
		<script language="Javascript" type="text/javascript" src=jetpack.js></script>
		<script type=text/javascript language=javascript src=lytebox.js></script>
		<link rel="stylesheet" href="lytebox.css" media="screen", type="text/css" />
		<title>
			Dokholyan Group - Events
		</title>
	</head>
	<body>
<?php
	include_once 'head.php';
	require_once 'db.php';
	require_once 'functions.php';
	date_default_timezone_set("America/New_York");
	include_once 'events/events.php';

  	$time = time();
	(isset($_GET[ 'year'])) ? $year = $_GET[ 'year'] : $year = date('Y', $time);
	(isset($_GET[ 'month'])) ? $month = $_GET[ 'month'] : $month = date('n', $time);
	getEventsIn($month, $year);
#print_r($events);

	//Any other events
unset($events['allday']);
	$days = array();
	foreach ($events as $etag):
	  //echo $etag['edate']."<br>";
		if(!isset($days[$etag[ 'edate']]) || !is_array($days[$etag[ 'edate']])) $days[$etag[ 'edate']] = array();
		@list($sh, $sm, $ss) = explode(":", $etag[ 'estart_time']);
		if($sh!=00):
			if($sh>=12):
				if($sh!=12) $sh-=12;
				$etime = $sh.":".$sm."p";
			else:
				$etime = $sh.":".$sm;
			endif;
		endif;
		@list($eh, $em, $es) = explode(":", $etag[ 'eend_time']);
		if($eh!=00):
			if($eh>=12):
				if($eh!=12) $eh-=12;
				$etime .= " - ".$eh.":".$em."p";
			else:
				$etime .= " - ".$eh.":".$em;
			endif;
		endif;
		$kvp = array();
		foreach ($etag as $k=>$v):
			array_push($kvp, $k."=".$v);
		endforeach;
		if($sh==00 and $eh==00) $etime='All day';
		array_push($days[$etag[ 'edate']], array($etag[ 'edescription'],$etime,implode("&", $kvp)));
	endforeach;
	//print_r($days);

	$day_name_length = 3;
	$first_day = 0;
	$prev_month = $month - 1;
	$next_month = $month + 1;
	if ($prev_month == 0) {
	  	$prev_month = 12;
		$prev_year = $year - 1;
	} else {
		$prev_year = $year;
	}
	if($next_month == 13) {
	  	$next_month = 1;
		$next_year = $year + 1;
	} else {
		$next_year = $year;
	}
	$pn = array('&laquo;'=>"http://danger.med.unc.edu/event-devel.php?year=$prev_year&month=$prev_month",'&raquo;'=>"http://danger.med.unc.edu/event-devel.php?year=$next_year&month=$next_month");
//	echo '<div class=container align=center>';
//	echo generate_calendar($year, $month, $days, $day_name_length, $first_day, $pn);
//	echo '</div>';

//function generate_calendar($year, $month, $days = array(), $day_name_length = 3, $first_day = 0, $pn = array()){ 
  	$width = $height = 700;
	$tdwidth = $tdheight = $width/7;
	$first_of_month = gmmktime(0,0,0,$month,1,$year); 
	#remember that mktime will automatically correct if invalid dates are entered 
	# for instance, mktime(0,0,0,12,32,1997) will be the date for Jan 1, 1998 
	# this provides a built in "rounding" feature to generate_calendar() 

	$day_names = array(); #generate all the day names according to the current locale 
	for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400) #January 4, 1970 was a Sunday 
		$day_names[$n] = ucfirst(gmstrftime('%A',$t)); #%A gives full textual day name 

	list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month)); 
	$weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day 
	$title   = htmlentities(ucfirst($month_name)).'&nbsp;'.$year;  #note that some locales don't capitalize month and day names 

	#Begin calendar. Uses a real <caption>. See http://diveintomark.org/archives/2002/07/03 
	@list($p, $pl) = each($pn); @list($n, $nl) = each($pn); #previous and next links, if applicable 
	if($p) $p = '<span class="calendar-prev">'.($pl ? '<a class=calendar-prev href="'.htmlspecialchars($pl).'">'.$p.'</a>' : $p).'</span>&nbsp;'; 
	//echo $pl;
	//echo htmlspecialchars($pl);
	if($n) $n = '&nbsp;<span class="calendar-next">'.($nl ? '<a class=calendar-next href="'.htmlspecialchars($nl).'">'.$n.'</a>' : $n).'</span>'; 
	$calendar = '<table class="calendar" cellspacing=0 cellpadding=0>'."\n". 
	'<caption class="calendar-month">'.$p.$title.$n."</caption>\n<tr>"; 

	if($day_name_length){ #if the day names should be shown ($day_name_length > 0) 
		#if day_name_length is >3, the full name of the day will be printed 
		foreach($day_names as $d) 
		$calendar .= '<th class=calendar-td abbr="'.htmlentities($d).'">'.htmlentities($day_name_length < 4 ? substr($d,0,$day_name_length) : $d).'</th>'; 
		$calendar .= "</tr>\n<tr>"; 
	} 

	if($weekday > 0) $calendar .= '<td class="calendar-blank" colspan="'.$weekday.'">&nbsp;</td>'; #initial 'empty' days 
	@list($m, $d, $y) = explode("-",date('m-j-Y',time()));
	for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++){ 
		if($weekday == 7){ 
			$weekday   = 0; #start a new week 
			$calendar .= "</tr>\n<tr>"; 
		} 
		$thclass = $tbclass = "";
		if($month == $m && $day == $d && $year == $y) {
			$thclass = "calendar-today";
			$tbclass = "calendar-today-body";
		}
		if(isset($days["$month-$day-$year"]) and is_array($days["$month-$day-$year"])){ 
			$divcontent = "";
			$calendar .= '<td width="'.$tdwidth.'" height="'.$tdheight.'" class=calendar-td align="right"><div class="calendar-day calendar-event '.htmlspecialchars($thclass).'">'.$day.'</div><div class="calendar-event-body '.htmlspecialchars($tbclass).'">';
			foreach ($days[ "$month-$day-$year"] as $dayarr):
				@list($link, $desc, $getstr) = $dayarr; 
					$calendar .= '<a href="showevent.php?'.$getstr.'" class="info" rel="lyteframe" title="Event Description" rev="width: 400px; height: 250px; scrolling: yes;">'.$desc.'<span>'.$link.'</span></a><br>'; 
			endforeach;
			$calendar .= '</div></td>';
		} 
			else {
				($weekday == 0 || $weekday == 6) ? $hclass = "calendar-day calendar-weekend" : $hclass = "calendar-day";
				($weekday == 0 || $weekday == 6) ? $bclass = "calendar-weekend-body" : $bclass = "calendar-day-body";
				$calendar .= '<td width="'.$tdwidth.'" height="'.$tdheight.'" class="calendar-td" align="right"><div class="'.htmlspecialchars($hclass).' '.htmlspecialchars($thclass).'">'.$day.'</div><div class="'.htmlspecialchars($bclass).' '.htmlspecialchars($tbclass).'"></div></td>'; 
			}
	} 
	if($weekday != 7) $calendar .= '<td class="calendar-blank" colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days 

	$calendar."</tr>\n</table>\n";
//	return $calendar."</tr>\n</table>\n"; 
//} 
	echo '<div class=container align=center>';
//	echo generate_calendar($year, $month, $days, $day_name_length, $first_day, $pn);
	echo $calendar."</tr>\n</table>\n";
	echo '</div>';
?>
