<?php
$host = 'dedi1035.jnb1.host-h.net';
$dbdb = 'sacmajwetg_db3';
$dbun = 'sacmajwetg_3';
$dbpw = 'ydZ59eNnBF8';

$dbconn = new mysqli($host, $dbun, $dbpw, $dbdb);
if ($dbconn->connect_error) {
    die("Connection failed: " . $dbconn->connect_error);
}
?>