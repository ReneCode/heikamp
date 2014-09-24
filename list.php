<!DOCTYPE html>
<html>
<head>
	<meta content="text/html"; charset="utf-8">
	<title>Objekt Liste</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="heikamp.js"></script>
</head>

<?php

require('db.php');
require('utility.php');

$sQuery = $_GET["q"];

$pdo = dbOpen();
$status = getDatabaseStatus($pdo);
?>

<body>
	<div id="all">
		<h2>Objektsuche</h2>
		<div id="status"><?php echo $status ?></div>
		<div id="search">
		<form action="list.php">
			<div>Suchbegriffe z.B.: <span class="example">K&ouml;ln Grundst&uuml;ck</span></div>
			<input class="txtsearch" placeholder="Suchbegriffe" type="text" value="<?php echo $sQuery ?>" name="q" />
			<input class="btnsearch" type="submit" value="Suche starten" />
		</form>
		</div>
		<div>
		 	<table>
			 	<thead>
			 		<td>Stadt</td>
			 		<td>PLZ</td>
			 		<td>Bundesland</td>
			 		<td>Strasse</td>
			 		<td>Objekttyp</td>
			 		<td>Gr&ouml;&szlig;e</td>
			 	</thead>
<?php


function printTable($stmt) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$nr++;
		$stadt = $row['stadt']; 
		$plz = $row['plz']; 
		$bundesland = $row['bundesland']; 
		$strasse = $row['strasse']; 
		$objekttyp = $row['type']; 
		$groesse = $row['groesse']; 
		print_r("<tr class=\"objrow\"><td>$stadt</td><td>$plz</td><td>$bundesland</td><td>$strasse</td><td>$objekttyp</td><td>$groesse</td></tr>");
	}
}

// split the query string
$aTmp = explode(" ", $sQuery);
$aQ = array();
for ($i=0; $i<count($aTmp); $i++) {
	if ($aTmp[$i] != "") {
		array_push($aQ, $aTmp[$i]);
	}
}

// query on all fields
// combine the query-strings with AND
$cntQuery = count($aQ);
if ($cntQuery > 0) {
	// show only, if there is at least one query-string
	if ($cntQuery == 1) {
		// only one query-string than 
		// 1. look for 'stadt'  
		// 2. look for the other fields (and stadt does not match)

		// where on 'stadt'
		$aFilter = array();
		$sql = "select * from tblobject WHERE ";
		$sql = $sql . "(stadt LIKE :q) ";
		$aFilter = array(":q" => "%" . $sQuery . "%");
		$sql = $sql . " order by stadt,plz,bundesland,strasse";
		$stmt = $pdo->prepare($sql);
		$stmt->execute($aFilter);
		printTable($stmt);

		// where in all other fields (and not 'stadt')	
		$aFilter = array();
		$sql = "select * from tblobject WHERE ";
		$sql = $sql . "(not stadt LIKE :q AND (plz like :q OR bundesland like :q OR strasse like :q OR type like :q OR groesse like :q)) ";
		$aFilter = array(":q" => "%" . $sQuery . "%");
		$sql = $sql . " order by stadt,plz,bundesland,strasse";
		$stmt = $pdo->prepare($sql);
		$stmt->execute($aFilter);
		printTable($stmt);
	}
	else {
		// if more than 1 query-string
		// than look on all fields
		$aFilter = array();
		$sql = "select * from tblobject WHERE ";
		for ($i=0; $i<count($aQ); $i++) {
			if ($i > 0) {
				$sql = $sql . "AND ";
			}
			$sql = $sql . "(stadt LIKE :q$i OR plz like :q$i OR bundesland like :q$i OR strasse like :q$i OR type like :q$i OR groesse like :q$i) ";
			$arr = array(":q$i" => "%" . $aQ[$i] . "%");
			$aFilter = array_merge($aFilter, $arr);
		}
		$sql = $sql . " order by stadt,plz,bundesland,strasse";
		$stmt = $pdo->prepare($sql);
		$stmt->execute($aFilter);
		printTable($stmt);
	}

}
?>
		 </table>
		</div>
	</div>
</body>

