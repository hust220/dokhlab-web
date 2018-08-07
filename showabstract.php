<?php
	require_once 'functions.php';
	$publication = getAbstract($_GET[ 'code']);
?>
<html>
<head>
	<link rel=stylesheet type=text/css href=dokh.css>
</head>
<body>
<div style="margin: 20px 20px 0px 20px; border: 1px solid #BBBBBB; background-color: #EEEEEE; text-align: center; font-size: 16px; font-family: Geneva, arial, helvetica, sans-serif;">
<?php
	echo $publication[ 'title'];
?>
</div>
<div style="margin: 5px 25px 0px 25px; text-align: center; font-size: 12px; font-family: Geneva, arial, helvetica, sans-serif;">
<?php
	echo rtrim($publication[ 'authors'],", ");
?>
</div>
<div style="margin: 5px; padding: 15px; font-size: 13px; border: 1px solid #BBBBBB; scrollbar-base-color: #BBBBBB; text-align: justify; font-family: Geneva, arial, helvetica, sans-serif; width: 560px;">
<?php
	echo $publication[ 'abstract'];
?>
</div></div>
</body>
</html>
