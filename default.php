<?php
header('Content-Type: text/html; charset=utf-8');
$host = $_SERVER['HTTP_HOST'];
setlocale(LC_TIME, "de_DE.utf8");
date_default_timezone_set('Europe/Berlin');


$url = 'list.php';
header("Location: $url");

?>