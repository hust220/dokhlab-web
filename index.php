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
                    <a id=maintext href="images/members/dg2010S.jpg" rel="lytebox" title="Dokholyan Group 2014">
                        <img border=0 src=images/members/dg2010S.jpg>
                    </a>
                </center>
                <div>
                <div class=spacer10></div>

<!-- END COMMENT THE ADD-->
<!--                <div style="border: dashed 1px #666666; font-family: Courier; padding: 5px;">
                <strong><font size=3>Postdoctoral Positions</font></strong></br>
                <font size=2> Postdoctoral positions available in <a href=Ads/Ad_Postdoc_in_Pain_Research_2013>pain</a> and <a href=Ads/Ad_Postdoc_in_Neurodegeneration_2013.pdf>neurodegenerative</a> research areas.<br> 
                <a href=Ads/Ad_Software_Engineer_2013.pdf>Software engineer position</a> is available. <br>
                Please contact Professor Nikolay Dokholyan (dokh@unc.edu).</font>
                </div>-->
<!-- END COMMENT THE ADD-->

                <div style="border: dashed 1px #666666; font-family: Courier; padding: 5px;">
                <strong><font size=3>Postdoctoral Positions</font></strong></br>
                <font size=2>Postdoctoral position available in computational biophysics and drug discovery research. For details, please <a href=Ads/Ad_postdoc_computational_biophysics>click</a> here. 
                </div>
<!-- END COMMENT THE ADD-->


                <div class=spacer10></div>
                <font size=4>W</font>e are a computational and experimental biophysics group in the <a id=maintext href=http://med.unc.edu/biochem target=_blank>Department of Biochemistry and Biophysics</a> at the <a id=maintext href=http://www.unc.edu target=_blank>University of North Carolina</a>, Chapel Hill, <a id=maintext href=http://med.unc.edu/biochem target=_blank>School of Medicine</a>. 
                <div class=spacer10></div>
                <font size=4>O</font>ur laboratory focuses on understanding etiologies of human diseases, such as cystic fibrosis (CF), amyotrophic lateral sclerosis (ALS), and pain conditions, such as hyperalgesia. We have utilized several integrated computational and experimental strategies to <i>understand, sense (recognize and report), and control</i> aberrant biological molecules, and uncover etiologies of human diseases. We have developed approaches to molecular structural modeling and dynamic simulations, allowing study of structure and dynamics of biological molecules at time scales relevant to biological systems. These approaches uniquely integrate rapid physical dynamics simulations, experiments, and molecular modeling and design, allowing us to make significant breakthroughs in understanding etiologies of CF and ALS. Such integration allows us to perform translational research: from understanding molecular players at atomic level to probing their function at the cellular and organism level, as well as discovering molecular therapeutic strategies to affect these players.
                <div class=spacer10></div>
              <div style="width:80px; font-family: Geneva, arial, sans-serif; font-size: 12px;position:relative; margin: 5px 0px 0px 676px;"><a id=maintext href=research.php>Read More...</a></div>
        </div>
                <font size=4>O</font>ur group is affiliated with the following programs/centers:
                <div class=spacer10></div>
                <div class=fright>
                    <?php
                        echo '<div style="border: 1px solid #eee;" id="news-panel">';
                        echo '<span style="border-width: 1px 1px 1px 1px; border-style: solid; border-color: #666 #666 #666 #666; background: #ccc; font-size: 12px; padding: 1px 3px 1px 3px; margin-top: 10px; margin-right: 10px; float: right" ><strong>News</strong></span>';
                        echo '<div id="news-container" class="newsticker">';
                        echo '<ul id="ticker">';
                        $ticker = "";
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
                                                if(strlen($content)>400) {
                                                    $short_content = substr($content, 0, 300);
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
                <li>The North Carolina Translational and Clinical Sciences Institute</li>
                <li>Cystic Fibrosis and Pulmonary Research & Treatment Center</li>
                <li>Center for Neorosensory Disorders </li>
                <li>Division of Chemical Biology and Medicinal Chemistry, Eshelman School of Pharmacy</li>
                </ul>
                <!--<font size=4>O</font>ur present principal effort is directed towards understanding the nature of physical interactions between amino acids in proteins and the impact of these interactions on the chemical and biological properties of proteins and, at a higher level, cells and organisms.
                </div>-->
                <div class=cleardiv></div>
            </div>
    </div>
    </body>
</html>
