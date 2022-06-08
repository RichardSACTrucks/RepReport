<?php
session_start();
/*
function error_mailer($number, $message, $file, $line){
    $erremail = "
        <p>An error ($number) occurred on line 
        <strong>$line</strong> and in the <strong>file: $file.</strong> 
        <p> $message </p>";
	
	//$allvars = print_r(var_dump($GLOBALS),1);

   // $erremail .= "<pre>" . htmlspecialchars($allvars) . "</pre>";
     
    $errheaders = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
     
    // Email the error to someone...
    error_log($erremail, 1, 'dev@sactrucks.co.za', $errheaders);
 
    // Make sure that you decide how to respond to errors (on the user's side)
    // Either echo an error message, or kill the entire project. Up to you...
    // The code below ensures that we only "die" if the error was more than
    // just a NOTICE.
    //if ( ($number !== E_NOTICE) && ($number < 2048) ) {
    //    die("There was an error. Please try again later.");
    //}
}
set_error_handler('error_mailer');
ini_set('memory_limit', '1024M');
//*/

if ( $rucode === "rr001" ){
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
}
//*/

$dir = dirname($_SERVER['PHP_SELF']);
include '../../globals/dbcon.inc';
$srid = $_SESSION['sacmr'];
$stmt = $dbcon->prepare("SELECT name,branch FROM sacstaff WHERE id = ? LIMIT 1;");
$stmt->bind_param("i",$srid);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$repnam = $row['name'];
$branch = $row['branch'];
$stmt->close();

if ( empty($branch) ){
    $_SESSION = array();
    session_destroy();
    header("location: $dir/index.php");
    exit;
}
else if ( isset($_GET['reload']) && $_GET['reload'] == 1 ){
	$msg = mysqli_real_escape_string($dbcon,$_GET['message']);
	header("location: $dir/home.php?status=1&message=$msg");
}
else {
	if ( isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
		/* * DEV MAIL * /
			$postreceived = null;
			foreach ($_POST as $key => $value){
				$postreceived .= "<b>$key : </b>".mysqli_real_escape_string($dbcon,$value)."<br>";
			}
			$tomail = 'dev@sactrucks.co.za';
			$header = "MIME-Version: 1.0"."\r\n";
			$header.= "Content-type: text/html; charset=UTF-8"."\r\n";
			$header.= "From: SAC Rep App (no-reply@sacmarketing.co.za)"."\r\n";
			$subjct = "New Rep Visit Logged";
			$contnt = '
			<html>
			<head>
			<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<style>
				@import url(https://fonts.googleapis.com/css?family=Open+Sans);
				* {font-family: Tahoma,serif !important;}
				#mbody {background-color:#ffffff;text-align:left;height:auto;color:#000000;max-width:600px !important;width:600px !important;margin:0;font-family:Tahoma,serif !important;font-size:16px;}
				.button{
					font-family: Tahoma,serif !important;font-weight:bold !important;font-size:12px !important;
					text-decoration: none;color: #ffffff !important;line-height:38px;text-transform: uppercase;text-align: center;
					display:inline-block;background-color: #cb1a1f;border-radius: 4px;
					padding: 2px;padding-bottom:14px;width: 200px !important;height: 15px !important;
					-webkit-text-size-adjust:none;
				}
				.button a:link {color: #FFFFFF !important;}
				.button a:visited, .button a:hover, .button a:active {color: #FFFFFF !important;}
			</style>
			</head>
			<body id="mbody">
				<p>'.$postreceived.'</p>
			</body>
			</html>
			';
			mail($tomail, $subjct, $contnt, $header);
			$tomail = $header = $subjct = $contnt = null;
		/** end DEV MAIL */

		$cmpyid = mysqli_real_escape_string($dbcon,$_POST['cmpyid']); // id of company on clients_main
		$branch = mysqli_real_escape_string($dbcon,$_POST['branch']); // branch of rep
		$rucode = mysqli_real_escape_string($dbcon,$_POST['rucode']); // ucode of rep
		$compny = strtoupper(mysqli_real_escape_string($dbcon,$_POST['compni'])); // company name
		$pstree = strtoupper(mysqli_real_escape_string($dbcon,$_POST['pstree'])); // company's physical street address
		$ptownl = strtoupper(mysqli_real_escape_string($dbcon,$_POST['ptownl'])); // company's town
		$provin = strtoupper(mysqli_real_escape_string($dbcon,$_POST['provin'])); // company's province
		//$hubreg = strtoupper(mysqli_real_escape_string($dbcon,$_POST['hubreg'])); // hub region
		$hubare = strtoupper(mysqli_real_escape_string($dbcon,$_POST['hubare'])); // hub area
		$rating = mysqli_real_escape_string($dbcon,$_POST['rating']); // rating of clients possible purchase and record
		$contid = strtoupper(mysqli_real_escape_string($dbcon,$_POST['contac'])); // contact spoke with id

		if (!($stmt = $dbcon->prepare("SELECT contact_name FROM clients_contacts WHERE id = ?;"))){
			$msg.= "Prepare failed: (" . $dbcon->errno . ") " . $dbcon->error.'<br>Contact:'.$contid;
		}
		if (!($stmt->bind_param("i",$contac))){
			$msg.= "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error.'<br>Contact:'.$contid;
		}
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$ctcnam = $row['contact_name'];
		$stmt->close();
		
		if ( !isset($cmpyid) || empty($cmpyid) ){
			$sql = "SELECT id FROM clients_main WHERE company_name=? AND physical_street=? AND physical_town=? AND assigned_branch=? ORDER BY id ASC LIMIT 1;";
			$qry = $dbcon ->prepare($sql);
			$qry ->bind_param("ssss",$compny,$pstree,$ptownl,$branch);
			$qry ->execute();
			$res = $qry ->get_result();
			if ( $res ->num_rows > 0 ){
				$row = $res->fetch_assoc();
				$cmpyid = $row['id'];
				$doexist = 1;
				}
			else {
				$doexist = 0;
				}
			$qry->close();
		}
		
		if ( $doexist === 1 ){
			$sql = "SELECT time_visited FROM clients_repvisits WHERE branch=? AND ucode=? AND contact_name=? ORDER BY id DESC LIMIT 1;";
			$qry = $dbcon ->prepare($sql);
			$qry ->bind_param("sss",$branch,$rucode,$ctcnam);
			$qry ->execute();
			$res = $qry ->get_result();
			if ( $res ->num_rows > 0 ){
				$row = $res->fetch_assoc();
				$prevvisit = $row['time_visited'];
				/////if previs and current time less than x, exit to home
				$prevvisit = strtotime($prevvisit);
                $timenow = strtotime(date("Y-m-d H:i:s"));
                $diff = $timenow - $prevvisit;
				if ( $diff >= 300 ){
					$continuelog = 1;
					}
				else {
					$continuelog = 0;
					}
				}
			else {
				$continuelog = 1;
				}
			$qry->close();
		}
		else {
			$continuelog = 1;
		}

		if ( $continuelog === 1 ){
			$positn = mysqli_real_escape_string($dbcon,$_POST['positn']); // contac's position
			$nconta = strtoupper(mysqli_real_escape_string($dbcon,$_POST['newcontac'])); //new contact if new
			$cellnr = strtoupper(mysqli_real_escape_string($dbcon,$_POST['cellnr'])); // contacts cell
			$cemail = strtoupper(mysqli_real_escape_string($dbcon,$_POST['cemail'])); // contacts email
			//$infofo = mysqli_real_escape_string($dbcon,$_POST['infofo']); // communication method
			$infow = mysqli_real_escape_string($dbcon,$_POST['infow']); // whatsapp communication method
			$infos = mysqli_real_escape_string($dbcon,$_POST['infos']); // sms communication method
			$infoe = mysqli_real_escape_string($dbcon,$_POST['infoe']); // email communication method
			$infon = mysqli_real_escape_string($dbcon,$_POST['infon']); // no communication method
			if ( $infow == "W" && $infos == "S" && $infoe == "E" ){ $infofo = "W,S,E"; }
			else if ( $infow == "W" && $infos == "S" ){ $infofo = "W,S"; }
			else if ( $infow == "W" && $infos == "E" ){ $infofo = "W,E"; }
			else if ( $infos == "S" && $infoe == "E" ){ $infofo = "S,E"; }
			else if ( $infow == "E" ){ $infofo = "W"; }
			else if ( $infos == "S" ){ $infofo = "S"; }
			else if ( $infoe == "E" ){ $infofo = "E"; }
			else if ( $infon == "NONE" ){ $infofo = "NONE"; }	

			$settomaincoords = mysqli_real_escape_string($dbcon,$_POST['tomaincoords']); // set visit coords to main coords
			if ( $settomaincoords == "yes" ){
				$stmt = $dbcon->prepare("SELECT physical_latitude,physical_longitude FROM clients_main WHERE id = ? LIMIT 1;");
				$stmt->bind_param("i", $cmpyid);
				$stmt->execute();
				$result = $stmt->get_result();
				$row0 = $result->fetch_assoc();
				$replat = $row0['physical_latitude'];
				$replon = $row0['physical_longitude'];
				//echo "cpy: $cmpyid<br>lat: $replat<br>lon: $replon";
				$stmt->close();
			}
			else {
				$replat = strtoupper(mysqli_real_escape_string($dbcon,$_POST['replat'])); $replat = substr($replat, 0, 10);
				$replon = strtoupper(mysqli_real_escape_string($dbcon,$_POST['replon'])); $replon = substr($replon, 0, 9);

				if ( $_POST['newcpyloc'] == "yes" ){
					$stmt = $dbcon->prepare("UPDATE clients_main SET physical_latitude = ?, physical_longitude = ? WHERE id = ?;");
					$stmt->bind_param("ddi", $replat,$replon,$cmpyid);
					$stmt->execute();
					$stmt->close();
				}
			}

			$quoter = $_POST['quoter'];
			if ( isset($quoter) && $quoter == "yes" ){
				$quoter = "1";$mailsalesman = 1;
				$partsn = trim(nl2br(mysqli_real_escape_string($dbcon,$_POST['partsn']))); // quotes parts request
				$vinnrs = trim(mysqli_real_escape_string($dbcon,$_POST['vinnr'])); // quotes VIN request
				$vatnrs = trim(mysqli_real_escape_string($dbcon,$_POST['vatnr'])); // client VAT number
				$addinf = trim(nl2br(mysqli_real_escape_string($dbcon,$_POST['addinf']))); // quotes additional info
				$selsal = mysqli_real_escape_string($dbcon,$_POST['selsal']); // quotes salesman select
				if ( $selsal != '' ){ $mailsalesman = 1; } else { $mailsalesman = ''; }
			}
			else {
				$quoter = "0";
			}

			$pvnote = mysqli_real_escape_string($dbcon,$_POST['prvino']); //pre-visit notes
			$happyc = $_POST['happyc'];
			if ( $happyc == "yes" ){ $happyc = "1"; } else { $happyc = "0"; }
			
			$cmment = mysqli_real_escape_string($dbcon,$_POST['cmment']);
			$rnotes = mysqli_real_escape_string($dbcon,$_POST['rnotes']);

			// POSTPONE VISIT
			if ( $_POST['visit'] == "postpone" ){
				$stmt = $dbcon->prepare("INSERT INTO clients_repvisits VALUES ('',?,NOW(),?,?,'postponed','','1','0','',?,?,?,?);");
				$stmt->bind_param("ssissdd", $branch,$rucode,$cmpyid,$pvnote,$rnotes,$replat,$replon);
				if ( $stmt->execute() ){
					$msg = "Report Successfully Loaded.";
				}
				else {
					$msg = "ERROR: Could not add your visit.";
				}
				$stmt->close();
				header("Location: $dir/repconfirm.php?reload=1&message=".$msg);
			}
			// END POSTPONE VISIT

			if ( empty($cmpyid) || $cmpyid == '' ){
				// add client to db
				$cont1 = 0;
				$stmt = $dbcon->prepare("INSERT INTO clients_main VALUES ('','',?,?,?,?,'South Africa','',?,?,'',?,'','','','','','','','','','',?,'',?,'',?);");
				$stmt->bind_param("ssssddssss",$compny,$pstree,$ptownl,$provin,$replat,$replon,$hubare,$cemail,$branch,$rating);
				if ( $stmt->execute() ){
					$cont1 = 1;
				}
				else {
					$msg = "ERROR: Could not add client company.";
				}
				$stmt->close();

				if ( $cont1 === 1 ){
					// get client main id
					$cont2 = 0;
					$stmt = $dbcon->prepare("SELECT id FROM clients_main WHERE company_name = ? AND physical_street = ?;");
					$stmt->bind_param("ss",$compny,$pstree);
					if ( $stmt->execute() ){
						$result = $stmt->get_result();
						$row = $result->fetch_assoc();
						$cmpyid = $row['id'];
						$cont2 = 1;
					}
					else {
						$msg = "ERROR: Could not determine client upload.";
					}
					$stmt->close();

					if ( $cont2 === 1 ){
						// capture client contact details
						$cont3 = 0;
						$stmt = $dbcon->prepare("INSERT INTO clients_contacts VALUES('',?,?,?,'','',?,'',?,?);");
						$stmt->bind_param("isisss",$cmpyid,$nconta,$cellnr,$cemail,$positn,$infofo);
						if ( $stmt->execute() ){
							$cont3 = 1;
						}
						else {
							$msg = "ERROR: Could not add the contact details.";
						}
						$stmt->close();

						if ( $cont3 === 1 ){
							// capture visit itself
							$cont4 = 0;
							//$stmt = $dbcon->prepare("INSERT INTO clients_repvisits VALUES ('',?,NOW(),?,?,?,?,?,?,?,?,?,?,?);");
							if (!($stmt = $dbcon->prepare("INSERT INTO clients_repvisits VALUES ('',?,NOW(),?,?,?,?,?,?,?,?,?,?,?);"))) {
								echo "Prepare failed: (" . $dbcon->errno . ") " . $dbcon->error;
							}
							//$stmt->bind_param("ssissiisssdd",$branch,$rucode,$cmpyid,$nconta,$positn,$happyc,$quoter,$cmment,$pvnote,$rnotes,$replat,$replon);
							if (!$stmt->bind_param("ssissiisssdd",$branch,$rucode,$cmpyid,$nconta,$positn,$happyc,$quoter,$cmment,$pvnote,$rnotes,$replat,$replon)) {
								echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
							}

							if ( $stmt->execute() ){
								$cont4 = 1;
							}
							else {
								//echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
								$admin = $stmt->error;
								$msg = "ERROR: Could not add your visit.<br><b>SCREENSHOT AND ADD TO REP WHATS APP GROUP</b><br>$admin";
							}
							$stmt->close();
							
							if ( $cont4 === 1 ){

								
								// the below gives error if 1st visit is submitted multiple times (for what ever reason), thus:
								// check if $c01 exist, update all, else insert all. 


								// capture client's vehicles
								$cont5 = 0;
								$stmt = $dbcon->prepare("INSERT INTO clients_vehicles VALUES('',?,?,'01',?),('',?,?,'02',?),('',?,?,'03',?),('',?,?,'04',?),('',?,?,'06',?),('',?,?,'11',?),('',?,?,'20',?),('',?,?,'22',?),('',?,?,'30',?),('',?,?,'60',?),('',?,?,'61',?),('',?,?,'63',?),('',?,?,'64',?),('',?,?,'71',?),('',?,?,'80',?),('',?,?,'81',?),('',?,?,'82',?);");
								$stmt->bind_param("siisiisiisiisiisiisiisiisiisiisiisiisiisiisiisiisii",$c01,$cmpyid,$vehm01,$c02,$cmpyid,$vehm02,$c03,$cmpyid,$vehm03,$c04,$cmpyid,$vehm04,$c06,$cmpyid,$vehm06,$c11,$cmpyid,$vehm11,$c20,$cmpyid,$vehm20,$c22,$cmpyid,$vehm22,$c30,$cmpyid,$vehm30,$c60,$cmpyid,$vehm60,$c61,$cmpyid,$vehm61,$c63,$cmpyid,$vehm63,$c64,$cmpyid,$vehm64,$c71,$cmpyid,$vehm71,$c80,$cmpyid,$vehm80,$c81,$cmpyid,$vehm81,$c82,$cmpyid,$vehm82);

								$vehm01 = mysqli_real_escape_string($dbcon,$_POST['vehm01']); // volvo
								$vehm02 = mysqli_real_escape_string($dbcon,$_POST['vehm02']); // scania
								$vehm03 = mysqli_real_escape_string($dbcon,$_POST['vehm03']); // merc
								$vehm04 = mysqli_real_escape_string($dbcon,$_POST['vehm04']); // man
								$vehm06 = mysqli_real_escape_string($dbcon,$_POST['vehm06']); // daf
								$vehm20 = mysqli_real_escape_string($dbcon,$_POST['vehm20']); // bpw
								$vehm22 = mysqli_real_escape_string($dbcon,$_POST['vehm22']); // henred
								$vehm30 = mysqli_real_escape_string($dbcon,$_POST['vehm30']); // afrit
								$vehm82 = mysqli_real_escape_string($dbcon,$_POST['vehm82']); // isuzu
								$vehm80 = mysqli_real_escape_string($dbcon,$_POST['vehm80']); // hino
								$vehm81 = mysqli_real_escape_string($dbcon,$_POST['vehm81']); // ud
								$vehm60 = mysqli_real_escape_string($dbcon,$_POST['vehm60']); // toyota
								$vehm61 = mysqli_real_escape_string($dbcon,$_POST['vehm61']); // ford
								$vehm63 = mysqli_real_escape_string($dbcon,$_POST['vehm63']); // isuzu
								$vehm64 = mysqli_real_escape_string($dbcon,$_POST['vehm64']); // nissan
								$vehm71 = mysqli_real_escape_string($dbcon,$_POST['vehm71']); // mazda
								$vehm11 = mysqli_real_escape_string($dbcon,$_POST['vehm11']); // sprinter

								$c01 = "$cmpyid.01";
								$c02 = "$cmpyid.02";
								$c03 = "$cmpyid.03";
								$c04 = "$cmpyid.04";
								$c06 = "$cmpyid.06";
								$c11 = "$cmpyid.11";
								$c20 = "$cmpyid.20";
								$c22 = "$cmpyid.22";
								$c30 = "$cmpyid.30";
								$c60 = "$cmpyid.60";
								$c61 = "$cmpyid.61";
								$c63 = "$cmpyid.63";
								$c64 = "$cmpyid.64";
								$c71 = "$cmpyid.71";
								$c80 = "$cmpyid.80";
								$c81 = "$cmpyid.81";
								$c82 = "$cmpyid.82";

								if ( $stmt->execute() ){
									$cont5 = 1;
								}
								else {
									$admin = $stmt->error;
									$msg = "ERROR: Could not add client vehicles.<br><b>SCREENSHOT AND ADD TO REP WHATS APP GROUP</b><br>$admin";
								}
								$stmt->close();

								if ( $cont5 === 1 ){

									// capture other vehicles specified
									$cont6 = 0;
									
									$stmt = $dbcon->prepare("INSERT INTO clients_vehicles_other (clients_main_id,veh_othr) VALUES (?,?) ON DUPLICATE KEY UPDATE veh_othr = VALUES(veh_othr);");
									if (!$stmt->bind_param("is",$cmpyid,$vehotr)){
										echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
									}
									
									$vehotr = mysqli_real_escape_string($dbcon,$_POST['vehotr']);
									if ( empty($vehotr) || $vehotr == '' ){ $vehotr = 'none'; }

									if ( $stmt->execute() ){
										$cont6 = 1;
									}
									else {
										$msg = "ERROR: Could not add other vehicles to client.";
									}
									$stmt->close();

									if ( $cont6 === 1 ){
										$msg = "Report Successfully Loaded.";
										//$mailsalesman = 1;
									}
								}
							}
						}
					}
				}
			}
			else {
				$conti1 = 0;
				$stmt = $dbcon->prepare("SELECT time_visited FROM clients_repvisits WHERE branch = ? AND ucode = ? AND clients_main_id = ? ORDER BY time_visited DESC LIMIT 1");
				$stmt->bind_param("ssi",$branch,$rucode,$cmpyid);
				if ( $stmt->execute() ){ 

					$row = $result->fetch_assoc();
					$lastvisit = $row['time_visited'];
					$lastvisit = strtotime($lastvisit);
					$timenow = strtotime(date("Y-m-d H:i:s"));
					$diff = $timenow - $lastvisit;
					if ( $diff >= 300 ){
						$conti1 = 1;
					}
				}
				$stmt->close();

				if ( $conti1 === 1 ){
					$conti2 === 0;
					if (!($stmt1 = $dbcon->prepare("SELECT physical_latitude FROM clients_main WHERE id = ?;"))){
						echo "Prepare failed (1): (" . $dbcon->errno . ") " . $dbcon->error;
					}
					if (!$stmt1->bind_param("i",$cmpyid)){
						echo "Binding parameters failed: (" . $stmt1->errno . ") " . $stmt1->error;
					}
					$cmpyid = mysqli_real_escape_string($dbcon,$_POST['cmpyid']); // id of company on clients_main

					$stmt1->execute();
					$row = $result->fetch_assoc();
					$havelat = $row['physical_latitude'];
					$stmt1->close();

					if ( $havelat == '' ){
						$stmt = $dbcon->prepare("UPDATE clients_main SET physical_street = ?, physical_town = ?, physical_province = ?, physical_latitude = ?, physical_longitude = ?, delivery_town = ?, assigned_branch = ?, client_rating = ? WHERE id = ?;");
						$stmt->bind_param("sssddsssi",$pstree,$ptownl,$provin,$replat,$replon,$hubare,$branch,$rating,$cmpyid);
					}
					else {
						$stmt = $dbcon->prepare("UPDATE clients_main SET physical_street = ?, physical_town = ?, physical_province = ?, delivery_town = ?, assigned_branch = ?, client_rating = ? WHERE id = ?;");
						$stmt->bind_param("ssssssi",$pstree,$ptownl,$provin,$hubare,$branch,$rating,$cmpyid);
					}
					$qry = $havelat = null;

					if ( $stmt->execute() ){ 
						$conti2 = 1;
					}
					else {
						$admin = $stmt->error;
						$msg = "ERROR: Could not update client company.<br><b>SCREENSHOT AND ADD TO REP WHATS APP GROUP</b><br>$admin";
					}
					$stmt->close();

					if ( $conti2 === 1 ){
						$conti3 = 0;
						if ( empty($ctcnam) || $ctcnam == '' || $ctcnam == '\\' || $ctcnam == '\\\\' ){
							if ( !empty($ctcname) && $ctcname != '' ){
								$vstctc = $ctcname;
							}
							else if ( !empty($contac) && $contac != '' ){
								$vstctc = $contac;
							}
							else if ( !empty($nconta) && $nconta != '' ){
								$vstctc = $nconta;
							}
							else {
								$vstctc = "";
							}
						}
						else {
							$vstctc = $ctcnam;
						}

						if ( $infofo == null || empty($infofo) || $infofo == '' ){ $infofo = 'NONE'; }

						if ( strlen($nconta) > 2 ){
							$stmt = $dbcon->prepare("INSERT INTO clients_contacts (clients_main_id,contact_name,contact_cellnr,contact_cellnr2,contact_telnr,contact_email,contact_email2,contact_position,contact_marketing) VALUES(?,?,?,'','',?,'',?,?);");
							$stmt->bind_param("isssss",$cmpyid,$vstctc,$cellnr,$cemail,$positn,$infofo);
							$ctcname = $nconta;
						}
						else {
							$stmt = $dbcon->prepare("UPDATE clients_contacts SET contact_cellnr = ?, contact_email = ?, contact_position = ?, contact_marketing = ? WHERE id = ?;");
							$stmt->bind_param("sssss",$cellnr,$cemail,$positn,$infofo,$contid);
							//$ctcname = $ctcnam;
						}

						if ( $stmt->execute() ){ 
							$conti3 = 1;
						}
						else {
							$admin = $stmt->error;
							$msg = "ERROR: Could not update the contact details.<br><b>SCREENSHOT AND ADD TO REP WHATS APP GROUP</b><br>$admin<br>$admin<br>1: $ctcnam<br>2: $ctcname<br>3: $contac<br>4: $nconta<br>5: $contid";
						}
						$stmt->close();

						if ( $conti3 === 1 ){
							$conti4 = 0;
							$stmt = $dbcon->prepare("INSERT INTO clients_vehicles (uniq_ref,clients_main_id,veh_code,veh_qty) VALUES (?,?,'01',?),(?,?,'02',?),(?,?,'03',?),(?,?,'04',?),(?,?,'06',?),(?,?,'11',?),(?,?,'20',?),(?,?,'22',?),(?,?,'30',?),(?,?,'60',?),(?,?,'61',?),(?,?,'63',?),(?,?,'64',?),(?,?,'71',?),(?,?,'80',?),(?,?,'81',?),(?,?,'82',?) ON DUPLICATE KEY UPDATE veh_qty = VALUES(veh_qty);");
							$stmt->bind_param("iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii",$c01,$cmpyid,$vehm01,$c02,$cmpyid,$vehm02,$c03,$cmpyid,$vehm03,$c04,$cmpyid,$vehm04,$c06,$cmpyid,$vehm06,$c11,$cmpyid,$vehm11,$c20,$cmpyid,$vehm20,$c22,$cmpyid,$vehm22,$c30,$cmpyid,$vehm30,$c60,$cmpyid,$vehm60,$c61,$cmpyid,$vehm61,$c63,$cmpyid,$vehm63,$c64,$cmpyid,$vehm64,$c71,$cmpyid,$vehm71,$c80,$cmpyid,$vehm80,$c81,$cmpyid,$vehm81,$c82,$cmpyid,$vehm82);

							$vehm01 = mysqli_real_escape_string($dbcon,$_POST['vehm01']); // volvo
							$vehm02 = mysqli_real_escape_string($dbcon,$_POST['vehm02']); // scania
							$vehm03 = mysqli_real_escape_string($dbcon,$_POST['vehm03']); // merc
							$vehm04 = mysqli_real_escape_string($dbcon,$_POST['vehm04']); // man
							$vehm06 = mysqli_real_escape_string($dbcon,$_POST['vehm06']); // daf
							$vehm20 = mysqli_real_escape_string($dbcon,$_POST['vehm20']); // bpw
							$vehm22 = mysqli_real_escape_string($dbcon,$_POST['vehm22']); // henred
							$vehm30 = mysqli_real_escape_string($dbcon,$_POST['vehm30']); // afrit
							$vehm82 = mysqli_real_escape_string($dbcon,$_POST['vehm82']); // isuzu
							$vehm80 = mysqli_real_escape_string($dbcon,$_POST['vehm80']); // hino
							$vehm81 = mysqli_real_escape_string($dbcon,$_POST['vehm81']); // ud
							$vehm60 = mysqli_real_escape_string($dbcon,$_POST['vehm60']); // toyota
							$vehm61 = mysqli_real_escape_string($dbcon,$_POST['vehm61']); // ford
							$vehm63 = mysqli_real_escape_string($dbcon,$_POST['vehm63']); // isuzu
							$vehm64 = mysqli_real_escape_string($dbcon,$_POST['vehm64']); // nissan
							$vehm71 = mysqli_real_escape_string($dbcon,$_POST['vehm71']); // mazda
							$vehm11 = mysqli_real_escape_string($dbcon,$_POST['vehm11']); // sprinter

							$c01 = "$cmpyid.01";
							$c02 = "$cmpyid.02";
							$c03 = "$cmpyid.03";
							$c04 = "$cmpyid.04";
							$c06 = "$cmpyid.06";
							$c11 = "$cmpyid.11";
							$c20 = "$cmpyid.20";
							$c22 = "$cmpyid.22";
							$c30 = "$cmpyid.30";
							$c60 = "$cmpyid.60";
							$c61 = "$cmpyid.61";
							$c63 = "$cmpyid.63";
							$c64 = "$cmpyid.64";
							$c71 = "$cmpyid.71";
							$c80 = "$cmpyid.80";
							$c81 = "$cmpyid.81";
							$c82 = "$cmpyid.82";

							if ( $stmt->execute() ){
								$conti4 = 1;
							}
							else {
								$admin = $stmt->error;
								$msg = "ERROR: Could not update client vehicles.<br><b>SCREENSHOT AND ADD TO REP WHATS APP GROUP</b><br>$admin";
							}
							$stmt->close();

							if ( $conti4 === 1 ){
								$conti5 = 0;
								$stmt = $dbcon->prepare("INSERT INTO clients_vehicles_other (clients_main_id,veh_othr) VALUES (?,?) ON DUPLICATE KEY UPDATE veh_othr = VALUES(veh_othr);");
								$stmt->bind_param("is",$cmpyid,$vehotr);
								$vehotr = mysqli_real_escape_string($dbcon,$_POST['vehotr']);
								if ( $stmt->execute() ){ 
									$conti5 = 1;
								}
								else {
									$admin = $stmt->error;
									$msg = "ERROR: Could not add other vehicles to client.<br><b>SCREENSHOT AND ADD TO REP WHATS APP GROUP</b><br>$admin";
								}
								$stmt->close();	
								
								if ( $conti5 === 1 ){
									$stmt = $dbcon->prepare("INSERT INTO clients_repvisits (branch,time_visited,ucode,clients_main_id,contact_name,contact_position,contact_happy,request_quote,contact_comments,previsit_notes,rep_notes,rep_latitude,rep_longitude) VALUES (?,NOW(),?,?,?,?,?,?,?,?,?,?,?);");
									$stmt->bind_param("ssissiisssdd",$branch,$rucode,$cmpyid,$vstctc,$positn,$happyc,$quoter,$cmment,$pvnote,$rnotes,$replat,$replon);
									
									if ( empty($ctcnam) || $ctcnam == '' ){
										if ( !empty($ctcname) && $ctcname != '' ){
											$vstctc = $ctcname;
										}
										else if ( !empty($contac) && $contac != '' ){
											$vstctc = $contac;
										}
										else if ( !empty($nconta) && $nconta != '' ){
											$vstctc = $nconta;
										}
										else {
											$vstctc = "";
										}
									}
									else {
										$vstctc = $ctcnam;
									}

									if ( $stmt->execute() ){
										$msg = "Report Successfully Loaded.";
									}
									else {
										$admin = $stmt->error;
										$msg = "ERROR: Could not update your visit.<br><b>SCREENSHOT AND ADD TO REP WHATS APP GROUP</b><br>$admin<br>1: $ctcnam<br>2: $ctcname<br>3: $contac<br>4: $nconta<br>5: $replat<br>6: $replon<br>7: $cmpyid";
									}
									$stmt->close();
								}
							}
						}
					}
				}
			}
		}
		else {
			$mailsalesman = 0;
			header("Location: $dir/repconfirm.php?reload=1&&message=".$msg);
		}
	}

	if ( $mailsalesman == 1 ){
		$stmt = $dbcon->prepare("SELECT name,surname,email FROM sacstaff WHERE ucode = ? LIMIT 1;");
		$stmt->bind_param("s",$rucode);
		$stmt->execute();
		$row = $result->fetch_assoc();
		$qsalesrepname = $row['name'].' '.$row['surname'];
		$qsalesrepemail = $row['email'];
		$stmt->close();

		$stmt = $dbcon->prepare("SELECT name,surname,email FROM sacstaff WHERE ucode = ? LIMIT 1;"); // get salesman's name, surname & email
		$stmt->bind_param("s",$selsal);
		$stmt->execute();
		$row = $result->fetch_assoc();
		$qsalesmanname = $row['name'].' '.$row['surname'];
		$qsalesmanemail = $row['email'];
		$stmt->close();

		$stmt = $dbcon->prepare("SELECT account_nr FROM clients_main WHERE id = ? LIMIT 1;"); // get account nr
		$stmt->bind_param("i",$cmpyid);
		$stmt->execute();
		$row = $result->fetch_assoc();
		$acc = $row['account_nr'];
		$stmt->close();
		if ( $acc != '' ){
			$cpyacc = '<tr><td><b>Account Nr</b></td><td width="12">:</td><td>'.mysqli_fetch_assoc($qry)['account_nr'].'</td></tr>';
		} else {
			$cpyacc = '';
		}
		if ( $vatnrs != '' ){
			$cpyvat = '<tr><td><b>VAT Number</b></td><td width="12">:</td><td>'.$vatnrs.'</td></tr>';
		} else {
			$cpyvat = '';
		}

		//$tomail = "dev@sactrucks.co.za";
		$tomail = $qsalesmanemail;

		$header = "MIME-Version: 1.0"."\r\n";
		$header .= "Content-type: text/html; charset=UTF-8"."\r\n";
		$header .= "From: SAC Rep App (no-reply@sacmarketing.co.za)"."\r\n";
		//$header .= "Reply-To: ".$qsalesrepemail."\r\n";
		//$header .= "Cc: ".$qsalesrepemail."\r\n";
		//$header .= "Bcc: dev@sactrucks.co.za"."\r\n";
		
		$subjct = "New Quote Request from Rep";

		$contnt = '
		<html>
		<head>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<style>
		@import url(https://fonts.googleapis.com/css?family=Open+Sans);
		* {font-family: Tahoma,serif !important;}
		#mbody {background-color:#ffffff;text-align:left;height:auto;color:#000000;max-width:600px !important;width:600px !important;margin:0;font-family:Tahoma,serif !important;font-size:16px;}
		.button{
			font-family: Tahoma,serif !important;font-weight:bold !important;font-size:12px !important;
			text-decoration: none;color: #ffffff !important;line-height:38px;text-transform: uppercase;text-align: center;
			display:inline-block;background-color: #cb1a1f;border-radius: 4px;
			padding: 2px;padding-bottom:14px;width: 200px !important;height: 15px !important;
			-webkit-text-size-adjust:none;
		}
		.button a:link {color: #FFFFFF !important;}
		.button a:visited, .button a:hover, .button a:active {color: #FFFFFF !important;}

		</style>
		</head>
		<body id="mbody">
			<p>Dear '.$qsalesmanname.' :: '.$selsal.'</p>
			<p>Please send a quotation to <b>'.$compny.'</b> using the below details:</p>
			
			<table border="0" cellspacing="0" callpadding="4">'.$cpyacc.$cpyvat.'
				<tr><td><b>Contact</b></td><td width="12">:</td><td>'.$ctcname.'</td></tr>
				<tr><td><b>Position</b></td><td width="12">:</td><td>'.$positn.'</td></tr>
				<tr><td><b>Email</b></td><td width="12">:</td><td>'.$cemail.'</td></tr>
				<tr><td><b>Cell Nr.</b></td><td width="12">:</td><td>'.$cellnr.'</td></tr>
				<tr><td colspan="3"> &nbsp; </td></tr>
				<tr><td><b>Parts Requested</b></td><td width="12">:</td><td width="600">'.$partsn.'</td></tr>
				<tr><td><b>VIN NR</b></td><td width="12">:</td><td width="600">'.$vinnrs.'</td></tr>
				<tr><td><b>Additional Notes</b></td><td width="12">:</td><td width="600">'.$addinf.'</td></tr>
			</table>
			<p> <br /> </p>
			<p>Kind Regards</p>
			<p>'.$qsalesrepname.'</p>
		</body>
		</html>
		';

		mail($tomail, $subjct, $contnt, $header);
	}
	mysqli_close($dbcon);
	header("Location: $dir/repconfirm.php?reload=1&&message=".$msg);
}
?>