<?
/**
 * Process.php
 * 
 * The Process class is meant to simplify the task of processing
 * user submitted forms, redirecting the user to the correct
 * pages if errors are found, or if form is successful, either
 * way. Also handles the logout procedure.
 *
 */
include("session.php");
//while(list($k,$v)=each($_POST)) echo "$k = $v <br>";
class Process
{
	/* Class constructor */
	function Process(){
		global $session;
		/* User submitted login form */
		if(isset($_POST['sublogin'])){
			$this->procLogin();
		}
		/* User submitted registration form */
		else if(isset($_POST['subjoin'])){
			$this->procRegister();
		}
		/* User submitted forgot password form */
		else if(isset($_POST['subforgot'])){
			$this->procForgotPass();
		}
		/* User submitted edit account form */
		else if(isset($_POST['subedit'])){
			$this->procEditAccount();
		}
		else if(isset($_POST[ 'page'])) {
			$this->procShowPage();
		}
		else if(isset($_POST[ 'subremauth'])) {
			$this->procRemAuthor();
		}
		else if(isset($_POST[ 'subaddauth'])) {
			$this->procAddAuthor();
		}
		else if(isset($_POST[ 'subshowcal']) && $_POST[ 'subshowcal'] == 1) {
			$this->procShowCalendar();
		}
		else if(isset($_POST[ 'addevent'])) {
			$this->procAddEvent();
		}
		/**
		 * The only other reason user should be directed here
		 * is if he wants to logout, which means user is
		 * logged in currently.
		 */
		else if($session->logged_in){
			$this->procLogout();
		}
		/**
		 * Should not get here, which means user is viewing this page
		 * by mistake and therefore is redirected.
		 */
		else{
			header("Location: main.php");
		}
	}
	/**
	 * procLogin - Processes the user submitted login form, if errors
	 * are found, the user is redirected to correct the information,
	 * if not, the user is effectively logged in to the system.
	 */
	function procLogin(){
		global $session, $form;
		/* Login attempt */
		$retval = $session->login($_POST['user'], $_POST['pass'], isset($_POST['remember']));

		/* Login successful */
		if($retval){
			header("Location: ".$session->referrer."?page=".$session->page);
		}
		/* Login failed */
		else{
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			header("Location: ".$session->referrer);
		}
	}

	/**	
	 * procLogout - Simply attempts to log the user out of the system
	 * given that there is no logout form to process.
	 */
	function procLogout(){
		global $session;
		$retval = $session->logout();
		header("Location: main.php");
	}

	/**
	 * procRegister - Processes the user submitted registration form,
	 * if errors are found, the user is redirected to correct the
	 * information, if not, the user is effectively registered with
	 * the system and an email is (optionally) sent to the newly
	 * created user.
	 */
	function procRegister(){
		global $session, $form;
		/* Convert username to all lowercase (by option) */
		if(ALL_LOWERCASE){
			$_POST['user'] = strtolower($_POST['user']);
		}
		/* Registration attempt */
		$retval = $session->register($_POST['user'], $_POST['pass'], $_POST['email']);

		/* Registration Successful */
		if($retval == 0){
			$_SESSION['reguname'] = $_POST['user'];
			$_SESSION['regsuccess'] = true;
			header("Location: ".$session->referrer);
		}
		/* Error found with form */
		else if($retval == 1){
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			header("Location: ".$session->referrer);
		}
		/* Registration attempt failed */
		else if($retval == 2){
			$_SESSION['reguname'] = $_POST['user'];
			$_SESSION['regsuccess'] = false;
			header("Location: ".$session->referrer);
		}
	}

	/**
	 * procForgotPass - Validates the given username then if
	 * everything is fine, a new password is generated and
	 * emailed to the address the user gave on sign up.
	 */
	function procForgotPass(){
		global $database, $session, $mailer, $form;
		/* Username error checking */
		$subuser = $_POST['user'];
		$field = "user";  //Use field name for username
		if(!$subuser || strlen($subuser = trim($subuser)) == 0){
			$form->setError($field, "* Username not entered<br>");
		}
		else{
			/* Make sure username is in database */
			$subuser = stripslashes($subuser);
			if(strlen($subuser) < 5 || strlen($subuser) > 30 ||
				!eregi("^([0-9a-z])+$", $subuser) ||
				(!$database->usernameTaken($subuser))){
				$form->setError($field, "* Username does not exist<br>");
			}
		}

		/* Errors exist, have user correct them */
		if($form->num_errors > 0){
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
		}
		/* Generate new password and email it to user */
		else{
			/* Generate new password */
			$newpass = $session->generateRandStr(8);

			/* Get email of user */
			$usrinf = $database->getUserInfo($subuser);
			$email  = $usrinf['email'];

			/* Attempt to send the email with new password */
			if($mailer->sendNewPass($subuser,$email,$newpass)){
				/* Email sent, update database */
				$database->updateUserField($subuser, "password", md5($newpass));
				$_SESSION['forgotpass'] = true;
			}
			/* Email failure, do not change password */
			else{
				$_SESSION['forgotpass'] = false;
			}
		}

		header("Location: ".$session->referrer);
	}

	/**
	 * procEditAccount - Attempts to edit the user's account
	 * information, including the password, which must be verified
	 * before a change is made.
	 */
	function procEditAccount(){
		global $session, $form;
		/* Account edit attempt */
		$retval = $session->editAccount($_POST['curpass'], $_POST['newpass'], $_POST['email']);

		/* Account edit successful */
		if($retval){
			$_SESSION['useredit'] = true;
			header("Location: ".$session->referrer);
		}
		/* Error found with form */
		else{
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			header("Location: ".$session->referrer);
		}
	}

	/**
	 * procShowPage - Attempts to show the appropriate page
	 * based on the page index of the GET array
	 */
	function procShowPage() {
		global $session;
		$session->setPage($_POST[ 'page']);
		header("Location: ".$session->referrer."?page=".$_SESSION[ 'page']);
	}

	/**
	 * procAddAuthor - Attempts to add required fields for an
	 * author in the publication management page.
	 */
	function procAddAuthor() {
		global $session, $form;
		$_SESSION[ 'numauths']++;
#while(list($a,$b) = each($_POST)) { echo "$a = $b<br>"; }
		$_SESSION[ 'value_array'] = $_POST;
		$_SESSION[ 'error_array'] = $form->getErrorArray();
		header("Location: ".$session->referrer."?page=".$session->page);
	}

	/**
	 * procRemAuthor - Attempts to remove required fields for an
	 * author in the publication management page.
	 */
	function procRemAuthor() {
		global $session, $form;
		while(list($a,$b) = each($_POST)) {
			$pos = preg_match('/^auth/',$a);
			if($pos==1) {
				preg_match('/\d+/', $a, $m);
				if($m[0]>$_POST[ 'subremauth']) {
					$k = $m[0]-1;
					$_POST[ 'auth'.$k] = $_POST[ 'auth'.$m[0]];
					echo $_POST[ 'subremauth']." ".$_POST[ 'auth'.$k]." ".$_POST[ 'auth'.$m[0]]."<br>";
				}
			}
		}
		unset($_POST[ 'auth'.$_POST[ 'subremauth']]);
		$_SESSION[ 'numauths']--;
		//unset($_POST[ 'subaddauth']);
		//echo $_POST[ 'subaddauth'];
		$_SESSION[ 'value_array'] = $_POST;
		$_SESSION[ 'error_array'] = $form->getErrorArray();
		header("Location: ".$session->referrer."?page=".$session->page);
	}

	/** procShowCalendar - Attempts to show the calendar for a
	 *  chosen month and year to pick a date for an event
	 */
	function procShowCalendar() {
		global $session, $form;
		$_SESSION[ 'showmonth'] = $_POST[ 'showmonth'];
		$_SESSION[ 'showyear'] = $_POST[ 'showyear'];
		$_SESSION[ 'subshowcal'] = $_POST[ 'subshowcal'];
		$_SESSION[ 'value_array'] = $_POST;
		$_SESSION[ 'error_array'] = $form->getErrorArray();
		header("Location: ".$session->referrer."?page=".$session->page);
	}

	/** procAddEvent - Attempts to process data from the event form and
	 *  add an event to the events database
	 */
	function procAddEvent() {
		global $database, $session, $form;
		unset($_POST[ 'subshowcal']);
		//Initialize event details
		$edetails = array();
		//Set event id - typically this is the timestamp at which the event is registered
		$eid = time();
		$edetails[ 'eid'] = $eid;
		//Set event description - from the form
		$edetails[ 'edescription'] = $_POST[ 'edescription'];
		//Set event type - from form
		($_POST[ 'etype'] == "once") ? $edetails[ 'etype'] = "O" : $edetails[ 'etype'] = "R";
		//Set event frequency
		$edetails[ 'efrequency'] = $_POST[ 'pickfreq'];
		if($edetails[ 'etype'] == "O") $edetails[ 'efrequency'] = "Once";
		//Set event visibility - private or public event
		$edetails[ 'evisibility'] = $_POST[ 'evis'];
		//Set venue for the event
		($_POST[ 'pickvenue'] == "dummy") ? $edetails[ 'evenue'] = $_POST[ 'evenue'] : $edetails[ 'evenue'] = $_POST[ 'pickvenue'];
		//Set event start date
		@list($smm, $sdd, $syy) = explode("-", $_POST[ 'esdate']);
		$edetails[ 'estart_date'] = $syy.'-'.$smm.'-'.$sdd;
		//Set event end date
		($_POST[ 'eedate'] == "") ? $eedate = "12-31-2069" : $eedate = $_POST[ 'eedate'];
		@list($emm, $edd, $eyy) = explode("-", $eedate);
		$edetails[ 'eend_date'] = $eyy.'-'.$emm.'-'.$edd;
		//Set last occurrence of repeating events
		$edetails[ 'elast_occurrence'] = 0;
		//Set event start time
		($_POST[ 'sampm'] == "pm" && ($_POST[ 'shour']!=0 || $_POST[ 'shour']!=12)) ? $eshour = $_POST[ 'shour'] + 12 : $eshour = $_POST[ 'shour'];
		$edetails[ 'estart_time'] = $eshour.":".str_pad($_POST[ 'smin'], 2, "0", STR_PAD_LEFT).":00";
		//Set event end time
		($_POST[ 'eampm'] == "pm" && ($_POST[ 'ehour']!=0 || $_POST[ 'ehour']!=12)) ? $eehour = $_POST[ 'ehour'] + 12 : $eehour = $_POST[ 'ehour'];
		$edetails[ 'eend_time'] = $eehour.":".str_pad($_POST[ 'emin'], 2, "0", STR_PAD_LEFT).":00";
		//Set event notes
		$edetails[ 'enotes'] = $_POST[ 'enotes'];
		if($edetails[ 'enotes'] == "") $edetails[ 'enotes'] = "None";
		//Set event owner
		$edetails[ 'ecreated_by'] = $_POST[ 'eby'];
		var_dump($edetails);
		$database->addEvent($edetails);
	}
};

/* Initialize process */
$process = new Process;

?>
