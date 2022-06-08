<!-- KEVIN 2021/09/02 -->
    <?php
// ===============================================================================================================================================
//                                                                  INCLUDES
// ===============================================================================================================================================
    require_once '../../globals/dbcon.inc';
// ===============================================================================================================================================
//                                                                  VARIABLES
// ===============================================================================================================================================
    $contactid = $_REQUEST['id'];
// ===============================================================================================================================================
//                                               CREATE NEW CONTACT SELECTED UNDER CONTACT DETAILS
// ===============================================================================================================================================
    if ( $contactid == "createnewcontact" )
    {
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
                <option value="LEFT COMPANY" <?php if ($contact_posi == "LEFT COMPANY"){ echo "selected"; } ?> >LEFT COMPANY</option>
            </select>

            <label>Contact's Cell Number:*</label>
            <input id="cellnr" name="cellnr" type="text" <?php if(!empty($cellnr)){ echo 'value="'.$cellnr.'"'; } ?> placeholder="Clients Phone Number" required>


            <label>Contact's Email:*</label>
            <input id="cemail" name="cemail" type="email" <?php if(!empty($cemail)){ echo 'value="'.$cemail.'"'; } ?> placeholder="Clients Email" required>

            <label>Marketing Preference:*</label><br>
            <input type="checkbox" id="markp1" name="infow" value="w"><label for="s1"> WhatsApp</label><br>
            <input type="checkbox" id="markp2" name="infos" value="s"><label for="s2"> SMS</label><br>
            <input type="checkbox" id="markp3" name="infoe" value="e"><label for="s3"> Email</label><br>
            <input type="checkbox" id="markp0" name="infon" value="none"><label for="s0"> None</label>

        </div>
    <?php
    }
// ===============================================================================================================================================
//                                                     IF PRE EXSISTING CONTACT SELECTED
// ===============================================================================================================================================
    else 
    {
        echo '<div id="contactdetails">';
            // SELECT CLIENT CONTACTS
            $sql = "SELECT 
                    contact_cellnr,
                    contact_email,
                    contact_position,
                    contact_marketing 
                    FROM 
                    clients_contacts 
                    WHERE 
                    id = '$contactid' 
                    LIMIT 1";

            // QRY BUILDER
            $qry = mysqli_query($dbcon,$sql);
            $row = mysqli_fetch_assoc($qry);

            // POPULATE VARIABLES
            $cellnr = $row['contact_cellnr'];
            $cemail = $row['contact_email'];
            $contact_posi = $row['contact_position'];
            $infofo = $row['contact_marketing'];

            //echo "<p>mp: $infofo</p>";

            // MARKETING PREFERENCE
            if ( $infofo == "W,S,E" )
            { 
                $infow = "W"; $infos = "S"; $infoe = "E"; 
            }
            else if ( $infofo == "W,S" )
            { 
                $infow = "W"; $infos = "S"; 
            }
            else if ( $infofo == "W,E" )
            { 
                $infow = "W"; $infos = "E"; 
            }
            else if ( $infofo == "S,E" )
            { 
                $infos = "S"; $infoe = "E"; 
            }
            else if ( $infofo == "W" )
            { 
                $infow = "W"; 
            }
            else if ( $infofo == "S" )
            { 
                $infos = "S"; 
            }
            else if ( $infofo == "E" )
            { 
                $infoe = "E"; 
            }
            else if ( $infofo == "" || $infofo == "NONE" )
            { 
                $infon == "NONE"; 
            }
    ?>

            <label>Contact's Position:*</label>
            <select id="positn" name="positn" required>
                <option value="" <?php if ($contact_posi == "none" || empty($contact_posi)){ echo "selected"; } ?> disabled >Position / Job Description of Contact</option>
                <option value="OWNER" <?php if ($contact_posi == "OWNER" ){ echo "selected"; } ?> >OWNER</option>
                <option value="MANAGER" <?php if ($contact_posi == "MANAGER" ){ echo "selected"; } ?> >MANAGER</option>
                <option value="BUYER" <?php if ($contact_posi == "BUYER" ){ echo "selected"; } ?> >BUYER</option>
                <option value="MECHANIC" <?php if ($contact_posi == "MECHANIC" ){ echo "selected"; } ?> >MECHANIC</option>
                <option value="ADMIN" <?php if ($contact_posi == "ADMIN" ){ echo "selected"; } ?> >ADMIN</option>
                <option value="LEFT COMPANY" <?php if ($contact_posi == "LEFT COMPANY"){ echo "selected"; } ?> >LEFT COMPANY</option>
            </select>
    
            <label>Contact's Cell Number:*</label>
            <input id="cellnr" name="cellnr" type="text" <?php if(!empty($cellnr)){ echo 'value="'.$cellnr.'"'; } ?> placeholder="Clients Phone Number" required>

            <label>Contact's Email:*</label>
            <input id="cemail" name="cemail" type="email" <?php if(!empty($cemail)){ echo 'value="'.$cemail.'"'; } ?> placeholder="Clients Email" required>

            <label>Marketing Preference:*</label><br>
            <input type="checkbox" id="markp1" name="infow" value="W" <?php if ( $infow == "W" ){ echo "checked"; } ?> ><label for="s1"> WhatsApp</label><br>
            <input type="checkbox" id="markp2" name="infos" value="S" <?php if ( $infos == "S" ){ echo "checked"; } ?> ><label for="s2"> SMS</label><br>
            <input type="checkbox" id="markp3" name="infoe" value="E" <?php if ( $infoe == "E" ){ echo "checked"; } ?> ><label for="s3"> Email</label><br>
            <input type="checkbox" id="markp0" name="infon" value="NONE" <?php if ( $infon == "NONE" ){ echo "checked"; } ?> ><label for="s0"> None</label>

        </div>
        <?php
    }
    ?>