<?php

date_default_timezone_set("America/New_York");

/* The database connection information */
//$HOSTNAME = "troll.med.unc.edu:3306";
//$DBAID = "webadmin";  
//$DBPASS = 'ccsb$me3';
//$DB = "dokhlab";
//$TABLE = "GroupMeeting";
$HOSTNAME = "localhost";
$DBAID = "dokhlab_svc";  
$DBPASS = 'second-S3cr3t';
$DB = "dokhlab";
$TABLE = "GroupMeeting";

/* Set up the connection */
$CONNECTION = mysql_connect($HOSTNAME,$DBAID,$DBPASS) or die ("Couldn't connect: ". mysql_error());
$DBCONNECT = mysql_select_db($DB,$CONNECTION) or die ("Couldn't select database: ". mysql_error());

/* get time */
$time= getdate();
$c_date = $time['mon']."/".$time['mday'];
//echo $c_date;

/* Initialize */
$Date = array();
$Name = array();
$Content = array();
$Id = array();
$i=9;
/* get the GM information */
$GM_SELECT = "SELECT * FROM GroupMeeting order by ID DESC limit 10 ";
$QUERY_GM_SELECT = mysql_query($GM_SELECT,$CONNECTION) or die("can't select");


while($GM_OBJECT = mysql_fetch_object($QUERY_GM_SELECT)) {
  $Id[$i] = $GM_OBJECT->ID;
  $Date[$i] = $GM_OBJECT->Date;
  $Name[$i] = $GM_OBJECT->Name;
  $Content[$i] = $GM_OBJECT->Content;
  $i--;
}

/* get JournalClub information */
$JC_SELECT = "SELECT * FROM JournalClub order by ID DESC limit 10 ";
$QUERY_JC_SELECT = mysql_query($JC_SELECT,$CONNECTION) or die("can't select");

$JC_Date = array();
$JC_Name = array();
$JC_Content = array();
$Id = array();
$i=9;
while($JC_OBJECT = mysql_fetch_object($QUERY_JC_SELECT)){
  $JC_Id[$i]   = $JC_OBJECT->ID;
  $JC_Date[$i] = $JC_OBJECT->Date;
  $JC_Name[$i] =$JC_OBJECT->Name;
  $JC_Content[$i]=$JC_OBJECT->Content;
  $i--;
}

function getGM($m,$d,$y) {
	global $Date, $Name, $time;
	$gmstr = "";
	$year = date('Y',time());
	for ($j=0;$j<10;$j++){
		//echo "in the for";
		//echo "<tr><td class='out'>";
		$arr = split('[/.-]', $Date[$j]);
        if (count($arr) == 2) {
            list($month, $day) = $arr;
        }
        elseif (count($arr) == 3) {
            list($month, $day, $year) = $arr;
        }
		//list($month, $day) = split('[/.-]', $Date[$j]);
		if(($month == $m) && ($year == $y)){ 
		  	if($day == $d) {
				$gmstr.="<font color=red>".$Date[$j]."  ".$Name[$j]."</font><br>";
				$gmper = $Name[$j];
			} else {
				$gmstr.=$Date[$j]." ".$Name[$j]."<br>";
			}
		}
	}
	return $gmper;
	//echo "<td valign=top>Journal Club Schedule HERE!</td>";
}

function getJC($m,$d,$y) {
	global $JC_Date, $JC_Name, $time;
	$jcstr="";
	$year = date('Y',time());
	for ($j=0;$j<10;$j++){
		//echo "in the for";
		//echo "<tr><td class='out'>";
		$arr = split('[/.-]', $JC_Date[$j]);
        if (count($arr) == 2) {
            list($month, $day) = $arr;
        }
        elseif (count($arr) == 3) {
            list($month, $day, $year) = $arr;
        }
		//list($month, $day) = split('[/.-]', $JC_Date[$j]);
		if(($month == $m) && ($year==$y)){
		 	if($day == $d) { 
				$jcstr.="<font color=red>".$JC_Date[$j]."  ".$JC_Name[$j]."</font><br>";
				$jcper = $JC_Name[$j];
			} else {
			  	$jcstr.=$JC_Date[$j]." ".$JC_Name[$j]."<br>";
			}
		}
	}
	return $jcper;
}
?>
