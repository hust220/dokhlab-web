<?php //common.php
echo 'Y-00';
date_default_timezone_set("America/New_York");
echo 'Y-0';
require_once 'db.php';
echo 'Y-1';
dbConnect($dbname);
echo 'Y-2';
$dberror = "A database error occured while processing your request. If this error persists, please contact pkota@email.unc.edu";

function error($msg) {
	exit;
}

function showmsg($msg) {

}

$memtable = "mems";
$pubtable = "pubs";
$minfotbl = "mem_info";
$events = array();
$memid = array();
$members = array();
$currmem = array();
$hascurr = array();
$hasform = array();
$f_name = array();
$m_init = array();
$l_name = array();
$has_publ = array();
$current = array();
$designation = array();
$tenure = array();
$email  = array();
$fullname = array();
$categories = array();
$mempubs = array();
$pmid = array();
$code = array();
$journals = array();
$jindex = array();
$tindex = array();
$yindex = array();
$years = array();
$topics = array();
$publications = array();
$results = array();
$results[ 'articles'] = array();
$results[ 'books'] = array();
$results[ 'confs'] = array();
$flags[ 'search'] = 0;
$flags[ 'filter'] = 0;
$flags[ 'keyword'] = 0;

$sql = "SELECT * FROM ".$pubtable." ORDER BY pub_id DESC";
$result = mysql_query($sql);
while($row=mysql_fetch_object($result)) {
	$journals[ $row->journal] = 0;
	$years[ $row->year] = 0;
	$topics[ $row->topic] = 0;
	if($row->type=='article' || $row->type=='editorial') {
		$publications[ 'articles'][ $row->pub_id] = $row->authors." \"".$row->title."\", <i>".$row->journal."</i>, ";
		if($row->volume==0 && $row->fpage=="" && $row->lpage=="") {
	  		$publications[ 'articles'][ $row->pub_id].="<i>in press</i>";
		} else {
	  		$publications[ 'articles'][ $row->pub_id].=$row->volume.":".$row->fpage;
			if($row->lpage != "") $publications[ 'articles'][ $row->pub_id].="-".$row->lpage;
		}
		$publications[ 'articles'][ $row->pub_id].=" (".$row->year.")<br>";
	} elseif($row->type=='book') {
		$publications[ 'books'][ $row->pub_id] = $row->authors." \"".$row->title."\" in \"".$row->journal."\", ";
		if($row->volume==0 && $row->fpage=="" && $row->lpage=="") {
	  		$publications[ 'books'][ $row->pub_id].="<i>in press</i>";
		} else {
			if($row->volume) $publications[ 'books'][ $row->pub_id].="Vol. ".$row->volume.":";
	  		$publications[ 'books'][ $row->pub_id].="<i>pp</i> ".$row->fpage;
			if($row->lpage != "") $publications[ 'books'][ $row->pub_id].="-".$row->lpage;
		}
		if($row->series) {
			$publications[ 'books'][ $row->pub_id].=", ".$row->series;
		}
		if($row->editors) {
			$publications[ 'books'][ $row->pub_id].=", Editors: ".$row->editors;
		}
		if($row->publisher) {
			$publications[ 'books'][ $row->pub_id].=" ".$row->publisher;
		}
		$publications[ 'books'][ $row->pub_id].=", (".$row->year.")<br>";
	} elseif($row->type=='conf') {
		$publications[ 'confs'][ $row->pub_id] = $row->authors." \"".$row->title."\", <i>".$row->journal."</i>, ";
		if($row->volume==0 && $row->fpage=="" && $row->lpage=="") {
	  		$publications[ 'confs'][ $row->pub_id].="<i>in press</i>";
		} else {
			if($row->volume) $publications[ 'confs'][ $row->pub_id].=$row->volume.":";
	  		$publications[ 'confs'][ $row->pub_id].=$row->fpage;
			if($row->lpage != "") $publications[ 'confs'][ $row->pub_id].="-".$row->lpage;
		}
		if($row->editors) {
			$publications[ 'confs'][ $row->pub_id].=", Editors: ".$row->editors;
		}
		$publications[ 'confs'][ $row->pub_id].=", (".$row->year.")<br>";
	}
	$publications[ 'authors'][$row->pub_id] = $row->authors;
	$publications[ 'title'][$row->pub_id] = $row->title;
	$publications[ 'pmid'][$row->pub_id] = $row->pmid;
	$publications[ 'code'][$row->pub_id] = $row->code;
	$publications[ 'cover'][$row->pub_id] = $row->cover;
	$publications[ 'abstract'][$row->pub_id] = $row->abstract;
	$publications[ 'suppinfo'][$row->pub_id] = $row->suppinfo;
	$publications[ 'f1000'][$row->pub_id] = $row->f1000;
}
krsort($journals);
krsort($topics);
krsort($years);

$sql = "SELECT * FROM ".$memtable;
$result = mysql_query($sql);
$cnt = 0;
while($row=mysql_fetch_object($result)) {
	$categories[$row->designation]=0;
	if($row->current == "yes") $hascurr[$row->designation]=0;
	if($row->current == "no") $hasform[$row->designation]=0;
}

function getMembers() {
	global $memtable, $pubtable, $categories, $currmem, $members, $hascurr, $hasform, $memid;
	global $f_name, $m_init, $l_name, $has_publ, $current;
	global $designation, $fullname, $tenure, $email;
	$sql = "SELECT * FROM ".$memtable." ORDER BY f_name ";
	$result = mysql_query($sql);
	if(!$result) {
		error('A database error occured while retrieving'.
				'the list of available members\\n'.
				'If this problem persists, please'.
				'contact pkota@email.unc.edu');
	} else {
	  	$cnt=0;
		while($row=mysql_fetch_object($result)) {
			$fname = trim($row->f_name)." ".trim($row->m_init)." ".trim($row->l_name);
			$members[$fname] = $row->designation;
			$currmem[$fname] = $row->current;
			$categories[$row->designation]++;
			$tuple = $fname.":".$row->has_publ.":".$row->current.":".$row->designation.":".$row->memfrom." - ".$row->memtill;
			$memid[$row->mem_id] = $tuple;
			$fullname[$row->mem_id] = $fname;
			$f_name[$row->mem_id] = $row->f_name;
			$m_init[$row->mem_id] = $row->m_init;
			$l_name[$row->mem_id] = $row->l_name;
			$email[$row->mem_id] = $row->email;
			$has_publ[$row->mem_id] = $row->has_publ;
			$current[$row->mem_id] = $row->current;
			$designation[$row->mem_id] = $row->designation;
			if($row->memfrom != $row->memtill) {
				$tenure[$row->mem_id] = $row->memfrom." - ".$row->memtill;
			} else {
				$tenure[$row->mem_id] = $row->memfrom;
			}
			if($row->current == "yes") {
				$hascurr[$row->designation]++;
			} else {
				$hasform[$row->designation]++;
			}
		}
	}
}

function getID($cat, $currstat) {
 	global $memtable;
	$query = "SELECT mem_id FROM ".$memtable." WHERE designation='".$cat."' AND current='".$currstat."'";
	$result = mysql_query($query);
	if(!$result) {
		error('Invalid category');
		return;
	} else {
		$row = mysql_fetch_object($result);
		return $row->mem_id;
	}
}

function getMemPubs($m) {
	global $mempubs, $pmid, $code, $pubtable;
	$query = "SELECT * FROM ".$pubtable." WHERE BINARY authors LIKE '%".$m."%' ORDER BY year DESC";
	$publist = mysql_query($query);
	if(!$publist) {
		error('Unable to retrieve member publications');
	} else {
		$pcnt=0;
		while($row=mysql_fetch_object($publist)) {
			$authors = str_replace("$m","<b>$m</b>",$row->authors);
	 		$mempubs[ $row->pub_id] = $authors." \"".$row->title."\", <i>".$row->journal."</i>, ";
			if($row->volume==0 && $row->fpage=="" && $row->lpage=="") {
	  			$mempubs[ $row->pub_id].="<i>in press</i>";
			} else {
	  			$mempubs[ $row->pub_id].=$row->volume.":".$row->fpage;
				if($row->lpage != "") $mempubs[ $row->pub_id].="-".$row->lpage;
			}
			$mempubs[ $row->pub_id].=", (".$row->year.")<br>";
			$pmid[ $row->pub_id] = $row->pmid;
			$code[ $row->pub_id] = $row->code;
			$pcnt++;
		}
	}
	return $pcnt;
}

function getMemInfo($m) {
	global $memtable, $minfotbl;
	$meminfoarray=array();
	$query = "SELECT * FROM $minfotbl where mem_id=$m";
	$meminfo = mysql_query($query);
	if(!$meminfo) {
		error('Unable to retrieve member information');
	} else {
		while($row=mysql_fetch_object($meminfo)) {
			if($row->info==null) {
				$meminfoarray[ 'info']="NA";
			} else {
				$meminfoarray[ 'info'] = $row->info;
			}
			if($row->awards==null) {
				$meminfoarray[ 'awards']="NA";
			} else {
				$meminfoarray[ 'awards'] = $row->awards;
			}
			if($row->education==null) {
				$meminfoarray[ 'education']="NA";
			} else {
				$meminfoarray[ 'education'] = $row->education;
			}
		}
	}
	return $meminfoarray;
}

function getJournals() {
 	global $journals, $jindex, $pubtable;
	$query = "SELECT journal, COUNT(journal) AS pub_count FROM ".$pubtable." GROUP BY journal ORDER BY pub_count DESC";
	$cnt = 0;
	$jrnlst = mysql_query($query);
	if(!$jrnlst) {
	  	error('Unable to retrieve journal information');
	} else {
		while($row=mysql_fetch_object($jrnlst)) {
			$journals[ $row->journal] = $row->pub_count;
			$jindex[$cnt] = $row->journal;
			$cnt++;
		}
	}
}

function getYears() {
	global $years, $yindex, $pubtable;
	$query = "SELECT year FROM ".$pubtable." ORDER BY year DESC";
	$yrlist = mysql_query($query);
	if(!$yrlist) {
	  	error('Unable to retrieve year information');
	} else {
		while($row=mysql_fetch_object($yrlist)) {
		  	$years[ $row->year]++;
		}
		$yindex = array_keys($years);
	}
}

function getTopics() {
	global $topics, $tindex, $pubtable;
	$query = "SELECT topic, COUNT(topic) AS topic_count FROM ".$pubtable." GROUP BY topic ORDER BY topic_count DESC";
	$tplist = mysql_query($query);
	$cnt = 0;
	if(!$tplist) {
	  	error('Unable to retrieve topic information');
	} else {
		while($row=mysql_fetch_object($tplist)) {
		  	if($row->topic) {
				$topics[ $row->topic] = $row->topic_count;
				$tindex[$cnt] = $row->topic;
				$cnt++;
			}
		}
	}
}

function retrieveSearch($keyword, $category) {
	global $pubtable;
	$flags[ 'keyword'] = 1;
  	if($category=="authors"):
		$query = "SELECT * FROM ".$pubtable." WHERE authors LIKE '%".$keyword."%' ORDER BY year DESC";
  	elseif($category=="title"):
		$query = "SELECT * FROM ".$pubtable." WHERE title LIKE '%".$keyword."%' ORDER BY year DESC";
	elseif($category=="journal"):
  		$query = "SELECT * FROM ".$pubtable." WHERE journal LIKE '%".$keyword."%' ORDER BY year DESC";
	else:
		$query = "SELECT * FROM ".$pubtable." WHERE authors LIKE '%".$keyword."%' OR title LIKE '%".$keyword."%' OR journal LIKE '%".$keyword."%' OR topic LIKE '%".$keyword."%' OR year LIKE '%".$keyword."%' ORDER BY year DESC";
	endif;
	getSearchResults($query, $keyword);
}

function getSearchResults($query, $keyword) {
	global $results, $flags, $pubtable;
	$records = mysql_query($query);
	if(!$records) {
		echo "A MySQL error occured while trying the following query<br>";
		echo $query."<br>";
		echo "MySQL returned the following error. See it if helps debug the problem.<br>";
		mysql_error();
	}
	$rcnt = 0;
	$results[ 'articles'] = array();
	$results[ 'books'] = array();
	$results[ 'confs'] = array();
	$results[ 'jrnls'] = array();
	$results[ 'pmid'] = array();
	$results[ 'code'] = array();
	$results[ 'suppinfo'] = array();
	$results[ 'f1000'] = array();
	$tmp="";
	while($row=mysql_fetch_object($records)) {
		$article = $row->authors." \"".$row->title."\", <i>".$row->journal."</i>, ";
		if($row->volume==0 && $row->fpage=="" && $row->lpage=="") {
	  		$article.="<i>in press</i>";
		} else {
	  		$article.=$row->volume.":".$row->fpage;
			if($row->lpage != "") $article.="-".$row->lpage;
		}
		$article.=", (".$row->year.")<br>";
		if($flags[ 'keyword'] == 1) {
			if(strpos($article, $keyword) !== false):
				$tmp = $keyword;
			elseif(stripos($article, $keyword) !== false):
				$tmp = substr($article,stripos($article,$keyword),strlen($keyword));
			endif;
		}
		$result = str_replace("$tmp","<b>$tmp</b>",$article);
		if($row->type=="article") $results[ 'articles'][$row->pub_id] = $result;
		if($row->type=="book") $results[ 'books'][$row->pub_id] = $result;
		if($row->type=="conf") $results[ 'confs'][$row->pub_id] = $result;
		$results[ 'pmid'][$row->pub_id] = $row->pmid;
		$results[ 'code'][$row->pub_id] = $row->code;
		$results[ 'cover'][$row->pub_id] = $row->cover;
		$results[ 'abstract'][$row->pub_id] = $row->abstract;
		$results[ 'suppinfo'][$row->pub_id] = $row->suppinfo;
		$results[ 'f1000'][$row->pub_id] = $row->f1000;
		$rcnt++;
	}	  
}

function updateSearch($filstr, $keyword, $category) {
	global $pubtable, $results, $publications, $l_name, $years, $journals, $topics;
	global $jindex, $tindex, $yindex;
	getMembers();
	//getJournals();
	getYears();
	getTopics();
	if(trim($keyword)!="") {
		$flags[ 'keyword'] = 1;
		if($category!="all") $tmplikestr = $category." LIKE '%".$keyword."%' AND ";
		else $tmplikestr = "(authors LIKE '%".$keyword."%' OR journal LIKE '".$keyword."' OR title LIKE '%".$keyword."%' OR topic LIKE '%".$keyword."%') AND ";
	} else {
		$flags[ 'keyword'] = 0;
		$tmplikestr = "";
	}
	$tmp = rtrim($filstr,",");
	$fils = split(",",$tmp);
	$tmparr = array();
	$filters[ 'auth'] = array();
	$filters[ 'year'] = array();
	$filters[ 'jrnl'] = array();
	$filters[ 'topic'] = array();
	$tmparr = preg_grep("/auth/",$fils);
	foreach($tmparr as $index=>$match):
		preg_match("/\d+/",$match,$matches);
		array_push($filters[ 'auth'], $matches[0]);
	endforeach;
	$tmparr = preg_grep("/year/",$fils);
	foreach($tmparr as $index=>$match):
		preg_match("/\d+/",$match,$matches);
		array_push($filters[ 'year'], $matches[0]);
	endforeach;
	$tmparr = preg_grep("/jrnl/",$fils);
	foreach($tmparr as $index=>$match):
		preg_match("/\d+/",$match,$matches);
		array_push($filters[ 'jrnl'], $matches[0]);
	endforeach;
	$tmparr = preg_grep("/topic/",$fils);
	foreach($tmparr as $index=>$match):
		preg_match("/\d+/",$match,$matches);
		array_push($filters[ 'topic'], $matches[0]);
	endforeach;
	foreach($filters[ 'auth'] as $index=>$mid):
		$tmplikestr.=" authors LIKE '%".$l_name[$mid]."%' AND";
	endforeach;
	if(count($filters[ 'jrnl'])>0) $tmplikestr.=" (";
	foreach($filters[ 'jrnl'] as $index=>$mid):
		$tmplikestr.=" journal LIKE '".$jindex[$mid]."' OR";
	endforeach;
	if(count($filters[ 'jrnl'])>0) $tmplikestr.=") AND ";
	if(count($filters[ 'year'])>0) $tmplikestr.=" (";
	foreach($filters[ 'year'] as $index=>$mid):
		$tmplikestr.=" year LIKE '%".$yindex[$mid]."%' OR";
	endforeach;
	if(count($filters[ 'year'])>0) $tmplikestr.=")";
	if(count($filters[ 'topic'])>0) $tmplikestr.=" (";
	foreach($filters[ 'topic'] as $index=>$mid):
		$tmplikestr.=" topic LIKE '%".$tindex[$mid]."%' OR";
	endforeach;
	if(count($filters[ 'topic'])>0) $tmplikestr.=")";
	$lstr = rtrim($tmplikestr," AND");
	$tmpstr = str_replace(" OR)",")",$lstr);
	$likestr = str_replace(" AND)",")",$tmpstr);
	$query = "SELECT * FROM ".$pubtable." WHERE ".$likestr." ORDER BY year DESC";
	getSearchResults($query, $keyword);
	//echo $likestr;
}

function getAbstract($pubid) {
	global $publications;
	$pub[ 'abstract'] = $publications[ 'abstract'][$pubid];
	$pub[ 'title'] = $publications[ 'title'][$pubid];
	$pub[ 'authors'] = $publications[ 'authors'][$pubid];
	return $pub;	
}

function writeEvents($el, $events) {
	while($row = mysql_fetch_object($el)) {
		$events[ $row->eid] = array();
		$events[ $row->eid][ 'edescription'] = $row->edescription;
		$events[ $row->eid][ 'etype'] = $row->etype;
		$events[ $row->eid][ 'efrequency'] = $row->efrequency;
		$events[ $row->eid][ 'evisibility'] = $row->evisibility;
		$events[ $row->eid][ 'evenue'] = $row->evenue;
		$events[ $row->eid][ 'estart_date'] = $row->estart_date;
		$events[ $row->eid][ 'eend_date'] = $row->eend_date;
		$events[ $row->eid][ 'elast_occurrence'] = $row->elast_occurrence;
		$events[ $row->eid][ 'estart_time'] = $row->estart_time;
		$events[ $row->eid][ 'eend_time'] = $row->eend_time;
		$events[ $row->eid][ 'enotes'] = $row->enotes;
		$events[ $row->eid][ 'ecreated_by'] = $row->ecreated_by;
		$events[ $row->eid][ 'ecreated_on'] = $row->ecreated_on;
	}
}

function getEvents() {
	global $events;
	$events = array();
	$q = "SELECT * FROM events";
	$event_list = mysql_query($q);
	writeEvents($event_list, $events);
}

function getEventsIn($month, $year) {
	global $events;
	$i=1;
	$events = array();
	if($year%4==0) {
		$days = array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
	} else {
		$days = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	}
	$q = "SELECT * FROM events WHERE etype='O' AND estart_date >= '".$year."-".str_pad($month,2,"0",STR_PAD_LEFT)."-01' AND eend_date <= '".$year."-".str_pad($month,2,"0",STR_PAD_LEFT)."-".$days[$month-1]."'";
	$el = mysql_query($q);
	while($row = mysql_fetch_object($el)) {
		$cnt = 'o'.$i;
		$events[ $cnt] = array();
		$events[ $cnt][ 'eid'] = $row->eid;
		$events[ $cnt][ 'edescription'] = $row->edescription;
		$events[ $cnt][ 'etype'] = $row->etype;
		$events[ $cnt][ 'efrequency'] = $row->efrequency;
		$events[ $cnt][ 'evisibility'] = $row->evisibility;
		$events[ $cnt][ 'evenue'] = $row->evenue;
		$events[ $cnt][ 'estart_date'] = $row->estart_date;
		$events[ $cnt][ 'eend_date'] = $row->eend_date;
		$events[ $cnt][ 'elast_occurrence'] = $row->elast_occurrence;
		$events[ $cnt][ 'estart_time'] = $row->estart_time;
		$events[ $cnt][ 'eend_time'] = $row->eend_time;
		$events[ $cnt][ 'enotes'] = $row->enotes;
		$events[ $cnt][ 'ecreated_by'] = $row->ecreated_by;
		$events[ $cnt][ 'ecreated_on'] = $row->ecreated_on;
		@list($y, $m, $d) = explode("-", $row->estart_date);
		$events[ $cnt][ 'edate'] = $m."-".$d."-".$y;
		$i++;
	}
	//writeEvents($event_list, $events);
	$q = "SELECT * FROM events WHERE etype='R'";
	$rel = mysql_query($q);
	while($row = mysql_fetch_object($rel)) {
		$erf = $row->efrequency;
		@list($cmo,$cda,$cyr,$chr,$cmn,$csc) = explode("-",date('m-j-Y-G-i-s',time()));
		$cts = mktime($chr, $cmn, $csc, $cmo, $cda, $cyr);
		@list($syr, $smo, $sda) = explode("-", $row->estart_date);
		@list($shr, $smn, $ssc) = explode(":", $row->estart_time);
		@list($eyr, $emo, $eda) = explode("-", $row->eend_date);
		@list($ehr, $emn, $esc) = explode(":", $row->eend_time);
		$sts = mktime($shr, $smn, $ssc, $smo, $sda, $syr);
		$ets = mktime($ehr, $emn, $esc, $emo, $eda, $eyr);
		if( ($erf == "yearly") && ($cyr >= $syr) && ($cyr <= $eyr) && ($smo == $cmo) ) {
			if( ($cmo != 2) ) {
				$events[ $row->eid] = array();
				$events[ $row->eid][ 'edescription'] = $row->edescription;
				$events[ $row->eid][ 'etype'] = $row->etype;
				$events[ $row->eid][ 'efrequency'] = $row->efrequency;
				$events[ $row->eid][ 'evisibility'] = $row->evisibility;
				$events[ $row->eid][ 'evenue'] = $row->evenue;
				$events[ $row->eid][ 'estart_date'] = $row->estart_date;
				$events[ $row->eid][ 'eend_date'] = $row->eend_date;
				$events[ $row->eid][ 'elast_occurrence'] = $row->elast_occurrence;
				$events[ $row->eid][ 'estart_time'] = $row->estart_time;
				$events[ $row->eid][ 'eend_time'] = $row->eend_time;
				$events[ $row->eid][ 'enotes'] = $row->enotes;
				$events[ $row->eid][ 'ecreated_by'] = $row->ecreated_by;
				$events[ $row->eid][ 'ecreated_on'] = $row->ecreated_on;
				$events[ $row->eid][ 'edate'] = $month."-".$sda."-".$year;
			}
			if( ($cmo == 2) ) {
				if($sda == 29) {
					if($cyr%4 == 0) {
						$events[ $row->eid] = array();
						$events[ $row->eid][ 'edescription'] = $row->edescription;
						$events[ $row->eid][ 'etype'] = $row->etype;
						$events[ $row->eid][ 'efrequency'] = $row->efrequency;
						$events[ $row->eid][ 'evisibility'] = $row->evisibility;
						$events[ $row->eid][ 'evenue'] = $row->evenue;
						$events[ $row->eid][ 'estart_date'] = $row->estart_date;
						$events[ $row->eid][ 'eend_date'] = $row->eend_date;
						$events[ $row->eid][ 'elast_occurrence'] = $row->elast_occurrence;
						$events[ $row->eid][ 'estart_time'] = $row->estart_time;
						$events[ $row->eid][ 'eend_time'] = $row->eend_time;
						$events[ $row->eid][ 'enotes'] = $row->enotes;
						$events[ $row->eid][ 'ecreated_by'] = $row->ecreated_by;
						$events[ $row->eid][ 'ecreated_on'] = $row->ecreated_on;
						$events[ $row->eid][ 'edate'] = "02-".$sda."-".$year;
					}
				} else {
					$events[ $row->eid] = array();
					$events[ $row->eid][ 'edescription'] = $row->edescription;
					$events[ $row->eid][ 'etype'] = $row->etype;
					$events[ $row->eid][ 'efrequency'] = $row->efrequency;
					$events[ $row->eid][ 'evisibility'] = $row->evisibility;
					$events[ $row->eid][ 'evenue'] = $row->evenue;
					$events[ $row->eid][ 'estart_date'] = $row->estart_date;
					$events[ $row->eid][ 'eend_date'] = $row->eend_date;
					$events[ $row->eid][ 'elast_occurrence'] = $row->elast_occurrence;
					$events[ $row->eid][ 'estart_time'] = $row->estart_time;
					$events[ $row->eid][ 'eend_time'] = $row->eend_time;
					$events[ $row->eid][ 'enotes'] = $row->enotes;
					$events[ $row->eid][ 'ecreated_by'] = $row->ecreated_by;
					$events[ $row->eid][ 'ecreated_on'] = $row->ecreated_on;
					$events[ $row->eid][ 'edate'] = "02-".$sda."-".$year;
				}
			}
		} elseif( ($erf == "monthly") && ($cmo >= $smo) && ($cmo <= $emo) && ($cyr >= $syr) && ($cyr <= $eyr) ) {
			if($sda <= 28) {
				$events[ $row->eid] = array();
				$events[ $row->eid][ 'edescription'] = $row->edescription;
				$events[ $row->eid][ 'etype'] = $row->etype;
				$events[ $row->eid][ 'efrequency'] = $row->efrequency;
				$events[ $row->eid][ 'evisibility'] = $row->evisibility;
				$events[ $row->eid][ 'evenue'] = $row->evenue;
				$events[ $row->eid][ 'estart_date'] = $row->estart_date;
				$events[ $row->eid][ 'eend_date'] = $row->eend_date;
				$events[ $row->eid][ 'elast_occurrence'] = $row->elast_occurrence;
				$events[ $row->eid][ 'estart_time'] = $row->estart_time;
				$events[ $row->eid][ 'eend_time'] = $row->eend_time;
				$events[ $row->eid][ 'enotes'] = $row->enotes;
				$events[ $row->eid][ 'ecreated_by'] = $row->ecreated_by;
				$events[ $row->eid][ 'ecreated_on'] = $row->ecreated_on;
				$events[ $row->eid][ 'edate']  = $month."-".$sda."-".$year;
			} elseif($sda >= 29) {
				if($smo != 2) {
					$events[ $row->eid] = array();
					$events[ $row->eid][ 'edescription'] = $row->edescription;
					$events[ $row->eid][ 'etype'] = $row->etype;
					$events[ $row->eid][ 'efrequency'] = $row->efrequency;
					$events[ $row->eid][ 'evisibility'] = $row->evisibility;
					$events[ $row->eid][ 'evenue'] = $row->evenue;
					$events[ $row->eid][ 'estart_date'] = $row->estart_date;
					$events[ $row->eid][ 'eend_date'] = $row->eend_date;
					$events[ $row->eid][ 'elast_occurrence'] = $row->elast_occurrence;
					$events[ $row->eid][ 'estart_time'] = $row->estart_time;
					$events[ $row->eid][ 'eend_time'] = $row->eend_time;
					$events[ $row->eid][ 'enotes'] = $row->enotes;
					$events[ $row->eid][ 'ecreated_by'] = $row->ecreated_by;
					$events[ $row->eid][ 'ecreated_on'] = $row->ecreated_on;
					$events[ $row->eid][ 'edate'] = $month."-".$sda."-".$year;
				} else {
					if($cyr%4 == 0) {
						$events[ $row->eid] = array();
						$events[ $row->eid][ 'edescription'] = $row->edescription;
						$events[ $row->eid][ 'etype'] = $row->etype;
						$events[ $row->eid][ 'efrequency'] = $row->efrequency;
						$events[ $row->eid][ 'evisibility'] = $row->evisibility;
						$events[ $row->eid][ 'evenue'] = $row->evenue;
						$events[ $row->eid][ 'estart_date'] = $row->estart_date;
						$events[ $row->eid][ 'eend_date'] = $row->eend_date;
						$events[ $row->eid][ 'elast_occurrence'] = $row->elast_occurrence;
						$events[ $row->eid][ 'estart_time'] = $row->estart_time;
						$events[ $row->eid][ 'eend_time'] = $row->eend_time;
						$events[ $row->eid][ 'enotes'] = $row->enotes;
						$events[ $row->eid][ 'ecreated_by'] = $row->ecreated_by;
						$events[ $row->eid][ 'ecreated_on'] = $row->ecreated_on;
						$events[ $row->eid][ 'edate'] = $month."-".$sda."-".$year;
					}
				}
			}
		} elseif($erf == "weekly") {
			$s = $sts;
			while($s <= $ets) {
				$date = date("m-j-Y", $s);
				@list($tm, $td, $ty) = explode("-", $date);
				if($tm == $month && $ty == $year):
					$cnt = 'w'.$i;
					$events[ $cnt] = array();
					$events[ $cnt][ 'eid'] = $row->eid;
					$events[ $cnt][ 'edescription'] = $row->edescription;
					$events[ $cnt][ 'etype'] = $row->etype;
					$events[ $cnt][ 'efrequency'] = $row->efrequency;
					$events[ $cnt][ 'evisibility'] = $row->evisibility;
					$events[ $cnt][ 'evenue'] = $row->evenue;
					$events[ $cnt][ 'estart_date'] = $row->estart_date;
					$events[ $cnt][ 'eend_date'] = $row->eend_date;
					$events[ $cnt][ 'elast_occurrence'] = $row->elast_occurrence;
					$events[ $cnt][ 'estart_time'] = $row->estart_time;
					$events[ $cnt][ 'eend_time'] = $row->eend_time;
					$events[ $cnt][ 'enotes'] = $row->enotes;
					$events[ $cnt][ 'ecreated_by'] = $row->ecreated_by;
					$events[ $cnt][ 'ecreated_on'] = $row->ecreated_on;
					$events[ $cnt][ 'edate'] = $date;
					$i++;
				endif;
				$s+=(7*86400);
			}
		} else {
			$s = $sts;
			while($s <= $ets) {
				$date = date("m-j-Y", $s);
				@list($tm, $td, $ty) = explode("-", $date);
				if($shr == 0 && $ehr == 0 && $smn == 0 && $emn == 0):
					if(!isset($events[ 'allday']) || !is_array($events[ 'allday'])) $events[ 'allday'] = array();
					
				endif;
				if($tm == $month && $ty == $year):
					$cnt = 'd'.$i;
					$events[ $cnt] = array();
					$events[ $cnt][ 'eid'] = $row->eid;
					$events[ $cnt][ 'edescription'] = $row->edescription;
					$events[ $cnt][ 'etype'] = $row->etype;
					$events[ $cnt][ 'efrequency'] = $row->efrequency;
					$events[ $cnt][ 'evisibility'] = $row->evisibility;
					$events[ $cnt][ 'evenue'] = $row->evenue;
					$events[ $cnt][ 'estart_date'] = $row->estart_date;
					$events[ $cnt][ 'eend_date'] = $row->eend_date;
					$events[ $cnt][ 'elast_occurrence'] = $row->elast_occurrence;
					$events[ $cnt][ 'estart_time'] = $row->estart_time;
					$events[ $cnt][ 'eend_time'] = $row->eend_time;
					$events[ $cnt][ 'enotes'] = $row->enotes;
					$events[ $cnt][ 'ecreated_by'] = $row->ecreated_by;
					$events[ $cnt][ 'ecreated_on'] = $row->ecreated_on;
					$events[ $cnt][ 'edate'] = $date;
					$i++;
				endif;
				$s+=86400;
			}
		}
	}
}

?>
