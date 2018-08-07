<?
/**
 * Main.php
 *
 * This is an example of the main page of a website. Here
 * users will be able to login. However, like on most sites
 * the login form doesn't just have to be on the main page,
 * but re-appear on subsequent pages, depending on whether
 * the user has logged in or not.
 *
 */
error_reporting(E_ALL);
include("session.php");
?>

<html>
<head>
		<script type=text/javascript src=../pubs.js></script>
		<script type=text/javascript src=../prototype.js></script>
		<script type=text/javascript src=../jetpack.js></script>
		<script type=text/javascript src=../lytebox.js></script>
		<link rel=stylesheet href=../dokh.css type=text/css>
		<link rel="stylesheet" href="../lytebox.css" media="screen,projection" type="text/css" />
		<title>
			Dokholyan Group - Administration
		</title>

</head>
<body>
<?
/**
 * Include page header. This html contains top bar and buttons
 */

include("head.html");

?>
	<div class=container>
		<div align=right>
			<img src=../images/publications.gif>
		</div>
		<div class=spacer5></div>
		<div class=spacer10></div>
		<!-- Center content div -->
		<form name="admin" method="POST" action="process.php">
		<div class="tabcontentdiv">
		<div class="tabs">
			<input type="button" class="tabActive" name="main" value="Main Page" onClick="toggleTabClass(this,this.form);adminForm(this.name,this.form)">
			<div class="spacer5"></div>
			<input type="button" class="tab" name="publications" value="Manage Publications" onclick="toggleTabClass(this,this.form);adminForm(this.name,this.form)">
			<div class="spacer5"></div>
			<input type="button" class="tab" name="events" value="Manage Events" onclick="toggleTabClass(this,this.form);adminForm(this.name,this.form)">
			<div class="spacer5"></div>
			<input type="button" class="tab" name="users" value="Manage Users" onclick="toggleTabClass(this,this.form);adminForm(this.name,this.form)">
			<div class="spacer5"></div>
			<input type="button" class="tab" name="members" value="Manage Members" onclick="toggleTabClass(this,this.form);adminForm(this.name,this.form)">
		</div>
		</form>
		<?php include 'userbar.php';?>
			<div class=spacer5></div>
		<div class=tabcontent>
			<div class=contentdiv>
			<?php
				
			while(list($index, $value) = each($_SESSION)){
		//		echo "$index = $value <br>";
			}

?>
<table border=0>
<tr><td>


<?
/**
 * Determine access control
 */
if($session->control == 0 || $session->logged_in !== false) {
	if($session->page == "main") include("manage/main.php");
?>
	<script type=text/javascript>
		setState('<? echo $session->page ?>','admin');
		showUserbar('<? echo $session->username ?>','ubar');
	</script>

<?
}
if($_SESSION[ 'control'] == 1) {
/**
 * User has already logged in, so display relevant links, including
 * a link to the admin center if the user is an administrator.
 */
if($session->logged_in) {
  //echo "page = ".$session->page;
?>
	<script type=text/javascript>
		showUserbar('<? echo $session->username ?>','ubar');
		setState('<? echo $session->page ?>','admin');
	</script>
	<center><img src="http://dokhlab.unc.edu/images/W.gif">elcome Administrator !</center>
<?
	include("manage/".$_SESSION[ 'page'].".php");
}
else{
?>

	<center>
		<img src="http://dokhlab.unc.edu/images/W.gif">elcome Administrator !
	</center>
	<?
	/**
	 * User not logged in, display the login form.
	 * If user has already tried to login, but errors were
	 * found, display the total number of errors.
	 * If errors occurred, they will be displayed.
	*/
	if($form->num_errors > 0){
	     echo "<font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font>";
	}
  ?>
	<form name="login" action="process.php" method="POST">
	<div class=spacer10></div>
	<div class=login>
	<fieldset><legend align=left>Login</legend>
	<table align="left" border="0" cellspacing="0" cellpadding="3">
	<tr><td>Username:</td><td><input type="text" name="user" maxlength="30" value="<? echo $form->value("user"); ?>"></td><td><? echo $form->error("user"); ?></td></tr>
	<tr><td>Password:</td><td><input type="password" name="pass" maxlength="30" value="<? echo $form->value("pass"); ?>"></td><td><? echo $form->error("pass"); ?></td></tr>
	<tr><td colspan="2" align="left"><input type="checkbox" name="remember" <? if($form->value("remember") != ""){ echo "checked"; } ?>>
	<font size="2">Remember me next time     
	<input type="hidden" name="sublogin" value="1">
	<input type="submit" value="Login"></td></tr>
	<tr><td colspan="2" align="left"><br><font size="2">[<a href="forgotpass.php">Forgot Password?</a>]</font></td><td align="right"></td></tr>
	</table>
	</fieldset>
	</div>
	</form>

	<?
}

/**
 * Just a little page footer, tells how many registered members
 * there are, how many users currently logged in and viewing site,
 * and how many guests viewing site. Active users are displayed,
 * with link to their user information.
 */
//echo "</td></tr><tr><td align=\"center\"><br><br>";
//echo "<b>Member Total:</b> ".$database->getNumMembers()."<br>";
//echo "There are $database->num_active_users registered members and ";
//echo "$database->num_active_guests guests viewing the site.<br><br>";

//include("include/view_active.php");
}
?>


</td></tr>
</table>
<?

				/*if(sizeof($_POST)==0) {
					if(sizeof($_GET)==0) {
						$_POST['main']=1;
					} else {
						list($index, $value) = each($_GET);
						$_POST[ $index] = 1;
					}
				}
				//setSession();
				while(list($index, $value)=each($_POST)) 
				{ 
					echo "$index = $value <br>";
					$$index = $value; 
				}
				if(isset($_SESSION[ 'userok'])) {
					$uname = $_SESSION[ 'uname'];
				}
				//if($page == "adm_main") {
				if($session->page == 'main') {
					echo "<center><img src=\"http://dokhlab.unc.edu/images/W.gif\">elcome Administrator !</center>";
					include("admin-main");
				} else {
					//include 'accesscontrol.php';
					//$uname = $_SESSION[ 'uname'];
					//$uperm = explode(",",$_SESSION[ 'perms']);
					//$noperm = false;
					//foreach($uperm as $perm):
					//	$_SESSION[$perm]=1;
					//endforeach;
					//echo "<script type=text/javascript>showUserbar('$uname','ubar');</script>";
					//echo "<center><img src=\"http://dokhlab.unc.edu/images/W.gif\">elcome ".$user." !</center>";
					//if($page == "adm_pubs") {
					if(isset($_SESSION[ 'publications'])) {
						if(isset($_SESSION[ 'pubs']) or isset($_SESSION[ 'all'])) {
							//include 'txt/manage-pubs.php';
						} else {
							$noperm = true;
							//include 'accesscontrol.php';
						}
					}
					//if($page == "adm_events") {
					if(isset($_SESSION[ 'events'])) {
						if(isset($_SESSION[ 'events']) or isset($_SESSION[ 'all'])) {
							include 'txt/manage-events.php';
						} else {
							$noperm = true;
							include 'accesscontrol.php';
						}
					}
					//if($page == "adm_users") {
					if(isset($_SESSION[ 'users'])) {
						if(isset($_SESSION[ 'users']) or isset($_SESSION[ 'all'])) {
							include 'txt/manage-users.php';
						} else {
							$noperm = true;
							include 'accesscontrol.php';
						}
					}
					//if($page == "adm_members") {
					if(isset($_SESSION[ 'members'])) {
						if(isset($_SESSION[ 'members']) or isset($_SESSION[ 'all'])) {
							include 'txt/manage-members.php';
						} else {
							$noperm = true;
							include 'accesscontrol.php';
						}
					}
				}*/
			?>
			</div>
		</div>
		</div>
		<!-- Right col div -->
	<div class=cleardiv>&nbsp;</div>
		</div>
</body>
</html>
