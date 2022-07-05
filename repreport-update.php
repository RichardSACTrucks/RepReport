<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ( isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' ){
    require_once '../globals/dbconn.inc';
    
    function updateDB($c,$t,$f,$v){
        global $dbconn;
        if ( $t == 'clients_main' ){
            $sql = "UPDATE $t SET $f = ? WHERE id = ?;";
            $qry = $dbconn ->prepare($sql);
            $qry ->bind_param("si",$v,$c);
            }
        else if ( $t == 'clients_vehicles' ){
            $vehcode = substr($f,4,6);
            $uniqref = $c.'.'.$vehcode;
            //echo "cpyid: $c. table: $t. field: $f. value: $v. vehcod: $vehcode. uniref: $uniqref.";
            //*
            $sql = "INSERT INTO $t (uniq_ref,clients_main_id,veh_code,veh_qty) VALUES (?,?,?,?) ON DUPLICATE KEY UPDATE veh_qty = VALUES(veh_qty);";
            $qry = $dbconn ->prepare($sql);
            if (!($qry ->bind_param("siii",$uniqref,$c,$vehcode,$v))){
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error.'<br>Contact:'.$contac;
                }
            //*/
            }
        else { 
            $sql = "UPDATE $t SET $f = ? WHERE clients_main_id = ?;";
            $qry = $dbconn ->prepare($sql);
            $qry ->bind_param("si",$v,$c);
            }

        // do when all is binded
        if ( $qry ->execute() ){
            echo 'saved';
            }
        else {
            echo 'failed';
            }
        $qry->close();
        //echo "Prepare failed: (" . $dbconn->errno . ") " . $dbconn->error.'<br>S:'.$sql;
        }

    $cpyid = $dbconn -> real_escape_string($_POST['cid']);
    $field = $dbconn -> real_escape_string($_POST['field']);
    $value = strtoupper($dbconn -> real_escape_string($_POST['value']));

    if ( $field === 'contac'){
        if (!($stmt = $dbconn->prepare("SELECT contact_name FROM clients_contacts WHERE id = ?;"))){
            echo "Prepare failed: (" . $dbconn->errno . ") " . $dbconn->error.'<br>Contact:'.$contac;
            }
        if (!($stmt->bind_param("i",$value))){
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error.'<br>Contact:'.$contac;
            }
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $value = $row['contact_name'];
        $stmt->close();
        }

    if ( $field === 'pstree' ){ $addto = 'physical_street'; }
    else if ( $field === 'ptownl' ){ $addto = 'physical_town'; }
    else if ( $field === 'provin' ){ $addto = 'physical_province'; }
    else if ( $field === 'replat' ){ $addto = 'physical_latitude'; }
    else if ( $field === 'replon' ){ $addto = 'physical_longitude'; }
    else if ( $field === 'provin' ){ $addto = 'delivery_province'; }
    else if ( $field === 'hubare' ){ $addto = 'delivery_town'; }
    else if ( $field === '' ){ $addto = 'email_main'; }
    else if ( $field === 'branch' ){ $addto = 'assigned_branch'; }
    else if ( $field === 'rating' ){ $addto = 'client_rating'; }
    else if ( $field === 'contac' ){ $field = 'contact_name'; }
    //else if ( $field === 'vehm01' ){ $addto = ''; }
    //else if ( $field === 'vehm02' ){ $addto = ''; }
    //else if ( $field === 'vehm03' ){ $addto = ''; }
    //else if ( $field === 'vehm04' ){ $addto = ''; }
    //else if ( $field === 'vehm06' ){ $addto = ''; }
    //else if ( $field === '' ){ $addto = ''; }
    //else if ( $field === '' ){ $addto = ''; }
    //else { $addto = ''; }

    $clients_main = array('provin','ptownl','pstree','rating','replat','replon','hubare');
    $clients_contacts = array('contid','positn','cellnr','cemail');
    $clients_notes = array('notes');
    $clients_repvisits = array('contac','positn','happyc','cmment','rnotes','replat','replon');
    $clients_vehicles = array('vehm01','vehm02','vehm03','vehm04','vehm06','vehm20','vehm22','vehm30','vehm82','vehm80','vehm81','vehm60','vehm61','vehm63','vehm64','vehm71','vehm11');
    $clients_vehicles_other = array('vehotr');

    if ( in_array($field, $clients_main) ){ updateDB($cpyid,'clients_main',$addto,$value); }
    if ( in_array($field, $clients_contacts) ){ updateDB($cpyid,'clients_contacts',$field,$value); }
    if ( in_array($field, $clients_notes) ){ updateDB($cpyid,'clients_notes',$field,$value); }
    if ( in_array($field, $clients_repvisits) ){ updateDB($cpyid,'clients_repvisits',$field,$value); }
    if ( in_array($field, $clients_vehicles) ){ updateDB($cpyid,'clients_vehicles',$field,$value); }
    if ( in_array($field, $clients_vehicles_other) ){ updateDB($cpyid,'clients_vehicles_other',$field,$value); }

}
?>