<?php //accesscontrol.php

include_once 'db.php';
include_once 'common.php';

$noperm = false; 
if(! isset($_POST[ 'uname'])) $_POST[ 'uname'] = "";
if(! isset($_POST[ 'pword'])) $_POST[ 'pword'] = "";
$pword = "";
if($noperm==1) {
	echo "Sorry ".$user." ! Your access is restricted to ".$_SESSION['perms'];
}
if(isset($_POST[ 'adm_pubs'])) {
?>
	<script type="text/javascript">
		setState('adm_pubs','admin');
	</script>
<?php
}

if(isset($_POST[ 'adm_events'])) {
?>
	<script type="text/javascript">
		setState('adm_events','admin');
	</script>
<?php
}

if(isset($_SESSION[ 'adm_users'])) {
?>
	<script type="text/javascript">
		setState('adm_users','admin');
	</script>
<?php
}

if(isset($_SESSION[ 'adm_members'])) {
?>
	<script type="text/javascript">
		setState('adm_members','admin');
	</script>
<?php
}

$uname = isset($_POST[ 'uname']) ? $_POST[ 'uname'] : $_SESSION[ 'uname'];
$pword = isset($_POST[ 'pword']) ? $_POST[ 'pword'] : $_SESSION[ 'pword'];

if(!isset($uname)) {
	include 'txt/adminform';
	exit;
}

$_SESSION[ 'uname'] = $uname;
$_SESSION[ 'pword'] = $pword;

dbConnect($dbname);

$sql = "SELECT * FROM members WHERE uname='$uname'";
$result = mysql_query($sql);
if (!$result) {
	error('A database error occured while checking your login details.\\n'.
			'If this problem persists, please contact pkota@email.unc.edu');
}	
if(mysql_num_rows($result)==0) {
	unset($_SESSION[ 'uname']);
	unset($_SESSION[ 'pword']);
	include 'txt/adminform';
	echo "<script type=text/javascript>loginError('$uname','y');</script>";
	exit;
} else {	
	if (md5($pword)!=mysql_result($result,0,'pword')) {
		unset($_SESSION[ 'uname']);
		unset($_SESSION[ 'pword']);
		include 'txt/adminform';
		echo "<script type=text/javascript>loginError('$uname','n');</script>";
		exit;
	}
}

$user = mysql_result($result,0,'f_name');
$perm = mysql_result($result,0,'perms');
$_SESSION[ 'userok'] = 1;
$_SESSION[ 'perms'] = mysql_result($result,0,'perms');
?>
