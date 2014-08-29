<?php

require_once('config.inc.php');

function dbOpen(){
    $dsn = 'mysql:dbname='.C_BASE.';host='.C_HOST;
    $dbh = new PDO($dsn, C_USER, C_PASS);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}



?>
