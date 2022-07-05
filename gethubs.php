<!-- KEVIN PHILLIP ALERS 2021/10/13 -->
<?php
//echo "OKAY";
// IF PROVINCE IS SET
if ( isset($_POST['provin']) )
{
    // GET LOCATION
    $provin = $_POST['provin'];
    $region = $_POST['region'];
    $hbarea = $_POST['hbarea'];
    
    require '../globals/dbcon.inc';

    $sql = "SELECT hub_name FROM kargo_locations WHERE province = '$provin' GROUP BY hub_name ORDER BY hub_name ASC;";
    //echo "rx:$sql";
    if ( $qry = mysqli_query($dbcon,$sql) ){
        if ( mysqli_num_rows($qry) > 0 ){
            $formsel = '<label>Hub Region:*</label><br><select id="hubreg" name="hubreg" required onchange="getHubArea()"><option value="">Select The Region</option>';
            //$formsel = '<label>Hub Region:*</label><br><select id="hubreg" name="hubreg" required ><option value="">Select The Region</option>';
            while ( $row = mysqli_fetch_assoc($qry) ){
                $hub_name = $row['hub_name'];
                if ( $hub_name == $region ){
                    $formsel.=  '<option value="'.$hub_name.'" selected>'.$hub_name.'</option>';
                }
                else {
                    $formsel.=  '<option value="'.$hub_name.'">'.$hub_name.'</option>';
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
    //*/
}
//*/
?>