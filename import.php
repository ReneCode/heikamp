<!DOCTYPE html>
<html>
<head>
	<meta content="text/html"; charset="utf-8">
	<title>Import</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
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
//	move_uploaded_file($tmpFile, './tmp.csv');
//	$tmpFile = 'tmp.csv';
	echo "<h2>Importing file: $fileName </h2>";
	$dbo = dbOpen();

	$sql = "DELETE FROM tblobject";
	$cnt = $dbo->exec($sql);
	echo "<p>" . $cnt . " old rows deleted</p>";


	$hFile = fopen($tmpFile, 'r');
	$cnt = 0;
	if ($hFile != FALSE) {
		$bCont = true;
		$line = 0;
		$converted = 0;
		while ($bCont) {
			$data = fgetcsv($hFile, 10000, ";");
			if ($data == NULL) {
				$bCont = false;
			}			
			else {
				$line++;
				// ignore first line
				if ($line > 1) {

					// convert the strings to utf8 if they are not
					// http://stackoverflow.com/questions/21371208/ansi-encoded-file-converting-to-utf-8-encoded-file-with-php-script
					for ($i=0; $i<count($data); $i++) {
						if( !mb_check_encoding( $data[$i], 'UTF-8') ) {
							$data[$i] = utf8_encode($data[$i]);
							$converted++;
						}
					}

					dbInsertObjectRow($dbo, $data);
					$cnt++;
				}
			}
		}
	}
	echo "<p>$cnt new rows added to database. $converted strings converted.</p>";

	$currentDate = date('d.n.Y');
	echo "<p>set last change to: $currentDate<p>";
	dbSetOption($dbo, "lastchange", $currentDate);

	echo "<a href=\"list.php?q=nrw\">Liste anzeigen</a>";

}

?>
