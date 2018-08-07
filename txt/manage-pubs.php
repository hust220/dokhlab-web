<?php // manage-publications
	include_once 'login.php';
?>
<p>You may now insert update or delete publications from the publications database using the form below.</p>
<form name="pubload" method=POST action="common.php" onsubmit="return validateForm(this)">
<div class=spacer10></div>
<div class=login>
<fieldset><legend align=left>Upload File</legend>
<table border=0 class=text cellpadding=3 align=center>
<tr>
	<td align=right>
		Choose File
	</td>
	<td align=center>:</td>
	<td align=left>
		<input type=browse name=getfile class=button value="Choose File...">
	</td>
</tr>
<tr>
	<td align=right>
		Assign Permissions
	</td>
	<td align=center>:</td>
	<td align=left>
		<select name=add_perm class=dropdown>
			<option value="all">All
			<option value="pubs">Publications
			<option value="events">Events
			<option value="users">Users
			<option value="members">Members
		</select>
	</td>
</tr>
<tr>
	<td align=right>
		Set Username<font color=maroon><sup>*</sup></font>
	</td>
	<td align=center>:</td>
	<td align=left>
		<input type=text name=add_uname class=keyword value="">
	</td>
</tr>
<tr>
	<td align=right>
		Set Password<font color=maroon><sup>*</sup></font><br>
		<div class=micro>(User can change this later)</div>
	</td>
	<td align=center>:</td>
	<td align=left>
		<input type=password name=add_pword class=keyword value="">
	</td>
</tr>
<tr>
	<td align=center colspan=3>
		<div class=spacer5></div>
		<input type=submit class=button name=muser value="Add">
	</td>
</tr>
</table>
</fieldset>
</div>
<input type=hidden name=<?php echo $page?> value=1>
</form>

<form name="edituser" method=POST action="common.php" onsubmit="return validateForm(this)">
<div class=login>
<fieldset><legend align=left>Edit/Remove User</legend>
<table align=center border=0 class=text>
	<tr>
		<td align=right>
			Current Users<font color=maroon><sup>*</sup></font>
		</td>
		<td width=5 align=center>
			:
		</td>
		<td align=left>
		<select name=edit_seluser class=dropdown>
			<option value="dummy">Pick One...
			<?php
				if(count($currmem)>0) {
					foreach($currmem as $mem=>$currmem):
						echo "<option value=".$mem.">".$currmem;
					endforeach;
				}
			?>
		</select>
		</td>
	</tr>
	<tr>
		<td align=right>
			Current Permissions
		</td>
		<td align=center>:</td>
		<td align=left>
			<select name=edit_perm class=dropdown>
				<option value="all">All
				<option value="pubs">Publications
				<option value="events">Events
				<option value="users">Users
				<option value="members">Members
			</select>
		</td>
	</tr>
	<tr>
		<td align=right>
			<div class=spacer5></div>
			<input type=submit class=button name="muser" value="Update">
		</td>
		<td align=center>&nbsp;</td>
		<td align=left>
			<div class=spacer5></div>
			<input type=submit class=button name="muser" value="Remove" onclick="return confirmRemove()">
		</td>
	</tr>
</table>
</fieldset>
<div class=micro >* required fields</div>
</div>
<!--<input type=hidden name=adm_users value=1>-->
</form>
<?php 
	if(isset($_SESSION['error'])) {
		showmsg($_SESSION['error']);
		unset($_SESSION[ 'error']);
	}
?>
