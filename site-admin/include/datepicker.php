<?php 
# PHP Calendar (version 1.0)
# written by Pradeep Kota
# Last Updated : 12 Mar 2009

function initpicker($y, $m, $t) {
	(!is_null($m)) ? $month = $m : $month = date('n',time());
	(!is_null($y)) ? $year = $y : $year = date('Y',time());
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
	$formfield = "document.forms['subnewevent']";
	$calfield = $formfield.'.subshowcal.value=1';
	$yearfield = $formfield.'.showyear.value';
	$monthfield = $formfield.'.showmonth.value';
	$pn = array('&laquo;'=>"$calfield;$yearfield=$prev_year;$monthfield=$prev_month;$formfield.submit(); return false;",'&raquo;'=>"$calfield;$yearfield=$next_year;$monthfield=$next_month;$formfield.submit(); return false;");
	echo datepicker($year, $month, NULL, NULL, $t, $pn);
}

function datepicker($year, $month, $days = array(), $month_href = NULL, $target, $pn = array()){ 	
	$first_day = 0;
	$caltext   = 'style="font-family: arial, helvetica, sans-serif; font-size: 12px;"';
	$linkstyle = 'style="cursor: pointer; text-decoration: none; font-family: arial, helvetica, sans-serif; align: right; color: #FFFFFF;"';
	$dateborder= 'style="font-weight: bold; color: maroon; cursor: pointer;"';
	$pastdate  = 'style="color: #999999;"';
	$futdate   = 'style="cursor: pointer;"';
	$day_name_length = 1;
	$first_of_month = gmmktime(0,0,0,$month,1,$year); 
	#remember that mktime will automatically correct if invalid dates are entered 
	# for instance, mktime(0,0,0,12,32,1997) will be the date for Jan 1, 1998 
	# this provides a built in "rounding" feature to generate_calendar() 

	$day_names = array(); #generate all the day names according to the current locale 
	for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400) #January 4, 1970 was a Sunday 
	$day_names[$n] = ucfirst(gmstrftime('%A',$t)); #%A means full textual day name 

	list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month)); 
	$weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day 
	$title   = htmlentities(ucfirst($month_name)).'&nbsp;'.$year;  #note that some locales don't capitalize month and day names 

	#Begin calendar. Uses a real <caption>. See http://diveintomark.org/archives/2002/07/03 
	@list($p, $pl) = each($pn); @list($n, $nl) = each($pn); #previous and next links, if applicable 
	$curr_month = date('m',time());
	$curr_year = date('Y', time());
	($month>$curr_month || $year>$curr_year) ? $p = '<span '.($pl ? 'onclick="'.$pl.'" '.$linkstyle.'>'.$p.'</a>' : $p).'</span>&nbsp;' : $p=""; 
	if($n) $n = '&nbsp;<span '.($nl ? 'onclick="'.$nl.'" '.$linkstyle.'>'.$n : $n).'</span>'; 
	$calendar = '<table class=mini-cal cellspacing=0 '.$caltext.'>'."\n". 
	'<tr><td colspan=7 align=center class="mini-cal-month" >'. $p .($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title).$n."</td></tr>\n<tr>"; 

	if($day_name_length){ #if the day names should be shown ($day_name_length > 0) 
		#if day_name_length is >3, the full name of the day will be printed 
		foreach($day_names as $d) 
		$calendar .= '<th align=center class="mini-cal-cell" abbr="'.htmlentities($d).'">'.htmlentities($day_name_length < 4 ? substr($d,0,$day_name_length) : $d).'</th>'; 
		$calendar .= "</tr>\n<tr>"; 
	} 

	if($weekday > 0) $calendar .= '<td class=mini-cal-cell colspan="'.$weekday.'">&nbsp;</td>'; #initial 'empty' days 
	for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++){ 
		if($weekday == 7){ 
			$weekday   = 0; #start a new week 
			$calendar .= "</tr>\n<tr>"; 
		}
		@list($m, $d, $y) = explode('-',date('m-d-Y',time()));
		if($month == $m && $day == $d && $year == $y) {
			$divclass = $dateborder;
			$daystyle = 'style="text-decoration: none; color: maroon;"';
			$daytarget = 'onclick="pickdate(\''.$month.'\',\''.str_pad($day, 2, "0", STR_PAD_LEFT).'\',\''.$year.'\',\''.$target.'\');"';
		} elseif($year == $y && $month == $m && $day<$d) {
			$divclass = $pastdate;
			$daystyle = "";
			$daytarget = "";
		} else {
			$divclass = $futdate;
			$daystyle = 'style="text-decoration: none; color: black;"';
			$daytarget = 'onclick="pickdate(\''.$month.'\',\''.str_pad($day, 2, "0", STR_PAD_LEFT).'\',\''.$year.'\',\''.$target.'\');"';
		}
		//$calendar .= '<td align=right><div '.$divclass.'>'.(($month==$m && $day>=$d) ? '<a '.$daystyle.' href="datepicker.php?mo='.$month.'&da='.$day.'&yr='.$year.'">'.$day.'</a>' : $day).'</div></td>'; 
		$calendar .= '<td align=center class=mini-cal-cell><div '.$divclass.' '.$daytarget.'>'.$day.'</div></td>'; 
	} 
	if($weekday != 7) $calendar .= '<td class=mini-cal-cell colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days 
	return $calendar."</tr>\n</table>\n"; 
} 
?>
