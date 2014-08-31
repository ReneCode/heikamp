<!DOCTYPE html>
<html>
<head>
	<meta content="text/html; charset=utf-8">
	<title>Administration</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="heikamp.js"></script>
</head>

<body>
	<div id="all">
		<h2>Administration / Upload CSV-Datei</h2>
		<div>Die CSV-Datei muss diese Felder beinhalten: </div>
		<code>	Stadt;PLZ;Bundesland;Strasse;Objekttyp;Gr&ouml;&szlig;e. </code>
		<div>Die erste Zeile (header) wird nicht importiert</div>

		<div id="search">
		<form method="POST" enctype="multipart/form-data" action="import.php">
			<input type="file" name="csvfile" id="filename">
			<input class="btn" type="submit" value="Upload" />
		</form>
		</div>
		<div>
		</div>
	</div>
</body>
