<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

session_start();

$dir = dirname($_SERVER['PHP_SELF']);
include '../../globals/dbcon.inc';
// include '../includes/log.inc';

// if ($_SESSION['sacmbs'])
// // {
// //     header("location: $dir/index.php");
// // }
// // else 
// {
//     $srid = $_SESSION['sacmbs'];

    // $sql = "SELECT ucode,name,branch FROM sacstaff WHERE id=? LIMIT 1;";
    // $qry = $dbconn ->prepare($sql);
    // $qry ->bind_param('i',$srid);
    // $qry ->execute();
    // $res = $qry ->get_result();
    // $row = $res ->fetch_assoc();
    // $rucode = $row['ucode'];
    // $repnam = $row['name'];
    // $branch = $row['branch'];
//     // $qry-> close();

//     if (!empty($branch))
//     // {
//     //     $_SESSION = array();
//     //     session_destroy();
//     //     header("location: $dir/index.php");
//     //     exit;
//     // }
//     // else 
//     {
//         require_once 'includes/html-head.html';

//             $checksession = $_SESSION['sacmbs'];
//             //echo "<p><b>session: $checksession</b></p>";
//             //$branch = $_REQUEST['branch'];
//             $cpyid = $_REQUEST['cpyid'];
//             $company = $_REQUEST['company'];
//             $dist = '';
//             $contact_posi = null;
            ?>
<!-- =================================================================================================================================== -->
<!--                                                         DOC HEAD                                                                    -->
<!-- =================================================================================================================================== -->
<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>SAC Rep Report</title>
        <meta charset="UTF-8">
        <meta name="author" content="Jan van der Westhuizen">
        <meta name="Edits" content="Kevin Alers">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./includes/repstyle.css">
    </head>
<!-- =================================================================================================================================== -->
<!--                                                           BODY                                                                      -->
<!-- =================================================================================================================================== -->
    <body>
            <script>var savedcount = 0;</script>

            <input type="hidden" id="cmpyid" name="cmpyid" value="<?php echo $cpyid; ?>" >
            <input type="hidden" id="branch" name="branch" value="<?php echo $branch; ?>" >
            <input type="hidden" id="rucode" name="rucode" value="<?php echo $rucode; ?>" >

            <div>

                <section><h3><?php if ( isset($acnr) && !empty($acnr) ){ echo "$company <br><i>Account Nr: $acnr</i>"; } else { echo $company; } ?></h3></section>

                <h2 id="cmpydets">COMPANY DETAILS</h2>
                <section id="divcpydet">

                    <?php
                        // $checkprevrepsvsts = 0;
                        // $sql = "SELECT company_name,account_nr,physical_street,physical_town,physical_province,delivery_town,client_rating FROM clients_main WHERE id = ? AND assigned_branch = ? LIMIT 1;";
                        // $qry = $dbconn ->prepare($sql);
                        // $qry ->bind_param('is',$cpyid,$branch);

                        // if ( $qry ->execute() )
                        // {
                        //     $res = $qry ->get_result();
                        //     if ( $res ->num_rows == 1 )
                        //     {
                        //         $row = $res ->fetch_assoc();
                        //         $company = $row['company_name'];
                        //         $acnr = $row['account_nr'];

                        //         $pa_street = $row['physical_street'];
                        //         $pa_town = $row['physical_town'];
                        //         $pa_prov = $row['physical_province'];
                        //         $hub_area = $row['delivery_town'];
                        //         $rating = $row['client_rating'];

                        //         $checkprevrepsvsts = 1;
                        //     }
                        // }
                        // // else 
                        // // {
                        // //     echo "Error 1: " . mysqli_error($dbconn);
                        // //     echo "Company details cannot be found.";
                        // // }
                        // // $qry ->close();

                        // if ( $checkprevrepsvsts === 1 )
                        // {
                        //     $sql = "SELECT count(id) AS amount FROM clients_repvisits WHERE clients_main_id = ? LIMIT 1;";
                        //     $qry = $dbconn ->prepare($sql);
                        //     $qry ->bind_param('i',$cpyid);
                        //     if ( $qry ->execute() )
                        //     {
                        //         $res = $qry ->get_result();
                        //         $row = $res ->fetch_assoc();
                        //         $num = $row['amount'];
                        //         if ( $num > 0 )
                        //         {
                        //             $previsits = "yes";
                        //         }
                        //         else 
                        //         {
                        //             $previsits = 0;
                        //         }
                        //     }
                        //     $qry ->close();
                        // }
                    ?>

                    <form id="comdet">
                
                        <input type="hidden" name="compni" <?php if( !empty($company) ){ echo 'value="'.$company.'"'; } ?> autocomplete="off" autocapitalize=off required ></p>

                        <label>Physical Province:*</label>
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
                        
                        <label>Hub Area:*</label>
                        <input type="text" id="hubare" name="hubare" required value="<?php if(!empty($hub_area)){ echo $hub_area; } ?>" >
                        
                        <label>Physical Town:*</label>
                        <input id="ptownl" name="ptownl" type="text" required value="<?php if(!empty($pa_town)){ echo $pa_town; } ?>" >

                        <label>Physical Street Address:*</label>
                        <input id="pstree" name="pstree" type="text" rows="3" cols="28" rows="5" required value="<?php if(!empty($pa_street)){ echo $pa_street; } ?>" >

                        <label>Client Rating:*</label>
                        <select id="rating" name="rating" required>
                            <option value="null" <?php if ( empty($rating) ){ echo "selected"; } ?> disabled >Please Select Clients Rating</option>
                            <option value="VERY GOOD" <?php if ( $rating == "VERY GOOD" ){ echo "selected"; } ?> >VERY GOOD</option>
                            <option value="GOOD" <?php if ( $rating == "GOOD" ){ echo "selected"; } ?> >GOOD</option>
                            <option value="AVERAGE" <?php if ( $rating == "AVERAGE" ){ echo "selected"; } ?> >AVERAGE</option>
                            <option value="BAD" <?php if ( $rating == "BAD" ){ echo "selected"; } ?> >BAD</option>
                        </select>

                        <button type="submit" id="saveComDet">Save</button>

                        <div id="resComDet" style="width:100%;text-align:center;margin:8px auto">You need to save to approve this information.</div>

                    </form>

                    <!-- <script>
                        var comgood = 0;
                        $(function() {
                            $( "#hubare" ).keypress().autocomplete({
                                source: "getarea.php",
                                minLength: 3
                            });
                        });

                        var $lastsave = $('form#comdet'), origForm = $lastsave.serialize();

                        $('form#comdet :input').on('change input', function(){
                            if ( $lastsave.serialize() !== origForm ){
                                $('#resComDet').html('You need to save your changes.');
                                $('#cmpydets').css('background-color','#777777');
                            }
                            else {
                                $('#resComDet').html(' ');
                            }
                        });

                        $("#comdet").submit(function(e){
                            //$('#saveComDet').click(function(){

                            var comdet = 0;
                            var cmpyid = $('#cmpyid').val();
                            var branch = $('#branch').val();
                            var rucode = $('#rucode').val();

                            var provin = $('#provin').val();
                            var hubare = $('#hubare').val();
                            var ptownl = $('#ptownl').val();
                            var pstree = $('#pstree').val();
                            var rating = $('#rating').val();

                            var dataString = 'sectin=comdet&cmpyid='+cmpyid+'&branch='+branch+'&rucode='+rucode+'&provin='+provin+'&hubare='+hubare+'&ptownl='+ptownl+'&pstree='+pstree+'&rating='+rating;

                            $.ajax({ 
                                type: "POST",
                                url: "repsavedets.php",
                                data: dataString,
                                timeout: 30000, // 30 seconds
                                cache: false,
                                success: function(showRes) {
                                    if ( showRes === 'Saved' ){
                                        comdet = 1;
                                        $('#cmpydets').css('background-color','#009100');
                                        $('#resComDet').html('<i>'+showRes+'</i>');
                                        // $('#divcpydet').hide();
                                        comgood = 1;
                                        checkcompleteness();
                                    }
                                    else {
                                        comdet = 0;
                                        $('#resComDet').html(showRes);
                                        $('#cmpydets').css('background-color','#c10000');
                                    }
                                },
                                error: function(xhr, status, error){
                                    comdet = 0;
                                    var errorMessage = xhr.status + ': ' + xhr.statusText
                                    $('#resComDet').html('<b>ERROR:</b> ' + errorMessage);
                                    $('#cmpydets').css('background-color','#c10000');
                                }
                            });
                            return false;
                        });
                    </script> -->

                    <div class="h32"></div>

                </section>

                <h2 id="contdets">CONTACT DETAILS</h2>
                <section id="divcondet" style="display:none">

                    <form id="condet">

                        <?php 
                            $sql = "SELECT id,contact_name,contact_position FROM clients_contacts WHERE clients_main_id=?;";
                            $qry = $dbconn ->prepare($sql);
                            $qry ->bind_param("i",$cpyid);
                            $qry ->execute();
                            $res = $qry ->get_result();
                            if ( $res ->num_rows > 0 ){
                                echo '<label>Select Contact:*</label>';
                                echo '<select id="contactSelect" name="contac" required>';
                                echo '<option value="" disabled selected>-- Select --</option>';
                                while ( $row = $res ->fetch_assoc() ){
                                    $contactid = $row['id'];
                                    $contact_name = $row['contact_name'];
                                    $contact_posi =  strtoupper($row['contact_position']);
                                    echo '<option value="'.$contactid.'" >'.$contact_name.' ('.$contact_posi.')</option>';
                                }
                                echo '<option value="createnewcontact" >+ Create New Contact</option>';
                                echo '</select>';
                            }
                            
                                ?>
                                <div id="newcontact">
                                    <label>Contact Name:*</label>
                                    <input id="newcontac" name="newcontac" type="text" placeholder="Clients Name" required>
                                    
                                    <label>Contact's Position:*</label>
                                    <select id="positn" name="positn" required>
                                        <option value="" <?php if ($contact_posi == "none" || empty($contact_posi)){ echo "selected"; } ?> disabled >Position / Job Description of Contact</option>
                                        <option value="OWNER" <?php if ($contact_posi == "OWNER" ){ echo "selected"; } ?> >OWNER</option>
                                        <option value="MANAGER" <?php if ($contact_posi == "MANAGER" ){ echo "selected"; } ?> >MANAGER</option>
                                        <option value="BUYER" <?php if ($contact_posi == "BUYER" ){ echo "selected"; } ?> >BUYER</option>
                                        <option value="MECHANIC" <?php if ($contact_posi == "MECHANIC" ){ echo "selected"; } ?> >MECHANIC</option>
                                        <option value="ADMIN" <?php if ($contact_posi == "ADMIN" ){ echo "selected"; } ?> >ADMIN</option>
                                    </select>
                                    
                                    <label>Contact's Cell Number:*</label>
                                    <input id="cellnr" name="cellnr" type="text" <?php if(!empty($cellnr)){ echo 'value="'.$cellnr.'"'; } ?> required>
                                    
                                    <label>Contact's Email:*</label>
                                    <input id="cemail" name="cemail" type="email" <?php if(!empty($cemail)){ echo 'value="'.$cemail.'"'; } ?> required>

                                    <label>Marketing Preference:*</label><br>
                                    <input type="checkbox" id="markp1" name="markp1" value="W"><label for="s1"> WhatsApp</label><br>
                                    <input type="checkbox" id="markp2" name="markp2" value="S"><label for="s2"> SMS</label><br>
                                    <input type="checkbox" id="markp3" name="markp3" value="E"><label for="s3"> Email</label><br>
                                    <input type="checkbox" id="markp0" name="markp0" value="NONE"><label for="s0"> None</label>

                                </div>
                          

                        <div id="clientContactDetails"></div>

                        <button type="submit" id="saveConDet">Save</button>

                        <div id="resConDet" style="width:100%;text-align:center;margin:8px auto">You need to save to approve this information.</div>

                    </form>
<!-- 
                    <script>
                        var congood = 0;
                        var savedcontac = null;
                        var savedpositn;

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

                            // if (i=="createnewcontact") {
                            //     $('#newcontact').show();
                            // }
                            // else {
                            //     $('#newcontact').hide();
                            // }
                        });

                        function showNewContact(){
                            $('#newcontact').show();
                        }

                        var $lastsave = $('form#condet'), origForm = $lastsave.serialize();

                        $('form#condet :input').on('change input', function(){
                            if ( $lastsave.serialize() !== origForm ){
                                $('#resConDet').html('You need to save your changes.');
                                $('#contdets').css('background-color','#777777');
                            }
                            else {
                                $('#resConDet').html(' ');
                            }
                        });

                        $("#condet").submit(function(e){
                            //$('#saveConDet').click(function(){
                            
                            var condet = 0;
                            var cmpyid = $('#cmpyid').val();
                            var branch = $('#branch').val();
                            var rucode = $('#rucode').val();

                            var contid = $('#contactSelect').val();
                            var contac = $('#newcontac').val();
                            var positn = $('#positn').val();
                            var cellnr = $('#cellnr').val();
                            var cemail = $('#cemail').val();
                            var markp0 = null;
                            var markp1 = null;
                            var markp2 = null;
                            var markp3 = null;

                            if (  $('#markp0').prop("checked") == true ){
                                markp0 = $('#markp0').val();
                            }
                            if (  $('#markp1').prop("checked") == true ){
                                markp1 = $('#markp1').val();
                            }
                            if (  $('#markp2').prop("checked") == true ){
                                markp2 = $('#markp2').val();
                            }
                            if (  $('#markp3').prop("checked") == true ){
                                markp3 = $('#markp3').val();
                            }

                            var dataString = 'sectin=condet&cmpyid='+cmpyid+'&branch='+branch+'&rucode='+rucode+'&contid='+contid+'&contac='+contac+'&positn='+positn+'&cellnr='+cellnr+'&cemail='+cemail+'&markp0='+markp0+'&markp1='+markp1+'&markp2='+markp2+'&markp3='+markp3;

                            //window.alert('test<br>'+dataString.);

                            $.ajax({ 
                                type: "POST",
                                url: "repsavedets.php",
                                data: dataString,
                                timeout: 30000, // 30 seconds
                                cache: false,
                                success: function(showRes) {
                                    //$('#resConDet').html('<i>'+showRes+'</i>');
                                    //window.alert('showRes: '+showRes);
                                    var rejson = JSON.parse(showRes);
                                    savedcontac = rejson.contact;
                                    savedpositn = rejson.position;

                                    if ( rejson.result === 'Saved' ){
                                        comdet = 1;
                                        $('#contdets').css('background-color','#009100');
                                        $('#resConDet').html('<i>'+rejson.result+'</i>');
                                        // $('#divcondet').hide();
                                        congood = 1;
                                        checkcompleteness();
                                    }
                                    else {
                                        comdet = 0;
                                        $('#resConDet').html(rejson.result);
                                        $('#contdets').css('background-color','#c10000');
                                    }
                                },
                                error: function(xhr, status, error){
                                    comdet = 0;
                                    var errorMessage = xhr.status + ': ' + xhr.statusText
                                    $('#resConDet').html('<b>ERROR:</b> ' + errorMessage);
                                    $('#contdets').css('background-color','#c10000');
                                }
                            });
                            return false;
                        });
                    </script> -->

                    <div class="h32"></div>

                </section>

                <h2 id="vehicles">VEHICLES</h2>
                <section id="divfleveh" style="display:none">

                    <form id="vehicl">

                        <?php
                            function vehQty($cpynr, $vehnr){
                                global $dbconn;
                                $sql = "SELECT veh_qty FROM clients_vehicles WHERE clients_main_id=? AND veh_code=? LIMIT 1;";
                                $qry = $dbconn ->prepare($sql);
                                $qry ->bind_param("ii",$cpynr,$vehnr);
                                if ( !$qry ->execute() ){
                                    $cvehqty = "0";
                                }
                                else {
                                    $res = $qry ->get_result();
                                    if ( $res ->num_rows == 1 ){
                                        $row = $res ->fetch_assoc();
                                        $cvehqty = $row['veh_qty'];
                                    }
                                    else {
                                        $cvehqty = "0";
                                    }
                                }
                                echo $cvehqty;
                                $qry ->close();
                            }
                        ?>
                        <p><input type="number" id="vehm01" name="vehm01" value="<?php vehQty($cpyid,"1"); ?>" min="0" max="9999" maxlength="4" size="4"> Volvo</p>
                        <p><input type="number" id="vehm02" name="vehm02" value="<?php vehQty($cpyid,"2"); ?>" min="0" max="9999" maxlength="4" size="4"> Scania</p>
                        <p><input type="number" id="vehm03" name="vehm03" value="<?php vehQty($cpyid,"3"); ?>" min="0" max="9999" maxlength="4" size="4"> Mercedes</p>
                        <p><input type="number" id="vehm04" name="vehm04" value="<?php vehQty($cpyid,"4"); ?>" min="0" max="9999" maxlength="4" size="4"> MAN</p>
                        <p><input type="number" id="vehm06" name="vehm06" value="<?php vehQty($cpyid,"6"); ?>" min="0" max="9999" maxlength="4" size="4"> DAF</p>
                        <hr>
                        <p><input type="number" id="vehm20" name="vehm20" value="<?php vehQty($cpyid,"20"); ?>" min="0" max="9999" maxlength="4" size="4"> BPW</p>
                        <p><input type="number" id="vehm22" name="vehm22" value="<?php vehQty($cpyid,"22"); ?>" min="0" max="9999" maxlength="4" size="4"> Henred</p>
                        <p><input type="number" id="vehm30" name="vehm30" value="<?php vehQty($cpyid,"30"); ?>" min="0" max="9999" maxlength="4" size="4"> Afrit</p>
                        <hr>
                        <p><input type="number" id="vehm82" name="vehm82" value="<?php vehQty($cpyid,"82"); ?>" min="0" max="9999" maxlength="4" size="4"> Isuzu MCV</p>
                        <p><input type="number" id="vehm80" name="vehm80" value="<?php vehQty($cpyid,"80"); ?>" min="0" max="9999" maxlength="4" size="4"> Hino</p>
                        <p><input type="number" id="vehm81" name="vehm81" value="<?php vehQty($cpyid,"81"); ?>" min="0" max="9999" maxlength="4" size="4"> UD</p>
                        <hr>
                        <p><input type="number" id="vehm60" name="vehm60" value="<?php vehQty($cpyid,"60"); ?>" min="0" max="9999" maxlength="4" size="4"> Toyota</p>
                        <p><input type="number" id="vehm61" name="vehm61" value="<?php vehQty($cpyid,"61"); ?>" min="0" max="9999" maxlength="4" size="4"> Ford</p>
                        <p><input type="number" id="vehm63" name="vehm63" value="<?php vehQty($cpyid,"63"); ?>" min="0" max="9999" maxlength="4" size="4"> Isuzu LCV</p>
                        <p><input type="number" id="vehm64" name="vehm64" value="<?php vehQty($cpyid,"64"); ?>" min="0" max="9999" maxlength="4" size="4"> Nissan</p>
                        <p><input type="number" id="vehm71" name="vehm71" value="<?php vehQty($cpyid,"71"); ?>" min="0" max="9999" maxlength="4" size="4"> Mazda</p>
                        <hr>
                        <p><input type="number" id="vehm11" name="vehm11" value="<?php vehQty($cpyid,"11"); ?>" min="0" max="9999" maxlength="4" size="4"> Sprinter</p>
                        <hr>
                        <p>Other Vehicles:<br>
                        <?php
                            $sql = "SELECT veh_othr FROM clients_vehicles_other WHERE clients_main_id=? LIMIT 1;";
                            $qry = $dbconn ->prepare($sql);
                            $qry ->bind_param('i',$cpyid);
                            if ( !$qry ->execute() ){
                                $vehotr = "0";
                            }
                            else {
                                $res = $qry ->get_result();
                                if ( $res ->num_rows == 1 ){
                                    $row = $res ->fetch_assoc();
                                    $vehotr = $row['veh_othr'];
                                }
                                else {
                                    $vehotr = "0";
                                }
                            }
                            $qry ->close();
                        ?>					
                        <input type="text" id="vehotr" name="vehotr" <?php if ( !empty($vehotr) ){ echo 'value="'.$vehotr.'"'; } ?> ></p>

                        <button type="submit" id="saveFleVeh">Save</button>

                        <div id="resFleVeh" style="width:100%;text-align:center;margin:8px auto">You need to save to approve this information.</div>

                    </form>

                    <!-- <script>
                        var vehgood = 0;
                        var $lastsave = $('form#vehicl'), origForm = $lastsave.serialize();

                        $('form#vehicl :input').on('change input', function(){
                            if ( $lastsave.serialize() !== origForm ){
                                $('#resFleVeh').html('You need to save your changes.');
                                $('#vehicles').css('background-color','#777777');
                            }
                            else {
                                $('#resFleVeh').html(' ');
                            }
                        });

                        $("#vehicl").submit(function(e){
                            //$('#saveComDet').click(function(){

                            var comdet = 0;
                            var cmpyid = $('#cmpyid').val();
                            var branch = $('#branch').val();
                            var rucode = $('#rucode').val();

                            var vehm01 = $('#vehm01').val();
                            var vehm02 = $('#vehm02').val();
                            var vehm03 = $('#vehm03').val();
                            var vehm04 = $('#vehm04').val();
                            var vehm06 = $('#vehm06').val();
                            var vehm20 = $('#vehm20').val();
                            var vehm22 = $('#vehm22').val();
                            var vehm30 = $('#vehm30').val();
                            var vehm82 = $('#vehm82').val();
                            var vehm80 = $('#vehm80').val();
                            var vehm81 = $('#vehm81').val();
                            var vehm60 = $('#vehm60').val();
                            var vehm61 = $('#vehm61').val();
                            var vehm63 = $('#vehm63').val();
                            var vehm64 = $('#vehm64').val();
                            var vehm71 = $('#vehm71').val();
                            var vehm11 = $('#vehm11').val();
                            var vehotr = $('#vehotr').val();

                            var dataString = 'sectin=fleveh&cmpyid='+cmpyid+'&branch='+branch+'&rucode='+rucode+'&vehm01='+vehm01+'&vehm02='+vehm02+'&vehm03='+vehm03+'&vehm04='+vehm04+'&vehm06='+vehm06+'&vehm20='+vehm20+'&vehm22='+vehm22+'&vehm30='+vehm30+'&vehm82='+vehm82+'&vehm80='+vehm80+'&vehm81='+vehm81+'&vehm60='+vehm60+'&vehm61='+vehm61+'&vehm63='+vehm63+'&vehm64='+vehm64+'&vehm71='+vehm71+'&vehm11='+vehm11+'&vehotr='+vehotr;

                            $.ajax({ 
                                type: "POST",
                                url: "repsavedets.php",
                                data: dataString,
                                timeout: 30000, // 30 seconds
                                cache: false,
                                success: function(showRes) {
                                    if ( showRes === 'Saved' ){
                                        comdet = 1;
                                        $('#vehicles').css('background-color','#009100');
                                        $('#resFleVeh').html('<i>'+showRes+'</i>');
                                        // $('#divfleveh').hide();
                                        vehgood = 1;
                                        checkcompleteness();
                                    }
                                    else {
                                        comdet = 0;
                                        $('#resFleVeh').html(showRes);
                                        $('#vehicles').css('background-color','#c10000');
                                    }
                                },
                                error: function(xhr, status, error){
                                    comdet = 0;
                                    var errorMessage = xhr.status + ': ' + xhr.statusText
                                    $('#resFleVeh').html('<b>ERROR:</b> ' + errorMessage);
                                    $('#vehicles').css('background-color','#c10000');
                                }
                            });
                            return false;
                        });
                    </script> -->

                </section>

                <h2 id="visinote">VISIT NOTES</h2>
                <section id="divvisnot" style="display:none">

                    <form id="visnot">

                        <input type="hidden" id="compny" value="<?php echo $company; ?>">

                        <label>Pre-Visit Notes</label>
                        <?php
                            $sql = "SELECT clients_previsit_note FROM clients_notes WHERE clients_main_id = ? LIMIT 1;";
                            $qry = $dbconn ->prepare($sql);
                            $qry ->bind_param("i",$cpyid);
                            if ( !$qry ->execute() ){
                                $pvnote = "<i>no connection</i>";
                            }
                            else {
                                $res = $qry ->get_result();
                                if ( $res ->num_rows == 1 ){
                                    $row = $res ->fetch_assoc();
                                    $pvnote = $row['clients_previsit_note'];
                                }
                                else {
                                    $pvnote = "";
                                }
                            }
                            $qry ->close();
                        ?>
                        <textarea id="prvino" name="prvino" readonly><?php echo $pvnote; ?></textarea>

                        <button id="requote">Request A Quote</button>
                        <button id="shquote" style="display:none">Cancel Quote Request</button>
                        <div class="h32"></div>
                        <section id="doquote">
                            <input type="hidden" id="quoter" name="quoter" value="no">
                            <input type="hidden" id="partsn" name="partsn" value="">
                            <input type="hidden" id="vinnr" name="vinnr" value="">
                            <input type="hidden" id="vatnr" name="vatnr" value="">
                            <input type="hidden" id="addinf" name="addinf" value="">
                            <input type="hidden" id="selsal" name="selsal" value="">
                        </section>
                        
                        <label>Happy With Service?*</label>
                        <input type="radio" id="happy1" name="happyc" value="yes"> Yes &emsp; <input type="radio" id="happy0" name="happyc" value="no" required > No
                        <div class="h32"></div>

                        <label>Contact's Comments:</label>
                        <textarea id="cmment" name="cmment" type="text" rows="3" cols="28" rows="5" maxlength="255" placeholder="Customer comments about our service and/or visit"><?php if ( !empty($cmment) ){ echo $cmment; } ?></textarea>

                        <label>My Notes:*</label>
                        <textarea id="rnotes" name="rnotes" type="text" rows="3" cols="28" rows="5" maxlength="255" placeholder="My notes about the visit" required><?php if ( !empty($cmment) ){ echo $cmment; } ?></textarea>

                        <button type="submit" id="saveVisNot">Save</button>

                        <div id="resVisNot" style="width:100%;text-align:center;margin:8px auto">You need to save to approve this information.</div>

                    </form>
                
                    <!-- <script>
                        var visgood = 0;
                        var vistim = '<?php echo date('Y-m-d H:i:s'); ?>';
                        var $lastsave = $('form#visnot'), origForm = $lastsave.serialize();

                        $('form#visnot :input').on('change input', function(){
                            if ( $lastsave.serialize() !== origForm ){
                                $('#resVisNot').html('You need to save your changes.');
                                $('#visinote').css('background-color','#777777');
                            }
                            else {
                                $('#resVisNot').html(' ');
                            }
                        });

                        $("#visnot").submit(function(e){
                            
                            var cmpyid = $('#cmpyid').val();
                            var branch = $('#branch').val();
                            var rucode = $('#rucode').val();

                            var prvino = $('#prvino').val();
                            var happyc; if ( $('#happy1').prop('checked') == true ){ happyc = 1; } else { happyc = 0; }
                            var cmment = $('#cmment').val();
                            var rnotes = $('#rnotes').val();
                            var quoter = $('#quoter').val();
                            var compny = $('#compny').val();
                            var partsn = $('#partsn').val();
                            var qvinnr = $('#vinnr').val();
                            var qvatnr = $('#vatnr').val();
                            var addinf = $('#addinf').val();
                            var selsal = $('#selsal').val();

                            var dataString = 'sectin=visnot&cmpyid='+cmpyid+'&branch='+branch+'&rucode='+rucode+'&prvino='+prvino+'&contac='+savedcontac+'&positn='+savedpositn+'&happyc='+happyc+'&cmment='+cmment+'&rnotes='+rnotes+'&quoter='+quoter+'&compny='+compny+'&partsn='+partsn+'&qvinnr='+qvinnr+'&qvatnr='+qvatnr+'&addinf='+addinf+'&selsal='+selsal+'&vistim='+vistim;
                            //window.alert(dataString);

                            if ( savedcontac !== null ){
                                $.ajax({ 
                                    type: "POST",
                                    url: "repsavedets.php",
                                    data: dataString,
                                    timeout: 30000, // 30 seconds
                                    cache: false,
                                    success: function(showRes) {
                                        if ( showRes === 'Saved' ){
                                            $('#visinote').css('background-color','#009100');
                                            $('#resVisNot').html('<i>'+showRes+'</i>');
                                            // $('#divvisnot').hide();
                                            visgood = 1;
                                            checkcompleteness();
                                        }
                                        else {
                                            $('#resVisNot').html(showRes);
                                            $('#visinote').css('background-color','#c10000');
                                        }
                                    },
                                    error: function(xhr, status, error){
                                        var errorMessage = xhr.status + ': ' + xhr.statusText
                                        $('#resVisNot').html('<b>ERROR:</b> ' + errorMessage);
                                        $('#visinote').css('background-color','#c10000');
                                    }
                                });
                            }
                            else {
                                $('#resVisNot').html('<b>CONTACT DETAILS need to be saved</b>');
                            }
                            return false;
                        });

                        $('#requote').click(function(){
                            // $('#requote').hide();
                            $('#shquote').show();
                            $("#doquote").load("repquote.php");
                        });
                        $('#shquote').click(function(){
                            // $('#shquote').hide();
                            $('#requote').show();
                            $("#doquote").load("empty.php");
                        });

                        function doQuote(){
                            $("#doquote").load("repquote.php");
                        }
                    </script> -->

                </section>

                <h2 id="locadeta">LOCATION DETAILS</h2>
                <section id="divlocdet" style="display:none">

                    <form id="locdet">

                        <label>Latitude:*</label>
                        <input name="replat" type="text" id="lat" required onclick="getLocation()" onfocus="getLocation()" >

                        <label>Longitude:*</label>
                        <input name="replon" type="text" id="long" required onclick="getLocation()" >

                        <label>GPS Accuracy:</label>
                        <input name="accura" type="text" id="accu" readonly></i>

                        <?php
                            $qry0 = mysqli_query($dbcon,"SELECT physical_latitude,physical_longitude FROM clients_main WHERE id = '$cpyid' LIMIT 1;");
                            if ( $row0 = mysqli_fetch_assoc($qry0) )
                            {
                                $hasmain = "1";
                                $mainlat = $row0['physical_latitude'];
                                $mainlon = $row0['physical_longitude'];
                            }
                            echo '<input type="hidden" readonly id="mainlat" value="'.$mainlat.'"><input type="hidden" readonly id="mainlon" value="'.$mainlon.'">';

                            if ( empty($mainlat) || empty($mainlon) )
                            {
                                echo '<label> <b>You Have to be close to the Client, 1km required.</b></label>';
                                echo '<br>';
                                echo '<i>Distance From Client\'s Main Coordinates</i>:<input type="text" id="distfm" value="'.$dist.' Km" readonly><br>';
                                echo '<div id="forcoordupd">';
                                
                                echo '<label>Use Client\'s Main Coordinates?*</label><br>';
                                echo '<input type="radio" id="tomaincoords" name="tomaincoords" value="yes" readonly> Yes &emsp; <input type="radio" name="tomaincoords" value="no" required checked> No<br>';
                                echo '</div>';
                                echo '<br>';
                               
                                echo '<div id="setthisasmaincoord" style="display:none">';
                                echo '<label>Set This As Client\'s Main Coordinates?*</label><br>';
                                echo '<input type="radio" id="newcpyloc" name="newcpyloc" value="yes" checked readonly> Yes<br>';
                                echo '</div>';
                                echo '<div id="setmaincoordreqacc">';
                                echo '<label>Set This As Client\'s Main Coordinates?*</label>';
                                echo '<span>(Require 50m Accuracy)</span>';          
                                echo '</div>';
                               
                            }
                            else 
                            {
                                echo '<label> <b>You Have to be close to the Client, 1km required.</b></label>';
                                echo '<br>';
                                echo '<i>Distance From Client\'s Main Coordinates</i>:<input type="text" id="distfm" value="'.$dist.' Km" readonly><br>';
                                echo '<div id="forcoordupd">';
                                
                                echo '<label>Use Client\'s Main Coordinates?*</label><br>';
                                echo '<input type="radio" id="tomaincoords" name="tomaincoords" value="yes" checked> Yes &emsp; <input type="radio" name="tomaincoords" value="no" required > No<br>';
                                echo '</div>';
                                echo '<br>';
                                
                                echo '<div id="setthisasmaincoord" style="display:none">';
                                echo '<label>Set This As Client\'s Main Coordinates?*</label><br>';
                                echo '<input type="radio" id="newcpyloc" name="newcpyloc" value="yes"> Yes &emsp; <input type="radio" name="newcpyloc" value="no" required checked> No<br>';
                                echo '</div>';
                                echo '<div id="setmaincoordreqacc">';
                                echo '<label>Set This As Client\'s Main Coordinates?*</label>';
                                echo '<span>(Require 50m Accuracy)</span>';
                               
                                echo '</div>';
                                
                            }

                        ?>

                        <p> <br> </p>
                       

                        <button type="submit" id="saveLocDet">Save</button>


                        <div id="resLocDet" style="width:100%;text-align:center;margin:8px auto">You need to save to approve this information.</div>

                    </form>

                    <!-- <script>
                        
                        var locgood = 0;
                        var $lastsave = $('form#locdet'), origForm = $lastsave.serialize();

                        $('form#locdet :input').on('change input', function()
                        {
                            if ( $lastsave.serialize() !== origForm )
                            {
                                $('#resLocDet').html('You need to save your changes.');
                                $('#locadeta').css('background-color','#777777');
                            }
                            else 
                            {
                                $('#resLecDet').html(' ');
                            }
                        });

                        $("#locdet").submit(function(e){

                            var cmpyid = $('#cmpyid').val();
                            var branch = $('#branch').val();
                            var rucode = $('#rucode').val();

                            var replat = $('#lat').val();
                            var replon = $('#long').val();
                            var accura = $('#accu').val();
                            var mainla = $('#mainlat').val();
                            var mainlo = $('#mainlon').val();
                            var distfm = $('#distfm').val();
                            var tomain;
                            var newloc;
                            
                            if ( $('#tomaincoords').prop('checked') === true ){ tomain = 'yes'; }
                            else { tomain = 'no'; }

                            if ( $('#newcpyloc').prop('checked') === true ){ newloc ='yes'; }
                            else { newloc = 'no'; }

                            var dataString = 'sectin=locdet&cmpyid='+cmpyid+'&branch='+branch+'&rucode='+rucode+'&replat='+replat+'&replon='+replon+'&accura='+accura+'&mainla='+mainla+'&mainlo='+mainlo+'&tomain='+tomain+'&newloc='+newloc+'&vistim='+vistim;

                            $.ajax({ 
                                type: "POST",
                                url: "repsavedets.php",
                                data: dataString,
                                timeout: 30000, // 30 seconds
                                cache: false,
                                success: function(showRes) 
                                {

                                    if ( showRes === 'Saved' )
                                    {
                                        
                                        comdet = 1;
                                        $('#locadeta').css('background-color','#009100');
                                        $('#resLocDet').html('<i>'+showRes+'</i>');
                                        // $('#divlocdet').hide();
                                        locgood = 1;
                                        checkcompleteness();                                     
                                       

                                    }
                                    else 
                                    {
                                        comdet = 0;
                                        $('#resLocDet').html(showRes);
                                        $('#locadeta').css('background-color','#c10000');
                                    }
                                },

                                error: function(xhr, status, error)
                                {
                                    comdet = 0;
                                    var errorMessage = xhr.status + ': ' + xhr.statusText
                                    $('#resLocDet').html('<b>ERROR:</b> ' + errorMessage);
                                    $('#locadeta').css('background-color','#c10000');
                                }
                            });
                            return false;
                        });
                    </script> -->

                </section>

                <div class="h32"></div>

                <section id="submitarea">
                    <div id="allowSubmit" style="display:none">
                        <a href="home.php?status=1"><button type="button">Submit</button></a>
                    </div>
                </section>

            </div>
            <div>
                <div class="h16"></div>
                <section><a href="home.php?status=1&cpyid=<?php echo $cpyid; ?>"><button>Back</button></a></section>
                <div class="h32"></div>

                <?php
                    //*
                    if ( $previsits == "yes")
                    {
                        echo '<section>';
                        $sql3 = "SELECT * FROM clients_repvisits WHERE clients_main_id = '$cpyid' ORDER BY time_visited DESC LIMIT 3;";
                        $qry3 = mysqli_query($dbcon,$sql3);
                        $num3 = mysqli_num_rows($qry3);
                        if ( $num3 > 0 )
                        {
                            echo "<h3>Previous Visits</h3>";
                            while ( $row3 = mysqli_fetch_assoc($qry3) )
                            {
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
                    //*/
                ?>		

            </div>

            <!-- <script>
                var replat;// = position.coords.latitude;
                var replon;// = position.coords.longitude;
                var gpsAccu;
                var lastAccu = 1000; //for checking if better
                var mainlat;// = document.getElementById("mainlat").value;
                var mainlon;// = document.getElementById("mainlon").value;

                var x = document.getElementById("lat");
                var z = document.getElementById("long");
                var y = document.getElementById("accu");
                var jsdistsh = document.getElementById("distfm");

                function getLocation() 
                {
                    //accu = position.coords.latitude;
                    if (navigator.geolocation) 
                    {
                        navigator.geolocation.watchPosition(showPosition);
                    } else 
                    { 
                        x.innerHTML = "Geolocation is not supported by this browser.";
                    }
                }
        
                function showPosition(position) 
                {
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
                        jsdistsh.value = dist ;
                        //jsdistsh.value = mainlat+"/"+mainlon+"/"+replat+"/"+replon;

                        // if ( d < 1.00 )
                        // { 
                        //     // 10m & 1km
                        //     $('#forcoordupd').show();
                        //     //document.getElementById("forcoordupd").innerHTML = 'Use Client\'s Main Coordinates?*<br><input type="radio" id="tomaincoords" name="tomaincoords" value="yes" checked> Yes &emsp; <input type="radio" name="tomaincoords" value="no" required > No<br>';
                        // }
                        // if ( d > 0.20 )
                        // { 
                        //     // 200m
                        //     if ( gpsAccu <= 50 )
                        //     {
                        //         $('#setthisasmaincoord').show();
                        //         $('#setmaincoordreqacc').hide();
                        //         //document.getElementById("setmaincoord").innerHTML = '<p>Set This As Client\'s Main Coordinates?*<br><input type="radio" id="newcpyloc" name="newcpyloc" value="yes"> Yes &emsp; <input type="radio" name="newcpyloc" value="no" required checked> No</p>';
                        //     }
                        //     else 
                        //     {
                        //         $('#setthisasmaincoord').hide();
                        //         $('#setmaincoordreqacc').show();
                        //         //document.getElementById("setmaincoord").innerHTML = 'setmaincoordreqacc<p>Set This As Client\'s Main Coordinates?*<br>(Require 50m Accuracy)</p>';
                        //     }
                        // }
                        // else 
                        // {
                        //     $('#setthisasmaincoord').hide();
                        //     $('#setmaincoordreqacc').hide();
                        // }
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
                function toRad(Value) 
                {
                    return Value * Math.PI / 180;
                }

                // $('#cmpydets').click(function(){
                //     $('#divcpydet').toggle();
                //     $('#divcondet').hide();
                //     $('#divfleveh').hide();
                //     $('#divvisnot').hide();
                //     $('#divlocdet').hide();
                // });
                // $('#contdets').click(function(){
                //     $('#divcpydet').hide();
                //     $('#divcondet').toggle();
                //     $('#divfleveh').hide();
                //     $('#divvisnot').hide();
                //     $('#divlocdet').hide();
                // });
                // $('#vehicles').click(function(){
                //     $('#divcpydet').hide();
                //     $('#divcondet').hide();
                //     $('#divfleveh').toggle();
                //     $('#divvisnot').hide();
                //     $('#divlocdet').hide();
                // });
                // $('#visinote').click(function(){
                //     $('#divcpydet').hide();
                //     $('#divcondet').hide();
                //     $('#divfleveh').hide();
                //     $('#divvisnot').toggle();
                //     $('#divlocdet').hide();
                // });
                // $('#locadeta').click(function(){
                //     $('#divcpydet').hide();
                //     $('#divcondet').hide();
                //     $('#divfleveh').hide();
                //     $('#divvisnot').hide();
                //     $('#divlocdet').toggle();
                // });
                // $('#prevvisi').click(function(){
                //     $('#divprevis').toggle();
                // });
                function checkcompleteness()
                {
                    

                    //window.alert(comgood+","+congood+","+vehgood+","+visgood+","+locgood);
                    if ( comgood == 1 && congood == 1 && vehgood == 1 && visgood == 1 && locgood == 1 )
                    {
                        $('#allowSubmit').show();
                    }
                    else 
                    {
                        $('#allowSubmit').hide();
                    }
                }
            </script> -->
        
        </body>
        </html>
        <?php
//     }
// }
?>