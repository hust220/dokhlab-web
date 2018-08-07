<?php // manage-events
	if(!isset($_SESSION[ 'showmonth'])) $_SESSION[ 'showmonth'] = date("n",time());
	if(!isset($_SESSION[ 'showyear'])) $_SESSION[ 'showyear'] = date("Y",time());
	include_once $_SERVER['DOCUMENT_ROOT'].'/site-admin/include/htmlElements.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/site-admin/include/datepicker.php';
	$curr_month = date("n",time());
?>
<p>Please use the form below to add, update or delete events.</p>
<form name="subnewevent" method=POST action="process.php">
<input type="hidden" name="subshowcal" value="0">
<input type="hidden" name="showmonth" value="">
<input type="hidden" name="showyear" value="">
<input type="hidden" name="sshow" value="">
<input type="hidden" name="eshow" value="">
<div class=spacer10></div>
<div class=admin-content>
<fieldset class=fset><legend align=left><img id=expevent src="../../images/expand.gif" onclick="if(document.getElementById('eventable').style.display=='none'){document.getElementById('eventable').style.display='block'; document.getElementById('expevent').src='../../images/collapse.gif';}else{document.getElementById('eventable').style.display='none';document.getElementById('expevent').src='../../images/expand.gif';}"> Add New Event</legend>
<table id="eventable" border=0  width=100% class=text cellpadding=3 align=center style="display:none;">
<tr>
	<td>
		<fieldset class=fset><legend>Short Description</legend>
		<?php
			echo '<input type="text" size=58 class="input-text" name="edescription" value="'.$form->value("edescription").'">';
		?>
		</fieldset>
	</td>
</tr>
<tr>
	<td>
		<fieldset class=fset><legend>Location</legend>
		<?php
			echo '<select name=pickvenue class=dropdown>';
				echo '<option value=dummy />Choose One...';
				echo '<option value=hsl '.(($form->value("pickvenue")=="hsl") ? 'selected = "yes"/>' : '/>').'HSL Rm. 527';
				echo '<option value=rm3007 '.(($form->value("pickvenue")=="rm3007") ? 'selected = "yes"/>' : '/>').'GM Rm. 3007';
				echo '<option value=rm3095 '.(($form->value("pickvenue")=="rm3095") ? 'selected = "yes"/>' : '/>').'GM Rm. 3095';
				echo '<option value=rm3081 '.(($form->value("pickvenue")=="rm3081") ? 'selected = "yes"/>' : '/>').'GM Rm. 3081';
			echo '</select>&nbsp;/';
			echo '<input type="text" class="keyword" name="evenue" value='.$form->value("venue").'> <font class=micro>(e.g. Nikolay\'s House)</font>';
		?>
		</fieldset>
	</td>
</tr>
<tr>
	<td>
		<fieldset class=fset><legend>Type</legend>
		<?php
			echo '<input type="radio" name="etype" value="once" onclick="repeatEvent(\'efreq\',\'once\');"'.(($form->value("etype")) ? 'checked="yes" />' : '/>').'Once ';
			echo '<input type="radio" name="etype" value="repeat" onclick="repeatEvent(\'efreq\',\'repeat\');"'.(($form->value("etype")) ? 'checked="yes" />' : '/>').'Repeating ';
			echo '<select id=efreq name=pickfreq class=dropdown '.(($form->value("type")=="repeat") ? 'style="display: inline;"' : 'style="display: none;"').'>';
				echo '<option value=daily '.(($form->value("pickfreq")=="daily") ? 'selected = "yes"/>' : '/>').'Daily';
				echo '<option value=weekly '.(($form->value("pickfreq")=="weekly") ? 'selected = "yes"/>' : '/>').'Weekly';
				echo '<option value=monthly '.(($form->value("pickfreq")=="monthly") ? 'selected = "yes"/>' : '/>').'Monthly';
				echo '<option value=yearly '.(($form->value("pickfreq")=="yearly") ? 'selected = "yes"/>' : '/>').'Yearly';
			echo '</select>';
		?>
		</fieldset>
	</td>
</tr>
<tr>
	<td>
		<fieldset class=fset><legend>Visibility</legend>
		<?php
			echo '<input type="radio" name="evis" value="public" onclick="visInfo(\'visinfo\',\'public\');"'.(($form->value("evis")) ? 'checked="yes" />' : '/>').'Public ';
			echo '<input type="radio" name="evis" value="private" onclick="visInfo(\'visinfo\',\'private\');"'.(($form->value("evis")) ? 'checked="yes" />' : '/>').'Private ';
			echo '<div id=visinfo class="micro" style="display: none;">&nbsp;&nbsp;(Login required for viewing)</div>';
		?>
		</fieldset>
	</td>
</tr>
<tr>
	<td>
		<fieldset class=fset><legend>Time</legend>
			Starts&nbsp;-
			<select name=shour class=select-box>
			<?php
				for($i=0;$i<=12;$i++) {
					$opt = new htmlElement('option');
					$opt->setAttribute('value',$i);
					if ($form->value("shour") == $i) $opt->setAttribute('selected','yes') ;
					$opt->showElement();
					echo str_pad($i, 2, "0", STR_PAD_LEFT);
				}
			echo '</select>';
			echo ':';
			echo '<select name=smin class=select-box>';
				for($i=0;$i<60;$i=$i+15) {
					$opt = new htmlElement('option');
					$opt->setAttribute('value',$i);
					if ($form->value("smin") == $i) $opt->setAttribute('selected','yes');
					$opt->showElement();
					echo str_pad($i, 2, "0", STR_PAD_LEFT);
				}
			echo '</select>';
			echo '<select name=sampm class=select-box>';
				$ampm = array('am','pm');
				foreach ($ampm as $m):
					$opt = new htmlElement('option');
					$opt->setAttribute('value',$m);
					if ($form->value("sampm") == $m) $opt->setAttribute('selected','yes');
					$opt->showElement();
					echo $m;
				endforeach;
			echo '</select>';
			echo '&nbsp;Ends&nbsp;-';
			echo '<select name=ehour class=select-box>';
				for($i=0;$i<=12;$i++) {
					$opt = new htmlElement('option');
					$opt->setAttribute('value',$i);
					if($form->value("ehour") == $i) $opt->setAttribute('selected','yes');
					$opt->showElement();
					echo str_pad($i, 2, "0", STR_PAD_LEFT);
				}
			echo '</select>';
			echo ':';
			echo '<select name=emin class=select-box>';
				for($i=0;$i<60;$i=$i+15) {
					$opt = new htmlElement('option');
					$opt->setAttribute('value',$i);
					if ($form->value("smin") == $i) $opt->setAttribute('selected','yes');
					$opt->showElement();
					echo str_pad($i, 2, "0", STR_PAD_LEFT);
				}
			echo '</select>';
			echo '<select name=eampm class=select-box>';
				foreach ($ampm as $m):
					$opt = new htmlElement('option');
					$opt->setAttribute('value',$m);
					if ($form->value("eampm") == $m) $opt->setAttribute('selected','yes');
					$opt->showElement();
					echo $m;
				endforeach;
			echo '</select>';
			?>
		</fieldset>
	</td>
</tr>
<tr>
	<td>
		<fieldset class=fset><legend>Date</legend>
			<div style="float:left; display: inline;">
			<?php
				echo 'Starts On&nbsp;<input size=10 class=input-text type=text name=esdate style="display: inline;" value="'.$form->value('esdate').'">';
			?>
				<img src="../../images/datepicker.png" style="cursor: pointer;" width=15 height=15 border=1 onmouseover="document.getElementById('sdate').style.display='block';document.getElementById('edate').style.display='none';">
			<?php
				echo 'and ends on&nbsp;<input size=10 class=input-text type=text name=eedate style="display: inline;" value="'.$form->value('eedate').'">';
			?>	
				<img src="../../images/datepicker.png" style="cursor: pointer;" width=15 height=15 border=1 onmouseover="document.getElementById('edate').style.display='block';document.getElementById('sdate').style.display='none';">
				<?php
					if(isset($_SESSION[ 'subshowcal'])) {
						$showhidecal = 'style="display: block;"';
						unset($_SESSION[ 'subshowcal']);
					} else {
						$showhidecal = 'style="display: none;"';
					}
				?>
				<div class=datepicker id="sdate" <? echo $showhidecal ?>>
				<?php initpicker($_SESSION[ 'showyear'], $_SESSION[ 'showmonth'], "es") ?>
					<div style="position: relative; width: 30px; padding-left: 3px; height: 14px; border: 1px solid #555555; background-color: #BBBBBB; margin: 0px 0px 0px 394px; cursor: pointer;" onclick="document.getElementById('sdate').style.display='none';"><font class=micro>Close</font></div>
					</div>
				<div class=datepicker id="edate" <? echo $showhidecal ?>>
				<?php initpicker($_SESSION[ 'showyear'], $_SESSION[ 'showmonth'], "ee") ?>
					<div style="position: relative; width: 30px; padding-left: 3px; height: 14px; border: 1px solid #555555; background-color: #BBBBBB; margin: 0px 0px 0px 394px; cursor: pointer;" onclick="document.getElementById('edate').style.display='none';"><font class=micro>Close</font></div>
					</div>
			</div>
		</fieldset>
	</td>
</tr>
<tr>
	<td>
		<fieldset class=fset><legend>Notes</legend>
		<?php
			echo '<textarea name=enotes rows=5 cols=60>'.$form->value("enotes").'</textarea>';
		?>
		</fieldset>
	</td>
</tr>
<tr>
	<td>
		<fieldset class=fset><legend>Signature<sup><font color=maroon>*</font></sup></legend>
		<?php
			echo '<input type="text" size=25 class="input-text" name="eby" value="'.$form->value("eby").'">';
		?>
		</fieldset>
	</td>
</tr>
<tr>
	<td align=center>
		<div class=spacer5></div>
		<input type=submit class=button name="addevent" value="Add Event">
	</td>
</tr>
</table>
</fieldset>
</div>
</form>
<?php
	//unset($_SESSION[ 'showmonth']);
	//unset($_SESSION[ 'showyear']);
?>

<form name="subeditevent" method=POST action="process.php">
<div class=spacer10></div>
<div class=admin-content>
<fieldset class=fset><legend align=left>Edit Existing Event</legend>
<table border=0  width=100% class=text cellpadding=3 align=center>
<tr>
	<td>
	</td>
</tr>
</table>
</fieldset>
<div class=micro >* required fields</div>
</div>
</form>
</div>
</div>

<!--<input type=hidden name=adm_users value=1>-->
</form>
<?php 
	if(isset($_SESSION['error'])) {
		showmsg($_SESSION['error']);
		unset($_SESSION[ 'error']);
	}
?>
