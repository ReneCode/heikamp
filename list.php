<!DOCTYPE html>
<html>
<header>
	<meta content="text/html; charset=utf-8">
	<title>Objekt Liste</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="heikamp.js"></script>
</header>

<?php

require('db.php');
require('utility.php');

$sQuery = $_GET["q"];

$pdo = dbOpen();
?>

<body>
	<h1>Objektsuche</h1>
	<div>
	<form action="list.php">
		<div><input class="search" type="text" value="<?php echo $sQuery ?>" name="q" />
		<div class="btn search"><input type="submit" value="Suche starten" />
	</form>
	</div>
	<div>
	 <table>
	 	<thead>
	 		<td>Nr.</td>
	 		<td>Stadt</td>
	 		<td>PLZ</td>
	 		<td>Bundesland</td>
	 		<td>Strasse</td>
	 		<td>Objekttyp</td>
	 		<td>Gr&ouml;&szlig;e</td>
	 	</thead>
	 	<?php

$aTmp = explode(" ", $sQuery);
$aQ = array();
for ($i=0; $i<count($aTmp); $i++) {
	if ($aTmp[$i] != "") {
		array_push($aQ, $aTmp[$i]);
	}
}

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
$nr = 0;
$stmt->execute($aFilter);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$nr++;
	$stadt = $row['stadt']; 
	$plz = $row['plz']; 
	$bundesland = $row['bundesland']; 
	$strasse = $row['strasse']; 
	$objekttyp = $row['type']; 
	$groesse = $row['groesse']; 

	print_r("<tr class=\"objrow\" onclick=\"onRowClick($nr);\"><td>$nr</td><td>$stadt</td><td>$plz</td><td>$bundesland</td><td>$strasse</td><td>$objekttyp</td><td>$groesse</td></tr>");
}


	 	?>
	 </table>
	</div>
</body>

