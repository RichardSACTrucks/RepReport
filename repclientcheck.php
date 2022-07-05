<?php
session_start();
if ( $rucode === "ts001" ){
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
}

if ( isset($_SESSION['sacmr']) ){

    $timenow = date('Y-m-d H:i:s');
    $sourcip = $_SERVER['REMOTE_ADDR'];
    $root = $_SERVER['DOCUMENT_ROOT'];
    $url = $_SERVER['REQUEST_URI'];
    $srid = $_SESSION['sacmr'];
    //$dir = "/rep";
    $dir = dirname($_SERVER['PHP_SELF']);

    require_once "../globals/dbconn.inc";
    require_once 'includes/log.inc'; // PROVIDES: $userfname, $userlname, $userbranch, $usercode, $userlevel //
    //echo "<p>$repnam $repsur ($branch) $ucode</p>";


    $stmt = $dbconn->prepare("SELECT name,surname,branch,ucode,level FROM sacstaff WHERE id = ? LIMIT 1;");
    $stmt->bind_param("i", $srid);
    $srid = $dbconn-> real_escape_string($_SESSION['sacmr']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $userfname = $row['name'];
    $userlname = $row['surname'];
    $userbranch = $row['branch'];
    $usercode = $row['ucode'];
    $userlevel = $row['level'];
    $stmt->close();

    $stmt = $dbconn->prepare("INSERT INTO uselog (ucode,page,attime,source) VALUES (?, ?, NOW(), ?);");
    $stmt->bind_param("sss", $usercode,$url,$sourcip);
    $stmt->execute();
    $stmt->close();

    if ( isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' ){
        //require_once 'includes/dbconn.inc';
        $fbranch = $dbconn -> real_escape_string($_POST['branch']);
        $fcompny = $dbconn -> real_escape_string($_POST['company']); $fcompny = strtoupper($fcompny);

        if ( isset($_POST['createcpy']) && $_POST['createcpy'] === 'yes' ){

            $atlat = $dbconn -> real_escape_string($_POST['replat']); $atlat = substr($atlat,0,16);
            $atlon = $dbconn -> real_escape_string($_POST['replon']); $atlon = substr($atlon,0,16);
            //echo "<p>$fcompny,$atlat,$atlon,$fbranch</p>";
            
            // first have to get coordinates
            $sql = "INSERT INTO clients_main (account_nr,company_name,physical_street,physical_town,physical_province,physical_country,physical_code,physical_latitude,physical_longitude,delivery_street,delivery_town,delivery_province,delivery_country,delivery_code,postal_street,postal_town,postal_province,postal_country,postal_code,telnr_main,telnr_secondary,email_main,email_secondary,assigned_branch,account_type,client_rating) VALUES ('',?,'','','','','',?,?,'','','','','','','','','','','','','','',?,'','')";
            

            if ( !($stmt = $dbconn ->prepare($sql)) ){
                echo $dbconn->error;
            }
            $stmt->bind_param("ssss", $fcompny,$atlat,$atlon,$fbranch);
            if ( !($stmt->execute()) ){
                echo "ERROR: Could not add your visit.<br>".$stmt->error;
                exit;
            }
            $stmt->close();

            // get id once created
            $stmt = $dbconn->prepare("SELECT id FROM clients_main WHERE company_name = ? AND assigned_branch = ? LIMIT 1;");
            $stmt->bind_param("ss", $fcompny,$fbranch);
            $stmt->execute();
            $result = $stmt->get_result();
            if ( $result->num_rows > 0 ){
                $row = $result->fetch_assoc();
                $cpyid = $row['id'];
                header('Location: home.php?status=1&cpyid='.$cpyid);
            }
            else {
                echo "Something gone wrong, please contact the app creator";

            }
            $stmt->close();
        }
        else {
            $qry = $dbconn-> prepare("SELECT id FROM clients_main WHERE company_name = ? AND assigned_branch = ? LIMIT 1;");
            $qry-> bind_param("ss", $fcompny, $fbranch);
            $qry-> execute();
            $res = $qry-> get_result();
            if ( $res->num_rows > 0 ){
                $row = $res-> fetch_assoc();
                $cpyid = $row['id'];
                header('Location: home.php?status=1&cpyid='.$cpyid);
            }
            else {
                require_once 'includes/html-head.html';
                ?>
                <section onload="getLocation()">
                    <p><br>Client does not exist. Do you want to create new client?</p>
                    <form action="repclientcheck.php" method="post">

                        <input type="text" name="company" value="<?php echo $fcompny; ?>" readonly>
                        <input type="hidden" name="branch" value="<?php echo $fbranch; ?>">

                        <button id="checklocat" type="button">Yes, create client</button>

                        <div id="locatcheck" style="display:none">
                            
                            <input type="hidden" name="createcpy" value="yes"><input type="hidden" name="replat" id="lat" readonly ><input type="hidden" name="replon" id="long" readonly >
                            
                            <p>Are you currently at the client's premises?</p>
                            
                            <label for="accu">Current accuracy in meters (50m required): </label>
                            <input type="text" id="accu" readonly placeholder="waiting for 50m accuracy ">

                            <button type="button" id="forcegps" onclick="forceGPS()" style="display:none">Force GPS Refresh</button>
                            
                            <button id="newsubmit" type="submit" style="display:none">Yes, I'm on the premises</button>
                        
                        </div>
                        
                    </form>        
                    <p><a href="home.php?status=1"><button>No, let me search again</button></a></p>
                </section>
                <script>
                function forceGPS(){
                    getLocation();
                }

                $('#checklocat').click(function(){
                    getLocation();
                    $('#locatcheck').show();
                    $('#checklocat').hide();
                });

                var replat = $("#lat");
                var replon = $("#long");
                var repacc = $("#accu");

                while ( repacc.val() > 50 ){
                    getLocation();
                    $('#forcegps').show();

                }

                function getLocation() {
                    if (navigator.geolocation) {
                        navigator.geolocation.watchPosition(showPosition);
                    } else { 
                        x.innerHTML = "Geolocation is not supported by this browser.";
                    }
                }

                function showPosition(position) {
					replat.val(position.coords.latitude);
					replon.val(position.coords.longitude);
                    repacc.val(Math.round(position.coords.accuracy));

                    if ( position.coords.accuracy < 50 ){
                        $('#newsubmit').show();
                    }
                    else {
                        $('#newsubmit').hide();
                    }
                }
                </script>
                <?php
                require_once 'includes/html-foot.html';
            }
            $qry-> close();
        }
    }
}
$dbconn->close();
?>