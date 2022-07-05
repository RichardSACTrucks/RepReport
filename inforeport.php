    <!-- KEVIN ALERS 2021/10/13  -->
    <?php
// ==================================================================================================================
//                                              INCLUDES VARIABLES
// ==================================================================================================================
    session_start();
    $dir = dirname($_SERVER['PHP_SELF']);
    include '../globals/dbcon.inc';
    //$rid = $_COOKIE['sacmr'];
    $srid = $_SESSION['sacmr'];
// ==================================================================================================================
//                                                  SELECT USER
// ==================================================================================================================
    //$sql = "SELECT name,branch FROM sacstaff WHERE id = '$rid' LIMIT 1;";

    // SELETC UCODE AND BRANCH WHERE THEY ARE === TO SESSION ROW ID
    $sql = "SELECT 
            ucode,
            name,
            branch 
            FROM 
            sacstaff 
            WHERE 
            id = '$srid' 
            LIMIT 1;";

    // QRY BUILDER
    $qry = mysqli_query($dbcon,$sql);
    $row = mysqli_fetch_assoc($qry);

    // VARIABLES
    $rucode = $row['ucode'];
    $repnam = $row['name'];
    $branch = $row['branch'];

    //echo "<p>r: $rid, ".$_COOKIE['sacmr']."</p>";
    //echo "<p>branch: $branch, $repnam</p>";

    if ( empty($branch) )
    {
        $_SESSION = array();
        session_destroy();
        header("location: $dir/index.php");
        exit;
    }
    else 
    {
    	require_once 'includes/html-head.html';
    	?>
    		<?php
    		$checksession = $_SESSION['sacmr'];
    		//echo "<p><b>session: $checksession</b></p>";
    		$branch = $_REQUEST['branch'];
            $cpyid = $_REQUEST['company'];
            $info = $_REQUEST['info'];

    		$sql = "SELECT 
                    company_name,
                    account_nr 
                    FROM 
                    clients_main 
                    WHERE 
                    id = '$cpyid' 
                    AND 
                    assigned_branch = '$branch' 
                    LIMIT 1;";

    		if ( $qry = mysqli_query($dbcon,$sql) )
            {
    			$num = mysqli_num_rows($qry);
    			if ( $num > 0 )
                {
                    $row = mysqli_fetch_assoc($qry);
                    $company = $row['company_name'];
    				$acnr = $row['account_nr'];

    				$sql1 = "SELECT count(id) AS amount FROM clients_repvisits WHERE clients_main_id = '$cpyid' LIMIT 1;";
    				$qry1 = mysqli_query($dbcon,$sql1);
    				$num1 = mysqli_fetch_assoc($qry1)['amount'];
    				if ( $num1 > 0 )
                    {
    					$previsits = "yes";
    				}
    				$sql1 = ""; $qry1 = "";
    			}
    		}
    		else 
            {
    			echo "Error 1: " . mysqli_error($dbcon);
    			echo "Company details cannot be found.";
    		}
    		?>

    		<section><h3><?php if ( $acnr != '' ){ echo "$company ($acnr)"; } else { echo $company; } ?></h3></section>

            <?php
            if ( $info === "cpy" )
            { 
                $sql = "SELECT physical_street,physical_town,physical_province,physical_latitude,physical_longitude,client_rating FROM clients_main WHERE id = '$cpyid' LIMIT 1;";
                $qry = mysqli_query($dbcon,$sql);
                $row = mysqli_fetch_assoc($qry);
                $pa_street = $row['physical_street'];
                $pa_town = $row['physical_town'];
                $pa_prov = $row['physical_province'];
                $pa_lati = $row['physical_latitude'];
                $pa_long = $row['physical_longitude'];
                $rating = $row['client_rating'];
                ?>

                <h2>COMPANY DETAILS</h2>

    			<section>
    				<label>Physical Street Address:</label><input type="text" value="<?php echo $pa_street; ?>" readonly>
    				<label>Physical Town Address:</label><input type="text" value="<?php echo $pa_town; ?>" readonly>
    				<label>Physical Province:</label><input type="text" value="<?php echo $pa_prov; ?>" readonly>
    				<label>Latitude:</label><input type="text" value="<?php echo $pa_lati; ?>" readonly>
    				<label>Longitude:</label><input type="text" value="<?php echo $pa_long; ?>" readonly>
                    <label>Client Rating:</label><input type="text" value="<?php echo $rating; ?>" readonly>
                </section>
                <div class="h32"></div>
            <?php
            }

            if ( $info === "cct" )
            { 
                $sql = "SELECT contact_name,contact_cellnr,contact_email,contact_position,contact_marketing FROM clients_contacts WHERE clients_main_id = '$cpyid' ORDER BY contact_position;";
                $qry = mysqli_query($dbcon,$sql);
                $num = mysqli_num_rows($qry);
                if ( $num > 0 ){
                    while ( $row = mysqli_fetch_assoc($qry) )
                    {
                        $co_name = $row['contact_name'];
                        $co_cell = $row['contact_cellnr'];
                        $co_email = $row['contact_email'];
                        $co_posi = $row['contact_position'];
                        $co_markp = $row['contact_marketing'];

                        if ( $co_posi === 'Owner' ){ $cposi = "OWNER"; }
                        else if ( $co_posi === 'Manager' ){ $cposi = "MANAGER"; }
                        else if ( $co_posi === 'Buyer' ){ $cposi = "BUYER"; }
                        else if ( $co_posi === 'Mechanic' ){ $cposi = "MECHANIC"; }
                        else if ( $co_posi === 'Admin' ){ $cposi = "ADMIN"; }
                        else { $cposi = "CONTACT"; }

                        if ( $co_markp === "w" ){ $co_markp = "Whatsapp"; }
                        else if ( $co_markp === "s" ){ $co_markp = "SMS"; }
                        else if ( $co_markp === "e" ){ $co_markp = "Email"; }

                        echo '<h2>'.$cposi.' DETAILS</h2>';
                        ?>

                        <section>
                            <label>Contact Name:</label><input type="text" value="<?php echo $co_name; ?>" readonly>
                            <label>Cell Number:</label><input type="text" value="<?php echo $co_cell; ?>" readonly>
                            <label>Email Address:</label><input type="text" value="<?php echo $co_email; ?>" readonly>
                            <label>Marketing Preference:</label><input type="text" value="<?php echo $co_markp; ?>" readonly>
                        </section>                    
                        <div class="h32"></div>
                        <?php
                    }
                }
                else 
                {
                    echo "<section>No contacts defined for this company.</section>";
                }
            }

            if ( $info === "veh" )
            {
                function vehQty($cpynr, $vehnr)
                {
                    $sql = "SELECT veh_qty FROM clients_vehicles WHERE clients_main_id = '$cpynr' AND veh_code = '$vehnr' LIMIT 1;";
                    global $dbcon;
                    if ( $qry = mysqli_query($dbcon,$sql) )
                    {
                        $num = mysqli_num_rows($qry);
                        if ( $num == 1 )
                        {
                            $cvehqty = mysqli_fetch_assoc($qry)['veh_qty'];
                        }
                        else 
                        {
                            $cvehqty = "0";
                        }
                    }
                    else 
                    {
                        $cvehqty = "0";
                    }
                    echo $cvehqty;
                }
                ?>
    			<h2>HEAVY TRUCKS</h2>
    			<section>
                    <label>Volvo:</label><input type="text" value="<?php vehQty($cpyid,"1"); ?>" readonly>
                    <label>Scania:</label><input type="text" value="<?php vehQty($cpyid,"2"); ?>" readonly>
                    <label>Mercedes:</label><input type="text" value="<?php vehQty($cpyid,"3"); ?>" readonly>
                    <label>MAN:</label><input type="text" value="<?php vehQty($cpyid,"4"); ?>" readonly>
                    <label>DAF:</label><input type="text" value="<?php vehQty($cpyid,"6"); ?>" readonly>
                </section>
                <div class="h32"></div>
                <h2>TRAILERS</h2>
                <section>
                    <label>BPW:</label><input type="text" value="<?php vehQty($cpyid,"20"); ?>" readonly>
                    <label>Henred:</label><input type="text" value="<?php vehQty($cpyid,"22"); ?>" readonly>
                    <label>Afrit:</label><input type="text" value="<?php vehQty($cpyid,"30"); ?>" readonly>
                </section>
                <div class="h32"></div>
                <h2>MEDIUM TRUCKS</h2>
                <section>
                    <label>Isuzu Trucks:</label><input type="text" value="<?php vehQty($cpyid,"82"); ?>" readonly>
                    <label>Hino:</label><input type="text" value="<?php vehQty($cpyid,"80"); ?>" readonly>
                    <label>UD:</label><input type="text" value="<?php vehQty($cpyid,"81"); ?>" readonly>
                </section>
                <div class="h32"></div>
                <h2>BAKKIES</h2>
                <section>
                    <label>Toyota:</label><input type="text" value="<?php vehQty($cpyid,"60"); ?>" readonly>
                    <label>Ford:</label><input type="text" value="<?php vehQty($cpyid,"61"); ?>" readonly>
                    <label>Isuzu Bakkies:</label><input type="text" value="<?php vehQty($cpyid,"63"); ?>" readonly>
                    <label>Nissan:</label><input type="text" value="<?php vehQty($cpyid,"64"); ?>" readonly>
                    <label>Mazda:</label><input type="text" value="<?php vehQty($cpyid,"71"); ?>" readonly>
                </section>
                <div class="h32"></div>
                <h2>TRANSPORTERS</h2>
                <section>
                    <label>Mercedes Sprinter:</label><input type="text" value="<?php vehQty($cpyid,"11"); ?>" readonly>
                </section>
                <div class="h32"></div>
                <?php
                $sql = "SELECT veh_othr FROM clients_vehicles_other WHERE clients_main_id = '$cpyid' LIMIT 1;";
                if ( $qry = mysqli_query($dbcon,$sql) )
                {
                    $num = mysqli_num_rows($qry);
                    if ( $num == 1 )
                    {
                        $vehotr = mysqli_fetch_assoc($qry)['veh_othr'];
                        echo '<h2>OTHER VEHICLES</h2><section><label>Other Vehicles:</label><input type="text" value="'.$vehotr.'" readonly></section><div class="h32"></div>';
                    }
                    else 
                    {
                        $vehotr = "";
                    }
                }
                else 
                {
                    $vehotr = "";
                }
            }

            if ( $info === "vsn" )
            {
                $sql = "SELECT DATE(time_visited) AS datev,ucode,contact_name,contact_happy,request_quote,contact_comments,previsit_notes,rep_notes FROM clients_repvisits WHERE clients_main_id = '$cpyid' ORDER BY time_visited DESC LIMIT 5;";
                $qry = mysqli_query($dbcon,$sql);
                $num = mysqli_num_rows($qry);
                if ( $num > 0 ){
                    while ( $row = mysqli_fetch_assoc($qry) )
                    {
                        $rv_date = $row['datev'];
                        $rv_ucod = $row['ucode'];
                        $rv_conm = $row['contact_name'];
                        $rv_happ = $row['contact_happy'] == 1 ?  "Yes" : "No";
                        $rv_quot = $row['request_quote'] == 1 ?  "Yes" : "No";
                        $rv_cuco = $row['contact_comments'];
                        $rv_prvn = $row['previsit_notes'];
                        $rv_repn = $row['rep_notes'];

                        $qry0 = mysqli_query($dbcon,"SELECT name,surname FROM sacstaff WHERE ucode = '$rv_ucod' LIMIT 1;");
                        $rv_vrep = mysqli_fetch_assoc($qry0)['name'].' '.mysqli_fetch_assoc($qry0)['surname'];

                        echo '<h2>'.$rv_date.'</h2>';
                        ?>					
            			<section>
                            <label>Contact Name:</label><input type="text" value="<?php echo $rv_conm; ?>" readonly>    
                            <label>Contact Happy:</label><input type="text" value="<?php echo $rv_happ; ?>" readonly>
                            <label>Request Quote:</label><input type="text" value="<?php echo $rv_quot; ?>" readonly>
                            <label>Contact's Comments:</label><textarea readonly><?php echo $rv_cuco; ?></textarea>
                            <label>Visiting Rep:</label><input type="text" value="<?php echo $rv_vrep; ?>" readonly>
                            <label>Pre-visit Notes:</label><textarea readonly><?php echo $rv_prvn; ?></textarea>
                            <label>Rep's Notes:</label><textarea readonly><?php echo $rv_repn; ?></textarea>
                        </section>
                        <div class="h32"></div>
                        <?php
                    }
                }
            }

            if ( $info === "vsd" )
            {
                echo '<h2>Previous Visits</h2><section>';
                $sql = "SELECT time_visited,ucode FROM clients_repvisits WHERE clients_main_id = '$cpyid' ORDER BY time_visited DESC;";
                $qry = mysqli_query($dbcon,$sql);
                $num = mysqli_num_rows($qry);
                if ( $num > 0 ){
                    while ( $row = mysqli_fetch_assoc($qry) )
                    {
                        $rd_date = $row['time_visited'];
                        $rd_ucod = $row['ucode'];

                        $qry0 = mysqli_query($dbcon,"SELECT name,surname FROM sacstaff WHERE ucode = '$rd_ucod' LIMIT 1;");
                        $rd_vrep = mysqli_fetch_assoc($qry0)['name'].' '.mysqli_fetch_assoc($qry0)['surname'];

                        echo'<b>'.$rd_date.'</b> - '.$rd_vrep.'<br>';
                    }
                }
                echo '</section><div class="h32"></div>';
            }
            ?>


    		<section><a href="home.php?status=1&cpyid=<?php echo $cpyid; ?>"><button>Back</button></a></section>

    	    <div class="h32"></div>
        
    		<?php
    		mysqli_close($dbcon);
    		?>
        </body>
    	</html>
    	<?php
    }
    ?>