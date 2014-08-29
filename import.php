<?php

//$fileName = $_GET["filename"];
require('db.php');
require('utility.php');



$fileName = strtolower($_FILES['csvfile']['name']);
$tmpFile = $_FILES['csvfile']['tmp_name'];

if ($tmpFile == "") {
	echo 'File missing';
	exit(0);
}

$whitelist = array('csv'); 
if(!in_array(end(explode('.', $fileName)), $whitelist))
{
    echo 'Invalid file type';
    exit(0);
}

if (is_uploaded_file($tmpFile)) {
	echo "<h2>Importing file: $fileName </h2>";
	$dbo = dbOpen();
  
	$sql = "DELETE FROM tblobject";
	$cnt = $dbo->exec($sql) or die(print_r($dbo->errorInfo(), true));
	echo "<p>" . $cnt . " old rows deleted</p>";

	$sql = "LOAD DATA LOCAL INFILE '" . $tmpFile . "' INTO TABLE tblobject FIELDS TERMINATED BY ';' IGNORE 1 LINES";

	$cnt = $dbo->exec($sql) or die(print_r($dbo->errorInfo(), true));
	echo "<p>$cnt new rows added to database</p>";

	$currentDate = date('d.n.Y');
	echo "<p>set last change to: $currentDate<p>";
	dbSetOption($dbo, "lastchange", $currentDate);

	echo "<a href=\"list.php\">Liste anzeigen</a>";

}

?>
