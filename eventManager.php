<html>
	<head>
		<link rel=stylesheet href=dokh.css type=text/css>
		<link rel="stylesheet" href="lytebox.css" media="screen", type="text/css" />
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		
		<script language="Javascript" type=text/javascript src=pubs.js></script>
		<script language="Javascript" type="text/javascript" src=jetpack.js></script>
		<script type=text/javascript language=javascript src=lytebox.js></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
		<script type="text/javascript" src="dokhlab.jquery.js"></script>
		
		<style>
			.contentdiv ul { list-style-type: none; margin: 0; padding: 0; margin-bottom: 10px; }
			.contentdiv li { font-family: arial; font-size: 11pt; border: 1px dotted #AAAAAA; background: #DDDDDD; margin: 5px; padding: 5px; width: 150px; }
			a:link { font-family: arial; font-size: 12pt; text-decoration: none;  color: #333333; }
		</style>
		
		<title>
			Dokholyan Group - Events
		</title>
	</head>
	<body>
<?php
	include_once 'head.php';
	require_once 'db.php';
	require_once 'functions.php';
?>
<div class="container">
	<div class="contentdiv" style="width: 785px;">
		<div class="publist" style="width: 750px; padding: 5px 20px 5px 20px;">
		<div id='accordion'>
			<h3><a href='#'>Manage Group Meeting</a></h3>
			<div class="accordionContent">
				Drag names to change order
				<li id='newGmMem' class='ui-state-default'>Drag new</li>
				<ul id="gmSort">
					<li class="ui-state-default">Pradeep Kota</li>
					<li class="ui-state-default">Srinivas Ramachandran</li>
					<li class="ui-state-default">Elizabeth Proctor</li>
					<li class="ui-state-default">David Shirvanyants</li>
					<li class="ui-state-default">Lanette Fee</li>
					<li class="ui-state-default">Rachel Redler</li>
					<li class="ui-state-default">Feng Ding</li>
					<li class="ui-state-default">Onur Dagliyan</li>
					<li class="ui-state-default">Arpit Tandon</li>
				</ul>
				<div>
					Save Changes:
					<span id="gmtc" class="saveButton">This Cycle</span>
					<span id="gmp" class="saveButton">Permanent</span>
				</div>
			</div>
			<h3><a href='#'>Manage Journal Club</a></h3>
			<div id="accordionContent">
				Drag names to change order
				<ul id="jcSort">
					<li class="ui-state-default">Pradeep Kota</li>
					<li class="ui-state-default">Srinivas Ramachandran</li>
					<li class="ui-state-default">Elizabeth Proctor</li>
					<li class="ui-state-default">David Shirvanyants</li>
					<li class="ui-state-default">Lanette Fee</li>
					<li class="ui-state-default">Rachel Redler</li>
					<li class="ui-state-default">Feng Ding</li>
					<li class="ui-state-default">Onur Dagliyan</li>
					<li class="ui-state-default">Arpit Tandon</li>
				</ul>
				<div>
					Save Changes:
					<span id="jctc" class="saveButton">This Cycle</span>
					<span id="jcp" class="saveButton">Permanent</span>
				</div>
			</div>
		</div>
		</div>
		</div>
	</div>
</div>
