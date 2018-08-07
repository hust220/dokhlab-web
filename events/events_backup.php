<?php
require_once("event_top.html");
/* The database connection information */
$HOSTNAME = "localhost";
$DBAID = "root";  
$DBPASS = "";
$DB = "lab";
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
$i=7;
/* get the GM information */
$GM_SELECT = "SELECT * FROM GroupMeeting order by id DESC limit 8 ";
$QUERY_GM_SELECT = mysql_query($GM_SELECT,$CONNECTION);


/* get other information */
//$OTHER_SELECT = "SELECT * FROM OtherEvents order by ID ";
//$QUERY_OTHER_SELECT = mysql_query($OTHER_SELECT,$CONNECTION) or die("can't select");


while($GM_OBJECT = mysql_fetch_object($QUERY_GM_SELECT)) {
  //  echo $GM_OBJECT;
  $Id[$i] = $GM_OBJECT->ID;
  $Date[$i] = $GM_OBJECT->Date;
  $Name[$i] = $GM_OBJECT->Name;
  $Content[$i] = $GM_OBJECT->Content;
  //  echo $Date[$i]."in the while";
  $i--;
}

echo "<td valign='top' rowspan='3'><!-- #BeginEditable 'text1' --> <b>
<font color='#333333'>Group meetings</font></b><br>";
echo "<i>Mondays 5-6pm, 305MEJ</i><br>";
echo "<hr align='left' width='170'>";
for ($j=0;$j<8;$j++){
  //echo "in the for";
  //echo "<tr><td class='out'>";
  list($month, $day) = split('[/.-]', $Date[$j]);
  if(($month == $time['mon']) && ($day>=$time['mday'])){ 
    echo "<font size=3 color=red>"; 
    echo $Date[$j]."  ";
    echo $Name[$j]."</font>";
  }
  else {
    echo"<font size=3 >";
    echo $Date[$j]." ";
    echo $Name[$j]."</font>";
  }
  echo "<br>";
} 
echo "<br>";
//if ($QUERY_OTHER_SELECT){
//  while($OTHER_OBJECT = mysql_fetch_object($QUERY_OTHER_SELECT)){
//    echo"<font size=2 face='Trebuchet MS, Arial, Helvetica'><b>Current Events:</b></font><br><font size=2 face='Trebuchet MS, Arial, Helvetica' color=red>";
//    echo $OTHER_OBJECT->Date.":</font><br>";
//    echo $OTHER_OBJECT->Content."<br>";
//  }
//}
//else{
//  echo "<tr><td align=center colspan=3>";
//  echo "<font size=2 face='Trebuchet MS, Arial, Helvetica'><b><center>There is no other group events currently.</center></b></font>";
//}

//echo "</td></tr></table>";
require_once("event_bottom.html");
?>
