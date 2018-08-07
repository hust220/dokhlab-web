<?php //common.php
require_once 'db.php';
dbConnect($dbname);
if(! isset($_POST[ 'add_name']) ) $_POST[ 'add_uname'] = "";
if(! isset($_POST[ 'muser']) ) $_POST[ 'muser'] = "";
if(! isset($_POST[ 'member']) ) $_POST[ 'member'] = "";
$dberror = "A database error occured while processing your request. If this error persists, please contact pkota@email.unc.edu";
$dupuser = "The username - ".$_POST[ 'add_uname']." - is already chosen. Please choose a different name";
$dbadderror = "The database could not be updated for some reason. If this problem persists, please contact pkota@email.unc.edu";
$user_add_success = "User added successfully";
$user_update_success = "User updated successfully";
$user_remove_success = "User removed successfully";
$member_add_success = "Member added successfully";
$member_update_success = "Member updated successfully";
$member_remove_success = "Member removed successfully";
if($_POST[ 'muser'] == "Add") {
	$sql = "SELECT * FROM members WHERE uname='".$_POST[ 'add_uname']."'";
	$result = mysql_query($sql);
	if(!$result) {
		$_SESSION[ 'error'] = $dberror;
	} else if(mysql_num_rows($result)>0) {
		$_SESSION[ 'error'] = $dupuser;
	} else {
		$sql = "UPDATE members SET uname='".$_POST[ 'add_uname']."', pword='".md5($_POST[ 'add_pword'])."', perms='".$_POST[ 'add_perm']."' WHERE l_name='".$_POST[ 'add_seluser']."'";
		$result = mysql_query($sql);
		if(!$result) {
			$_SESSION[ 'error'] = $dbadderror;
		} else {
			$_SESSION[ 'error'] = $user_add_success;
			header("Location: admin.php?adm_users=1");
		}
	}
} else if($_POST[ 'muser'] == "Update") {
	$sql = "UPDATE members SET perms='".$_POST[ 'edit_perm']."' WHERE l_name='".$_POST[ 'edit_seluser']."'";
	$result = mysql_query($sql);
	if(!$result) {
		$_SESSION[ 'error'] = $dberror;
	} else {
		$_SESSION[ 'error'] = $user_update_success;
		header("Location: admin.php?adm_users=1");
	}
} else if ($_POST[ 'muser'] == "Remove") {
	$sql = "UPDATE members SET uname='', pword='', perms='' WHERE l_name='".$_POST[ 'edit_seluser']."'";
	$result = mysql_query($sql);
	if(!$result) {
		$_SESSION[ 'error'] = $dberror;
	} else {
		$_SESSION[ 'error'] = $user_remove_success;
		$_SESSION[ 'adm_users']=1;
		header("Location: admin.php?adm_users=1");
	}
}

if($_POST[ 'member'] == "Add") {
	$sql = "SELECT * FROM members WHERE f_name='".$_POST[ 'firstname']."' AND l_name='".$_POST[ 'lastname']."'";
	$result = mysql_query($sql);
	if(!$result) {
		$_SESSION[ 'error'] = $dberror;
	} else if(mysql_num_rows($result)>0) {
		$_SESSION[ 'error'] = $dupuser;
	} else {
		$sql = "INSERT INTO members (`f_name`,`m_init`,`l_name`,`uname`,`pword`,`perms`,`has_publ`,`current`) VALUES ('".$_POST[ 'firstname']."','".$_POST[ 'minitial']."','".$_POST[ 'lastname']."','','','','".$_POST[ 'haspubl']."','".$_POST[ 'current']."')";
		$result = mysql_query($sql);
		if(!$result) {
			$_SESSION[ 'error'] = $dbadderror;
		} else {
			$_SESSION[ 'error'] = $member_add_success;
		}
	}
} else if($_POST[ 'member'] == "Update") {
	$sql = "UPDATE members SET perms='".$_POST[ 'edit_perm']."' WHERE l_name='".$_POST[ 'edit_seluser']."'";
	$result = mysql_query($sql);
	if(!$result) {
		$_SESSION[ 'error'] = $dberror;
	} else {
		$_SESSION[ 'error'] = $member_update_success;
	}
} else if ($_POST[ 'member'] == "Remove") {
	$sql = "DELETE FROM members WHERE l_name='".$_POST[ 'edit_selmember']."'";
	$result = mysql_query($sql);
	if(!$result) {
		$_SESSION[ 'error'] = $dberror;
	} else {
		$_SESSION[ 'error'] = $member_remove_success;
	}
}

function error($msg) {
?>
	<html>
		<head>
			<script language="Javascript">
				<!--
					alert("<?=$msg?>");
					history.back();
				//-->
			</script>
		</head>
		<body></body>
	</html>
	<?
	exit;
}

function showmsg($msg) {
?>
	<html>
		<head>
			<script language="Javascript">
				<!--
					alert("<?=$msg?>");
				-->
			</script>
		</head>
		<body></body>
	</html>
<?
}

$pages = array("adm_main","adm_pubs","adm_events","adm_users","adm_members");
function setSession() {
	global $pages;
	foreach($pages as $p=>$val):
		if(isset($_POST[$val])) {
			$_SESSION[$val]=1;
		} else {
			unset($_SESSION[$val]);
		}
	endforeach;
}

function getPage() {
	global $pages;
	foreach($pages as $p=>$val):
		if(isset($_SESSION[$val])){
			return $val;
		}
	endforeach;
}

$currmem = array();
$availmem = array();

function getUsers($u) {
	global $currmem, $availmem;
	dbConnect("vdesign");
	$sql = "SELECT * FROM members WHERE perms='' AND current=True";
	$result = mysql_query($sql);
	if(!$result) {
		error('A database error occured while retrieving'.
				'the list of available users\\n'.
				'If this problem persists, please'.
				'contact pkota@email.unc.edu');
	} else {
		while($row=mysql_fetch_object($result)) {
			$availmem[trim($row->l_name)] = trim($row->f_name)." ".trim($row->m_init)." ".trim($row->l_name);
		}
	}
	$sql = "SELECT * FROM members WHERE perms!='' AND current=True";
	$result = mysql_query($sql);
	if(!$result) {
		error('A database error occured while retrieving'.
				'the list of current users\\n'.
				'If this problem persists, please'.
				'contact pkota@email.unc.edu');
	} else {
		while($row=mysql_fetch_object($result)) {
			if($row->uname != $u) $currmem[trim($row->l_name)] = trim($row->f_name)." ".trim($row->m_init)." ".trim($row->l_name);
		}
	}
}

function getMembers($u) {
	global $currmem;
	dbConnect("vdesign");
	$sql = "SELECT * FROM members WHERE f_name!='Nikolay'";
	$result = mysql_query($sql);
	if(!$result) {
		error('A database error occured while retrieving'.
				'the list of available members\\n'.
				'If this problem persists, please'.
				'contact pkota@email.unc.edu');
	} else {
		while($row=mysql_fetch_object($result)) {
			if($row->uname != $u) $currmem[trim($row->l_name)] = trim($row->f_name)." ".trim($row->m_init)." ".trim($row->l_name);
		}
	}
}

?>
