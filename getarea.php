    <!-- KEVIN ALERS 2021/10/13 -->
    <?php
// =================================================================================================================
//                                                  INCLUDES
// =================================================================================================================
        require_once ('../globals/dbcon.inc');
// =================================================================================================================
//                                                  GET AREA
// =================================================================================================================
        // SELECT TOWN FROM KARGO_LOCATION
        $stmt = $dbcon->prepare("SELECT 
                                 town_name 
                                 FROM 
                                 kargo_locations 
                                 WHERE 
                                 town_name 
                                 LIKE ?;");

        $stmt->bind_param("s", $q);

        $q = "%{$dbcon -> real_escape_string($_REQUEST['term'])}%";

        // QRY BUILDER
        $stmt->execute();
        $result = $stmt->get_result();

        $json=array();

        // POPULATE VARIABLES
        while ($row = $result->fetch_assoc()) 
        {
            // VARIABLES
            $tn1 = $row['town_name'];
            array_push($json, $tn1);
        }

        echo json_encode($json);

        $sql = $dbcon -> real_escape_string("");
        $qry = $dbcon -> real_escape_string("");
        $stmt->close();
        $dbcon->close();

// =================================================================================================================
//                                                  JUNK
// =================================================================================================================
    /*
    //echo "OKAY";
    if ( isset($_POST['provin']) ){
        $provin = $_POST['provin'];
        $region = $_POST['region'];
        $hbarea = $_POST['hbarea'];

        require 'includes/dbcon.inc';
        $sql = "SELECT town_name FROM kargo_locations ORDER BY town_name ASC;";
        //echo "rx:$sql";
        if ( $qry = mysqli_query($dbcon,$sql) ){
            if ( mysqli_num_rows($qry) > 0 ){
                //$formsel = '<label>Hub Area:*</label><br><select id="hubare" name="hubare" required onchange="getHubArea()"><option value="">Select The Area</option>';
                $formsel = '<label>Hub Area:*</label><br><select id="hubare" name="hubare" required ><option value="">Select The Area</option>';
                while ( $row = mysqli_fetch_assoc($qry) ){
                    $town_name = $row['town_name'];
                    if ( $town_name == $hbarea ){
                        $formsel.=  '<option value="'.$town_name.'" selected>'.$town_name.'</option>';
                    }
                    else {
                        $formsel.=  '<option value="'.$town_name.'">'.$town_name.'</option>';
                    }
                    //echo $hub_name.'<br>';
                }
                $formsel.= '</select>';
            }
            else {
                $formsel = '<label>No Records</label>';
            }
        }
        else {
            $formsel = "error qry";//: ".mysqli_error($qry);
        }
        echo $formsel;
        //* /
    }
    //*/
    ?>