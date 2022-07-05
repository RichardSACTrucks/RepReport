<?php
session_start();
$dir = dirname($_SERVER['PHP_SELF']);
include '../globals/dbcon.inc';
include 'includes/log.inc';
//$rid = $_COOKIE['sacmr'];
$srid = $_SESSION['sacmr'];
//$sql = "SELECT name,branch FROM sacstaff WHERE id = '$rid' LIMIT 1;";
$sql = "SELECT ucode,name,branch,level FROM sacstaff WHERE id = '$srid' LIMIT 1;";
$qry = mysqli_query($dbcon,$sql);
$row = mysqli_fetch_assoc($qry);
$rucode = $row['ucode'];
$repnam = $row['name'];
$branch = $row['branch'];
$rlevel = $row['level'];
//echo "<p>r: $rid, ".$_COOKIE['sacmr']."</p>";
//echo "<p>branch: $branch, $repnam</p>";
if ( empty($branch) ){
    $_SESSION = array();
    session_destroy();
    header("location: $dir/index.php");
    exit;
}
else {
	require_once 'includes/html-head.html';
	if ( $rlevel > 10 ){
	
		$checksession = $_SESSION['sacmr'];
		//echo "<p><b>session: $checksession</b></p>";
		//$branch = $_REQUEST['branch'];
		$cpyid = $_REQUEST['cpyid'];
		$company = $_REQUEST['company'];

		$sql = "SELECT company_name,account_nr,physical_street,physical_town,physical_province,delivery_town,client_rating FROM clients_main WHERE id = '$cpyid' AND assigned_branch = '$branch' LIMIT 1;";
		if ( $qry = mysqli_query($dbcon,$sql) ){
			$num = mysqli_num_rows($qry);
			if ( $num > 0 ){
				$row = mysqli_fetch_assoc($qry);
				$company = $row['company_name'];
				$acnr = $row['account_nr'];

				$pa_street = $row['physical_street'];
				$pa_town = $row['physical_town'];
				$pa_prov = $row['physical_province'];
				$hub_area = $row['delivery_town'];
				$rating = $row['client_rating'];

				$sql1 = "SELECT count(id) AS amount FROM clients_repvisits WHERE clients_main_id = '$cpyid' LIMIT 1;";
				$qry1 = mysqli_query($dbcon,$sql1);
				$num1 = mysqli_fetch_assoc($qry1)['amount'];
				if ( $num1 > 0 ){
					$previsits = "yes";
				}
				$sql1 = ""; $qry1 = "";
			}
		}
		else {
			echo "Error 1: " . mysqli_error($dbcon);
			echo "Company details cannot be found.";
		}
		?>

        <form class="" action="repconfirm.php" method="post">
            <?php if(!empty($cpyid)){ echo '<input type="hidden" name="cmpyid" value="'.$cpyid.'" >'; } ?>

            <input name="branch" type="hidden" value="<?php echo $branch; ?>" readonly> <!-- hidden-->
			<input name="rucode" type="hidden" value="<?php echo $rucode; ?>" >

			<section><h3><?php if ( $acnr != '' ){ echo "$company <br><i>Account Nr: $acnr</i>"; } else { echo $company; } ?></h3></section>

			<h2 id="cmpydets">COMPANY DETAILS</h2>

			<section id="divcpydet">
				<input type="hidden" name="compni" <?php if( !empty($company) ){ echo 'value="'.$company.'"'; } ?> autocomplete="off" autocapitalize=off required ></p>

				<label>Physical Province:*</label><br>
				<select id="provin" name="provin" required>
					<option value="GAUTENG" <?php if( $pa_prov == "GAUTENG" ){ echo "selected"; } ?> >GAUTENG</option>
					<option value="WESTERN CAPE" <?php if( $pa_prov == "WESTERN CAPE" ){ echo "selected"; } ?> >WESTERN CAPE</option>
					<option value="LIMPOPO" <?php if( $pa_prov == "LIMPOPO" ){ echo "selected"; } ?> >LIMPOPO</option>
					<option value="KWA-ZULU NATAL" <?php if( $pa_prov == "KWA-ZULU NATAL" ){ echo "selected"; } ?> >KWA-ZULU NATAL</option>
					<option value="NORTH WEST" <?php if( $pa_prov == "NORTH WEST" ){ echo "selected"; } ?> >NORTH WEST</option>
					<option value="MPUMALANGA" <?php if( $pa_prov == "MPUMALANGA" ){ echo "selected"; } ?> >MPUMALANGA</option>
					<option value="FREESTATE" <?php if( $pa_prov == "FREESTATE" ){ echo "selected"; } ?> >FREESTATE</option>
					<option value="EASTERN CAPE" <?php if( $pa_prov == "EASTERN CAPE" ){ echo "selected"; } ?> >EASTERN CAPE</option>
					<option value="NORTHERN CAPE" <?php if( $pa_prov == "NORTHERN CAPE" ){ echo "selected"; } ?> >NORTHERN CAPE</option>
					<option value="OUTSIDE RSA" <?php if( $pa_prov == "OUTSIDE RSA" ){ echo "selected"; } ?> >OUTSIDE RSA</option>
				</select>
				
				<label>Hub Area:*</label><br><input type="text" id="hubtown" name="hubare" required value="<?php if(!empty($hub_area)){ echo $hub_area; } ?>" >
				
				<?php /*if ( $rucode == 'ts001' ){ ?>

					<span id="infobox">.</span><br>
					<!--
						if #provin has value or change{}
						ON CHANGE of provin, create select options with hub_name shown as Hub Region.( delivery_province ) $hub_regi
						on change of hun_name create select option for town_name shown as Hub Area.( delivery_town ) $hub_area
					-->
				<?php }*/ ?>


				<label>Physical Town:*</label><br><input name="ptownl" type="text" required value="<?php if(!empty($pa_town)){ echo $pa_town; } ?>" >

				<label>Physical Street Address:*</label><br><input name="pstree" type="text" rows="3" cols="28" rows="5" required value="<?php if(!empty($pa_street)){ echo $pa_street; } ?>" >

				<p>Client Rating:*
					<select name="rating" required>
						<option value="null" <?php if ( empty($rating) ){ echo "selected"; } ?> disabled >Please Select Clients Rating</option>
						<option value="very good" <?php if ( $rating == "very good" ){ echo "selected"; } ?> >Very Good</option>
						<option value="good" <?php if ( $rating == "good" ){ echo "selected"; } ?> >Good</option>
						<option value="average" <?php if ( $rating == "average" ){ echo "selected"; } ?> >Average</option>
						<option value="bad" <?php if ( $rating == "bad" ){ echo "selected"; } ?> >Bad</option>
					</select>
				</p>

			</section>
			
			<div class="h32"></div>
			<h2 id="contdets">CONTACT DETAILS</h2>

			<section>
			
				<?php
				$sql = "SELECT id,contact_name,contact_position FROM clients_contacts WHERE clients_main_id = '$cpyid' ;";
				if ( $qry = mysqli_query($dbcon,$sql) ){
					$num = mysqli_num_rows($qry);
					if ( $num > 0 ){
						echo '<p>Select Contact:*<select id="contactSelect" name="contac" required>';
						echo '<option value="" disabled selected>-- Select --</option>';
						while ( $row = mysqli_fetch_assoc($qry) ){
							$contactid = $row['id'];
							$contact_name = $row['contact_name'];
							$contact_posi = $row['contact_position'];
							echo '<option value="'.$contactid.'" >'.$contact_name.' ('.$contact_posi.')</option>';
						}
						echo '<option value="createnewcontact" >+ Create New Contact</option>';
						echo '</select></p>';
					}
					else {
						?>
						<div id="newcontact">
							<p><!--style="display:none"-->Contact Name:*<input name="newcontac" type="text" placeholder="Clients Name" required></p>
							<p>
								<div>Contact's Position:*
									<select name="positn" required>
										<option value="" <?php if ($contact_posi == "none" || empty($contact_posi)){ echo "selected"; } ?> disabled >Position / Job Description of Contact</option>
										<option value="Owner" <?php if ($contact_posi == "Owner"){ echo "selected"; } ?> >Owner</option>
										<option value="Manager" <?php if ($contact_posi == "Manager"){ echo "selected"; } ?> >Manager</option>
										<option value="Buyer" <?php if ($contact_posi == "Buyer"){ echo "selected"; } ?> >Buyer</option>
										<option value="Mechanic" <?php if ($contact_posi == "Mechanic"){ echo "selected"; } ?> >Mechanic</option>
										<option value="Admin" <?php if ($contact_posi == "Admin"){ echo "selected"; } ?> >Admin</option>
									</select>
								</div>
							</p>
							<p>Contact's Cell Number:*<input name="cellnr" type="text" <?php if(!empty($cellnr)){ echo 'value="'.$cellnr.'"'; } ?> required></p>
							<p>Contact's Email:*<input name="cemail" type="email" <?php if(!empty($cemail)){ echo 'value="'.$cemail.'"'; } ?> required></p>
							<p>
								<div>Marketing Preference:*<br>

									<input type="checkbox" id="s1" name="infow" value="W"><label for="s1"> WhatsApp</label><br>
									<input type="checkbox" id="s2" name="infos" value="S"><label for="s2"> SMS</label><br>
									<input type="checkbox" id="s3" name="infoe" value="E"><label for="s3"> Email</label><br>
									<input type="checkbox" id="s0" name="infon" value="NONE"><label for="s0"> None</label>

									<!--select name="infofo" required>
										<option value="null" <?php if ($infofo == "NONE"){ echo "selected"; } ?> disabled >Please Select Information Format</option>
										<option value="w" <?php if ($infofo == "W"){ echo "selected"; } ?> >WhatsApp</option>
										<option value="s" <?php if ($infofo == "S"){ echo "selected"; } ?> >SMS</option>
										<option value="e" <?php if ($infofo == "E"){ echo "selected"; } ?> >Email</option>
										<option value="none" >None</option>
									</select-->
								</div>
							</p>
						</div>
						<?php
					}
				}
				else {
					echo "Error: " . mysqli_error($dbcon);
					echo "Could not retrieve contacts for client.";
				}
				?>

				<div id="clientContactDetails"></div>

			</section>

			<div class="h32"></div>
			<h2 id="vehicles">VEHICLES</h2>
			
			<section>
				<div>Vehicles In Fleet:*
					<?php
					function vehQty($cpynr, $vehnr){
						$sql = "SELECT veh_qty FROM clients_vehicles WHERE clients_main_id = '$cpynr' AND veh_code = '$vehnr' LIMIT 1;";
						//echo "<p>$sql</p>";
						global $dbcon;
						if ( $qry = mysqli_query($dbcon,$sql) ){
							$num = mysqli_num_rows($qry);
							if ( $num == 1 ){
								$cvehqty = mysqli_fetch_assoc($qry)['veh_qty'];
							}
							else {
								$cvehqty = "0";
							}
						}
						else {
							$cvehqty = "0";
						}
						echo $cvehqty;
					}
					?>
					<p><input type="number" name="vehm01" value="<?php vehQty($cpyid,"1"); ?>" min="0" max="9999" maxlength="4" size="4"> Volvo</p>
					<p><input type="number" name="vehm02" value="<?php vehQty($cpyid,"2"); ?>" min="0" max="9999" maxlength="4" size="4"> Scania</p>
					<p><input type="number" name="vehm03" value="<?php vehQty($cpyid,"3"); ?>" min="0" max="9999" maxlength="4" size="4"> Mercedes</p>
					<p><input type="number" name="vehm04" value="<?php vehQty($cpyid,"4"); ?>" min="0" max="9999" maxlength="4" size="4"> MAN</p>
					<p><input type="number" name="vehm06" value="<?php vehQty($cpyid,"6"); ?>" min="0" max="9999" maxlength="4" size="4"> DAF</p>
					<hr>
					<p><input type="number" name="vehm20" value="<?php vehQty($cpyid,"20"); ?>" min="0" max="9999" maxlength="4" size="4"> BPW</p>
					<p><input type="number" name="vehm22" value="<?php vehQty($cpyid,"22"); ?>" min="0" max="9999" maxlength="4" size="4"> Henred</p>
					<p><input type="number" name="vehm30" value="<?php vehQty($cpyid,"30"); ?>" min="0" max="9999" maxlength="4" size="4"> Afrit</p>
					<hr>
					<p><input type="number" name="vehm82" value="<?php vehQty($cpyid,"82"); ?>" min="0" max="9999" maxlength="4" size="4"> Isuzu MCV</p>
					<p><input type="number" name="vehm80" value="<?php vehQty($cpyid,"80"); ?>" min="0" max="9999" maxlength="4" size="4"> Hino</p>
					<p><input type="number" name="vehm81" value="<?php vehQty($cpyid,"81"); ?>" min="0" max="9999" maxlength="4" size="4"> UD</p>
					<hr>
					<p><input type="number" name="vehm60" value="<?php vehQty($cpyid,"60"); ?>" min="0" max="9999" maxlength="4" size="4"> Toyota</p>
					<p><input type="number" name="vehm61" value="<?php vehQty($cpyid,"61"); ?>" min="0" max="9999" maxlength="4" size="4"> Ford</p>
					<p><input type="number" name="vehm63" value="<?php vehQty($cpyid,"63"); ?>" min="0" max="9999" maxlength="4" size="4"> Isuzu LCV</p>
					<p><input type="number" name="vehm64" value="<?php vehQty($cpyid,"64"); ?>" min="0" max="9999" maxlength="4" size="4"> Nissan</p>
					<p><input type="number" name="vehm71" value="<?php vehQty($cpyid,"71"); ?>" min="0" max="9999" maxlength="4" size="4"> Mazda</p>
					<hr>
					<p><input type="number" name="vehm11" value="<?php vehQty($cpyid,"11"); ?>" min="0" max="9999" maxlength="4" size="4"> Sprinter</p>
					<hr>
					<p>Other Vehicles:<br>
					<?php
					$sql = "SELECT veh_othr FROM clients_vehicles_other WHERE clients_main_id = '$cpyid' LIMIT 1;";
					if ( $qry = mysqli_query($dbcon,$sql) ){
						$num = mysqli_num_rows($qry);
						if ( $num == 1 ){
							$vehotr = mysqli_fetch_assoc($qry)['veh_othr'];
						}
						else {
							$vehotr = "";
						}
					}
					else {
						$vehotr = "";
					}
					?>					
					<input type="text" name="vehotr" <?php if ( !empty($vehotr) ){ echo 'value="'.$vehotr.'"'; } ?> ></p>
				</div>
			</section>

			<div class="h32"></div>
			<h2 id="visinote">VISIT NOTES</h2>

			<section>

				<?php
				$qry2 = mysqli_query($dbcon,"SELECT clients_previsit_note FROM clients_notes WHERE clients_main_id = '$cpyid' LIMIT 1;");
				$pvnote = mysqli_fetch_assoc($qry2)['clients_previsit_note'];
				?>

				Pre-Visit Notes<textarea name="prvino" readonly><?php echo $pvnote; ?></textarea>

				<!--?php
				if ( $branch == "Centurion" || $branch == "Boksburg" ){?-->
				 	<!--button onclick="doQuote()">Request Quote</button-->
				
					<!--p>Request Quote:* &emsp; <input type="radio" id="yquot" name="quoter" value="yes"> Yes &emsp; <input type="radio" id="nqout" name="quoter" value="no" required > No</p>
					<!--button onclick="showQuote()">Request Quote</button-->
					<button id="requote">Request A Quote</button>
					<button id="shquote" style="display:none">Cancel Quote Request</button>
					<section id="doquote"></section>
				
					<!--?php
				}
				else {
					echo 'Request Quote:* &emsp; <input type="radio" name="quoter" value="yes"> Yes &emsp; <input type="radio" name="quoter" value="no" required > No</p>';
				}
				?-->
				<p>Happy With Service?* <input type="radio" name="happyc" value="yes"> Yes &emsp; <input type="radio" name="happyc" value="no" required > No</p>

				<p>Contact's Comments:<textarea name="cmment" type="text" rows="3" cols="28" rows="5" maxlength="255" placeholder="Customer comments about our service and/or visit"><?php if ( !empty($cmment) ){ echo $cmment; } ?></textarea></p>
 				<!--p>My Notes:*<input name="rnotes" type="text" placeholder="Notes" required></p-->
				<p>My Notes:*<textarea name="rnotes" type="text" rows="3" cols="28" rows="5" maxlength="255" placeholder="My notes about the visit" required><?php if ( !empty($cmment) ){ echo $cmment; } ?></textarea></p>


				<p>Latitude:*<input name="replat" type="text" id="lat" required onclick="getLocation()" onfocus="getLocation()" ><br>
				Longitude:*<input name="replon" type="text" id="long" required onclick="getLocation()" ><br>
				<i>GPS Accuracy:<input name="accura" type="text" id="accu" readonly></i><br>
				<?php
				if ( $rucode === "ts001" ){
					$qry0 = mysqli_query($dbcon,"SELECT physical_latitude,physical_longitude FROM clients_main WHERE id = '$cpyid' LIMIT 1;");
					if ( $row0 = mysqli_fetch_assoc($qry0) ){
						$hasmain = "1";
						$mainlat = $row0['physical_latitude'];
						$mainlon = $row0['physical_longitude'];
					}
					echo '<input type="hidden" readonly id="mainlat" value="'.$mainlat.'"><input type="hidden" readonly id="mainlon" value="'.$mainlon.'">';

					echo '<i>Distance From Client\'s Main Coordinates</i>:<input type="text" id="jsdist" value="'.$dist.' Km" readonly><br>';
				}
				?>
				<span id="forcoordupd"></span><span id="setmaincoord"></span>
				</p>

			</section>

			<div class="h32"></div>

			<section id="submitarea">
				<div id="allowSubmit"></div>
				<button type="submit">Submit</button>
			</section>
		</form>

		<div>
			<div class="h16"></div>
			<section><a href="home.php?status=1&cpyid=<?php echo $cpyid; ?>"><button>Back</button></a></section>

	        <div class="h32"></div>

			<?php
			if ( $previsits == "yes"){
				echo '<section>';
				$sql3 = "SELECT * FROM clients_repvisits WHERE clients_main_id = '$cpyid' ORDER BY time_visited DESC LIMIT 3;";
				$qry3 = mysqli_query($dbcon,$sql3);
				$num3 = mysqli_num_rows($qry3);
				if ( $num3 > 0 ){
					echo "<h3>Previous Visits</h3>";
					while ( $row3 = mysqli_fetch_assoc($qry3) ){
						$vstime = $row3['time_visited'];
						$repcod = $row3['ucode'];
						$sql = "SELECT name,surname FROM sacstaff WHERE ucode = '$repcod' LIMIT 1;";
						$qry = mysqli_query($dbcon,$sql);
						$row = mysqli_fetch_assoc($qry);
						$repnam = $row['name'];
						$repsur = $row['surname'];
						$contac = $row3['contact_name'];
						//$tel_nr = $row3['tel_nr'];
						//$cemail = $row3['cemail'];
						$quoter = $row3['request_quote']; if ( $quoter == "1" ){ $quoter = '<b><span class="fntblk">Yes</span></b>'; } else { $quoter = "No"; }
						$happyc = $row3['contact_happy']; if ( $happyc == "1" ){ $happyc = "<b>Yes</b>"; } else { $happyc = '<b><span class="fntred">No</span></b>'; }
						$rnotes = $row3['rep_notes'];
						$replat = $row3['rep_latitude'];
						$replon = $row3['rep_longitude'];
						?>
						<div class="previs">
							<div class="w80p"><u><?php echo $vstime; ?></u></div><div class="w20p"><b><?php echo $repnam; ?></b></div>
							<span>Spoke With: <b><span class="fntblk"><?php echo $contac; ?></span></b></span><br>
							<!--b><?php echo $tel_nr; ?></b><br>
							<i><?php echo $cemail; ?></i><br-->
							Happy: <?php echo $happyc; ?><br>
							Requested Quote: <?php echo $quoter; ?><br>
							<u>Notes:</u><br>
							<?php echo $rnotes; ?>
						</div>
						<?php
					}
				}
				$sql3 = "";
				$qry3 = "";
				echo '</section>';
			}
			?>		

			<p>&nbsp;</p>

		</div>

        <script>
            var x = document.getElementById("lat");
			var z = document.getElementById("long");
			var y = document.getElementById("accu");
			var replat;// = position.coords.latitude;
			var replon;// = position.coords.longitude;
			var gpsAccu;
			var lastAccu = 1000; //for checking if better

			var mainlat;// = document.getElementById("mainlat").value;
			var mainlon;// = document.getElementById("mainlon").value;
			var jsdistsh = document.getElementById("jsdist");

			//document.getElementById("jsdist").value = "2";

			/*/$(document).ready(function(){
				$(window).click(function(){
					getLocation();
				});
			//});*/

			function getLocation() {
				//accu = position.coords.latitude;
  				if (navigator.geolocation) {
    				navigator.geolocation.watchPosition(showPosition);
  				} else { 
    				x.innerHTML = "Geolocation is not supported by this browser.";
				}
			}
    
			function showPosition(position) {
    			//if ( position.coords.accuracy < lastAccu ){
				
					x.value = position.coords.latitude;
					z.value = position.coords.longitude;
					lastAccu = position.coords.accuracy;
					y.value = Math.round(position.coords.accuracy) + "m";
					replat = position.coords.latitude;
					replon = position.coords.longitude;
					gpsAccu = position.coords.accuracy;
					mainlat = document.getElementById("mainlat").value;
					mainlon = document.getElementById("mainlon").value;

					var R = 6371; // km
					var dLat = toRad(replat - mainlat);
					var dLon = toRad(replon - mainlon);
					var lat1 = toRad(mainlat);
					var lat2 = toRad(replat);
					var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
					var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
					var d = R * c;
					var dist = d.toFixed(2);
					jsdistsh.value = dist + " Km";
					//jsdistsh.value = mainlat+"/"+mainlon+"/"+replat+"/"+replon;


					if ( d > 0.01 && d < 1.00 ){ // 10m & 1km
						document.getElementById("forcoordupd").innerHTML = 'Use Client\'s Main Coordinates?*<br><input type="radio" name="tomaincoords" value="yes" checked> Yes &emsp; <input type="radio" name="tomaincoords" value="no" required > No<br>';
					}
					if ( d > 0.20 ){ // 200m
						if ( gpsAccu <= 50 ){
							document.getElementById("setmaincoord").innerHTML = '<p>Set This As Client\'s Main Coordinates?*<br><input type="radio" name="newcpyloc" value="yes"> Yes &emsp; <input type="radio" name="newcpyloc" value="no" required checked> No</p>';
						}
						else {
							document.getElementById("setmaincoord").innerHTML = '<p>Set This As Client\'s Main Coordinates?*<br>(Require 50m Accuracy)</p>';
						}
					}
					$('#submitarea').show();
				//}
				// https://developer.mozilla.org/en-US/docs/Web/API/GeolocationCoordinates
				//else {
					/*
					if ( !x.value || !!x.value || x.value == '' || x.value == null ){
						$('#submitarea').hide();
						z.value = "empty";
					}
					else {
						$('#submitarea').show();
						
					}
					//x.value = "Please wait";
					//z.value = "Better GPS accuracy required";
					y.value = Math.round(position.coords.accuracy) + "m";
					*/
				//}
			}

			// Converts numeric degrees to radians
			function toRad(Value) {
				return Value * Math.PI / 180;
			}

			$('#contactSelect').bind('change', function(event){
				var contactid = $('#contactSelect').val();
				$.ajax({
					data: $(this).serialize(),
					type: $(this).attr('method'),
					url: '/rep/clientcontactdetails.php?id=' + contactid,
					success: function(response) {
						//$("#setl4").show();
						$('#clientContactDetails').show().html(response);
						//$('#setAv').show();
					}
				});
				return false;

				if (i=="createnewcontact") {
					$('#newcontact').show();
				}
				else {
					$('#newcontact').hide();
				}
			});

			function showNewContact(){
				$('#newcontact').show();
			}

			/*
			function showQuote(){
				$('#doquote').toggle(doQuote());
			}
			*/
			$('#requote').click(function(){
				$('#requote').hide();
				$('#shquote').show();
				$("#doquote").load("repquote.php");
			});
			$('#shquote').click(function(){
				$('#shquote').hide();
				$('#requote').show();
				$("#doquote").load("empty.php");
			});

			/*$('#yquot').bind('change', function(){
				var sQ = $(this).val();
				if ( sQ == "yes" ){
					doQuote();
				}
			}*/

			function doQuote(){
				$("#doquote").load("repquote.php");
			}

			$(function() {
				$( "#hubtown" ).keypress().autocomplete({
					source: "getarea.php",
					minLength: 3
				});
			});


			/*
			function getHubRegion(){
				var provin = $('#provin').val();
				$.ajax({
					type: 'POST',
					url: '',
					success: function(response) {
                        $('#results').html(response);
                    }
                });
                return false;
			}

			function getHubRegion(){
				var provin = $("#provin").val();
				var region = $("#region").val();
				var hbarea = $("#hbarea").val();
				var dataString = 'provin=' + provin + '&region=' + region + '&hbarea=' + hbarea;
				$.ajax({
					data: dataString,
					type: "POST",
					url: "/rep/gethubs.php",
					success: function(response) {
						//$('#infobox').html(dataString);
						$('#shwHubReg').html(response);
					},
					error: function(response){
						alert("An error occured: " + response.status + " " + response.statusText);
					}
				});
				return false;
			}
			
			function getHubArea(){
				var eID = document.getElementById("hubreg");
				var eIDval = eID.options[eID.selectedIndex].value;
				var provin = $("#provin").val();
				var region = $("#region").val();
				var hbarea = $("#hbarea").val();
				var dataString = 'provin=' + provin + '&region=' + eIDval + '&hbarea=' + hbarea;
				$.ajax({
					data: dataString,
					type: "POST",
					url: "/rep/getarea.php",
					success: function(response) {
						//$('#infobox').html(dataString);
						$('#shwHubAre').html(response);
					},
					error: function(response){
						alert("An error occured: " + response.status + " " + response.statusText);
					}
				});
				return false;
			}

			$(document).ready(function(){
				getHubRegion();
				//getHubArea();
			});

			$('#provin').bind('change', function(){
				getHubRegion();
			});

			/*$('#hubreg').bind('change', function(){
				getHubArea();
			});*/

        </script>
	
		<?php
		mysqli_close($dbcon);
	}
	?>
    </body>
	</html>
	<?php
}
?>