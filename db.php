<?php


function dbOpen() {

	$host = 'localhost';
	$user = 'heikamp';
	$pw = 'heikamp';
	$database = 'heikamp';

	//$dbCon = mysql_connect($host, $user, $pw) or die ("Error connecting to db-server");

	//mysql_select_db($database);

	$pdo = new PDO("mysql:host=$host;dbname=$database;charset=UFT-8", 
							$user, $pw);

	return $pdo;	
}




?>
