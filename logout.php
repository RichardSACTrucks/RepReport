<?php
// Initialize the session
session_start();
$dir = dirname($_SERVER['PHP_SELF']);

// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();

// clear cookie
unset($_COOKIE['sacmr']); 
setcookie('sacmr', null, -1, '/rep');

// Redirect to login page
header("location: $dir/index.php");
exit;
?>