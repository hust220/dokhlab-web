<?php // manage-publications
	//include_once 'login.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/site-admin/include/htmlElements.php';
	if (!isset($_SESSION[ 'numauths'])) $_SESSION[ 'numauths'] = 5;
	while(list($a,$b) = each($_SESSION)) { echo "$a = $b<br>"; }
?>
<p>You may now insert update or delete publications from the publications database using the form below.</p>
<form name="subnewpub" id=subnewpub method=POST action="process.php">
<div class=spacer10></div>
<div class=admin-content>
<fieldset class=fset><legend align=left>Add New</legend>
<table border=0  width=100% class=text cellpadding=3 align=center>
<tr>
	<td>
		<fieldset class=fset><legend>Authors</legend>
			<?php
	while(list($a,$b) = each($_SESSION)) { echo "$a = $b<br>"; }
			$addauth = 'document.getElementById("subnewpub").innerHTML+="<input type=hidden name=subaddauth value='.$_SESSION[ 'numauths'].'>";document.getElementById("subnewpub").submit()';
			for($i=0;$i<$_SESSION[ 'numauths'];$i++) {
			 	//$change = ($i == $_SESSION[ 'numauths'] - 1) ? ' onchange = \'document.forms("subnewpub").submit();\'' : '';
				//echo '<select name=subselauth class=dropdown'.$change.'>';
				//echo '<option value=dummy>Choose One...';
				//$yrn = ($form->value("subselauth") == "auth$i") ? "yes" : "no";
				//echo '<option value=auth1 selected='.$yrn.'>Author1';
				//echo '<option value=auth2>Author2';
				//echo '</select>&nbsp;/';
				if(!isset($_SESSION[ 'subremauth']) || $i!=$_SESSION[ 'subremauth']) {
			  		$j = $i+1;
				  	echo 'Author'.$j.' : ';
					echo '<input type=text class=keyword name=auth'.$i.' value="'.$form->value('auth'.$i).'"/>';
					if($i==0) {
						echo '<font class=micro>  (e.g. Dokholyan, N. V.)</font>';
					}
					//if($i > 0) echo '&nbsp;&nbsp;<img style="cursor: pointer;" src="../images/remove.png" width=10 height=10 onclick=\'document.getElementById("subnewpub").innerHTML+="<input type=hidden name=subremauth value='.$i.'>";document.getElementById("subnewpub").submit()\'>';
					if($i>0) echo '<input type=submit name=remauth'.$i.' onclick=\'document.getElementById("subnewpub").innerHTML+="<input type=hidden name=subremauth value='.$i.'>"\' value="Remove">';
					echo $_SESSION[ 'numauths'];
					echo $i;
					echo "<br>";
				} else {
					$i = $i-1;
#unset($_SESSION[ 'subremauth']);
				}
			}
			echo '<div class=spacer10></div>';
			echo '<input type=hidden name=subaddauth value'.$_SESSION[ 'numauths'].'>';
			//echo '<div style="cursor: pointer; float: left" onclick=\''.$addauth.'\'>Add another author</div>';
			echo '<input type=submit style="cursor: pointer; float: left" value="Add another author">';
			?>
		</fieldset>
	</td>
</tr>
<tr>
	<td>
		<fieldset class=fset><legend>Journal</legend>
			<select name=jrnl class=dropdown>
				<option value=dummy />Choose One...
			</select>&nbsp;/
			<input type=text class=keyword name=jrnl value=""> <font class=micro>(e.g. Biophysical Journal)</font>
		</fieldset>
	</td>
</tr>
<tr>
	<td>
		<fieldset class=fset><legend>Title</legend>
		<input type=text size=58 class=input-text name=title>
		</fieldset>
	</td>
</tr>
<tr>
	<td>
		<fieldset class=fset><legend>Abstract</legend>
		<textarea name=abstract rows=15 cols=60></textarea>
		</fieldset>
	</td>
</tr>
<tr>
	<td>
		<fieldset class=fset><legend>Citation</legend>
		Volume&nbsp;
		<input size=3 class=input-text type=text name=volume>
		&nbsp;Issue&nbsp;
		<input size=3 class=input-text type=text name=issue>
		&nbsp;&nbsp;Start page&nbsp;
		<input size=4 class=input-text type=text name=spage>
		&nbsp;End page&nbsp;
		<input size=4 class=input-text type=text name=epage>
		</fieldset>
	</td>
</tr>
<tr>
	<td align=center>
		<div class=spacer5></div>
		<input type=submit class=button name=muser value="Add">
	</td>
</tr>
</table>
</fieldset>
</div>
</form>

<form name="edituser" method=POST action="common.php" onsubmit="return validateForm(this)">
<div class=login>
<fieldset class=fset><legend align=left>Edit/Remove User</legend>
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
