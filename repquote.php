<?php
	session_start();
	$dir = dirname($_SERVER['PHP_SELF']);
	include '../../globals/dbcon.inc';
	include 'includes/log.inc';
	//$rid = $_COOKIE['sacmr'];
	$srid = $_SESSION['sacmr'];
	//$sql = "SELECT name,branch FROM sacstaff WHERE id = '$rid' LIMIT 1;";
	$sql = "SELECT ucode,name,branch FROM sacstaff WHERE id = '$srid' LIMIT 1;";
	$qry = mysqli_query($dbcon,$sql);
	$row = mysqli_fetch_assoc($qry);
	$rucode = $row['ucode'];
	$repnam = $row['name'];
	$branch = $row['branch'];
	if ( $branch == "Centurion" ){
		$sqlwhere = "level > '10' AND company = 'Trucks' AND branch = 'Centurion' AND departm = 'Sales' OR level > '10' AND company = 'Trucks' AND branch = 'CNT Recycling' AND departm = 'Sales' OR level > '10' AND company = 'Trucks' AND branch = 'LCV' AND departm = 'Sales'";
	}
	else {
		$sqlwhere = "level > '10' AND company = 'Trucks' AND branch = '$branch' AND departm = 'Sales'";
	}
?>



						<input type="hidden" id="quoter" name="quoter" value="yes">
						
						<label>Parts Needed:*</label><textarea id="partsn" name="partsn" required></textarea>

						<label>Vehicle VIN:</label><input type="text" id="vinnr" name="vinnr" >

						<?php if (  $acnr == '' ){ echo 'VAT Number:<input type="text" id="vatnr" name="vatnr" >'; } ?>

						<label>Additional Info:</label><textarea id="addinf" name="addinf"></textarea>

						<label>Select Salesman:*</label><select id="selsal" name="selsal" required>
								<option value="" disabled selected>Please Select A Salesman</option>
								<?php
								$sql = "SELECT ucode,name,surname FROM sacstaff WHERE $sqlwhere ORDER BY name,surname;";
								//$sql = "SELECT ucode,name,surname FROM sacstaff WHERE company = 'Trucks' AND departm = 'Sales' ORDER BY name,surname;";
								$qry = mysqli_query($dbcon,$sql);
								while ( $row = mysqli_fetch_assoc($qry) ){
									$sucode = $row['ucode'];
									$salesman = $row['name'].' '.$row['surname'];
									echo '<option value="'.$sucode.'" >'.$salesman.'</option>';
								}
								?>
							</select>
