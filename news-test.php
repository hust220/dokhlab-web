<html>
	<head>
		<link rel="stylesheet" href="dokh.css" type=text/css>
		<link rel="stylesheet" href="lytebox.css" media="screen" type="text/css" />
		<script type=text/javascript language=javascript src=lytebox.js></script>
		<script type=text/javascript language=javascript src=pubs.js></script>
		<script type="text/javascript" language="javascript" src="style/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" language="javascript" src="style/js/dokhlab-jquery.js"></script>
		<title>
			Dokholyan Group - Home
		</title>
	</head>
	<body>
<?php 
	include "head.php";
?>
	<div class=container>
		<div align=right style="margin-right:5px;">
			<img src=images/home.gif>
		</div>
		<div class=spacer5></div>
		<div class=spacer10></div>
		<div class=contentdiv style="width: 785px;">
			<div class=publist style="width: 750px; padding: 5px 20px 5px 20px;">
				<center>
					<a id=maintext href="images/members/dg2010L.jpg" rel="lytebox" title="Dokholyan Group 2010">
						<img border=0 src=images/members/dg2010S.jpg>
					</a>
				</center>
				<div>
				<font size=4>W</font>e are a computational and experimental biophysics group in the <a id=maintext href=http://med.unc.edu/biochem target=_blank>Department of Biochemistry and Biophysics</a> at the <a id=maintext href=http://www.unc.edu target=_blank>University of North Carolina</a>, Chapel Hill, <a id=maintext href=http://med.unc.edu/biochem target=_blank>School of Medicine</a>. Our group is affiliated with the following programs/centers.
				<div class=spacer10></div>
				<div class=fright>
					<?php
						echo '<div style="border: 1px solid #eee;" id="news-panel">';
						echo '<span style="border-width: 1px 1px 1px 1px; border-style: solid; border-color: #666 #666 #666 #666; background: #ccc; font-size: 12px; padding: 1px 3px 1px 3px; margin-top: 10px; margin-right: 10px; float: right" ><strong>News</strong></span>';
						echo '<div id="news-container" class="newsticker">';
						echo '<ul id="ticker">';
						if($dh = opendir('news')) {
							while (false !== ($file = readdir($dh))) {
								if(!is_dir($file)) {
									if($file != "00README") {
										$filehandle = fopen('news/'.$file,'r');
										fclose($filehandle);
										$fileArray = file('news/'.$file);
										$fileArray = array_values(array_filter($fileArray, "trim"));
										while($title=array_shift($fileArray)) {
											$content = array_shift($fileArray);
											if($title && $content) {
												$ticker .= '<li>';
												$ticker .= '<span align=left><strong>'.$title.'</strong></span>';
												if(strlen($content)>175) {
													$short_content = substr($content, 0, 175);
													$content = $short_content.' ... <a href="shownews.php?title='.$title.'&content='.$content.'" rel="lyteframe" title="News" rev="width: 630px; height: 400px; scrolling: yes;" id="maintext">(more)</a>';
												}
												$ticker .= '<a href="#">'.$content.'</a>';
												$ticker .= '</li>';
											}
										}
									}
								}
							}
						}
						closedir($dh);
						echo $ticker;
						echo '</ul>';
						echo '<div id="newscontroller"><img class="imgbtn" id="prev_news" src="images/prev.png">&nbsp;<img class="imgbtn" id="next_news" src="images/next.png"></div>';
						echo '</div>';
						echo '</div>';
					?>
				</div>
				<ul><li><a id=maintext href=http://hekto.med.unc.edu:8080 target=_blank>Program in Cellular and Molecular Biophysics</a></li>
				<li><a id=maintext href=http://genomics.unc.edu target=_blank>Carolina Center for Genome Sciences</a></li>
				<li><a id=maintext href=http://bcb.unc.edu target=_blank>Bioinformatics and Computational Biology Training Program</a></li>
				<li><a id=maintext href=http://neuroscience.unc.edu target=_blank>Neuroscience Center</a></li>
				<li><a id=maintext href=http://unclineberger.org target=_blank>Lineberger Comprehensive Cancer Center</a></li>
				<li>Center for Computational and Systems Biology</li>
				</ul>
				<font size=4>W</font>e study the physical nature of interactions between atoms, molecules, cells, and organisms. The underlying question throughout our research is how these interactions shape the complex organization, behavior, and evolution of biomolecules and organisms. To approach this question we have been studying structure, dynamics, function, and evolution of biological molecules. Such a broad approach is necessary to tie together the diverse pieces of knowledge of molecular properties and evolution that is to us.
				<div class=spacer10></div>
				<font size=4>O</font>ur present principal effort is directed towards understanding the nature of physical interactions between amino acids in proteins and the impact of these interactions on the chemical and biological properties of proteins and, at a higher level, cells and organisms.
				</div>
				<div class=cleardiv></div>
			</div>
					<div style="width:80px; font-family: Geneva, arial, sans-serif; font-size: 12px;position:relative; margin: 5px 0px 0px 722px;"><a id=maintext href=research.php>Read More...</a></div>
		</div>
	</div>
	</body>
</html>
