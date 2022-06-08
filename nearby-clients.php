<?php
    //echo ".";
    //$uri = $_SERVER['REQUEST_URI'];
    //require '../globals/dbcon.inc';

    if ( isset($lat) && isset($lng) ){
        //$lat = $_POST['lat'];
        //$lng = $_POST['lon'];
        //$gac = $_POST['gac'];
        //$branch = $_POST['branch'];

        if ( !empty($lat) && !empty($lng) ){
            //echo "$lat<br>$lng<br>$gac<br>";
            $gac = number_format($gac,1);
            $sql ="SELECT id,company_name, 111.045 * DEGREES(ACOS(COS(RADIANS(?)) * COS(RADIANS(physical_latitude)) * COS(RADIANS(physical_longitude) - RADIANS(?)) + SIN(RADIANS(?)) * SIN(RADIANS(physical_latitude)))) AS distance FROM clients_main WHERE assigned_branch = ? ORDER BY distance ASC LIMIT 0,10;";
            //echo $sql;
            $stmt = $dbcon->prepare($sql);
            $stmt->bind_param("ddds", $lat,$lng,$lat,$branch);
            if ( $stmt->execute() ){
                $result = $stmt->get_result();
                if ( $result->num_rows > 0 ){
                    echo '<p>&nbsp;</p><h3>Nearby Clients (<i><span style="font-weight:400">Accuracy: '.$gac.' m</span></i>)</h3>';
                    //echo '<p>&nbsp;</p><h3>Nearby Clients</h3>';
                    while ( $row00 = $result->fetch_assoc() ){
                        $cpyid = $row00['id'];
                        $compny = $row00['company_name'];
                        //$branch = $row00['assigned_branch'];
                        $dist = $row00['distance'];
                        if ( $dist < 500 ){
                            $dist = number_format($dist,1);
                            echo '<a href="home.php?status=1&branch='.$branch.'&cpyid='.$cpyid.'"><div class="comps">'.$dist.' km:&emsp;'.$compny.'</div></a>';
                        }
                    }
                }
                else {
                    echo "no res";
                }
            }
            else {
                echo "Error: " . htmlspecialchars($stmt->error);
            }
            $stmt->close();
            
        }
        else{
            echo "empty values";
        }

    }
    
?>