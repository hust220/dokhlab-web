<?php
echo "<html><body bgcolor=#f0f0f0>";
$code = $_POST["code"];
//echo $code;

if( $code == "dokh" ){
  echo "<form name='jc_schedule' action='jc_schedule.php' method='post'>";
  echo "<input type='radio' name='type' value='old'>update current schedule<br>";
  echo "<input type='radio' name='type' value='new'>add new schedule<br>";
  echo "Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";
  echo "Content:<br>";
  for($i=0;$i<8;$i++){
    $date_name = "date".$i;
    $name_name = "name".$i;
    $content_name = "content".$i;
    echo "<input name=$date_name type=text size=10>&nbsp; ";
    echo "<input name=$name_name type=text size=10>&nbsp; ";
    echo "<input name=$content_name type=text size=10><br>";
  }
  echo "<br><input type='submit' value='update jc schedule'></form></body></html>";
}
else {
  echo "code is not correct.&nbsp;<a href='update_event.html'>Back</a>";
}
?> 
