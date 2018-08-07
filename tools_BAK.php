<html>
	<head>
		<link rel=stylesheet href=dokh.css type=text/css>
		<script type=text/javascript src=pubs.js></script>
		<script type=text/javascript src=jetpack.js></script>
		<script type=text/javascript language=javascript src=lytebox.js></script>
		<link rel="stylesheet" href="lytebox.css" media="screen" type="text/css" />
		<title>
			Dokholyan Group - Tools
		</title>
	</head>
	<body>
<?php 
	include "head.php";
?>
	<div class=container>
		<div align=right style="margin-right:5px;">
			<!--<img src=images/tools.gif>-->
		</div>
		<div class=spacer5></div>
		<div class=spacer10></div>
		<div class=contentdiv style="width: 785px;">
			<div class=publist style="width: 750px; padding: 5px 20px 5px 20px;">
			<div class=spacer10></div>
			<!-- Tool 1 -->
			<img src=images/collapse.gif id=imgtopic1 style="cursor:pointer;" border=0 onclick="slide_topic1.slideIt();"> <strong>iFold</strong>
			<div id=divtopic1 style="margin: 5px; padding: 5px 10px 5px 10px; width=750px; border: 1px solid #BBBBBB; display: block;">
				<div>	 
					<p><a href="http://troll.med.unc.edu/ifold/index.php" target=_blank><img style="border: 1px dotted #AAAAAA; padding: 3px 3px 3px 3px;" src=images/iFold.jpg align=right width=225 height=150></a>iFold is a web portal for interactive protein folding/unfolding simulations. We perform discrete molecular dynamics simulations of proteins using coarse-grained structural models (two-beads/residue).</p>
					<p>The underlying approach, discrete molecular dynamics, is one of the fastest strategies for simulating protein dynamics, due, in part, to its efficient sampling of the vast conformation space of biomolecules in both length and time scales. iFold server supports simulations for protein folding, unfolding, thermodynamic scan, simulated annealing and p(fold) analysis.</p>
					<p></p>
					<p>Currently two-bead/residue Go model is available for protein simulations. Models for DNA and RNA are under development and will be added to iFold in due course. Please use the adjoining menu to register/login to the iFold server. To cite iFold in your research, please use the following reference:</p>
					<p></p>
					<p>S. Sharma, F. Ding, H. Nie, D. Watson, A. Unnithan, J. Lopp, D. Pozefsky, and N. V. Dokholyan, "iFold: A platform for interactive folding simulations of proteins" Bioinformatics, 22: 2693-2694 (2006).</p>
				</div>
			</div>
			<script type=text/javascript>
				var slide_topic1 = new animatedDiv('slide_topic1','divtopic1',500,'imgtopic1',true);
			</script>
			<!-- End of Tool 1 -->
			<div class=spacer10></div>
			<!-- Tool 2 -->
			<img src=images/collapse.gif id=imgtopic2 style="cursor:pointer;" border=0 onclick="slide_topic2.slideIt();"> <strong>iFoldRNA</strong>
			<div id=divtopic2 style="margin: 5px; padding: 5px 10px 5px 10px; width=750px; border: 1px solid #BBBBBB; display: block;">
				<div>	   
					<p><a href="http://troll.med.unc.edu/ifoldrna/index.php" target=_blank><img style="border: 1px dotted #AAAAAA; padding: 3px 3px 3px 3px;" src=images/iFoldRNA.jpg align=right width=225 height=150></a>iFoldRNA is a web portal for interactive RNA folding simulations. We perform discrete molecular dynamics simulations of RNA using coarse-grained structural models (two-beads/residue).</p>
					<p>To cite iFoldRNA in your research, please use the following references:</p>
					<p> A. Krokhotin, K. Houlihan, and N. V. Dokholyan, "iFoldRNA v2: folding RNA with constraints" Bioinformatics, 31: 2891-2893 (2015).</p>
					<p>S. Sharma, F. Ding, and N. V. Dokholyan, "iFoldRNA:Three-dimensional RNA structure prediction and folding" Bioinformatics, 24: 1951-1952 (2008).</p>
					<p>F. Ding, S. Sharma, P. Chalasani, V. V. Demidov, N. E. Broude, and N. V. Dokholyan, "Large scale simulations of 3D RNA folding by discrete molecular dynamics: From structure prediction to folding mechanisms" RNA, 14: 1164-1173 (2008).</p>
				</div>
			</div>
			<script type=text/javascript>
				var slide_topic2 = new animatedDiv('slide_topic2','divtopic2',500,'imgtopic2',true);
			</script>
			<!-- End of Tool 2 -->
			<div class=spacer10></div>
			<!-- Tool 3 -->
			<img src=images/collapse.gif id=imgtopic3 style="cursor:pointer;" border=0 onclick="slide_topic3.slideIt();"> <strong>Eris</strong>
			<div id=divtopic3 style="margin: 5px; padding: 5px 10px 5px 10px; width=750px; border: 1px solid #BBBBBB; display: block;">
				<div>	   
					<p><a href="http://troll.med.unc.edu/eris/index.php" target=_blank><img style="border: 1px dotted #AAAAAA; padding: 3px 3px 3px 3px;" src=images/Eris.jpg align=right width=225 height=150></a>Eris, which takes the name of Greek goddess of discord, is a protein stability prediction server. Eris server calculates the change of the protein stability induced by mutations (&Delta;&Delta;G) utilizing the recently developed Medusa modeling suite. In our test study, the &Delta;&Delta;G values of a large dataset (&gt;500) were calculated and compared with the experimental data and significant correlations are found. The correlation coefficients vary from 0.5 to 0.8. Eris also allows refinement of the protein structure when high-resolution structures are not available. Compared with many other stability prediction servers, our method is not specifically trained using protein stability data and should be valid for a wider range of proteins. Furthermore, Eris models backbone flexibility, which turns out to be crucial for &Delta;&Delta;G estimation of small-to-large mutations. More details are available in our publications:</p>
					<p>S. Yin, F. Ding, and N. V. Dokholyan, "Eris: an automated estimator of protein stability" Nature Methods 4, 466-467 (2007) </p>
					<p>S. Yin, F. Ding, and N. V. Dokholyan, "Modeling backbone flexibility improves protein stability estimation" Structure, 15: 1567-1576 (2007) </p>
				</div>
			</div>
			<script type=text/javascript>
				var slide_topic3 = new animatedDiv('slide_topic3','divtopic3',500,'imgtopic3',true);
			</script>
			<!-- End of Tool 3 -->
			<div class=spacer10></div>
			<!-- Tool 4 -->
			<img src=images/collapse.gif id=imgtopic4 style="cursor:pointer;" border=0 onclick="slide_topic4.slideIt();"> <strong>Chiron</strong>
			<div id=divtopic4 style="margin: 5px; padding: 5px 10px 5px 10px; width=750px; border: 1px solid #BBBBBB; display: block;">
				<div>	   
					<p><a href="http://troll.med.unc.edu/chiron/index.php" target=_blank><img style="border: 1px dotted #AAAAAA; padding: 3px 3px 3px 3px;" src="images/Chiron.jpg" align=right width=225 height=150></a>Named after the Thessalian god of healing, Chiron is a server that rapidly minimizes steric clashes in proteins using short discrete molecular dynamics(DMD) simulations. MD or DMD performed under physiological conditions with the structures having high clash energy would result in the protein rapidly unfolding. However, Chiron utilizes a high heat exchange rate of the solute (protein) with the bath in DMD simulations; thus rapidly quenching high velocities arising due to clashes. Using our simulation conditions and the inherent sampling power of DMD, Chiron employs an iterative protocol aimed at minimizing the given protein until it attains an 'acceptable clash score'. Chiron rapidly minimizes clashes while at the same time causing minimal perturbation of the protein backbone. The resulting protein structure has normalized clash score that is comparable to high-resolution protein structures (&lt;2.5 &Aring;).</p>
				</div>
			</div>
			<script type=text/javascript>
				var slide_topic4 = new animatedDiv('slide_topic4','divtopic4',500,'imgtopic4',true);
			</script>
			<!-- End of Tool 4 -->
			<div class=spacer10></div>
			<!-- Tool 5 -->
			<img src=images/collapse.gif id=imgtopic5 style="cursor:pointer;" border=0 onclick="slide_topic5.slideIt();"> <strong>Erebus</strong>
			<div id=divtopic5 style="margin: 5px; padding: 5px 10px 5px 10px; width=750px; border: 1px solid #BBBBBB; display: block;">
				<div>	   
					<p><a href="http://troll.med.unc.edu/erebus/index.php" target=_blank><img style="border: 1px dotted #AAAAAA; padding: 3px 3px 3px 3px;" src="images/Erebus.png" align=right width=225 height=150></a>Identifying the location of binding sites on proteins is of fundamental importance for a wide range of applications, including molecular docking, de novo drug design, structure identification, and comparison of functional sites. Here we present Erebus, a web-server that searches the entire Protein Data Bank for a given substructure defined by a set of atoms of interest, such as the binding scaffolds for small molecules. The identified substructure contains atoms having the same names, belonging to same amino acids, and separated by the same distances (within a given tolerance) as the atoms of the query structure. The accuracy of a match is measured by the root-mean-square deviation or by the normal weight with a given variance. Tests show that our approach can reliably locate rigid binding scaffolds of drugs and metal ions.</p>
				</div>
			</div>
			<script type=text/javascript>
				var slide_topic5 = new animatedDiv('slide_topic5','divtopic5',500,'imgtopic5',true);
			</script>
			<!-- End of Tool 5 -->
			<div class=spacer10></div>
			<!-- Tool 6 -->
			<img src=images/collapse.gif id=imgtopic6 style="cursor:pointer;" border=0 onclick="slide_topic6.slideIt();"> <strong>H-Predictor</strong>
			<div id=divtopic6 style="margin: 5px; padding: 5px 10px 5px 10px; width=750px; border: 1px solid #BBBBBB; display: block;">
				<div>	   
					<p><a href="http://troll.med.unc.edu/dokhlab/index.php/Special:Hpredictor" target=_blank><img style="border: 1px dotted #AAAAAA; padding: 3px 3px 3px 3px;" src=images/hpredictor.jpg align=right width=225 height=150></a>Hinge region predictor (H-Predictor) predicts putative hinge regions involved in protein oligomerization via the domain-swapping mechanism. Domain swapping is an important mechanism for protein oligomerization, in which a fragment of a protein exchanges with a corresponding fragment of another like protein. The segment of polypeptide chain that links the swapped domain and the main protein is the hinge region. In most experimentally observed domain-swapped oligomers, the swapped domains correspond to one or several secondary structural elements from either the N- or C-termini. Only in some rare instances the swapped domains are positioned in the middle of the protein. The domain-swapped oligomeric structures are, therefore, mainly determined by the location and the properties of the hinge region.</p>
					<p>Using a simple contact-based potential for enthalpy and graph theory- based estimation for entropy, H-Predictor quantifies for each residue the propensity as the hinge region. Physically, the H-Predictor computes for each residue the effective temperature to populate an &quot;intermediate&quot; state, where the protein unfolds around this residue into two sub-domains each of which maintains their native-like structure. Thus, the smaller the effective temperature, the higher the probability for a residue to be in the hinge-region. The proposed predictor is not a measure of the protein&quot;s propensity for domain-swapping, but rather a structural propensity that a hinge region may result in domain swapping. Additionally, if the protein features folding intermediate, the H-Predictor can also provide hint to the weakest regions that unfold prior to the compete unfolding.</p>
				       	<p>For details of the method, please refer to the paper: F. Ding, K. C. Prutzman, S. L. Campbell, and N. V. Dokholyan, Structure, 14: 5-14 (2006)</p>
		    </div>
		  </div>
			<script type=text/javascript>
				var slide_topic6 = new animatedDiv('slide_topic6','divtopic6',500,'imgtopic6',true);
			</script>
			<!-- End of Tool 6 -->
			<div class=spacer10></div>
		  <!-- Tool 7 -->
	    <img src=images/collapse.gif id=imgtopic7 style="cursor:pointer;" border=0 onclick="slide_topic7.slideIt();"> <strong>UniRapR</strong>
      <div id=divtopic7 style="margin: 5px; padding: 5px 10px 5px 10px; width=750px; border: 1px solid #BBBBBB; display: block;">
        <div>      
		      <p><a target=_blank><img style="border: 1px dotted #AAAAAA; padding: 3px 3px 3px 3px;" src=images/uniRapR.jpg align=right width=225 height=150></a>For many critical cellular behaviors, cell signaling is precisely controlled in seconds at submicron level. Testing hypotheses about such a rapid spatiotemporal dynamics in intact living cells demands robust, rapid and generic tools that allow controlling activity at posttranscriptional level. UniRapR (unimolecular rapamycin-regulated) protein was designed for this purpose and it acts as a protein switch controlled by binding of small molecule rapamycin. Insertion of uniRapR domain into the vicinity of active sites renders host proteins inactive, and addition of rapamycin or its analogues into the cell medium reactivates the host protein in minutes. By this way, the function of the host protein can be easily investigated at either single cell or whole organism level.</p>
		      <p>For details of the method, please refer to the paper: O. Dagliyan, D. Shirvanyants, A. V. Karginov, F. Ding, L. Fee, S. N. Chandrasekaran, C. M. Freisinger, G. A. Smolen, A. Huttenlocher, K. M. Hahn, N. V. Dokholyan "Rational design of a ligand-controlled protein conformational switch" Proc Natl Acad Sci U S A,110:6800-4 (2013) </p>
          <p>The DNA construct is available at <a href="https://www.addgene.org/45381"> Addgene</a>. </p>
					</div>
	    </div>
      <script type=text/javascript>
			    var slide_topic7 = new animatedDiv('slide_topic7','divtopic7',500,'imgtopic7',true);
	    </script>
	<!-- End of Tool 7 -->
			<div class=spacer10></div>
	   </div>
    </div>
	 </div>
	</body>
</html>
