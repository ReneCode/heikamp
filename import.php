<?php

//$fileName = $_GET["filename"];
require('db.php');
require('utility.php');



$fileName = strtolower($_FILES['csvfile']['name']);
$tmpFile = $_FILES['csvfile']['tmp_name'];

if ($tmpFile == "") {
	echo 'file missing';
	exit(0);
}

$whitelist = array('csv'); 
if(!in_array(end(explode('.', $fileName)), $whitelist))
{
    echo 'Invalid file type';
    exit(0);
}

if (is_uploaded_file($tmpFile)) {
	echo "<h2>importing file:" . $fileName . "</h2>";

	$hFile = fopen($tmpFile, "r");

	$nr = 0;
	$bCont = true;
	while ($bCont) {
		$nr++;
		$colLine = fgetcsv($hFile, 1000, ";");
		if ($colLine != NULL) {
			if ($nr == 1) {

			}
			else {
				echo "<br>" . $colLine[1];
			}
		}
		else {
			// finish
			$bCont = false;
		}
	}
	fclose($hFile);
}


$sQuery = $_GET["q"];

$pdo = dbOpen();


?>
