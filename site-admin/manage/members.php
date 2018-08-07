<?php
	//include_once 'login.php';
	//getMembers($uname);
    include_once 'form.php';
    include_once 'database.php';
?>
<p>You may now add new members to the group or edit status of existing members. Please use the form below to do so.</p>
<form name="addmember" method="POST" action="common.php" onsubmit="return validateForm(this)">
<div class="spacer10"></div>
<div class="login">
<fieldset><legend align="left">Add Member</legend>
<table border="0" class="text" cellpadding="3" align="center">
<tr>
	<tr>
		<td align="right">
			First Name<font color=maroon><sup>*</sup></font>
		</td>
		<td align=center>:</td>
		<td align=left>
			<input type=text name=firstname class=keyword value="">
		</td>
	</tr>
	<tr>
		<td align=right>
			Middle Initials
		</td>
		<td align=center>:</td>
		<td align=left>
			<input type=text name=minitial class=keyword value="">
		</td>
	</tr>
	<tr>
		<td align=right>
			Last Name<font color=maroon><sup>*</sup></font>
		</td>
		<td align=center>:</td>
		<td align=left>
			<input type=text name=lastname class=keyword value="">
		</td>
	</tr>
	<tr>
		<td align=right>
			Current<font color=maroon><sup>*</sup></font>
		</td>
		<td align=center>:</td>
		<td align=left>
			<input type=radio name=curr value="1">Yes <input type=radio name=curr value="0">No
		</td>
	</tr>
	<tr>
		<td align=right>
			Has Publications<font color=maroon><sup>*</sup></font>
		</td>
		<td align=center>:</td>
		<td align=left>
			<input type=radio name=haspubl value="yes">Yes <input type=radio name=haspubl value="no">No
		</td>
	</tr>
	<tr>
		<td align=right>
			Designation<font color=maroon><sup>*</sup></font>
		</td>
		<td align=center>:</td>
		<td align=left>
			<select name=designation class=dropdown>
				<option value="dummy">Pick One...
				<option value="Postdoctoral Fellow">Postdoctoral
				<option value="Graduate">Graduate
				<option value="Roton">Roton
				<option value="Undergraduate">Undergraduate
				<option value="Alumni">Alumni
				<option value="Friend">Friend
			</select>
		</td>
	</tr>
	<?php 
	//	while(list($index,$value)=each($_POST)){
	//		echo "$index = $value<br>";
	//	}
	?>
	<tr>
		<td align=center colspan=3>
			<div class=spacer5></div>
			<input type=submit class=button name=member value="Add">
		</td>
	</tr>
</table>
</fieldset>
</div>
<input type=hidden name=<?php echo $page?> value=1>
</form>

<form name="editmember" method=POST value="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return validateForm(this)">
<div class=login>
<fieldset><legend align=left>Edit/Remove Member</legend>
<table align=center border=0 class=text>
	<tr>
		<td align=right>
			Current Members
		</td>
		<td width=5 align=center>
			:
		</td>
		<td align=left>
		<select name=edit_selmember class=dropdown>
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
		<td align="right">
			First Name<font color=maroon><sup>*</sup></font>
		</td>
		<td align=center>:</td>
		<td align=left>
			<input type=text name=firstname class=keyword value="">
		</td>
	</tr>
	<tr>
		<td align=right>
			Middle Initials
		</td>
		<td align=center>:</td>
		<td align=left>
			<input type=text name=minitial class=keyword value="">
		</td>
	</tr>
	<tr>
		<td align=right>
			Last Name<font color=maroon><sup>*</sup></font>
		</td>
		<td align=center>:</td>
		<td align=left>
			<input type=text name=lastname class=keyword value="">
		</td>
	</tr>
	<tr>
		<td align=right>
			Current<font color=maroon><sup>*</sup></font>
		</td>
		<td align=center>:</td>
		<td align=left>
			<input type=radio name=curr value="1">Yes <input type=radio name=curr value="0">No
		</td>
	</tr>
	<tr>
		<td align=right>
			Has Publications<font color=maroon><sup>*</sup></font>
		</td>
		<td align=center>:</td>
		<td align=left>
			<input type=radio name=haspubl value="yes">Yes <input type=radio name=haspubl value="no">No
		</td>
	</tr>
	<tr>
		<td align=right>
			Designation<font color=maroon><sup>*</sup></font>
		</td>
		<td align=center>:</td>
		<td align=left>
			<select name=designation class=dropdown>
				<option value="dummy">Pick One...
				<option value="Postdoctoral Fellow">Postdoctoral
				<option value="Graduate">Graduate
				<option value="Roton">Roton
				<option value="Undergraduate">Undergraduate
				<option value="Alumni">Alumni
				<option value="Friend">Friend
			</select>
		</td>
	</tr>
	<tr>
		<td align=right>
			<div class=spacer5></div>
			<input type=submit class=button name="member" value="Update">
		</td>
		<td align=center>&nbsp;</td>
		<td align=left>
			<div class=spacer5></div>
			<input type=submit class=button name="member" value="Remove" onclick="return confirmRemove()">
		</td>
	</tr>
</table>
</fieldset>
<div class=micro >* required fields</div>
</div>
<input type=hidden name=adm_members value=1>
</form>
