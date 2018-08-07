<?php
/* The database connection information */
$HOSTNAME = "localhost";
$DBAID = "root";  
$DBPASS = "";
$DB = "lab";
$TABLE = "GroupMeeting";

/* Set up the connection */
$CONNECTION = mysql_connect($HOSTNAME,$DBAID,$DBPASS) or die ("Couldn't connect: ". mysql_error());
$DBCONNECT = mysql_select_db($DB,$CONNECTION) or die ("Couldn't select database: ". mysql_error());

/* initialize */
$date = array();
$name = array();
$content = array();
$type = $_POST['type'];
echo "Update is successful.&nbsp;<a href='update_event.html'>Back</a>";
for($i=0; $i<14; $i++){ 
  $date[$i] = $_POST['date'.$i];
  $name[$i] = $_POST['name'.$i];
  $content[$i] = $_POST['content'.$i];
  //echo  $date[$i]." ".$name[$i]." ".$content[$i];  
  if($type == 'old'){
    $GM_UPDATE_NAME = "UPDATE GroupMeeting SET Name='$name[$i]' WHERE Date='$date[$i]'";
    $GM_UPDATE_NAME_QUERY = mysql_query($GM_UPDATE_NAME,$CONNECTION) or die ("Couldn't update information: ". mysql_error());
    $GM_UPDATE_CONTENT = "UPDATE GroupMeeting SET Content='$content[$i]' WHERE Date='$date[$i]'";
    $GM_UPDATE_CONTENT_QUERY = mysql_query($GM_UPDATE_CONTENT,$CONNECTION) or die ("Couldn't update information: ". mysql_error());
  }
  else{
    //echo "else";
    if($date[$i] && $name[$i]){
      $GM_INSERT = "INSERT INTO GroupMeeting (Date,Name,Content) VALUES ('$date[$i]','$name[$i]','$content[$i]')";
      $GM_INSERT_QUERY = mysql_query($GM_INSERT,$CONNECTION) or die ("Couldn't insert information: ". mysql_error());
    }
  }
}


?>
