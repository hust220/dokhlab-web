<?php //db.php
#$dbhost = '152.19.64.130:3306';
#$dbhost = '152.19.100.42:3306';
#$dbhost = '152.19.64.170:3306';
#$dbhost = '152.19.9.64:3306';
$dbhost = 'localhost';
#$dbuser = 'webadmin';
#$dbpass = 'ccsb$me3';
#$dbname = 'dokhlab';
#$dbuser = 'dokhlab_svc';
#$dbpass = 'second-S3cr3t';
#$dbname = 'dokhlab';
$dbuser = 'dokhlab_svc';
$dbpass = 'second-S3cr3t';
$dbname = 'dokhlab';

function dbConnect($db="") {
	global $dbhost, $dbuser, $dbpass;
	$dblink = @mysql_pconnect($dbhost,$dbuser,$dbpass)
		or die("The site appears to be down.".mysql_error());
	if($db!="" and !@mysql_select_db($db))
		die("The database $db is not available.");

	return $dblink;
}
?>
