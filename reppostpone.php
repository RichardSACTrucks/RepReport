	<?php

		/*************************************************************************
	*   Program ID:
	*   Program Desc:
	*   Author:
	*   Date created:
	*   Project ID:
	*
	*   ==========  =========== ============================================
	*   2022/06/15  KEVIN       Maintenance
	*
	*************************************************************************/
	// Initiat Session/s - $_SESSION
	session_start();

	// Include Assets - Database Connection Master
	include '../globals/dbcon.inc';
	include 'includes/log.inc';

	$dir = dirname($_SERVER['PHP_SELF']);
	/************************************************************************/

// GETS THE LOGGED IN USERS DETAILS
	// GETS THE LOGGED IN USERS ID
	$srid = $_SESSION['sacmr'];

	// GESTS THE DATA FOR THE LOGGED IN USER
	$sql = "SELECT 
		    ucode,
			name,
			branch 
			FROM sacstaff 
			WHERE id = '$srid' 
			LIMIT 1;";

	// POPULATES VAR WITH SELECT STATEMENT AND DATA CONNECTOR
	$qry = mysqli_query      ($dbcon,$sql);
	$row = mysqli_fetch_assoc($qry       );

	// POPUALTES VARS WITH USER DATA
	$rucode = $row['ucode' ];
	$repnam = $row['name'  ];
	$branch = $row['branch'];

// IF NO BRANCH FOR USERS
	// IF NO BRANCH IS FOUND FOR THE LOGGED IN USER EXIT!!
	if ( empty($branch) )
	{
		$_SESSION       = array();
		session_destroy        ();

		header("location: $dir/index.php");

		exit;
	}

// IF BRANCH IS FOUND
	else 
	{
		require_once 'includes/html-head.html';

		// GET COMPANY AND SESSION ID
		$checksession = $_SESSION['sacmr'  ];
		$cpyid        = $_REQUEST['cpyid'  ];
		$company      = $_REQUEST['company'];

		// SELECT THE CLIENT DETAILS BASED OF THE COMPANY
		$sql = "SELECT 
				company_name     ,
				account_nr       ,
				physical_street  ,
				physical_town    ,
				physical_province,
				client_rating 
				FROM 
				clients_main 
				WHERE id              = '$cpyid'
				AND   assigned_branch = '$branch' 
				LIMIT 1;";
			
			// IF THE SELECTS STATEMENT EXECUTES SUCCESSFULLY
			if ( $qry = mysqli_query($dbcon,$sql) )
			{
				$num = mysqli_num_rows($qry);

				if ( $num > 0 )
				{
					$row = mysqli_fetch_assoc($qry);

					$company = $row['company_name'];
					$acnr    = $row['account_nr'  ];

					$pa_street = $row['physical_street'  ];
					$pa_town   = $row['physical_town'    ];
					$pa_prov   = $row['physical_province'];
					$rating    = $row['client_rating'    ];

					// SEARCHES FOR PREVIOS VISITS
					$sql1 = "SELECT count(id) 
							 AS amount 
							 FROM clients_repvisits 
							 WHERE clients_main_id = '$cpyid' 
							 LIMIT 1;";

					$qry1 = mysqli_query      ($dbcon,$sql1)          ;
					$num1 = mysqli_fetch_assoc($qry1       )['amount'];

					// IF A PREVIOS VISIT FOUND 
					if ( $num1 > 0 )
					{
						$previsits = "yes";
					}

					$sql1 = ""; $qry1 = "";
				}
			}
			// IF THE QRY THAT SELECT THE CLIENT DETIALS FAILED
			else 
			{
				echo "Error 1: " . mysqli_error($dbcon);
				echo "Company details cannot be found.";
			}
	?>
<!-- THE FORM -->
			<form class	="" action	="repconfirm.php" method	="post">

	<?php 
				// IF COMPANY ID FOUND
				if(!empty($cpyid))
				{ 
					echo '<input type="hidden" name="cmpyid" value="'.$cpyid.'" >'; 
				} 
	?>
				<input	name="branch" 
						type="hidden" 
						value="<?php echo $branch; ?>" 
						readonly> 

				<input 	name="rucode" 
						type="hidden" 
						value="<?php echo $rucode; ?>" >

				<section>
					<h3>
	<?php 				// DISPLAY THE COMPANY NAME IN THE HEADER IF ACCOUNT NUMBER NOT FOUND
						if ( $acnr != '' )
						{ 
							echo "$company <br><i>Account Nr: $acnr</i>"; 
						} 

						else 
						{
							 echo $company; 
						} 
	?>
					</h3>
				</section>

				<h2 id="cmpydets">COMPANY DETAILS</h2>

				<section>
					<input 	type			="hidden" 
							name			="compni" 
	<?php 					if( !empty($company) )
							{ 
								echo 'value="'.$company.'"'; 
							} 
	?> 						autocomplete	="off" 
							autocapitalize	=off 
							required ></p>

					<p>Physical Street Address:*<input name="pstree" type="text" rows="3" cols="28" rows="5" required value="<?php if(!empty($pa_street)){ echo $pa_street; } ?>" ></p>
					<label>Physical Town Address:*</label><br><input name="ptownl" type="text" required value="<?php if(!empty($pa_town)){ echo $pa_town; } ?>" >
			
					<label>Physical Province:*</label><br>
					<select name="provin" required>
						<option value="Gauteng"        <?php if( $pa_prov == "Gauteng"        ){ echo "selected"; } ?> >Gauteng              </option>
						<option value="Western Cape"   <?php if( $pa_prov == "Western Cape"   ){ echo "selected"; } ?> >Western    Cape      </option>
						<option value="Limpopo"        <?php if( $pa_prov == "Limpopo"        ){ echo "selected"; } ?> >Limpopo              </option>
						<option value="Kwa-Zulu Natal" <?php if( $pa_prov == "Kwa-Zulu Natal" ){ echo "selected"; } ?> >Kwa       -Zulu Natal</option>
						<option value="North West"     <?php if( $pa_prov == "North West"     ){ echo "selected"; } ?> >North      West      </option>
						<option value="Mpumalanga"     <?php if( $pa_prov == "Mpumalanga"     ){ echo "selected"; } ?> >Mpumalanga           </option>
						<option value="Freestate"      <?php if( $pa_prov == "Freestate"      ){ echo "selected"; } ?> >Freestate            </option>
						<option value="Eastern Cape"   <?php if( $pa_prov == "Eastern Cape"   ){ echo "selected"; } ?> >Eastern    Cape      </option>
						<option value="Northern Cape"  <?php if( $pa_prov == "Northern Cape"  ){ echo "selected"; } ?> >Northern   Cape      </option>
					</select>

					<p>Client Rating:*
						<select name="rating" required>
							<option value="null"      <?php if ( empty($rating)               ){ echo "selected"; } ?> disabled >Please  Select Clients Rating</option>
							<option value="very good" <?php if (       $rating == "very good" ){ echo "selected"; } ?>          >Very    Good                 </option>
							<option value="good"      <?php if (       $rating == "good"      ){ echo "selected"; } ?>          >Good                         </option>
							<option value="average"   <?php if (       $rating == "average"   ){ echo "selected"; } ?>          >Average                      </option>
							<option value="bad"       <?php if (       $rating == "bad"       ){ echo "selected"; } ?>          >Bad                          </option>
						</select>
					</p>

				</section>

				<div class="h32"></div>
				<h2 id="visinote">POSTPONE VISIT</h2>
				<section>

	<?php
					$qry2 = mysqli_query($dbcon,"SELECT clients_previsit_note FROM clients_notes WHERE clients_main_id = '$cpyid' LIMIT 1;");
					$pvnote = mysqli_fetch_assoc($qry2)['clients_previsit_note'];
	?>

					Pre-Visit Notes<textarea name="prvino" readonly><?php echo $pvnote; ?></textarea>

					<p>Postpone Notes:*<textarea name="rnotes" type="text" rows="3" cols="28" rows="5" maxlength="255" placeholder="Whom came to visit and reason for postponement" required><?php if ( !empty($cmment) ){ echo $cmment; } ?></textarea></p>

					<p>Latitude:*<input name="replat" type="text" id="lat" required onclick="getLocation()" onfocus="getLocation()" ><br>
					Longitude:*<input name="replon" type="text" id="long" required onclick="getLocation()" ><br>
					<i>GPS Accuracy:<input name="accura" type="text" id="accu" readonly></i><br>
	<?php

					if ( $rucode === "ts001" )
					{
						$qry0 = mysqli_query($dbcon,"SELECT physical_latitude,physical_longitude FROM clients_main WHERE id = '$cpyid' LIMIT 1;");
						if ( $row0 = mysqli_fetch_assoc($qry0) )
						{
							$hasmain =       "1"                  ;
							$mainlat = $row0['physical_latitude' ];
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
				<section>
					<div id="allowSubmit"></div>
					<button type="submit" name="visit" value="postpone">Postpone</button>
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
					
					$qry3 = mysqli_query   ($dbcon,$sql3);
					$num3 = mysqli_num_rows($qry3       );

					if ( $num3 > 0 )
					{
						echo "<h3>Previous Visits</h3>";
						while ( $row3 = mysqli_fetch_assoc($qry3) )
						{

							$vstime = $row3['time_visited'];
							$repcod = $row3['ucode'       ];

							$sql = "SELECT name,surname FROM sacstaff WHERE ucode = '$repcod' LIMIT 1;";

							$qry = mysqli_query      ($dbcon,$sql);
							$row = mysqli_fetch_assoc($qry       );

							$repnam = $row ['name'        ];
							$repsur = $row ['surname'     ];
							$contac = $row3['contact_name'];
					
							$quoter = $row3['request_quote']; if ( $quoter == "1" ){ $quoter = '<b><span class="fntblk">Yes</span></b>'; } else { $quoter = "No"; }
							$happyc = $row3['contact_happy']; if ( $happyc == "1" ){ $happyc = "<b>Yes</b>"; } else { $happyc = '<b><span class="fntred">No</span></b>'; }
							$rnotes = $row3['rep_notes'    ];
							$replat = $row3['rep_latitude' ];
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
				var x = document.getElementById("lat" );
				var z = document.getElementById("long");
				var y = document.getElementById("accu");

				var replat ;
				var replon ;
				var gpsAccu;

				var mainlat                                     ;
				var mainlon                                     ;
				var jsdistsh = document.getElementById("jsdist");

				function getLocation() 
				{
					//accu = position.coords.latitude;
					if (navigator.geolocation) 
					{
						navigator.geolocation.watchPosition(showPosition);
					}
					else 
					{ 
						x.innerHTML = "Geolocation is not supported by this browser.";
					}
				}
		
				function showPosition(position) 
				{
					x.value = position.coords.latitude;
					z.value = position.coords.longitude;
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

					if ( d > 0.01 && d < 1.00 )
					{ // 10m & 1km
						document.getElementById("forcoordupd").innerHTML = 'Use Client\'s Main Coordinates?*<br><input type="radio" name="tomaincoords" value="yes" checked> Yes &emsp; <input type="radio" name="tomaincoords" value="no" required > No<br>';
					}
					if ( d > 0.20 )
					{ // 200m
						if ( gpsAccu <= 50 )
						{
							document.getElementById("setmaincoord").innerHTML = '<p>Set This As Client\'s Main Coordinates?*<br><input type="radio" name="newcpyloc" value="yes"> Yes &emsp; <input type="radio" name="newcpyloc" value="no" required checked> No</p>';
						}

						else 
						{
							document.getElementById("setmaincoord").innerHTML = '<p>Set This As Client\'s Main Coordinates?*<br>(Require 50m Accuracy)</p>';
						}
					}
				}

				// Converts numeric degrees to radians
				function toRad(Value) 
				{
					return Value * Math.PI / 180;
				}

				$('#contactSelect').bind('change', function(event){
					var contactid = $('#contactSelect').val();
					$.ajax({
						data: $(this).serialize(),
						type: $(this).attr('method'),
						url: '/rep/clientcontactdetails.php?id=' + contactid,
						success: function(response) 
						{
			
							$('#clientContactDetails').show().html(response);
	
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

				function doQuote(){
					$("#doquote").load("repquote.php");
				}
			</script>
		
			<?php
			mysqli_close($dbcon);

			?>
		</body>
		</html>
		<?php
	}
	?>