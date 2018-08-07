<?php
	include_once 'login.php';
?>
<html>
	<head>
		<script type=text/javascript src=pubs.js></script>
		<script type=text/javascript src=prototype.js></script>
		<script type=text/javascript src=lightbox.js></script>
		<link rel=stylesheet href=dokh.css type=text/css>
		<link rel="stylesheet" href="lightbox.css" media="screen,projection" type="text/css" />
		<title>
			Dokholyan Group - Administration
		</title>
	</head>
	<body>
	<?php include("head.html"); ?>
	<div class=container>
		<div align=right>
			<img src=images/publications.gif>
		</div>
		<div class=spacer5></div>
		<div class=spacer10></div>
		<!-- Center content div -->
		<form name=admin method=POST action="<?php echo $_SERVER['PHP_SELF'];?>">
		<div class=tabcontentdiv>
		<div class="tabs">
			<input type=button class=tabActive name=adm_main value="Main Page" onClick="toggleTabClass(this,this.form);submitForm(this.name,this.form)">
			<div class=spacer5></div>
			<input type=button class=tab name=adm_pubs value="Manage Publications" onclick="toggleTabClass(this,this.form);submitForm(this.name,this.form)">
			<div class=spacer5></div>
			<input type=button class=tab name=adm_events value="Manage Events" onclick="toggleTabClass(this,this.form);submitForm(this.name,this.form)">
			<div class=spacer5></div>
			<input type=button class=tab name=adm_users value="Manage Users" onclick="toggleTabClass(this,this.form);submitForm(this.name,this.form)">
			<div class=spacer5></div>
			<input type=button class=tab name=adm_members value="Manage Members" onclick="toggleTabClass(this,this.form);submitForm(this.name,this.form)">
		</div>
		</form>
		<?php include 'txt/userbar';?>
			<div class=spacer5></div>
		<div class=tabcontent>
			<div class=contentdiv>
			<?php
				if(sizeof($_POST)==0) {
					if(sizeof($_GET)==0) {
						$_POST['adm_main']=1;
					} else {
						list($index, $value) = each($_GET);
						$_POST[ $index] = 1;
					}
				}
				setSession();
				while(list($index, $value)=each($_POST)) 
				{ 
					echo "$index = $value <br>";
					$$index = $value; 
				}
				if(isset($_SESSION[ 'userok'])) {
					$uname = $_SESSION[ 'uname'];
						echo "<script type=text/javascript>showUserbar('$uname','ubar');</script>";
				}
				//if($page == "adm_main") {
				if(isset($_SESSION[ 'adm_main'])) {
					echo "<center><img src=\"http://dokhlab.unc.edu/images/W.gif\">elcome Administrator !</center>";
					include("txt/admin-main");
				} else {
					include 'accesscontrol.php';
					$uname = $_SESSION[ 'uname'];
					$uperm = explode(",",$_SESSION[ 'perms']);
					$noperm = false;
					foreach($uperm as $perm):
						$_SESSION[$perm]=1;
					endforeach;
					echo "<script type=text/javascript>showUserbar('$uname','ubar');</script>";
					echo "<center><img src=\"http://dokhlab.unc.edu/images/W.gif\">elcome ".$user." !</center>";
					//if($page == "adm_pubs") {
					if(isset($_SESSION[ 'adm_pubs'])) {
						if(isset($_SESSION[ 'pubs']) or isset($_SESSION[ 'all'])) {
							include 'txt/manage-pubs.php';
						} else {
							$noperm = true;
							include 'accesscontrol.php';
						}
					}
					//if($page == "adm_events") {
					if(isset($_SESSION[ 'adm_events'])) {
						if(isset($_SESSION[ 'events']) or isset($_SESSION[ 'all'])) {
							include 'txt/manage-events.php';
						} else {
							$noperm = true;
							include 'accesscontrol.php';
						}
					}
					//if($page == "adm_users") {
					if(isset($_SESSION[ 'adm_users'])) {
						if(isset($_SESSION[ 'users']) or isset($_SESSION[ 'all'])) {
							include 'txt/manage-users.php';
						} else {
							$noperm = true;
							include 'accesscontrol.php';
						}
					}
					//if($page == "adm_members") {
					if(isset($_SESSION[ 'adm_members'])) {
						if(isset($_SESSION[ 'members']) or isset($_SESSION[ 'all'])) {
							include 'txt/manage-members.php';
						} else {
							$noperm = true;
							include 'accesscontrol.php';
						}
					}
				}
			?>
			</div>
		</div>
		</div>
		<!-- Right col div -->
	<div class=cleardiv>&nbsp;</div>
		</div>
	</body>
</html>
