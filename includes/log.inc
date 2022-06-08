<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

if ( isset($_SESSION['sacmr']) ){
	$timenow = date('Y-m-d H:i:s');
	//$dir = dirname($_SERVER['PHP_SELF']);
	$dir = "/rep/";
	require_once "../globals/dbconn.inc";
		
	$timenow = date('Y-m-d H:i:s');
	$sourcip = $_SERVER['REMOTE_ADDR'];
	$root = $_SERVER['DOCUMENT_ROOT'];
	$url = $_SERVER['REQUEST_URI'];
	$srid = $_SESSION['sacmr'];

	$stmt = $dbconn->prepare("SELECT name,surname,branch,ucode,level FROM sacstaff WHERE id = ? LIMIT 1;");
	$stmt->bind_param("i", $srid);
	$srid = $dbconn-> real_escape_string($_SESSION['sacmr']);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	$userfname = $row['name'];
	$userlname = $row['surname'];
	$userbranch = $row['branch'];
	$usercode = $ucode = $row['ucode'];
	$userlevel = $row['level'];
	$stmt->close();

	$stmt = $dbconn->prepare("INSERT INTO uselog VALUES ('', ?, ?, NOW(), ?);");
	$stmt->bind_param("sss", $usercode,$url,$sourcip);
	$stmt->execute();
	$stmt->close();

	$proceed = 1;
}
else {
	$proceed = 0;
}



/* -> OLD
	$timenow = date('Y-m-d H:i:s');
	$sourcip = $_SERVER['REMOTE_ADDR'];
	$root = $_SERVER['DOCUMENT_ROOT'];
	$url = $_SERVER['REQUEST_URI'];
	$rid = $_SESSION['sacmbs'];
	$sql = "SELECT ucode,branch,level FROM sacstaff WHERE id = '$rid' LIMIT 1;";
	$qry = mysqli_query($dbcon,$sql);
	$row = mysqli_fetch_assoc($qry);
	$ucode = $row['ucode'];
	$userbranch = $row['branch'];
	$userlevel = $row['level'];
	if ( empty($function) ){
		$sql = "INSERT INTO uselog VALUES ('', '$ucode', '$url', '$timenow', '$sourcip');";
	}
	else {
		$sql = "INSERT INTO uselog VALUES ('', '$ucode', '$url', '$timenow', '$sourcip');";
	}
	mysqli_query($dbcon, $sql);
	$sql = "";
*/
?>