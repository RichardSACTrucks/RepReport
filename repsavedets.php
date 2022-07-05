<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ( isset($_POST['sectin']) && isset($_POST['cmpyid']) && isset($_POST['rucode']) ){

    require '../globals/dbconn.inc';
    $sectin = $dbconn ->real_escape_string($_POST['sectin']);
    $cmpyid = $dbconn ->real_escape_string($_POST['cmpyid']);
    $branch = $dbconn ->real_escape_string($_POST['branch']);
    $rucode = $dbconn ->real_escape_string($_POST['rucode']);
    $result = $msg = null;

    if ( $sectin === 'comdet' ){

        $provin = $dbconn ->real_escape_string($_POST['provin']); $provin = strtoupper(trim($provin));
        $hubare = $dbconn ->real_escape_string($_POST['hubare']); $hubare = strtoupper(trim($hubare));
        $ptownl = $dbconn ->real_escape_string($_POST['ptownl']); $ptownl = strtoupper(trim($ptownl));
        $pstree = $dbconn ->real_escape_string($_POST['pstree']); $pstree = strtoupper(trim($pstree));
        $rating = $dbconn ->real_escape_string($_POST['rating']); $rating = strtoupper(trim($rating));

        $sql = "UPDATE clients_main SET physical_street=?, physical_town=?, physical_province=?, physical_country='SOUTH AFRICA', delivery_town=?, client_rating=? WHERE id=?;";
        $qry = $dbconn ->prepare($sql);
        $qry ->bind_param("sssssi",$pstree,$ptownl,$provin,$hubare,$rating,$cmpyid);

        if ( !$qry ->execute() ){
            $result.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error;
        }
        else {
            $result.= 'Saved';
            //$result.= "<br>$pstree,$ptownl,$provin,$hubare,$rating,$cmpyid";
        }
        $qry ->close();
        $dbconn->close();

        echo $result;
        exit;
    }
    else if ( $sectin === 'condet' ){

        $contid = $dbconn ->real_escape_string($_POST['contid']); $contid = strtoupper(trim($contid));
        $contac = $dbconn ->real_escape_string($_POST['contac']); $contac = strtoupper(trim($contac));
        $positn = $dbconn ->real_escape_string($_POST['positn']); $positn = strtoupper(trim($positn));
        $cellnr = $dbconn ->real_escape_string($_POST['cellnr']); $cellnr = strtoupper(trim($cellnr));
        $cemail = $dbconn ->real_escape_string($_POST['cemail']); $cemail = strtoupper(trim($cemail));
        $infon = $dbconn ->real_escape_string($_POST['markp0']); $infon = strtoupper(trim($infon));
        $infow = $dbconn ->real_escape_string($_POST['markp1']); $infow = strtoupper(trim($infow));
        $infos = $dbconn ->real_escape_string($_POST['markp2']); $infos = strtoupper(trim($infos));
        $infoe = $dbconn ->real_escape_string($_POST['markp3']); $infoe = strtoupper(trim($infoe));

        if ( $infon === 'NONE' ){
            $infofo = 'NONE';
        }
        else {
			if ( $infow == "W" && $infos == "S" && $infoe == "E" ){ $infofo = "W,S,E"; }
			else if ( $infow == "W" && $infos == "S" ){ $infofo = "W,S"; }
			else if ( $infow == "W" && $infoe == "E" ){ $infofo = "W,E"; }
			else if ( $infos == "S" && $infoe == "E" ){ $infofo = "S,E"; }
			else if ( $infow == "W" ){ $infofo = "W"; }
			else if ( $infos == "S" ){ $infofo = "S"; }
			else if ( $infoe == "E" ){ $infofo = "E"; }
			else if ( $infon == "NONE" ){ $infofo = "NONE"; }	
        }
        //$result.= "contid: $contid<br>contac: $contac<br>positn: $positn<br>cellnr: $cellnr<br>cemail: $cemail<br>markp0: $infon<br>markp1: $infow<br>markp2: $infos<br>markp3: $infoe<br>markpr: $infofo<br><br>";
        
        if ( $contid == 'CREATENEWCONTACT' || $contid == 'UNDEFINED' || empty($contid) ){
            $sql = "INSERT INTO clients_contacts (clients_main_id,contact_name,contact_cellnr,contact_email,contact_position,contact_marketing) VALUES (?,?,?,?,?,?);";
            //$result = $sql;
            $qry = $dbconn ->prepare($sql);
            $qry ->bind_param("isssss",$cmpyid,$contac,$cellnr,$cemail,$positn,$infofo);
            
            if ( !$qry ->execute() ){
                $result = "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error;
            }
            else {
                $result = 'Saved';
                // also result contact name and position
            }
            $qry ->close();
            $dbconn->close();
        }
        else {
            $dogetcontact = null;

            $sql = "UPDATE clients_contacts SET contact_cellnr=?, contact_email=?, contact_position=?, contact_marketing=? WHERE id=?;";
            $qry = $dbconn ->prepare($sql);
            $qry ->bind_param("ssssi",$cellnr,$cemail,$positn,$infofo,$contid);
            if ( !$qry ->execute() ){
                $result = "<b>ERROR</b>: Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                $dogetcontact = 0;
            }
            else {
                $result = 'Saved';
                // also result contact name and position
                $dogetcontact = 1;    
            }
            $qry ->close();

            if ( $dogetcontact === 1 ){
                $sql = "SELECT contact_name FROM clients_contacts WHERE id=? LIMIT 1";
                $qry = $dbconn ->prepare($sql);
                $qry ->bind_param("i",$contid);
                $qry ->execute();
                $res = $qry ->get_result();
                if ( $res ->num_rows === 1 ){
                    $row = $res ->fetch_assoc();
                    $contac = $row['contact_name'];
                }
                else { $contact = 'No Name'; }
                $res ->close();
            }

            $dbconn->close();
        }
        
        // echo result with contact name and position to save to hidden field for visit notes
        //echo $result;

        // create json
            $rescon = new \stdClass();
            $rescon ->result = $result;
            $rescon ->contact = $contac;
            $rescon ->position = $positn;
            $rejson = json_encode($rescon);

            echo $rejson;
        // end json create
        exit;
    }
    else if ( $sectin === 'fleveh' ){

        $veherr = null;

        // NEW SUBMISSION
            $sql = "INSERT INTO clients_vehicles (uniq_ref,clients_main_id,veh_code,veh_qty) VALUES (?,?,?,?) ON DUPLICATE KEY UPDATE veh_qty = VALUES(veh_qty);";
            $qry = $dbconn ->prepare($sql);
            $qry ->bind_param("siii",$vehref,$cmpyid,$vehcod,$vehqty);
            $countveh = 0;
            $vehcod = '01'; $vehqty = ( empty($_POST['vehm01']) ) ? '0' : trim($dbconn ->real_escape_string($_POST['vehm01'])); $vehref = $cmpyid.'.'.$vehcod; if ( !$qry ->execute() ){ $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error; } else { $countveh++; }
            $vehcod = '02'; $vehqty = ( empty($_POST['vehm02']) ) ? '0' : trim($dbconn ->real_escape_string($_POST['vehm02'])); $vehref = $cmpyid.'.'.$vehcod; if ( !$qry ->execute() ){ $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error; } else { $countveh++; }
            $vehcod = '03'; $vehqty = ( empty($_POST['vehm03']) ) ? '0' : trim($dbconn ->real_escape_string($_POST['vehm03'])); $vehref = $cmpyid.'.'.$vehcod; if ( !$qry ->execute() ){ $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error; } else { $countveh++; }
            $vehcod = '04'; $vehqty = ( empty($_POST['vehm04']) ) ? '0' : trim($dbconn ->real_escape_string($_POST['vehm04'])); $vehref = $cmpyid.'.'.$vehcod; if ( !$qry ->execute() ){ $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error; } else { $countveh++; }
            $vehcod = '06'; $vehqty = ( empty($_POST['vehm06']) ) ? '0' : trim($dbconn ->real_escape_string($_POST['vehm06'])); $vehref = $cmpyid.'.'.$vehcod; if ( !$qry ->execute() ){ $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error; } else { $countveh++; }
            $vehcod = '11'; $vehqty = ( empty($_POST['vehm11']) ) ? '0' : trim($dbconn ->real_escape_string($_POST['vehm11'])); $vehref = $cmpyid.'.'.$vehcod; if ( !$qry ->execute() ){ $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error; } else { $countveh++; }
            $vehcod = '20'; $vehqty = ( empty($_POST['vehm20']) ) ? '0' : trim($dbconn ->real_escape_string($_POST['vehm20'])); $vehref = $cmpyid.'.'.$vehcod; if ( !$qry ->execute() ){ $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error; } else { $countveh++; }
            $vehcod = '22'; $vehqty = ( empty($_POST['vehm22']) ) ? '0' : trim($dbconn ->real_escape_string($_POST['vehm22'])); $vehref = $cmpyid.'.'.$vehcod; if ( !$qry ->execute() ){ $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error; } else { $countveh++; }
            $vehcod = '30'; $vehqty = ( empty($_POST['vehm30']) ) ? '0' : trim($dbconn ->real_escape_string($_POST['vehm30'])); $vehref = $cmpyid.'.'.$vehcod; if ( !$qry ->execute() ){ $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error; } else { $countveh++; }
            $vehcod = '60'; $vehqty = ( empty($_POST['vehm60']) ) ? '0' : trim($dbconn ->real_escape_string($_POST['vehm60'])); $vehref = $cmpyid.'.'.$vehcod; if ( !$qry ->execute() ){ $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error; } else { $countveh++; }
            $vehcod = '61'; $vehqty = ( empty($_POST['vehm61']) ) ? '0' : trim($dbconn ->real_escape_string($_POST['vehm61'])); $vehref = $cmpyid.'.'.$vehcod; if ( !$qry ->execute() ){ $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error; } else { $countveh++; }
            $vehcod = '63'; $vehqty = ( empty($_POST['vehm63']) ) ? '0' : trim($dbconn ->real_escape_string($_POST['vehm63'])); $vehref = $cmpyid.'.'.$vehcod; if ( !$qry ->execute() ){ $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error; } else { $countveh++; }
            $vehcod = '64'; $vehqty = ( empty($_POST['vehm64']) ) ? '0' : trim($dbconn ->real_escape_string($_POST['vehm64'])); $vehref = $cmpyid.'.'.$vehcod; if ( !$qry ->execute() ){ $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error; } else { $countveh++; }
            $vehcod = '71'; $vehqty = ( empty($_POST['vehm71']) ) ? '0' : trim($dbconn ->real_escape_string($_POST['vehm71'])); $vehref = $cmpyid.'.'.$vehcod; if ( !$qry ->execute() ){ $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error; } else { $countveh++; }
            $vehcod = '80'; $vehqty = ( empty($_POST['vehm80']) ) ? '0' : trim($dbconn ->real_escape_string($_POST['vehm80'])); $vehref = $cmpyid.'.'.$vehcod; if ( !$qry ->execute() ){ $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error; } else { $countveh++; }
            $vehcod = '81'; $vehqty = ( empty($_POST['vehm81']) ) ? '0' : trim($dbconn ->real_escape_string($_POST['vehm81'])); $vehref = $cmpyid.'.'.$vehcod; if ( !$qry ->execute() ){ $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error; } else { $countveh++; }
            $vehcod = '82'; $vehqty = ( empty($_POST['vehm82']) ) ? '0' : trim($dbconn ->real_escape_string($_POST['vehm82'])); $vehref = $cmpyid.'.'.$vehcod; if ( !$qry ->execute() ){ $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error; } else { $countveh++; }
        
            $qry ->close();
        // end: NEW SUBMISSION

        /* OLD SUBMISSION
            $vehm01 = $dbconn ->real_escape_string($_POST['vehm01']); if (empty($vehm01)){ $vehm01 = '0'; } $vehm01 = strtoupper(trim($vehm01)); $c01 = "$cmpyid.01"; // volvo
            $vehm02 = $dbconn ->real_escape_string($_POST['vehm02']); if (empty($vehm02)){ $vehm02 = '0'; } $vehm02 = strtoupper(trim($vehm02)); $c02 = "$cmpyid.02"; // scania
            $vehm03 = $dbconn ->real_escape_string($_POST['vehm03']); if (empty($vehm03)){ $vehm03 = '0'; } $vehm03 = strtoupper(trim($vehm03)); $c03 = "$cmpyid.03"; // merc
            $vehm04 = $dbconn ->real_escape_string($_POST['vehm04']); if (empty($vehm04)){ $vehm04 = '0'; } $vehm04 = strtoupper(trim($vehm04)); $c04 = "$cmpyid.04"; // man
            $vehm06 = $dbconn ->real_escape_string($_POST['vehm06']); if (empty($vehm06)){ $vehm06 = '0'; } $vehm06 = strtoupper(trim($vehm06)); $c06 = "$cmpyid.06"; // daf
            $vehm11 = $dbconn ->real_escape_string($_POST['vehm11']); if (empty($vehm11)){ $vehm11 = '0'; } $vehm11 = strtoupper(trim($vehm11)); $c11 = "$cmpyid.11"; // sprinter
            $vehm20 = $dbconn ->real_escape_string($_POST['vehm20']); if (empty($vehm20)){ $vehm20 = '0'; } $vehm20 = strtoupper(trim($vehm20)); $c20 = "$cmpyid.20"; // bpw
            $vehm22 = $dbconn ->real_escape_string($_POST['vehm22']); if (empty($vehm22)){ $vehm22 = '0'; } $vehm22 = strtoupper(trim($vehm22)); $c22 = "$cmpyid.22"; // henred
            $vehm30 = $dbconn ->real_escape_string($_POST['vehm30']); if (empty($vehm30)){ $vehm30 = '0'; } $vehm30 = strtoupper(trim($vehm30)); $c30 = "$cmpyid.30"; // afrit
            $vehm60 = $dbconn ->real_escape_string($_POST['vehm60']); if (empty($vehm60)){ $vehm60 = '0'; } $vehm60 = strtoupper(trim($vehm60)); $c60 = "$cmpyid.60"; // toyota
            $vehm61 = $dbconn ->real_escape_string($_POST['vehm61']); if (empty($vehm61)){ $vehm61 = '0'; } $vehm61 = strtoupper(trim($vehm61)); $c61 = "$cmpyid.61"; // ford
            $vehm63 = $dbconn ->real_escape_string($_POST['vehm63']); if (empty($vehm63)){ $vehm63 = '0'; } $vehm63 = strtoupper(trim($vehm63)); $c63 = "$cmpyid.63"; // isuzu lcv
            $vehm64 = $dbconn ->real_escape_string($_POST['vehm64']); if (empty($vehm64)){ $vehm64 = '0'; } $vehm64 = strtoupper(trim($vehm64)); $c64 = "$cmpyid.64"; // nissan
            $vehm71 = $dbconn ->real_escape_string($_POST['vehm71']); if (empty($vehm71)){ $vehm71 = '0'; } $vehm71 = strtoupper(trim($vehm71)); $c71 = "$cmpyid.71"; // mazda
            $vehm80 = $dbconn ->real_escape_string($_POST['vehm80']); if (empty($vehm80)){ $vehm80 = '0'; } $vehm80 = strtoupper(trim($vehm80)); $c80 = "$cmpyid.80"; // hino
            $vehm81 = $dbconn ->real_escape_string($_POST['vehm81']); if (empty($vehm81)){ $vehm81 = '0'; } $vehm81 = strtoupper(trim($vehm81)); $c81 = "$cmpyid.81"; // ud
            $vehm82 = $dbconn ->real_escape_string($_POST['vehm82']); if (empty($vehm82)){ $vehm82 = '0'; } $vehm82 = strtoupper(trim($vehm82)); $c82 = "$cmpyid.82"; // isuzu
            $vehotr = $dbconn ->real_escape_string($_POST['vehotr']); if (empty($vehotr)){ $vehotr = ' '; } $vehotr = strtoupper(trim($vehotr)); // other

            $vehqty = array($vehm01,$vehm02,$vehm03,$vehm04,$vehm06,$vehm11,$vehm20,$vehm22,$vehm30,$vehm60,$vehm61,$vehm63,$vehm64,$vehm71,$vehm80,$vehm81,$vehm82);
            $vehcod = array('01','02','03','04','06','11','20','22','30','60','61','63','64','71','80','81','82');
            $vehref = array($c01,$c02,$c03,$c04,$c06,$c11,$c20,$c22,$c30,$c60,$c61,$c63,$c64,$c71,$c80,$c81,$c82);

            $countveh = 0;

            foreach ( $vehcod as $vkey => $vval ){
                //$result.= $vehref[$vkey].','.$cmpyid.','.$vehcod[$vkey].','.$vehqty[$vkey].'<br>';

                $sql = "INSERT INTO clients_vehicles (uniq_ref,clients_main_id,veh_code,veh_qty) VALUES (?,?,?,?) ON DUPLICATE KEY UPDATE veh_qty = VALUES(veh_qty);";
                $qry = $dbconn ->prepare($sql);
                $qry ->bind_param("siii",$vehref[$vkey],$cmpyid,$vehcod[$vkey],$vehqty[$vkey]);

                if ( !$qry ->execute() ){
                    $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error;
                }
                else {
                    $countveh++;
                    //$result.= 'Saved';
                }
                $qry ->close();
            }
        // end: OLD SUBMISSION */

        $vehotr = $dbconn ->real_escape_string($_POST['vehotr']); if (empty($vehotr)){ $vehotr = ' '; } $vehotr = strtoupper(trim($vehotr)); // other

        $sql = "INSERT INTO clients_vehicles_other (clients_main_id,veh_othr) VALUES (?,?) ON DUPLICATE KEY UPDATE veh_othr = VALUES(veh_othr);";
        $qry = $dbconn ->prepare($sql);
        $qry ->bind_param('is',$cmpyid,$vehotr);
        if ( !$qry ->execute() ){
            $veherr.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error;
        }
        else {
            $countveh++;
            //$result.= 'Saved';
        }
        $qry ->close();

        $result = ( $countveh == 18 ) ? 'Saved' : $veherr.'<br>Vehicle count: '.$countveh.' of 18';
        echo $result;
        exit;
    }
    else if ( $sectin === 'visnot' ){
        
        $rquote = null;
        $prvino = $dbconn ->real_escape_string($_POST['prvino']); $prvino = trim($prvino);
        $contac = $dbconn ->real_escape_string($_POST['contac']); $contac = strtoupper(trim($contac));
        $positn = $dbconn ->real_escape_string($_POST['positn']); $positn = strtoupper(trim($positn));
        $happyc = $dbconn ->real_escape_string($_POST['happyc']); $happyc = strtoupper(trim($happyc));
        $cmment = $dbconn ->real_escape_string($_POST['cmment']); $cmment = trim($cmment);
        $rnotes = $dbconn ->real_escape_string($_POST['rnotes']); $rnotes = trim($rnotes);
        $quoter = $dbconn ->real_escape_string($_POST['quoter']); $quoter = strtoupper(trim($quoter));
        $compny = $dbconn ->real_escape_string($_POST['compny']); $compny = strtoupper(trim($compny));
        $partsn = $dbconn ->real_escape_string($_POST['partsn']); $partsn = nl2br(strtoupper(trim($partsn)));
        $qvinnr = $dbconn ->real_escape_string($_POST['qvinnr']); $qvinnr = strtoupper(trim($qvinnr));
        $qvatnr = $dbconn ->real_escape_string($_POST['qvatnr']); $qvatnr = strtoupper(trim($qvatnr));
        $addinf = $dbconn ->real_escape_string($_POST['addinf']); $addinf = nl2br(trim($addinf));
        $selsal = $dbconn ->real_escape_string($_POST['selsal']); $selsal = strtoupper(trim($selsal));
        $vistim = $dbconn ->real_escape_string($_POST['vistim']);
        
        
        //$result.= "cmpyid: $cmpyid<br>prvino: $prvino<br>contac: $contac<br>positn: $positn<br>happyc: $happyc<br>cmment: $cmment<br>rnotes: $rnotes<br>quoter: $quoter<br>partsn: $partsn<br>qvinnr: $qvinnr<br>addinf: $addinf<br>selsal: $selsal<br>vistim: $vistim<br>";

        if ( $quoter == 'YES' ){ // if quote is requested

            //send mail to salesman
            $stmt = $dbconn->prepare("SELECT name,surname,email FROM sacstaff WHERE ucode = ? LIMIT 1;");
            $stmt->bind_param("s",$rucode);
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            $qsalesrepname = $row['name'].' '.$row['surname'];
            $qsalesrepemail = $row['email'];
            $stmt->close();
    
            $stmt = $dbconn->prepare("SELECT name,surname,email FROM sacstaff WHERE ucode = ? LIMIT 1;"); // get salesman's name, surname & email
            $stmt->bind_param("s",$selsal);
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            $qsalesmanname = $row['name'].' '.$row['surname'];
            $qsalesmanemail = $row['email'];
            $stmt->close();
    
            $stmt = $dbconn->prepare("SELECT account_nr FROM clients_main WHERE id = ? LIMIT 1;"); // get account nr
            $stmt->bind_param("i",$cmpyid);
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            $acc = $row['account_nr'];
            $stmt->close();
            if ( $acc != '' ){
                $cpyacc = '<tr><td><b>Account Nr</b></td><td width="12">:</td><td>'.mysqli_fetch_assoc($qry)['account_nr'].'</td></tr>';
            } else {
                $cpyacc = '';
            }
            if ( isset($qvatnr) && $qvatnr != '' ){
                $cpyvat = '<tr><td><b>VAT Number</b></td><td width="12">:</td><td>'.$qvatnr.'</td></tr>';
            } else {
                $cpyvat = '';
            }

            // RETRIEVE CONTACT EMAIL, CELL NR FROM DB
            $sql = "SELECT contact_cellnr,contact_email FROM clients_contacts WHERE clients_main_id=? AND contact_name=? LIMIT 1";
            $qry = $dbconn ->prepare($sql);
            $qry ->bind_param('is',$cmpyid,$contac);
            if ( !$qry ->execute() ){
                //$result.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error;
                $cellnr = $cemail = null;
            }
            else {
                $res = $qry->get_result();
                $row = $res->fetch_assoc();
                $cemail = $row['contact_email'];
                $cellnr = $row['contact_cellnr'];
            }
            $qry ->close();

            $subject = "New Quote Request from Rep";
            $message = '
                <html>
                    <head>
                        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <style>
                            @import url(https://fonts.googleapis.com/css?family=Open+Sans);
                            * {font-family: Tahoma,serif !important;}
                            #mbody {background-color:#ffffff;text-align:left;height:auto;color:#000000;max-width:600px !important;width:600px !important;margin:0;font-family:Tahoma,serif !important;font-size:16px;}
                            .button{
                                font-family: Tahoma,serif !important;font-weight:bold !important;font-size:12px !important;
                                text-decoration: none;color: #ffffff !important;line-height:38px;text-transform: uppercase;text-align: center;
                                display:inline-block;background-color: #cb1a1f;border-radius: 4px;
                                padding: 2px;padding-bottom:14px;width: 200px !important;height: 15px !important;
                                -webkit-text-size-adjust:none;
                            }
                            .button a:link {color: #FFFFFF !important;}
                            .button a:visited, .button a:hover, .button a:active {color: #FFFFFF !important;}
                        </style>
                    </head>
                    <body id="mbody">
                        <p>Dear '.$qsalesmanname.'</p>
                        <p>Please send a quotation to <b>'.$compny.'</b> using the below details:</p>
                        
                        <table border="0" cellspacing="0" callpadding="4">'.$cpyacc.$cpyvat.'
                            <tr><td><b>Contact</b></td><td width="12">:</td><td>'.$contac.'</td></tr>
                            <tr><td><b>Position</b></td><td width="12">:</td><td>'.$positn.'</td></tr>
                            <tr><td><b>Email</b></td><td width="12">:</td><td>'.$cemail.'</td></tr>
                            <tr><td><b>Cell Nr.</b></td><td width="12">:</td><td>'.$cellnr.'</td></tr>
                            <tr><td colspan="3"> &nbsp; </td></tr>
                            <tr><td><b>Parts Requested</b></td><td width="12">:</td><td width="600">'.$partsn.'</td></tr>
                            <tr><td><b>VIN NR</b></td><td width="12">:</td><td width="600">'.$qvinnr.'</td></tr>
                            <tr><td><b>Additional Notes</b></td><td width="12">:</td><td width="600">'.$addinf.'</td></tr>
                        </table>
                        <p> <br /> </p>
                        <p>Kind Regards</p>
                        <p>'.$qsalesrepname.'</p>
                    </body>
                </html>
                ';
    
            // Do mail
                $tomail = $qsalesmanemail;
                $toname = $qsalesmanname;
                $ccmail = $qsalesrepemail;
                $ccname = $qsalesrepname;
                $frmail = $qsalesrepemail;
                $frname = $qsalesrepname;
                //$subject = "testing";
                //$message = "<h1>test</h1><p><u>testing</u></p>";
                require '../globals/function-mailer.php';
                if ( isset($sendmailresult) && $sendmailresult === 'sent' ){
                    $msg.= "Salesman notified about quote request.";
                }
                else if ( isset($sendmailresult) && $sendmailresult !== 'sent' ){
                    //$result = mail->error();
                    $msg.= 'Error sending quote request to the salesman.<br>'.$sendmailresult;
                }
                else {
                    //$result = mail->error();
                    $msg.= "Error sending quote request to the salesman.";
                }
            // end Do mail
            $rquote = 1;
        }
        else {
            $rquote = 0;
        }

        $newvisit = null;
        $sql = "SELECT id FROM clients_repvisits WHERE time_visited = '$vistim' AND clients_main_id = '$cmpyid' ORDER BY id DESC LIMIT 1;";
        $res = $dbconn->query($sql);
        if ( $res ->num_rows == 0 ){
            $newvisit = 1;
            $previd = null;
        }
        else {
            $newvisit = 0;
            $row = $res ->fetch_assoc();
            $previd = $row['id'];
        }
        $res ->close();

        if ( $newvisit === 1 ){
            $sql = "INSERT INTO clients_repvisits (branch,time_visited,ucode,clients_main_id,contact_name,contact_position,contact_happy,request_quote,contact_comments,previsit_notes,rep_notes) VALUES (?,?,?,?,?,?,?,?,?,?,?);";
            $qry = $dbconn ->prepare($sql);
            $qry ->bind_param('sssissiisss',$branch,$vistim,$rucode,$cmpyid,$contac,$positn,$happyc,$rquote,$cmment,$prvino,$rnotes);
            if ( !$qry ->execute() ){
                $result.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error;
            }
            else {
                $result.= 'Saved';
            }
            $qry ->close();
        }
        else if ( $newvisit === 0 ){
            $sql = "UPDATE clients_repvisits SET contact_name=?,contact_position=?,contact_happy=?,request_quote=?,contact_comments=?,previsit_notes=?,rep_notes=? WHERE id=?;";
            $qry = $dbconn ->prepare($sql);
            $qry ->bind_param('ssiisssi',$contac,$positn,$happyc,$rquote,$cmment,$prvino,$rnotes,$previd);
            if ( !$qry ->execute() ){
                $result.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error;
            }
            else {
                $result.= 'Saved';
            }
            $qry ->close();
        }

        echo $result;
        exit;
    }
    else if ( $sectin === 'locdet' ){

        if ( isset($_POST['replat']) ){ $replat = $dbconn ->real_escape_string($_POST['replat']); $replat = strtoupper(trim($replat)); } else { $replat = ''; }
        if ( isset($_POST['replon']) ){ $replon = $dbconn ->real_escape_string($_POST['replon']); $replon = strtoupper(trim($replon)); } else { $replon = ''; }
        if ( isset($_POST['accura']) ){ $accura = $dbconn ->real_escape_string($_POST['accura']); $accura = strtoupper(trim($accura)); } else { $accura = ''; }
        if ( isset($_POST['mainla']) ){ $mainla = $dbconn ->real_escape_string($_POST['mainla']); $mainla = strtoupper(trim($mainla)); } else { $mainla = ''; }
        if ( isset($_POST['mainlo']) ){ $mainlo = $dbconn ->real_escape_string($_POST['mainlo']); $mainlo = strtoupper(trim($mainlo)); } else { $mainlo = ''; }
        if ( isset($_POST['tomain']) ){ $tomain = $dbconn ->real_escape_string($_POST['tomain']); $tomain = strtoupper(trim($tomain)); } else { $tomain = ''; }
        if ( isset($_POST['newloc']) ){ $newloc = $dbconn ->real_escape_string($_POST['newloc']); $newloc = strtoupper(trim($newloc)); } else { $newloc = ''; }
        if ( isset($_POST['vistim']) ){ $vistim = $dbconn ->real_escape_string($_POST['vistim']); } else { $vistim = ''; }

        $newvisit = null;
        $sql = "SELECT id FROM clients_repvisits WHERE time_visited = '$vistim' AND clients_main_id = '$cmpyid' ORDER BY id DESC LIMIT 1;";
        $res = $dbconn->query($sql);
        if ( $res ->num_rows == 0 ){
            $newvisit = 1;
            $previd = null;
        }
        else {
            $newvisit = 0;
            $row = $res ->fetch_assoc();
            $previd = $row['id'];
        }
        $res ->close();

        //echo "r: $replat, $replon<br>c: $accura<br>a: $mainla<br>o: $mainlo<br>t: $tomain<br>l: $newloc<br>v: $vistim<br>$previd<br>";


        if ( $newvisit === 1 ){
            $sql = "INSERT INTO clients_repvisits (branch,time_visited,ucode,clients_main_id,rep_latitude,rep_longitude) VALUES (?,?,?,?,?,?);";
            $qry = $dbconn ->prepare($sql);
            $qry ->bind_param('sssiss',$branch,$vistim,$rucode,$cmpyid,$replat,$replon);
            if ( !$qry ->execute() ){
                $result.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error;
            }
            else {
                $result.= 'Saved';
            }
            $qry ->close();
        }
        else if ( $newvisit === 0 ){
            // mainloc: check if rep location must be used or main location to be used
                if ( !empty($tomain) && $tomain == "YES" ){
                    $replat = $mainla;
                    $replon = $mainlo;
                }
            // end: mainloc

            // reploc: also check location company location must be updated to reps location
                if ( !empty($newloc) && $newloc == "YES" ){
                    $updatemainlocation = 1;
                }
                else {
                    $updatemainlocation = 0;
                }
            // end: reploc

            $sql = "UPDATE clients_repvisits SET rep_latitude=?,rep_longitude=? WHERE id=?;";
            $qry = $dbconn ->prepare($sql);
            $qry ->bind_param('ssi',$replat,$replon,$previd);
            if ( !$qry ->execute() ){
                $result.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error;
                $domainlocupd = 0;
            }
            else {
                if ( $updatemainlocation === 1 ){
                    $domainlocupd = 1;
                }
                else {
                    $domainlocupd = 0;
                    $result.= 'Saved';
                }
            }
            $qry ->close();

            if ( isset($domainlocupd) && $domainlocupd === 1 ){
                $sql = "UPDATE clients_main SET physical_latitude=?,physical_longitude=? WHERE id=?;";
                $qry = $dbconn ->prepare($sql);
                $qry ->bind_param('ssi',$replat,$replon,$cmpyid);
                if ( !$qry ->execute() ){
                    $result.= "<b>ERROR</b>: Execute failed: (" . $qry->errno . ") " . $qry->error;
                }
                else {
                    $result.= 'Saved';
                }
                $qry ->close();
            }
        }
        echo $result;
        exit;
    }
}
else {
    echo '<b>ERROR</b>: Insufficient details to perform this action';
    exit;
}
?>