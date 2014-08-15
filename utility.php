<?php 



function getDatabaseStatus($pdo) {
	$sql = "select count(*) as cnt from tblobject";
	$stmt = $pdo->query($sql);
	$sCount = "";
	if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$sCount = $row['cnt']; 
	}
	$sLastChange = dbGetOption($pdo, "lastchange");

	return "Letzte Aktualisierung: " . $sLastChange[0] . " - " . $sCount . " Objekte.";
}


function dbGetOption($pdo, $name) {
	$sql = "select val from tbloption where name=:name order by val";
	$stmt = $pdo->prepare($sql);
	$stmt->execute( array(':name' => $name) );
	$arr = array();
	if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$val = $row['val']; 
		array_push($arr, $val);
	}
	return $arr;
}



function getHtmlOption($dbCon, $name, $currentValue = "") {
	$arr = dbGetOption($dbCon, $name);
	$result = "";
	$bSelected = false;
	foreach ($arr as $val) {
		$sel = "";
		if ($currentValue  &&  $currentValue != ""  &&  $currentValue == $val) {
			$sel = " selected";
			$bSelected = true;
		}
#		print_r("value:" . $val . $sel);
		$result = $result . sprintf("<option%s>%s</option>", $sel, $val);
	}
	if (!$bSelected) {
		$result = $result . sprintf("<option selected>Bitte auswählen</option>");
	}
	return $result;
}



?>