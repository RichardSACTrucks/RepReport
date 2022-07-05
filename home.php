<!-- KEVIN PHILLIP ALERS  -->

    <?php
// ===========================================================================================================================================
//                                                          IMPORTS INCLUDES
// ===========================================================================================================================================   
    session_start();
    $dir = 'https://sacmarketing.co.za/rep/';
// ============================================================================================================================================
//                                                      IF SESSION EMPTY EXIT
// ============================================================================================================================================
    if(empty($_GET['status']))
    {
        header("location:$dir/home.php?status=1");
        exit;
    }
    
// ============================================================================================================================================
//                                                     IF SESSION IS SACMR TRUE
// ============================================================================================================================================
    if ( isset($_SESSION['sacmr']) )
    {
        // -------------------------
        // - REQUIRES AND INCLUDES -
        // -------------------------

        // CURRENT TIME
        $timenow = date('Y-m-d H:i:s');

        // DBCON NON WRITE
        require_once "../globals/dbcon.inc";
        
        // provides $ucode $userlevel $userbranch
        require_once "includes/log.inc"; 

// ============================================================================================================================================
//                                                     SELECTS THE REPS DETAILS
// ============================================================================================================================================
        $stmt = $dbcon->prepare("SELECT 
                                name,surname,
                                branch,
                                ucode 
                                FROM sacstaff 
                                WHERE id = ? LIMIT 1;");
// ============================================================================================================================================
//                                                     ADDS db DATA TO LOCAL VARS
// ============================================================================================================================================
        $stmt->bind_param("i", $srid);
        $srid = $dbcon -> real_escape_string($_SESSION['sacmr']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $repnam = $row['name'];
        $repsur = $row['surname'];
        $branch = $row['branch'];
        $ucode  = $row['ucode'];

        $stmt->close();

        //echo "<p>$repnam $repsur ($branch) $ucode</p>";
// ============================================================================================================================================
//                                                    IF USER HAS NO BRANCH = EXIT
// ============================================================================================================================================
        if ( empty($branch) )
        {
            $_SESSION = array();
            session_destroy();
            header("location: $dir/index.php");
            exit;
        }
// ============================================================================================================================================
//                                                       IF COMPANY FOUND
// ============================================================================================================================================
        else if ( isset($_REQUEST['cpyid']) || isset($_REQUEST['company']) )
        {
            require_once 'includes/html-head.html';
    ?>

            <section>

    <?php

        // IF VARIABLE IS NULL SET $MSG TO 'MESSAGE'
        if ( isset($_GET['message']) )
        {
            $msg = $_GET['message']; 
        }

        // ECHO MESSAGE
        if ( $msg != "" || !empty($msg) )
        { 
            echo "<p><b><i>$msg</i></b></p>"; 
        }
    
        // SETS LOCAL VARS USED FOR LOCATION TO THOSE IN SESSION (LAT AND LONG)
        $lat = $_COOKIE['lat'];
        $lng = $_COOKIE['lng'];

        // IF LAT AND LONG NOT FOUND ECHO OUT THIS MESSAGE
        if ( $lat == "" || empty($lat)  )
        {
            echo '<p><b>Please turn on your GPS Location Services</b></p><p><a href="https://sacmarketing.co.za'.$dir.'/home.php"><button>Test Again</button></a>';
        }
        
        // IF LAT AND LONG FOUND
        else 
        {
// ============================================================================================================================================
//                                                      FETCH COMAPANY DETAILS                  
// ============================================================================================================================================
            // IF COMAPNY ID IS SET
            if ( isset($_REQUEST['cpyid']) )
            { 
                $cpyid = mysqli_real_escape_string($dbcon,trim($_REQUEST['cpyid']));

                $stmt = $dbcon->prepare("SELECT 
                                        id,
                                        company_name,
                                        account_nr,
                                        physical_street,
                                        physical_town,
                                        physical_province,
                                        physical_latitude,
                                        physical_longitude 
                                        FROM clients_main 
                                        WHERE id = ? 
                                        LIMIT 1;
                                        ");

                    $stmt->bind_param("i", $cpyid);   
            }
// ============================================================================================================================================
//                                                   SELECT COMPANY (clients_main)
// ============================================================================================================================================
            // IF NO ID FOUND SEARCH FOR COMPANY NAME
            else if ( isset($_REQUEST['company']) )
            {
                $compny = mysqli_real_escape_string($dbcon,trim($_REQUEST['company']));
                $stmt = $dbcon->prepare("SELECT 
                                        id,
                                        company_name,
                                        account_nr,
                                        physical_street,
                                        physical_town,
                                        physical_province,
                                        physical_latitude,
                                        physical_longitude 
                                        FROM clients_main 
                                        WHERE company_name = ? 
                                        AND assigned_branch = ? 
                                        LIMIT 1;
                                        ");

                $stmt->bind_param("ss", $compny, $branch);
            }
// ============================================================================================================================================
//                                                  INSERT COMPANY DATA INTO LOCAL VARS
// ============================================================================================================================================
            $stmt   ->execute();
            $result0 = $stmt->get_result();
            $row0    = $result0->fetch_assoc();

            $cpyid  = $row0['id']                ;
            $compny = $row0['company_name']      ;
            $acnr   = $row0['account_nr']        ;
            $pstr   = $row0['physical_street']   ;
            $ptow   = $row0['physical_town']     ;
            $ppro   = $row0['physical_province'] ;
            $plat   = $row0['physical_latitude'] ;
            $plon   = $row0['physical_longitude'];
            $stmt  -> close()                    ;
// ============================================================================================================================================
//                                                       DO CHECK ON DATA
// ============================================================================================================================================
            // IF PLAT (physical_latitude) AND PLON (physical_longitude)
            // IS NOT NULL. THEN VIEWMAPS EQUAL TO PLAT AND PLON OF THE CLIENT
            if ( $plat != '' && $plon != '' )
            { 
                $viewmaps = '<a href="https://maps.google.com/?q='.$plat.','.$plon.'" target="_blank"><button>View on Google Maps</button><a/></p>'; 
            } 

            // ELSE VIEWMAPS == NULL
            else 
            { 
                $viewmaps = ''; 
            }

            // COMAPANY NAME TO UPPERCASE
            if ( $compny == '' )
            { 
                $compny = strtoupper($_POST['company']); 
            }
    ?>
            <h3>
    <?php 
            // IF ACCOUNT NUMBER IS NOT NULL
            // ECHO ACOUNT NUMBER
            if ( $acnr != '' )
            { 
                echo "$compny<br><i>Account Nr: $acnr</i>"; 
            } 
            // IF NO ACC NUM ECHO COMPANY NAME
            else 
            { 
                echo $compny; 
            } 
    ?>
            </h3>
    <?php 
            // IF physical_street NOT NULL ECHO 
            // physical_street,physical_town AND physical_province
            if ( $pstr != '' )
            { 
                echo "<p>$pstr, $ptow<br>$ppro<br>"; 
            } 
            // IF physical_street NULL ECHO 
            // physical_town AND physical_province

            else 
            { 
                echo "$ptow<br>$ppro<br>"; 
            } 
    ?>

    <?php
            echo '<div class="h8"></div>';

            // ECHO viewmaps
            echo $viewmaps;
// ============================================================================================================================================
//                                                  SELECTS NOTES (clients_notes)   
// ============================================================================================================================================
            $stmt = $dbcon->prepare("SELECT 
                                    clients_previsit_note 
                                    FROM clients_notes 
                                    WHERE clients_main_id = ? 
                                    LIMIT 1;
                                    ");

                      $stmt->bind_param("i", $cpyid);
                      $stmt->execute   (           );
            $result = $stmt->get_result(           );
// ============================================================================================================================================
//                                           INSERT DATA INTO LOCAL VARS pre-visit notes
// ===========================================================================================================================================
            // IF RESULT FOUND POPULATE PVNOTE WITH clients_previsit_note
            if ( $result->num_rows > 0 )
            {
                /*while (*/ $row = $result->fetch_assoc() ;/*){*/
                $pvnote = $row['clients_previsit_note'];
                //}
            }

            // ELSE SET PVNOTE TO NULL
            else 
            {
                //echo '<textarea id="pvnote" name="pvnot" placeholder="Pre-visit notes for use by the rep."></textarea>';
                $pvnote = "";
            }

            // CLOSE CONNECTION
            $stmt->close();

            // ECHO TEXTBOX FOR PRE VISIT NOTES
            echo '<textarea id="pvnote" name="pvnote" placeholder="Pre-visit notes for use by the rep" >'.$pvnote.'</textarea>';
    ?>
<!-- ========================================================================================================================================= -->
<!--                                                                                                                                           -->
<!-- ========================================================================================================================================= -->
            <!--textarea name="ovalnt" placeholder="Overall notes to know about the company, like, Buyer on leave until mid august"></textarea-->
            <!--div id="saved" style="display:none"></div-->
            
            <div id="test"></div>
            <!--div class="h16"></div>
            Action Buttons:<br>
            <button>Pre-Visit Notes</button><br-->
            <!--form action="repreport.php" method="post">
                <input type="hidden" name="cpyid" value="<?php echo $cpyid; ?>">
                <input type="hidden" name="company" value="<?php echo $compny; ?>">
                <input type="hidden" name="branch" value="<?php echo $branch; ?>">
                <button type="submit">Log New Visit</button>
            </form-->

<!-- ========================================================================================================================================= -->
<!--                                                        REPORT 5                                                                           -->
<!-- ========================================================================================================================================= -->
            <form action     = "repreport-5.php" method="post">

                <input type  = "hidden" name ="cpyid"   value ="<?php echo $cpyid; ?>">
                <input type  = "hidden" name ="company" value ="<?php echo $compny; ?>">
                <input type  = "hidden" name ="branch"  value ="<?php echo $branch; ?>">

                <button type = "submit">Log New Visit </button>
            </form>

<!-- ========================================================================================================================================= -->
<!--                                                     REPREPORT (TEST)                                                                      -->
<!-- ========================================================================================================================================= -->
    <?php
            // UCODE 'TS001 IS THE TEST ACCOUNT'
            if ($ucode == 'ts001')
            { 
    ?>
                <!-- REPREPORT -->
                <form action = "repreport.php" method = "post">

                    <input  type ="hidden" name = "cpyid"   value = "<?php echo $cpyid; ?>">
                    <input  type ="hidden" name = "company" value = "<?php echo $compny; ?>">
                    <input  type ="hidden" name = "branch"  value = "<?php echo $branch; ?>">

                    <button type = "submit">Log New Visit</button>
                </form


                <form action = "repreport-2.php" method = "post">
                    <input type = "hidden" name = "cpyid"   value = "<?php echo $cpyid; ?>">
                    <input type = "hidden" name = "company" value = "<?php echo $compny; ?>">
                    <input type = "hidden" name = "branch"  value = "<?php echo $branch; ?>">

                    <button type = "submit">Log New Visit 2</button>

                </form

                <form action = "repreport-3.php" method = "post">

                    <input type = "hidden" name = "cpyid"   value = "<?php echo $cpyid; ?>">
                    <input type = "hidden" name = "company" value = "<?php echo $compny; ?>">
                    <input type = "hidden" name = "branch"  value = "<?php echo $branch; ?>">

                    <button type = "submit">Log New Visit 3</button>

                </form

                <form action = "repreport-6.php" method = "post">

                    <input type = "hidden" name = "cpyid"   value = "<?php echo $cpyid; ?>">
                    <input type = "hidden" name = "company" value = "<?php echo $compny; ?>">
                    <input type = "hidden" name = "branch"  value = "<?php echo $branch; ?>">

                    <button type = "submit">Log New Visit 6</button>

                </form>
    <?php
            }
    ?>

<!-- ============================================================================================================================== -->
<!--                                                        EUROL VISIT                                                             -->
<!-- ============================================================================================================================== -->
    <?php

        if ($ucode == 'ak002' OR $ucode == 'kp001')
        { 
    ?>
            <form action = "eurol-visit.php" method = "post">

                <input type = "hidden" name = "cpyid"   value = "<?php echo $cpyid; ?>">
                <input type = "hidden" name = "company" value = "<?php echo $compny; ?>">
                <input type = "hidden" name = "branch"  value = "<?php echo $branch; ?>">
                
                <button style="background-color:cornflowerblue" type = "submit">EUROL VISIT</button>

            </form>
    <?php
        }
    ?>
<!-- ========================================================================================================================================= -->
<!--                                                        POSTPONE                                                                           -->
<!-- ========================================================================================================================================= -->
                <form action = "reppostpone.php" method = "post">

                    <input type = "hidden" name = "cpyid"   value = "<?php echo $cpyid; ?>">
                    <input type = "hidden" name = "company" value = "<?php echo $compny; ?>">
                    <input type = "hidden" name = "branch"  value = "<?php echo $branch; ?>">

                    <button type = "submit">Postpone Visit</button>

                </form>
                                
<!-- ========================================================================================================================================= -->
<!--                                                        SERVICE CALL                                                                       -->
<!-- ========================================================================================================================================= -->
                
                <form action = "repservicecall.php" method = "post">

                    <input type = "hidden" name = "cpyid"   value = "<?php echo $cpyid; ?>">
                    <input type = "hidden" name = "company" value = "<?php echo $compny; ?>">
                    <input type = "hidden" name = "branch"  value = "<?php echo $branch; ?>">

                    <button type = "submit">Service Call</button>
                    
                </form>             
                
                <!-- SPACER -->
                <div class="h32"></div>

                <!-- INFORMATION HEADER -->
                Information:<br>
<!-- ========================================================================================================================================= -->
<!--                                                   20 FACTORIES QLICK                                                                      -->
<!-- ========================================================================================================================================= -->
    <?php
                //if ( $ucode == ""){}
                if ( $acnr != '' )
                {
    ?>
                    <!--a href="https://www.sacqlikview.com/QvAJAXZfc/opendoc.htm?document=trucks%5Csac%20trucks.qvw&lang=en-US&host=QVS%40qvs-srv&sheet=SH78&select=LB1147,<?php echo $acnr; ?>" target="_blank"><button>20 Factories</button></a><br-->
                    <a href="https://sacqlikview.com/QvAJAXZfc/opendoc.htm?document=trucks%5Csac%20trucks.qvw&lang=en-US&host=QVS%40qvs-srv&sheet=SH78&select=LB1147,<?php echo $acnr; ?>" target="_blank"><button>20 Factories</button></a><br>
    <?php 
                } 
    ?>
<!-- ========================================================================================================================================= -->
<!--                                                        BUTTONS                                                                            -->
<!-- ========================================================================================================================================= -->
                <a href="<?php echo 'inforeport.php?branch='.$branch.'&company='.$cpyid.'&info=cpy'; ?>"><button>View Company Details</button></a><br>
    <?php 
                $num = mysqli_fetch_assoc(mysqli_query($dbcon,"SELECT 
                                                               COUNT(id) AS num 
                                                               FROM clients_contacts 
                                                               WHERE clients_main_id = '$cpyid' 
                                                               LIMIT 1;"))['num'];

                // IF RESULTS RETURN DISPLAY View Contacts BTN
                if ( $num > 0 )
                { 
                    // View Contacts BTN
                    echo '<a href="inforeport.php?branch='.$branch.'&company='.$cpyid.'&info=cct"><button>View Contacts</button></a><br>'; 
                }
    ?>
                <!-- VIEW VEHICLES BTN -->
                <a href="<?php echo 'inforeport.php?branch='.$branch.'&company='.$cpyid.'&info=veh'; ?>"><button>View Vehicles</button></a><br>
                
    <?php
                $num = mysqli_fetch_assoc(mysqli_query($dbcon,"SELECT
                                                               COUNT(id) 
                                                               AS num 
                                                               FROM clients_repvisits 
                                                               WHERE clients_main_id = '$cpyid' 
                                                               LIMIT 1;"))['num'];

                if ( $num > 0 )
                {
                    // COMMENTS AND NOTES 
                    echo '<a href="inforeport.php?branch='.$branch.'&company='.$cpyid.'&info=vsd"><button>Previous Visit Dates</button></a><br>';
                    echo '<a href="inforeport.php?branch='.$branch.'&company='.$cpyid.'&info=vsn"><button>Notes From Previous Visits</button></a><br>'; 
                }
    ?>  
                <div class="h32"></div>
                <a href="home.php"><button>Back</button></a>
    <?php   
        }
    ?>
<!-- ========================================================================================================================================= -->
<!--                                                        SCRIPT                                                                             -->
<!-- ========================================================================================================================================= -->
            <p>&nbsp;</p>
            <script type="text/javascript">

                // AUTOCOMPLETE CLIENT FROM gethint.php
                $(function() 
                {
                    $( "#hint" ).keypress().autocomplete
                    ({
                        source: "gethint.php?br=<?php echo $branch; ?>",
                        minLength: 3
                    });
                });

                $("#pvnote").on('focusout', function() 
                {
                    var pvNote = $(this).val();
                    //var oaNote = itemVal.replace(/&/g, 'and');
                    var cmpyId = <?php echo $cpyid; ?>;
                    var itemstring = "id=" + cmpyId + "&pvnote=" + pvNote;
                    //$('#test').html(itemstring + "...");
                    processChange(itemstring);
                });

                function processChange(itemstring)
                {
                    console.log(itemstring);
                    //return false;
                    $.ajax({
                        type: "POST",
                        url: "pvnote-upl.php",
                        data: itemstring,
                        complete: function(data) 
                        {
                            var Resp = data.responseText;
                            console.log(Resp);
                            //$('#saved').html(Resp);
                        },
                        success: function() 
                        {
                            $('#saved').css('display', 'block');
                            setTimeout(function() 
                            {
                                $('#saved').animate({
                                    opacity: 0,
                                }, 500, function()
                                {
                                    $('#saved').css('display', 'none').css('opacity', '1');
                                });
                            }, 1000);
                        }
                    });
                }
            </script>
        </section>

<!-- ========================================================================================================================================= -->
<!--                                                   HEADER AND FOOTER                                                                       -->
<!-- ========================================================================================================================================= -->
    <?php
        require_once 'includes/html-foot.html';
    }

    else 
    {
        require_once 'includes/html-head.html'; 
    ?>  

        <section>

    <?php
// ===========================================================================================================================================
//                                                         HEADERS
// ===========================================================================================================================================
            // HEADER DISPLAYING REP NAME
            echo "<h3>$repnam $repsur ($branch)</h3>";

            $msg = mysqli_real_escape_string($dbcon,$_GET['message']);

            if ( $msg != "" || !empty($msg) )
            { 
                echo "<p><b><i>$msg</i></b></p>"; 
            }

            // DISPLAY CLIENT LOC
            $lat = $_COOKIE['lat'];
            $lng = $_COOKIE['lng'];
            $gac = $_COOKIE['gac'];

            // IF CLIENT LOC EMPTY
            if ( $lat == "" || empty($lat))
            {
                echo '<p><b>Please turn on your GPS Location Services</b></p><p><a href="https://sacmarketing.co.za'.$dir.'/home.php"><button>Test Again</button></a>';
            }

// ===========================================================================================================================================
//                                                      REST / OTHER
// ===========================================================================================================================================
            else 
            {
                //echo  "<p>Current Coordinates: $lat, $lng</p>";
    ?>
                <!-- LOGIN IN FIELD -->
                <div class = "h32"></div>
                <form class = "" action = "repclientcheck.php" method = "post">

                    <input name = "branch" type = "hidden" value = "<?php echo $branch; ?>" >

                    <label>Company Name: </label><br>

                    <input type  = "text" id = "hint" name = "company" autocomplete = "off" autocapitalize = "characters" style = "text-transform: uppercase;" autofocus required>

                    <div class   = "h32"></div>
                    <div class   = "h16"></div>
                    <button type = "submit">Submit</button>

                </form>

                <!-- BUTTON -->
            <div class="choose_rep_class">

            <!-- REP SCHEDULE -->
            <form action="https://sacmarketing.co.za/rep/rep-schedule.php" method="POST">
                <button 
                type="submit" 
                name="submit" 
                value="Plan_Delivery" 
                style="margin-top: 10px"
                onclick="GottoPage()"> 
                &nbsp My Schedule &nbsp
                </button> 
            </form>   

            </div>

                <div class="h32"></div>

                <a href="logout.php"><button>Log Out</button></a>
                
                <div id="nearbyclients">..</div>

    <?php
                /*
                    //include_once 'nearby-clients';
                    if ( !empty($lat) && !empty($lng) )
                    {

                        $stmt = $dbcon->prepare("SELECT id,company_name, 111.045 * DEGREES(ACOS(COS(RADIANS(?)) * COS(RADIANS(physical_latitude)) * COS(RADIANS(physical_longitude) - RADIANS(?)) + SIN(RADIANS(?)) * SIN(RADIANS(physical_latitude)))) AS distance FROM clients_main WHERE assigned_branch = ? ORDER BY distance ASC LIMIT 0,10;");
                        $stmt->bind_param("ddds", $lat,$lng,$lat,$branch);

                        if ( $stmt->execute() )
                        {
                            $result = $stmt->get_result();
                            if ( $result->num_rows > 0 )
                            {
                                //echo '<p>&nbsp;</p><h3>Nearby Clients (<i><span style="font-weight:400"><span id="nearbyaccuracy"></span> m</span></i>)</h3>';
                                echo '<p>&nbsp;</p><h3>Nearby Clients</h3>';
                                while ( $row00 = $result->fetch_assoc() )
                                {
                                    $cpyid = $row00['id'];
                                    $compny = $row00['company_name'];
                                    //$branch = $row00['assigned_branch'];
                                    $dist = $row00['distance'];
                                    if ( $dist < 500 )
                                    {
                                        $dist = number_format($dist,1);
                                        echo '<a href="home.php?status=1&branch='.$branch.'&cpyid='.$cpyid.'"><div class="comps">'.$dist.' km:&emsp;'.$compny.'</div></a>';
                                    }
                                }
                            }
                        }
                        else {
                            echo "Error: " . htmlspecialchars($stmt->error);
                        }
                        $stmt->close();
                    }
                */
            }
    ?>
            <p>&nbsp;</p>

            <script>
                $(function()
                {
                    $( "#hint" ).keypress().autocomplete
                    ({
                        source: "gethint.php?br=<?php echo $branch; ?>",
                        minLength: 3
                    });
                });

                function getCookie(key) 
                {
                    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
                    return keyValue ? keyValue[2] : null;
                }

                var rla = getCookie('gac');
                
                //function checkNearby(){
                    if ( Number(rla) < 500 )
                    {
                        $('#nearbyclients').html('<?php include "nearby-clients.php"; ?>');
                    }

                    else 
                    {
                        //$('#nearbyclients').html('<div class="h32"></div>GPS Accuracy: '+rla+'m<br><a><button type="button" id="getLocBtn">Force GPS</button></a>');
                        //$('#nearbyclients').html('<div class="h32"></div>GPS Accuracy: '+rla+'m<br>');
                        $('#nearbyclients').html('<div class="h32"></div>GPS Accuracy: '+rla+'m<br><a><button type="button" id="getLocBtn">Force GPS</button></a>');
                        getLocation();
                        //checkNearby();
                        //location.reload();
                    }
                //}
                getLocation();
                //checkNearby();
                $('#getLocBtn').on("click", function()
                {
                    getLocation();
                    location.reload();
                });
            </script>
        </section>
    <?php
        require_once 'includes/html-foot.html';
        mysqli_close($dbcon);
    }
    $sql ="";

    }

    else 
    {
        header("location: $dir/index.php");
        exit;
    }
    ?>