<html>
	<head>
		<script type=text/javascript src=pubs.js></script>
		<link rel=stylesheet href=dokh.old.css type=text/css>
		<script type=text/javascript language=javascript src=lytebox.old.js></script>
		<link rel="stylesheet" href="lytebox.old.css" media="screen" type="text/css" />
		<title>
			Dokholyan Group - Publications
		</title>
	</head>
	<body>
	<?php
		include("head.php");
		//require "alldata.php";
		require_once 'db.php';
		require_once 'functions.php';
		getMembers();
		getJournals();
		getTopics();
		while(list($k,$v)=each($_POST)){
		  //echo "$k = $v<br>";
		 }
	?>
	<div class=container>
		<div align=right style="margin-right:5px;">
			<img src=images/publications.gif>
		</div>
		<div class=spacer5></div>
		<div class=spacer10></div>
		<form name=search method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return validateForm(this)">
		<div class=searchbox align=center>
			Look for 
			<input type=text id=keyword class=keyword name=keyword> 
			in 
			<select name=category id=category class=dropdown>
				<option value="all">All
				<option value="authors">Authors
				<option value="title">Titles
				<option value="journal">Journals
				<option value="topic">Topics
			</select>
			<input type=submit class=button name=searchbtn value="Search">
			<input type=hidden name="searchres" value="search">
		</div>
		</form>
		<!-- Left buffer div -->
		<div class=rightcol>
		<div id=buffer></div>
		<div id=filter>
			Selected Filters
			<hr class=mainhr>
			<div id=filterlist>
		<form name=filter method="POST" action="<?php #echo $_SERVER["PHP_SELF"] ?>">
			<input type=hidden name=updateres value="update">
		<?php
			$authcnt=0;
			$jrnlcnt=0;
			$yearcnt=0;
			$topiccnt=0;
			$filterlist="";
			echo "<ul id=selected>\n";
			foreach ($fullname as $mid=>$fname):
				$filterlist.="sel_auth$mid,";
			endforeach;
			foreach ($jindex as $jidx=>$journal):
				$filterlist.="sel_jrnl$jidx,";
			endforeach;
			$jrnlcnt=0;
			foreach ($tindex as $tidx=>$topic):
				$filterlist.="sel_topic$tidx,";
			endforeach;
			$topiccnt=0;
			foreach ($years as $year=>$ycnt):
				$filterlist.="sel_year$yearcnt,";
				$yearcnt++;
			endforeach;
			$yearcnt=0;
			foreach ($fullname as $mid=>$fname):
				echo "<li id=\"sel_auth$mid\" style=\"display: none\"><img src=images/collapse.gif class=filterimg onclick=\"removeFilter('sel_auth$mid'); getFilters('".rtrim($filterlist,",")."','filter');\"> $fname</li>";
				//$authcnt++;
			endforeach;
			foreach ($jindex as $jidx=>$journal):
				echo "<li id=\"sel_jrnl$jidx\" style=\"display: none\"><img src=images/collapse.gif class=filterimg onclick=\"removeFilter('sel_jrnl$jidx'); getFilters('".rtrim($filterlist,",")."','filter');\"> $journal</li>";
			endforeach;
			foreach ($tindex as $tidx=>$topic):
				echo "<li id=\"sel_topic$tidx\" style=\"display: none\"><img src=images/collapse.gif class=filterimg onclick=\"removeFilter('sel_topic$tidx'); getFilters('".rtrim($filterlist,",")."','filter');\"> $topic</li>";
			endforeach;
			foreach ($years as $year=>$ycnt):
				echo "<li id=\"sel_year$yearcnt\" style=\"display: none\"><img src=images/collapse.gif class=filterimg onclick=\"removeFilter('sel_year$yearcnt'); getFilters('".rtrim($filterlist,",")."','filter');\"> $year</li>";
				$yearcnt++;
			endforeach;
			echo "</ul>\n";
			if(array_key_exists('updateres',$_POST) and trim($_POST["filters"])!="") {
				echo "<script type=\"text/javascript\">\n";
				echo "restoreFilters('".rtrim($_POST["filters"],",")."');\n";
				echo "</script>\n";
			}
		?>
		</div>
		</div>
		<div class=spacer10></div>
			<?php //echo "<input type=button name=updatebtn value=\"Update Results &raquo;\" class=button onclick=\"getFilters('".rtrim($filterlist,",")."')\">\n"; ?>
		<div id=filter>
			Available Filters
			<hr class=mainhr>
			<div id=filterlist>
				Authors
				<hr class=mainhr>
		<?php
			$dispcnt=0;
			$to_be_toggled="";
			$tmp = array();
			echo "<ul id=available>\n";
			foreach ($fullname as $mid=>$fname):
				if($has_publ[ $mid] == "yes"):
				  	$tmp[ $dispcnt] = $mid;
					  $pubcnt = getMemPubs($l_name[ $mid].", ".$f_init".");
					if ( $dispcnt<4 ){
						echo "<li id=\"avl_auth$mid\" style=\"display: block\"><img src=images/expand.gif class=filterimg onclick=\"addFilter('sel_auth$mid'); getFilters('".rtrim($filterlist,",")."','filter');\"> $fname ($pubcnt)</li>\n";
					} else {
						echo "<li id=\"avl_auth$mid\" style=\"display: none\"><img src=images/expand.gif class=filterimg onclick=\"addFilter('sel_auth$mid'); getFilters('".rtrim($filterlist,",")."','filter');\"> $fname ($pubcnt)</li>\n";
					}
					$dispcnt++;
				endif;
			endforeach;
			for($i=4;$i<count($tmp);$i++) {
				$to_be_toggled.="'avl_auth$tmp[$i]',";
			}
			echo "<div class=spacer5></div>\n";
			echo "<li id=\"avl_auth_more\" class=more style=\"display: block\" onclick=\"toggleDisplay($to_be_toggled'avl_auth_more','avl_auth_less')\">See more &raquo;</li>\n";
			echo "<li id=\"avl_auth_less\" class=less style=\"display: none\" onclick=\"toggleDisplay($to_be_toggled'avl_auth_less','avl_auth_more')\">&laquo; See less</li>\n";
			echo "</ul>\n";
		?>
		</div>
		<hr class=mainhr>
		<div id=filterlist>
			Journals
			<hr class=mainhr>
			<?php
				$dispcnt=0;
				$to_be_toggled="";
				echo "<ul id=available>\n";
				//foreach ($journals as $journal=>$jcnt):
				foreach ($jindex as $idx=>$journal):
					if ($dispcnt<4) {
						echo "<li id=\"avl_jrnl$dispcnt\" style=\"display: block\"><img src=images/expand.gif class=filterimg onclick=\"addFilter('sel_jrnl$dispcnt'); getFilters('".rtrim($filterlist,",")."','filter');\"> $journal ($journals[$journal])</li>\n";
					} else {
						echo "<li id=\"avl_jrnl$dispcnt\" style=\"display: none\"><img src=images/expand.gif class=filterimg onclick=\"addFilter('sel_jrnl$dispcnt'); getFilters('".rtrim($filterlist,",")."','filter');\"> $journal ($journals[$journal])</li>\n";
					}
					$dispcnt++;
				endforeach;
				for($i=4;$i<count($journals);$i++) {
					$to_be_toggled.="'avl_jrnl$i',";
				}
				echo "<div class=spacer5></div>";
				echo "<li id=\"avl_jrnl_more\" class=more style=\"display: block\" onclick=\"toggleDisplay($to_be_toggled'avl_jrnl_more','avl_jrnl_less')\">See more &raquo;</li>\n";
				echo "<li id=\"avl_jrnl_less\" class=less style=\"display: none\" onclick=\"toggleDisplay($to_be_toggled'avl_jrnl_less','avl_jrnl_more')\">&laquo; See less</li>\n";
				echo "</ul>\n";
			?>
			</div>
		<hr class=mainhr>
		<div id=filterlist>
				Topic
				<hr class=mainhr>
				<?php
					$dispcnt=0;
					$to_be_toggled="";
					echo "<ul id=available>\n";
					foreach ($tindex as $tidx=>$topic):
						if ($dispcnt<4) {
							echo "<li id=\"avl_topic$dispcnt\" style=\"display: block\"><img src=images/expand.gif class=filterimg onclick=\"addFilter('sel_topic$dispcnt'); getFilters('".rtrim($filterlist,",")."','filter');\"> $topic ($topics[$topic])</li>\n";
						} else {
							echo "<li id=\"avl_topic$dispcnt\" style=\"display: none\"><img src=images/expand.gif class=filterimg onclick=\"addFilter('sel_topic$dispcnt'); getFilters('".rtrim($filterlist,",")."','filter');\"> $topic ($topics[$topic])</li>\n";
						}
						$dispcnt++;
					endforeach;
					for($i=4;$i<count($topics);$i++) {
						$to_be_toggled.="'avl_topic$i',";
					}
					echo "<div class=spacer5></div>";
					echo "<li id=\"avl_topic_more\" class=more style=\"display: block\" onclick=\"toggleDisplay($to_be_toggled'avl_topic_more','avl_topic_less')\">See more &raquo;</li>\n";
					echo "<li id=\"avl_topic_less\" class=less style=\"display: none \" onclick=\"toggleDisplay($to_be_toggled'avl_topic_less','avl_topic_more')\">&laquo; See less</li>\n";
					echo "</ul>";
				?>
			</div>
		<hr class=mainhr>
		<div id=filterlist>
				Year
				<hr class=mainhr>
				<?php
					$dispcnt=0;
					$to_be_toggled="";
					getYears();
					echo "<ul id=available>\n";
					foreach ($years as $year=>$ycnt):
						if ($dispcnt<4) {
							echo "<li id=\"avl_year$dispcnt\" style=\"display: block\"><img src=images/expand.gif class=filterimg onclick=\"addFilter('sel_year$dispcnt'); getFilters('".rtrim($filterlist,",")."','filter');\"> $year ($ycnt)</li>\n";
						} else {
							echo "<li id=\"avl_year$dispcnt\" style=\"display: none\"><img src=images/expand.gif class=filterimg onclick=\"addFilter('sel_year$dispcnt'); getFilters('".rtrim($filterlist,",")."','filter');\"> $year ($ycnt)</li>\n";
						}
						$dispcnt++;
					endforeach;
					for($i=4;$i<count($years);$i++) {
						$to_be_toggled.="'avl_year$i',";
					}
					echo "<div class=spacer5></div>";
					echo "<li id=\"avl_year_more\" class=more style=\"display: block\" onclick=\"toggleDisplay($to_be_toggled'avl_year_more','avl_year_less')\">See more &raquo;</li>\n";
					echo "<li id=\"avl_year_less\" class=less style=\"display: none \" onclick=\"toggleDisplay($to_be_toggled'avl_year_less','avl_year_more')\">&laquo; See less</li>\n";
					echo "</ul>";
				?>
			</div>
			</form>
		</div>
	</div>
	</form>
		<!-- Center content div -->
		<div class=contentdiv>
			<?php
				if ( array_key_exists('searchres', $_POST) and ( trim($_POST["keyword"]) != "" ) ) {
					echo "You searched for \"<em>".$_POST["keyword"]."</em>\" in ".$_POST["category"];
				} elseif ( array_key_exists('updateres', $_POST) and ( trim($_POST["filters"]) != "" ) ) {
					$filters=rtrim($_POST["filters"],",");
				}
			?>
			<div class=pubtype>
				<a href="javascript:slide_resart.slideit()"><img id='expand_resart' src=images/collapse.gif border=0 align=bottom onclick="if (this.src.indexOf('collapse') > 0) {MM_swapImage('expand_resart','','images/expand.gif',1)} else {MM_swapImage('expand_resart','','images/collapse.gif',1)}"></a>
				RESEARCH ARTICLES
			</div>
			<div id=resart>
				<div class=publist>
					<?php
						if ( isset($_POST[ 'updateres']) and ( trim($_POST["filters"]) != "" ) ) {
							echo "<script type=\"text/javascript\">\n";
							echo "restoreSearch('".$_POST["duplss"]."','".$_POST["duplsc"]."');";
							echo "restoreFilters('".$_POST["filters"]."');";
							echo "</script>\n";
							updateSearch($_POST["filters"],$_POST["duplss"],$_POST["duplsc"]);
							if ( count($results[ 'articles']) == 0 ) {
								echo "No articles could be filtered";
							} else {
								foreach ($results[ 'articles'] as $pubid=>$article):
									echo $article;
									echo "<div class=spacer5></div>";
									echo "<div>";
									echo "<div id=abstractbtn>[<a href=\"showabstract.php?code=".$pubid."\" rel=\"lyteframe\" title=\"Abstract\" rev=\"width: 630px; height: 400px; scrolling: yes;\" id=maintext>Abstract</a>] </div>";
									if(file_exists("papers/pdf/".$results[ 'code'][$pubid].".pdf")) {
										echo "<div id=abstractbtn>[<a id=maintext href=papers/pdf/".$results[ 'code'][$pubid].".pdf target=_blank>PDF</a>] </div>";
									}
									if($results[ 'pmid'][$pubid]!=0) {
										echo "<div id=abstractbtn>[<a id=maintext href=http://www.ncbi.nlm.nih.gov/pubmed/".$results[ 'pmid'][ $pubid]." target=_blank>Pubmed</a>]</div>";
									}
									if($results[ 'cover'][$pubid]=="yes") {
										echo "<div id=abstractbtn>[<a id=maintext href=\"papers/images/".$results[ 'code'][$pubid].".jpg\" rel=\"lytebox\" title=\"Cover Image\">Cover</a>]</div>";
									}
									if($results[ 'suppinfo'][$pubid]=="yes") {
										echo "<div id=abstractbtn>[<a id=maintext href=\"papers/suppl/".$results[ 'code'][$pubid]."-SuppInfo.pdf\" target=_blank>Supporting Information</a>]</div>";
									}
									if($results[ 'f1000'][$pubid]=="yes") {
										echo "<div id=abstractbtn>[F1000 Evaulated]</div>";
									}
									
									echo "</div>";
									echo "<div class=spacer10></div>";
									echo "<br>";
								endforeach;
							}
						} elseif ( isset($_POST[ 'searchres']) and ( trim($_POST["keyword"]) != "" ) ) {
							echo "<script type=\"text/javascript\">\n";
							echo "restoreSearch('".$_POST["keyword"]."','".$_POST["category"]."');\n";
							echo "</script>\n";
							retrieveSearch($_POST["keyword"], $_POST["category"]);
							if ( count($results[ 'articles']) == 0 ) {
								echo "No research articles found<br>";
							} else {
								foreach ($results[ 'articles'] as $pubid=>$article):
									echo $article;
									echo "<div class=spacer5></div>";
									echo "<div>";
									echo "<div id=abstractbtn>[<a href=\"showabstract.php?code=".$pubid."\" rel=\"lyteframe\" title=\"Abstract\" rev=\"width: 630px; height: 400px; scrolling: yes;\" id=maintext>Abstract</a>] </div>";
									if(file_exists("papers/pdf/".$results[ 'code'][$pubid].".pdf")) {
										echo "<div id=abstractbtn>[<a id=maintext href=papers/pdf/".$results[ 'code'][$pubid].".pdf target=_blank>PDF</a>] </div>";
									}
									if($results[ 'pmid'][$pubid]!=0) {
										echo "<div id=abstractbtn>[<a id=maintext href=http://www.ncbi.nlm.nih.gov/pubmed/".$results[ 'pmid'][ $pubid]." target=_blank>Pubmed</a>]</div>";
									}
									if($results[ 'cover'][$pubid]=="yes") {
										echo "<div id=abstractbtn>[<a id=maintext href=\"papers/images/".$results[ 'code'][$pubid].".jpg\" rel=\"lytebox\" title=\"Cover Image\">Cover</a>]</div>";
									}
									if($results[ 'suppinfo'][$pubid]=="yes") {
										echo "<div id=abstractbtn>[<a id=maintext href=\"papers/suppl/".$results[ 'code'][$pubid]."-SuppInfo.pdf\" target=_blank>Supporting Information</a>]</div>";
									}
									if($results[ 'f1000'][$pubid]=="yes") {
										echo "<div id=abstractbtn>[F1000 evaluated]</div>";
									}
									echo "</div>";
									echo "<div class=spacer10></div>";
									echo "<br>";
								endforeach;
							}
						} else {
							foreach ($publications[ 'articles'] as $pubid=>$pub):
								echo "$pub";
								echo "<div class=spacer5></div>";
								echo "<div>";
								echo "<div id=abstractbtn>[<a href=\"showabstract.php?code=".$pubid."\" rel=\"lyteframe\" title=\"Abstract\" rev=\"width: 630px; height: 400px; scrolling: yes;\" id=maintext>Abstract</a>] </div>";
								if(file_exists("papers/pdf/".$publications[ 'code'][$pubid].".pdf")) {
									echo "<div id=abstractbtn>[<a id=maintext href=papers/pdf/".$publications[ 'code'][$pubid].".pdf target=_blank>PDF</a>] </div>";
								}
								if($publications[ 'pmid'][$pubid]!=0) {
									echo "<div id=abstractbtn>[<a id=maintext href=http://www.ncbi.nlm.nih.gov/pubmed/".$publications[ 'pmid'][ $pubid]." target=_blank>Pubmed</a>]</div>";
								}
								if($publications[ 'cover'][$pubid]=="yes") {
									echo "<div id=abstractbtn>[<a id=maintext href=\"papers/images/".$publications[ 'code'][$pubid].".jpg\" rel=\"lytebox\" title=\"Cover Image\">Cover</a>]</div>";
								}
								if($publications[ 'suppinfo'][$pubid]=="yes") {
									echo "<div id=abstractbtn>[<a id=maintext href=\"papers/suppl/".$publications[ 'code'][$pubid]."-SuppInfo.pdf\" target=_blank>Supporting Information</a>]</div>";
								}
									if($publications[ 'f1000'][$pubid]=="yes") {
										echo "<div id=abstractbtn>[F1000 evaluated]</div>";
									}
								echo "</div>";
								echo "<div class=spacer10></div>";
								echo "<br>";
							endforeach;
						}
					?>
				</div>
			</div>
			<script type="text/javascript">
				var slide_resart=new animatedcollapse("resart",500,false,"block");
			</script>
			<div class=spacer5>&nbsp;</div>
			<div class=pubtype>
				<a href="javascript:slide_bookch.slideit()"><img id='expand_bookch' src=images/collapse.gif border=0 align=bottom onclick="if (this.src.indexOf('collapse') > 0) {MM_swapImage('expand_bookch','','images/expand.gif',1)} else {MM_swapImage('expand_bookch','','images/collapse.gif',1)}"></a>
				BOOK CHAPTERS
			</div>
			<div id=bookch>
				<div class=publist>
					<?php
						if ( isset($_POST[ 'updateres']) and ( trim($_POST["filters"]) != "" ) ) {
							echo "<script type=\"text/javascript\">\n";
							echo "restoreSearch('".$_POST["duplss"]."','".$_POST["duplsc"]."');";
							echo "restoreFilters('".$_POST["filters"]."');";
							echo "</script>\n";
							updateSearch($_POST["filters"],$_POST["duplss"],$_POST["duplsc"]);
							if ( count($results[ 'books']) == 0 ) {
								echo "No book chapters could be filtered";
							} else {
								foreach ($results[ 'books'] as $pubid=>$article):
									echo $article;
									echo "<div class=spacer5></div>";
									echo "<div>";
									if(file_exists("papers/pdf/".$results[ 'code'][$pubid].".pdf")) {
										echo "<div id=abstractbtn>[<a id=maintext href=papers/pdf/".$results[ 'code'][$pubid].".pdf target=_blank>PDF</a>] </div>";
									}
									if($results[ 'pmid'][$pubid]!=0) {
										echo "<div id=abstractbtn>[<a id=maintext href=http://www.ncbi.nlm.nih.gov/pubmed/".$results[ 'pmid'][ $pubid]." target=_blank>Pubmed</a>]</div>";
									}
									echo "</div>";
									echo "<div class=spacer10></div>";
									echo "<br>";
								endforeach;
							}
						} elseif ( isset($_POST[ 'searchres']) and ( trim($_POST["keyword"]) != "" ) ) {
							echo "<script type=\"text/javascript\">\n";
							echo "restoreSearch('".$_POST["keyword"]."','".$_POST["category"]."');\n";
							echo "</script>\n";
							retrieveSearch($_POST["keyword"], $_POST["category"]);
							if ( count($results[ 'books']) == 0 ) {
								echo "No book chapters found<br>";
							} else {
								foreach ($results[ 'books'] as $pubid=>$article):
									echo $article;
									echo "<div class=spacer5></div>";
									echo "<div>";
									if(file_exists("papers/pdf/".$results[ 'code'][$pubid].".pdf")) {
										echo "<div id=abstractbtn>[<a id=maintext href=papers/pdf/".$results[ 'code'][$pubid].".pdf target=_blank>PDF</a>] </div>";
									}
									if($results[ 'pmid'][$pubid]!=0) {
										echo "<div id=abstractbtn>[<a id=maintext href=http://www.ncbi.nlm.nih.gov/pubmed/".$results[ 'pmid'][ $pubid]." target=_blank>Pubmed</a>]</div>";
									}
									echo "</div>";
									echo "<div class=spacer10></div>";
									echo "<br>";
								endforeach;
							}
						} else {
							foreach ($publications[ 'books'] as $pubid=>$pub):
								echo "$pub";
								echo "<div class=spacer5></div>";
								echo "<div>";
								if(file_exists("papers/pdf/".$publications[ 'code'][$pubid].".pdf")) {
									echo "<div id=abstractbtn>[<a id=maintext href=papers/pdf/".$publications[ 'code'][$pubid].".pdf target=_blank>PDF</a>] </div>";
								}
								if($publications[ 'pmid'][$pubid]!=0) {
									echo "<div id=abstractbtn>[<a id=maintext href=http://www.ncbi.nlm.nih.gov/pubmed/".$publications[ 'pmid'][ $pubid]." target=_blank>Pubmed</a>]</div>";
								}
								echo "</div>";
								echo "<div class=spacer10></div>";
								echo "<br>";
							endforeach;
						}
					?>
				</div>
			</div>
			<script type="text/javascript">
				var slide_bookch=new animatedcollapse("bookch",500,false,"block");
			</script>
			<div class=spacer5>&nbsp;</div>
			<div class=pubtype>
				<a href="javascript:slide_conpro.slideit()"><img id='expand_conpro' src=images/collapse.gif border=0 align=bottom onclick="if (this.src.indexOf('collapse') > 0) {MM_swapImage('expand_conpro','','images/expand.gif',1)} else {MM_swapImage('expand_conpro','','images/collapse.gif',1)}"></a>
				CONFERENCE PROCEEDINGS
			</div>
			<div id=conpro>
				<div class=publist>
					<?php
						if ( isset($_POST[ 'updateres']) and ( trim($_POST["filters"]) != "" ) ) {
							echo "<script type=\"text/javascript\">\n";
							echo "restoreSearch('".$_POST["duplss"]."','".$_POST["duplsc"]."');";
							echo "restoreFilters('".$_POST["filters"]."');";
							echo "</script>\n";
							updateSearch($_POST["filters"],$_POST["duplss"],$_POST["duplsc"]);
							if ( count($results[ 'confs']) == 0 ) {
								echo "No conference proceedings could be filtered";
							} else {
								foreach ($results[ 'confs'] as $pubid=>$article):
									echo $article;
									echo "<div class=spacer5></div>";
									echo "<div>";
									if(file_exists("papers/pdf/".$results[ 'code'][$pubid].".pdf")) {
										echo "<div id=abstractbtn>[<a id=maintext href=papers/pdf/".$results[ 'code'][$pubid].".pdf target=_blank>PDF</a>] </div>";
									}
									if($results[ 'pmid'][$pubid]!=0) {
										echo "<div id=abstractbtn>[<a id=maintext href=http://www.ncbi.nlm.nih.gov/pubmed/".$results[ 'pmid'][ $pubid]." target=_blank>Pubmed</a>]</div>";
									}
									echo "</div>";
									echo "<div class=spacer10></div>";
									echo "<br>";
								endforeach;
							}
						} elseif ( isset($_POST[ 'searchres']) and ( trim($_POST["keyword"]) != "" ) ) {
							echo "<script type=\"text/javascript\">\n";
							echo "restoreSearch('".$_POST["keyword"]."','".$_POST["category"]."');\n";
							echo "</script>\n";
							retrieveSearch($_POST["keyword"], $_POST["category"]);
							if ( count($results[ 'confs']) == 0 ) {
								echo "No conference proceedings found<br>";
							} else {
								foreach ($results[ 'confs'] as $pubid=>$article):
									echo $article;
									echo "<div class=spacer5></div>";
									echo "<div>";
									if(file_exists("papers/pdf/".$results[ 'code'][$pubid].".pdf")) {
										echo "<div id=abstractbtn>[<a id=maintext href=papers/pdf/".$results[ 'code'][$pubid].".pdf target=_blank>PDF</a>] </div>";
									}
									if($results[ 'pmid'][$pubid]!=0) {
										echo "<div id=abstractbtn>[<a id=maintext href=http://www.ncbi.nlm.nih.gov/pubmed/".$results[ 'pmid'][ $pubid]." target=_blank>Pubmed</a>]</div>";
									}
									echo "</div>";
									echo "<div class=spacer10></div>";
									echo "<br>";
								endforeach;
							}
						} else {
							foreach ($publications[ 'confs'] as $pubid=>$pub):
								echo "$pub";
								echo "<div class=spacer5></div>";
								echo "<div>";
								if(file_exists("papers/pdf/".$publications[ 'code'][$pubid].".pdf")) {
									echo "<div id=abstractbtn>[<a id=maintext href=papers/pdf/".$publications[ 'code'][$pubid].".pdf target=_blank>PDF</a>] </div>";
								}
								if($publications[ 'pmid'][$pubid]!=0) {
									echo "<div id=abstractbtn>[<a id=maintext href=http://www.ncbi.nlm.nih.gov/pubmed/".$publications[ 'pmid'][ $pubid]." target=_blank>Pubmed</a>]</div>";
								}
								echo "</div>";
								echo "<div class=spacer10></div>";
								echo "<br>";
							endforeach;
						}
					?>
				</div>
			</div>
			<script type="text/javascript">
				var slide_conpro=new animatedcollapse("conpro",500,false,"block");
			</script>
			<?php
			  if (count($results[ 'articles'])==0 and count($results[ 'books'])==0 and count($results[ 'confs'])==0 ) {
				//echo "<em>Suggestion: Since the search function is coarse, you may want to try the filters to get what you are looking for.</em>";
			}
			?>
		</div>
		<!-- Right col div -->
	<div class=cleardiv>&nbsp;</div>
		</div>
		<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
		<script type="text/javascript">
			_uacct = "UA-322570-1";
			urchinTracker();
		</script>

	</body>
</html>
