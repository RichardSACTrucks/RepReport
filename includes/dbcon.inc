<?php
$host = 'dedi1035.jnb1.host-h.net';
$dbdb = 'sacmajwetg_db3';
$dbun = 'sacmajwetg_3';
$dbpw = 'ydZ59eNnBF8';

$dbcon = mysqli_connect($host, $dbun, $dbpw, $dbdb);
if (!$dbcon) {
    die("Connection failed: " . mysqli_connect_error());
}

$dconn = new mysqli($host, $dbun, $dbpw, $dbdb);
if ($dconn->connect_error) {
    die("Connection failed: " . $dconn->connect_error);
}
?>