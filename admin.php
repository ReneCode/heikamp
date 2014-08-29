<!DOCTYPE html>
<html>
<head>
	<meta content="text/html; charset=utf-8">
	<title>Administration</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="heikamp.js"></script>
</head>

<?php

require('db.php');
require('utility.php');

$sQuery = $_GET["q"];


?>

<body>
	<div id="all">
		<h2>Administration</h2>
		<div id="status"><?php echo $status ?></div>
		<div id="search">
		<form method="POST" enctype="multipart/form-data" action="import.php">
			<div>Upload CSV-Datei</div>
			<input type="file" name="csvfile" id="filename">
			<input class="btn" type="submit" value="Upload" />
		</form>
		</div>
		<div>
		</div>
	</div>
</body>

