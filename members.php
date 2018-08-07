<html>
	<head>
		<link rel=stylesheet href=dokh.css type=text/css>
		<script language="Javascript" type=text/javascript src=pubs.js></script>
		<script language="Javascript" type="text/javascript" src=jetpack.js></script>
		<script type=text/javascript language=javascript src=lytebox.js></script>
		<link rel="stylesheet" href="lytebox.css" media="screen", type="text/css" />
		<title>
			Dokholyan Group - Members
		</title>
	</head>
	<body>
	<?php
		include "head.php";
		//require "alldata.php";
		require_once 'db.php';
		require_once 'functions.2.php';
		getMembers();
		while(list($k,$v)=each($_POST)) {
		//  	echo "$k = $v<br>";
		}
		if(!isset($_POST['memid'])) {
			$_POST['memid']="0";
		}
		$imgprefix = "images/members";
	?>
	<div class=container>
		<div align=right style="margin-right:5px;">
			<img src='images/members.gif'>
		</div>
		<div class=spacer5></div>
		<div class=spacer10></div>
		<!-- Left buffer div -->
		<form name=pickmem method=POST action="<?php echo $_SERVER[ 'PHP_SELF']?>">
		<div class=rightcol>
		<div id=buffer></div>
		<div id=filter>
			Current Members
			<hr class=mainhr>
		<?php
			$cnt = 0;
			foreach($hascurr as $category=>$set):
		?>
		<div id=filterlist>
		<?php 
			if($set>1):
				(isset($_POST[ 'divid']) and $_POST[ 'divid']=="curr$cnt")?$imgsrc="images/collapse.gif":$imgsrc="images/expand.gif";
		?>
		<img id=currimg<?php echo $cnt?> src=<?php echo $imgsrc?> border=0 align=bottom onclick="slide_curr<?php echo $cnt?>.slideIt(); slide_curr<?php echo $cnt?>.hideRest();">
		<?php
			echo $category."s<br>";
			//echo "<div id='curr".$cnt."'><div class='slidediv'>";
			(isset($_POST[ 'divid']) and $_POST[ 'divid']=="curr$cnt")?$divdisp="block":$divdisp="none";
			echo "<div id='curr".$cnt."' style=\"display: $divdisp; width: 145px; border: 1px solid #BBBBBB;\"><div>";
			foreach($fullname as $memid=>$fname):
				if($current[$memid]=="yes" and $designation[$memid]==$category):
					echo "&nbsp;&nbsp;<a id='maintext' href=\"javascript:showMember('".$memid."','curr".$cnt."','pickmem');\">".$fname."</a><br>";
				endif;
			endforeach;
		?>
		</div></div>
		<script type="text/javascript">
			var slide_curr<?php echo $cnt?>=new animatedDiv('slide_curr<?php echo $cnt?>','curr<?php echo $cnt?>',500,'currimg<?php echo $cnt?>',true);
		</script>
		<?php
			$cnt++;
			else:
				$catid = getID($category, "yes");
				if($category=='Principal Investigator'):
					echo "<a id='maintext' href=\"javascript:showMember('".$catid."',null,'pickmem');\">".$category."</a><br>";
				else:
					echo "<a id='maintext' href=\"javascript:showMember('".$catid."',null,'pickmem');\">".$category."s</a><br>";
				endif;
			endif;
		?>
		</div>
	<?php 
		endforeach;
	?>
		<hr class=mainhr>
		Alumni
		<hr class=mainhr>
		<?php
			$cnt = 0;
			foreach($hasform as $category=>$set):
		?>
		<div id=filterlist>
		<?php if($set>1):
			(isset($_POST[ 'divid']) and $_POST[ 'divid']=="form$cnt")?$imgsrc="images/collapse.gif":$imgsrc="images/expand.gif";
		?>
		<img id=formimg<?php echo $cnt?> src=<?php echo $imgsrc?> border=0 align=bottom onclick="slide_form<?php echo $cnt?>.slideIt(); slide_form<?php echo $cnt?>.hideRest();">
		<?php
			echo $category."s<br>";
			(isset($_POST[ 'divid']) and $_POST[ 'divid']=="form$cnt")?$divdisp="block":$divdisp="none";
			echo "<div id='form".$cnt."' style=\"display: $divdisp; width: 145px; border: 1px solid #BBBBBB;\"><div>";
			//echo "<div id='form".$cnt."' class=slidediv><div>";
			foreach($fullname as $memid=>$fname):
				if($current[$memid]=="no" and $designation[$memid]==$category):
					echo "&nbsp;&nbsp;<a id='maintext' href=\"javascript:showMember('".$memid."','form".$cnt."','pickmem');\">".$fname."</a><br>";
				endif;
			endforeach;
		?>
		</div></div>
		<script type="text/javascript">
			//var slide_form<?php echo $cnt?>=new animatedcollapse("form<?php echo $cnt?>",500,true,"none");
			var slide_form<?php echo $cnt?> = new animatedDiv('slide_form<?php echo $cnt?>','form<?php echo $cnt?>',500,'formimg<?php echo $cnt?>',true);
		</script>
		<?php
			$cnt++;
			else:
				$catid = getID($category, "no");
				if($category=='Principal Investigator'):
					echo "<a id='maintext' href=\"javascript:showMember('".$catid."',null,'pickmem');\">".$category."</a><br>";
				else:
					echo "<a id='maintext' href=\"javascript:showMember('".$catid."',null,'pickmem');\">".$category."s</a><br>";
				endif;
			endif;
		?>
		</div>
	<?php 
		endforeach;
	?>
	</div>
</div>
</form>
<!-- Center content div -->
<div class=contentdiv>
<div class=spacer10></div>
<div class=spacer5></div>
<div class="memberdiv">
	<div id=buffer></div>
	<?php if(isset($_POST[ 'memid']) && $_POST[ 'memid']>0) {
		$mem = explode(" ",$fullname[$_POST['memid']]);
	?>
	<table border=0 class=text align=center cellpadding=2 cellspacing=4>
		<tr>
			<td colspan=3><div id=buffer50></td>
			<td width=140 rowspan=5 align=left>
			<?php
				$img = $imgprefix."/".$f_name[$_POST['memid']]."-".$l_name[$_POST['memid']].".jpg";
				$altimg = $imgprefix."/scidude.png";
				(file_exists($img))?$memimg = $img:$memimg = $altimg;
			?>
				<img width=135 height=197 src=<?php echo $memimg;?>>
			</td>
		</tr>
		<tr>
			<td align=right>Full Name</td>
			<td align=center>:</td>
			<td align=left width=175><b><?php echo $fullname[$_POST['memid']];?></b></td>
		</tr>
		<tr>
			<td align=right>Status</td>
			<td align=center>:</td>
			<td aligna=left width=175><b><?php echo $designation[$_POST['memid']]; ?></b></td>
		</tr>
		<tr>
			<td align=right>Tenure</td>
			<td align=center>:</td>
			<td align=left width=175><b><?php echo $tenure[$_POST['memid']]; ?></b></td>
		</tr>
		<? if(!is_null($email[$_POST['memid']])) { ?>
		<tr>
			<td align=right>E-mail</td>
			<td align=center>:</td>
			<td align=left width=175><b><?php echo $email[$_POST['memid']]; ?></b></td>
		</tr>
		<? if($_POST['memid'] == 1) { ?>
		<tr>
			<td align=right>Phone</td>
			<td align=center>:</td>
			<td align=left width=175><b>919-843-2513</b></td>
		</tr>
			
			<? } ?>
		<? } ?>
		<tr></tr>
		</td>
	</tr>
	<?php 
		$memname=$mem[0]."-".end($mem);
		if(file_exists("cv/$memname-cv.pdf")) {
	?>
	<tr>
	<td colspan=3 align=right></td><td width=140 align=center><div id=abstractbtn>[ <a id=maintext href="cv/<?php echo $memname ?>-cv.pdf">Curriculum Vitae</a> ]</div></td>
	</tr>
	<?php
	}
	?>
</table>
	<?php
		$meminfo = getMemInfo($_POST['memid']);
		if($meminfo['info']!="NA") {
			print '<div class=text style="padding-left:10px;"><b>About '.$mem[0].'</b></div>';
			print '<div class=publist align=center>';
			print $meminfo['info'];
			print '</div>';
		}
		if($meminfo['education']!="NA") {
			print '<div class=text style="padding-left:10px;"><b>Education</b></div>';
			print '<div class=publist align=center>';
			$education = explode("<br>",$meminfo['education']);
			print '<table class=text>';
			foreach($education as $e):
				if(preg_match('`^[0-9]`',$e)!==false) {
					$fields = explode(" ",$e);
					$eyear = $fields[0];
					array_shift($fields);
					$etype = implode(" ",$fields);
					print "<tr><td width=90>$eyear</td><td>$etype</td></tr>";
				}
			endforeach;
			print '</table>';
			print '</div>';
		}
		if($meminfo['awards']!="NA") {
			print '<div class=text style="padding-left:10px;"><b>Honors and Awards</b></div>';
			print '<div class=publist align=center>';
			$education = explode("<br>",$meminfo['awards']);
			print '<table class=text>';
			foreach($education as $e):
				if(preg_match('`^[0-9]`',$e)!==false) {
					$fields = explode(" ",$e);
					$eyear = $fields[0];
					array_shift($fields);
					$etype = implode(" ",$fields);
					print "<tr><td width=90>$eyear</td><td>$etype</td></tr>";
				}
			endforeach;
			print '</table>';
			print '</div>';
		}
	?>
		<?php
			if($has_publ[$_POST['memid']]=="yes") {
				//$pcnt = getMemPubs(($f_name[$_POST['memid']]).($l_name[$_POST['memid']]));
				//$pcnt = getMemPubs($l_name[$_POST['memid']].", ".$f_init);
				//$pcnt = getMemPubs($l_name[$_POST['memid']].", ".$f_name[$_POST['memid][0]]');
				$pcnt = getMemPubs($l_name[$_POST['memid']]);
		?>
		<div class=text style="padding-left:10px;"><b>List of Publications (<?php echo $pcnt?>)</b></div>
<div id=resart>
	<div class=publist align=center style="width:605px;">
	<?php

		if($_POST['memid']==1) {
			echo "Please see the publications page";
		} else {
			foreach($mempubs as $id=>$pub):
				echo $pub;
				echo "<div class=spacer5></div>";
				echo "<div>";
				echo "<div id=abstractbtn>[<a href=\"showabstract.php?code=".$id."\" rel=\"lyteframe\" title=\"Abstract\" rev=\"width: 630px; height: 400px; scrolling: yes;\" id=maintext>Abstract</a>]</div>";
				if(file_exists("papers/pdf/".$code[ $id].".pdf")) {
					echo "<div id=abstractbtn>[<a id=maintext href=papers/pdf/".$code[ $id].".pdf target=_blank>PDF</a>]</div>";
				}
				if($pmid[$id]!=0):
					echo "<div id=abstractbtn>[<a id=maintext href=http://ncbi.nlm.nih.gov/pubmed/".$pmid[ $id]." target=_blank>Pubmed</a>]</div>";
				endif;
				echo "</div>";
				echo "<div class=spacer10></div>";
				echo "<br>";
			endforeach;
		}
			}	
	} else {
	?>
	  	<table border=0 align=center>
		<tr><td><img src=images/members/DG2017-bw.jpg></td></tr>
		</table>
		<div id=buffer50></div>
</div>
</div>
<div class=spacer5>&nbsp;</div>
</div>
</div>
<?php }?>
<!-- Right col div -->
<div class=cleardiv>&nbsp;</div>
	</div>
</body>
</html>
