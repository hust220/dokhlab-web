<?php
	//include_once 'login.php';
	include_once 'database.php';
	include_once 'form.php';
	//getUsers($uname);
?>
<p>You may now add new users to manage the group website or edit permissions for existing ones. Please use the form below to do so.</p>
<form name="adduser" method=POST action="common.php" onsubmit="return validateForm(this)">
<div class=spacer10></div>
<div class=login>
<fieldset><legend align=left>Add User</legend>
<table border=0 class=text cellpadding=3 align=center>
<tr>
	<td align=right>
		Available Members<font color=maroon><sup>*</sup></font>
	</td>
	<td align=center>:</td>
	<td align=left>
		<select name=add_seluser class=dropdown>
			<option value="dummy">Pick One...
			<?php
				if(count($availmem)>0) {
					foreach($availmem as $mem=>$memname):
						echo "<option value=".$mem.">".$memname;
					endforeach;
				}
			?>
		</select>
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
