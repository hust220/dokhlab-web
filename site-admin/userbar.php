<div id=ubar class="userbar">
	<div id=cuser class=leftfl>
		Current User :
	</div>
	<div class="loginpos widebuffer100"></div>
	<? if($session->username != GUEST_NAME) {
	 ?>
	<div class=rightfl>
		<div id=logout><a id=maintext href=process.php>Logout</a></div>
	</div>
	<div class=rightfl>
		<div> &nbsp;|&nbsp; </div>
	</div>
	<div class=rightfl>
		<div id=logout><a id=maintext href="useredit.php">Edit</a></div>
	</div>
	<div class=rightfl>
		<div> &nbsp;|&nbsp; </div>
	</div>
	<div class=rightfl>
		<div id=logout><a id=maintext href="userinfo.php?user=<? echo $session->username ?>">Profile</a></div>
	</div>
	<?
		if($session->isAdmin()) {
	?>
	<div class=rightfl>
		<div> &nbsp;|&nbsp; </div>
	</div>
	<div class=rightfl>
		<div id=logout><a id=maintext href="admin/admin.php">Admin Center</a></div>
	</div>
	<?
		}
	}
	?>
</div>
<div class=spacer10></div>
<div class=spacer10></div>
