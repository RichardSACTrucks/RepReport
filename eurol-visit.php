
<?php
    /*************************************************************************
    *   Program ID:
    *   Program Desc:           A module for the rep app to be used by the eurl rep
    *   Author:                 Richard Ross/Kevin Alers
    *   Date created:
    *   Project ID:
    *
    *   ==========  =========== ============================================
    *   Kevin Alers 2022/06/14  added php form validation
    *   Kevin Alers 2022/06/14  captured input fields
    *   Kevin Alers 2022/06/15  created table and insert captured data
    *   Kevin Alers 2022/06/15  multple select on truck brands
    *************************************************************************/
    // Initiat Session/s - $_SESSION
    session_start();

    // Include Assets - Database Connection Master
    require '../../globals/dbcon.inc';
    /************************************************************************/
// =====================================================================================================================================
//                                                          IMPORTS INCLUDES
// =====================================================================================================================================
    session_start();
    //$dir = dirname($_SERVER['PHP_SELF']);
    // $dir = 'https://sacmarketing.co.za/rep/';
    // $thisfile = htmlspecialchars($_SERVER["PHP_SELF"]);



    $EurolClient = $_POST['eurolClient'];
    $EurolOil = $_POST['eurolOil'];
    $EurolOwner = $_POST['eurolOwner'];
    $EurolDispensing = $_POST['eurolDispensing'];
    $truck_type = $_POST["subject"];
    $num_of_trucks = $_POST["num_of_trucks"]; 
    $main_trucks = $_POST["maintruckbrands"]; 
    $luberadio = $_POST["luberadio"];    
    $engine = $_POST["engine-brand"];
    $coolant = $_POST["coolant-brand"];        
    $gearbox = $_POST["gearbox-brand"];        
    $grease = $_POST["grease-brand"];
    $owner = $_POST["Owner-brand"];
    $manager = $_POST["Manager-brand"];
    $mechanic = $_POST["Mechanic-brand"];        
    $hydralics = $_POST["hydralics-brand"];                                       
    $lubricant_brand = $_POST["lubricant-brand"]; 
    $changeinterval = $_POST["changeinterval"]; 
    $packradio = $_POST["packradio"]; 
    $otherpack = $_POST["otherpack"]; 
    $contract = $_POST["contract"]; 
    $lubrication_dispensing_type = $_POST["lubrication_dispensing_type"]; 
    $maintenance = $_POST["maintenance"]; 
    $owner = $_POST["owner"]; 
    $contact_name = $_POST["contact_name"]; 
    $oil_name = $_POST["oil_name"]; 
    $gear_oil_name = $_POST["gear_oil_name"]; 
    $coolant_name = $_POST["coolant_name"]; 
    $actionradio = $_POST["actionradio"]; 


    ?>
<!-- =================================================================================================================================== -->
<!--                                                         DOC HEAD                                                                    -->
<!-- =================================================================================================================================== -->
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title></title>
        <meta charset="UTF-8">

        <meta   name="viewport" 
                content="width=device-width, initial-scale=1">

        <link   href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
                rel="stylesheet"
                integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js">
        </script>

        <link   rel="stylesheet"
                href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

        <link   rel="stylesheet" 
                src="assests/formSheet.css">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">

<!-- ============================================================================================================================= -->
<!--                                                        SCRIPTS                                                                -->
<!-- ============================================================================================================================= -->
        <script type="text/javascript">
        $(document).ready(function() 
        {
            $("#exampleRadios1").click(function() 
            {
                $("#hider").hide();
            });
            $("#exampleRadios2").click(function() 
            {
                $("#hider").show();
            });
        });

        </script>

<!-- ============================================================================================================================== -->
<!--                                                            STYLE                                                               -->
<!-- ============================================================================================================================== -->
        <style>
        /* Media Queries: Tablet Landscape */
        @media screen and (max-width: 1200px) 
        {
            #primary 
            {
                width: 67%;
            }

            #secondary 
            {
                width: 30%;
                margin-left: 3%;
            }
            .radio-inline{
                display: contents !important;
            }
        }

        @media screen and (max-width: 768px) 
        {
            #primary 
            {
                width: 100%;
            }

            #secondary 
            {
                width: 100%;
                margin: 0;
                border: none;
            }
            .container{
                width: auto !important;
            }
        }


        .radio-inline 
        {
            position: relative;
            display: flex;
            padding-left: 7%;
            margin-bottom: 0;
            font-weight: 400;
            vertical-align: middle;
            cursor: pointer;
        }

        .header 
        {
            padding: 0px;
            text-align: center;
            color: black;
            font-size: 30px;
        }
        img {
                width: 200px;
          
            }
        body 
        {
            background-image: url('includes/eurol-swoosh.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0px;
        }

        .container 
        {
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            color: #f1f1f1;
            width: 100%;
            height: 100%;
            padding: 2%;
            width: 50%;
        }
        /* Style the button that is used to open and close the collapsible content */
        .collapsible 
        {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
        }

        /* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
        .active, .collapsible:hover 
        {
            background-color: #ccc;
        }

        /* Style the collapsible content. Note: hidden by default */
        .content 
        {
            padding: 0 18px;
            display: none;
            overflow: hidden;
            background-color: #f1f1f1;
        }
        button{
            width: 100% !important;
            font-weight: bold;
            font-size: 25px;
            background: rgba(255, 255, 255, 0.31);   
        }
        input{
            width: 100%;
            font-size: 15px;
        }
        .close{
            width: 100% !important;
        }
        </style>
    </head>

<!-- ============================================================================================================================= -->
<!--                                                            FORM START                                                         -->
<!-- ============================================================================================================================= -->
    <body>

        <div class="header">

            <img src="includes/eurol-logo.png" alt="eurol-logo.png">
            <h1><b>Eurol Hunter App</b></h1>
        </div>
        <div class="container">
<button type="button" class="owner" id="owner"><h1 id="owner">Eurol Clients</h1></button>
<section id="divclient">
            <form action="" method="post">
<!-- TRUCK BRANDS -->
<?php
                            function vehQty($cpynr, $vehnr){
                                $sql = "SELECT veh_qty FROM clients_vehicles WHERE clients_main_id=? AND veh_code=? LIMIT 1;";
                            }
?>
                <label class="form-label"><b>Truck Brands</b></label>
                <p><input type="number" id="vehm01" name="vehm01" value="<?php vehQty($cpyid,"1"); ?>" min="0" max="9999" maxlength="4" size="4"> Volvo</p>
                        <p><input type="number" id="vehm02" name="vehm02" value="<?php vehQty($cpyid,"2"); ?>" min="0" max="9999" maxlength="4" size="4"> Scania</p>
                        <p><input type="number" id="vehm03" name="vehm03" value="<?php vehQty($cpyid,"3"); ?>" min="0" max="9999" maxlength="4" size="4"> Mercedes</p>
                        <p><input type="number" id="vehm04" name="vehm04" value="<?php vehQty($cpyid,"4"); ?>" min="0" max="9999" maxlength="4" size="4"> MAN</p>
                        <p><input type="number" id="vehm06" name="vehm06" value="<?php vehQty($cpyid,"6"); ?>" min="0" max="9999" maxlength="4" size="4"> DAF</p>
                        <p><input type="number" id="vehm20" name="vehm20" value="<?php vehQty($cpyid,"20"); ?>" min="0" max="9999" maxlength="4" size="4"> BPW</p>
                        <p><input type="number" id="vehm22" name="vehm22" value="<?php vehQty($cpyid,"22"); ?>" min="0" max="9999" maxlength="4" size="4"> Henred</p>
                        <p><input type="number" id="vehm30" name="vehm30" value="<?php vehQty($cpyid,"30"); ?>" min="0" max="9999" maxlength="4" size="4"> Afrit</p>
                        <p><input type="number" id="vehm82" name="vehm82" value="<?php vehQty($cpyid,"82"); ?>" min="0" max="9999" maxlength="4" size="4"> Isuzu MCV</p>
                        <p><input type="number" id="vehm80" name="vehm80" value="<?php vehQty($cpyid,"80"); ?>" min="0" max="9999" maxlength="4" size="4"> Hino</p>
                        <p><input type="number" id="vehm81" name="vehm81" value="<?php vehQty($cpyid,"81"); ?>" min="0" max="9999" maxlength="4" size="4"> UD</p>
                        <p><input type="number" id="vehm60" name="vehm60" value="<?php vehQty($cpyid,"60"); ?>" min="0" max="9999" maxlength="4" size="4"> Toyota</p>
                        <p><input type="number" id="vehm61" name="vehm61" value="<?php vehQty($cpyid,"61"); ?>" min="0" max="9999" maxlength="4" size="4"> Ford</p>
                        <p><input type="number" id="vehm63" name="vehm63" value="<?php vehQty($cpyid,"63"); ?>" min="0" max="9999" maxlength="4" size="4"> Isuzu LCV</p>
                        <p><input type="number" id="vehm64" name="vehm64" value="<?php vehQty($cpyid,"64"); ?>" min="0" max="9999" maxlength="4" size="4"> Nissan</p>
                        <p><input type="number" id="vehm71" name="vehm71" value="<?php vehQty($cpyid,"71"); ?>" min="0" max="9999" maxlength="4" size="4"> Mazda</p>
                        <p><input type="number" id="vehm11" name="vehm11" value="<?php vehQty($cpyid,"11"); ?>" min="0" max="9999" maxlength="4" size="4"> Sprinter</p>
                <div id="result" ></div>
<!-- NUMBER OF TRUCK -->
                <hr>
                <label class="form-label"><b>Number Of Trucks</b></label>
                <select class="form-select" name='num_of_trucks[]' >
                    <option value="1-10"     >1     -10  </option>
                    <option value="11-30"    >11    -30  </option>
                    <option value="31-60"    >31    -60  </option>
                    <option value="61-90"    >61    -90  </option>
                    <option value="91-120"   >91    -120 </option>
                    <option value="121-200"  >121   -200 </option>
                    <option value="201-500"  >201   -500 </option>
                    <option value="501-1000" >501   -1000</option>
                    <option value="10001+"   >10001+     </option>
                </select>
                <hr>
                <label for="radioForm2" class="form-label"><b>Volume Of Lubricants (Per Month)</b></label>

                <div class="form-check">

                    <div class="radio-inline">

                        <label class="radio-inline" for="volumeRadios1">
                            <input class="form-check-input" type="radio" name="luberadio[]" id="volumeRadios1"
                                value="0-100 L" checked> 0-100 L
                        </label>
                        <br>

                        <label class="radio-inline" for="volumeRadios2">
                            <input class="form-check-input" type="radio" name="luberadio[]" id="volumeRadios2"
                                value="101-1k L"> 101-1k L
                        </label>
                        <br>

                        <label class="radio-inline" for="volumeRadios3">
                            <input class="form-check-input" type="radio" name="luberadio[]" id="volumeRadios3"
                                value="1k - 5k L">1k - 5k L
                        </label>
                        <br>

                        <label class="radio-inline" for="volumeRadios4">
                            <input class="form-check-input" type="radio" name="luberadio[]" id="volumeRadios4"
                                value="5k - 10k L"> 5k - 10k L
                        </label>
                        <br>

                        <label class="radio-inline" for="volumeRadios5">
                            <input class="form-check-input" type="radio" name="luberadio[]" id="volumeRadios5"
                                value="10k L+"> 10k L+
                        </label>
                        
                    </div>

                </div>
                <hr>
                <input type="file" accept="images/*" capture="camera" name="files[]" multiple="multiple">
                    <hr>
                <input type="submit" name="Submit" class="close" onClick='window.self.close()' value="Save">
                <hr>
            <hr>
</section>
<button type="button" class="hdoil" id="hdoil"><h1 id="hdoil">Eurol Lubricants</h1></button>
<section id="divoil">
            <div class="mb-3">
                    <label for="lubricant" class="form-label"><b>Engine Oil Brand Names</b></label>
                    <textarea name='engine-brand' class="form-control" id="grease" rows="3"></textarea>
                </div>
<!-- LUBRICANTS BRAND NAMES -->
                <hr>
                <div class="mb-3">
                    <label for="lubricant" class="form-label"><b>Coolant Brand Names</b></label>
                    <textarea name='coolant-brand' class="form-control" id="coolant" rows="3"></textarea>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="lubricant" class="form-label"><b>Gearbox and Drivetrain Brand Names</b></label>
                    <textarea name='gearbox-brand' class="form-control" id="gearbox" rows="3"></textarea>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="lubricant" class="form-label"><b>Grease Brand Names</b></label>
                    <textarea name='grease-brand' class="form-control" id="grease" rows="3"></textarea>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="lubricant" class="form-label"><b>Hydralics Brand Names</b></label>
                    <textarea name='hydralics-brand' class="form-control" id="hydralics" rows="3"></textarea>
                </div>

                <hr>
                <!-- PACK SIZE -->
                <label for="radioForm2" class="form-label"><b>Pack Size Preference</b></label>
                <div class="form-check">
                    <div class="radio-inline">
                        <label class="radio-inline" for="sizeRadios1">
                            <input class="form-check-input" type="radio" name="packradio" id="sizeRadios1"
                                value="1L" checked> 1L
                        </label>
                        <br>

                        <label class="radio-inline" for="sizeRadios2">
                            <input class="form-check-input" type="radio" name="packradio" id="sizeRadios2"
                                value="2L"> 2L
                        </label>
                        <br>

                        <label class="radio-inline" for="sizeRadios3">
                            <input class="form-check-input" type="radio" name="packradio" id="sizeRadios3"
                                value="5L">5L
                        </label>
                        <br>

                        <label class="radio-inline" for="sizeRadios3">
                            <input class="form-check-input" type="radio" name="packradio" id="sizeRadios3"
                                value="25L"> 25L
                        </label>
                        <br>

                        <label class="radio-inline" for="sizeRadios4">
                            <input class="form-check-input" type="radio" name="packradio" id="sizeRadios4"
                                value="200L"> 200L
                        </label>
                        <br>

                        </div>
                </div>
                <hr>
                <button style="margin-top: 10PX;" type="button" class="collapsible">Other Pack Size</button>
                    <div class="content">
                        <div id="hider" class="mb-3">
                                <label id="hider" for="exampleFormControlInput1" class="form-label"><b>Other pack size preference</b></label>
                                <input name='otherpack' id="hider" type="text" class="form-control" id="exampleFormControlInput1"
                                    placeholder="custom pack size">
                        </div>
                </div>
                <!-- CHANGE INTERVALS -->
                <hr>
                <label for="radioForm2" class="form-label"><b>Current Change Intervals</b></label>
                <div class="form-check">
                    <div class="radio-inline">

                        <label class="radio-inline" for="changeRadios1">
                            <input class="form-check-input" type="radio" name="changeinterval" id="exampleRadios1"
                                value="10k-20k km" checked>10k - 20k km
                        </label>
                        <br>
                        <label class="radio-inline" for="changeRadios2">
                            <input class="form-check-input" type="radio" name="changeinterval" id="changeRadios2"
                                value="20k-40k km">20k - 40k km
                        </label>
                        <br>

                        <label class="radio-inline" for="changeRadios3">
                            <input class="form-check-input" type="radio" name="changeinterval" id="changeRadios3"
                                value="40k-60k km">40k - 60k km
                        </label>
                        <br>

                        <label class="radio-inline" for="changeRadios4">
                            <input class="form-check-input" type="radio" name="changeinterval" id="changeRadios4"
                                value="60k+ km">60k+ km
                        </label>
                    </div>
                </div>
                <hr>
                <input type="submit" name="Submit" class="close" value="Save">
                <hr>
</section>
<button type="button" class="hdclient" id="hdclient"><h1 id="hdclient">Eurol Owners</h1></button>
<section id="divowner">
                <hr>
                <div class="mb-3">
                    <label for="lubricant" class="form-label"><b>Owner Information</b></label>
                    <textarea name='Owner-brand' class="form-control" id="Owner" rows="3"></textarea>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="lubricant" class="form-label"><b>Manager Information</b></label>
                    <textarea name='Manager-brand' class="form-control" id="Manager" rows="3"></textarea>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="lubricant" class="form-label"><b>Mechanic Information</b></label>
                    <textarea name='Mechanic-brand' class="form-control" id="Mechanic" rows="3"></textarea>
                </div>
                <hr>
                <input type="submit" name="Submit" class="close" onClick='window.self.close()' value="Save">
                <hr>
</section>
<button type="button" class="hddispensing" id="hddispensing"><h1 id="hddispensing">Eurol Dispensing Lubricants</h1></button>
<section id="divdispensing">
                <!-- DISPENSE TYPE -->
                <hr>
                <div class="mb-3">
                    <label for="dispensing" class="form-label"><b>Lubrication Dispensing Type</b></label>
                    <input name="lubrication_dispensing_type" type="text" class="form-control" id="dispensing"
                        placeholder="Dispensing Type">
                </div>
                <!-- CONTRACT -->
                <hr>
                <label for="contract" class="form-label"><b>Contract?</b></label>

                <button style="margin-top: 10PX;" type="button" class="collapsible">Yes/No</button>
                    <div class="content">
                    <hr>
                        <div class="mb-3 OEM">
                            <label for="exampleFormControlInput1" class="form-label"><b>Contract Description?</b></label>
                            <input name='maintenance' type="text" class="form-control" id="OEM exampleFormControlInput1"
                                placeholder="Contract Description?">
                        </div>
                    <hr>
                        <div class="mb-3">
                            <label for="startDate"><b>Contract end date</b></label>
                            <input name='contract' id="startDate" class="form-control" type="date" />
                        </div>
                    </div>
                    <hr>
                <label for="exampleFormControlInput1" class="form-label"><b>Maintenance Plan?</b></label>

                <button style="margin-top: 10PX;" type="button" class="collapsible">Yes/No</button>
                    <div class="content">
                        <hr>
                        <div class="mb-3 OEM">
                            <label for="exampleFormControlInput1" class="form-label"><b>Which Contractor?</b></label>
                            <input name='maintenance' type="text" class="form-control" id="OEM exampleFormControlInput1"
                                placeholder="Which Contractor?">
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="startDate"><b>Date End For Contract</b></label>
                            <input name='contract' id="startDate" class="form-control" type="date" />
                        </div>
                    </div>
                <hr>
                <input type="submit" name="Submit" class="close" onClick='window.self.close()' value="Save">
                <hr>
</section>
 <!-- ACTIONS TAKEN -->
                <hr>
                <label for="exampleFormControlInput1" class="form-label"><b>Actions Taken</b></label>

                <div class="form-check">
                    <input name='actionradio' class="form-check-input" type="checkbox" value="Quote provided" id="ActionsDefault1">
                    <label class="form-check-label" for="ActionsDefault1">
                        Quote provided
                    </label>

                    <br>
                    <input name='actionradio' class="form-check-input" type="checkbox" value="Catalogue provided" id="ActionsDefault1">
                    <label class="form-check-label" for="ActionsDefault1">
                        Catalogue provided
                    </label>

                    <br>
                    <input name='actionradio' class="form-check-input" type="checkbox" value="Sale made" id="ActionsDefault1">
                    <label class="form-check-label" for="ActionsDefault1">
                        Sale made
                    </label>

                    <br>
                    <input name='actionradio' class="form-check-input" type="checkbox" value="Brochure provided" id="ActionsDefault1">
                    <label class="form-check-label" for="ActionsDefault1">
                        Brochure provided
                    </label>

                    <br>
                    <input name='actionradio' class="form-check-input" type="checkbox" value="None" id="ActionsDefault1">
                    <label class="form-check-label" for="ActionsDefault1">
                        None
                    </label>
                </div>

<!-- SEND ME A RESPONSE -->
                <hr>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="responsesCheckDefault">
                    <label class="form-check-label" for="responsesCheckDefault">
                        Send me a copy of my responses
                    </label>
                </div>
<!-- EMAIL -->
                <hr>
                <div class="mb-3">
                    <label for="EmailForm" class="form-label"><b>Email address</b></label>
                    <input type="text" class="form-control" id="EmailForm"
                        placeholder="Your Email Address">
                </div>
<!-- SAVE BTN -->
                <hr>
                <input type="submit" name="Submit" value="Save">
<!-- CANCEL BTN -->  
            </form>

            <!-- LOGOUT -->
            <form action="https://sacmarketing.co.za/rep/home.php" method="POST">
                <button 
                type="submit" 
                name="submit" 
                value="Delivery" 
                style="margin-top: 10px"> 
                &nbsp Back &nbsp 
                </button>
            </form>

        </div>
        <p><a href="https://sacmarketing.co.za/rep">Log Out</a></p>

    </body>

    </html>

<!-- ============================================================================================================================ -->
<!--                                                        SCRIPT                                                                -->
<!-- ============================================================================================================================ -->
<script type="text/javascript">
                // $(document).on("click", '.hdclient', function(){
                //     $('#divclient').toggle();
                //     $('#divoil').hide();
                //     $('#divowner').hide();
                //     $('#divdispensing').hide();
                // })
                // $(document).on("click", '.hdoil', function(){
                //     $('#divclient').hide();
                //     $('#divoil').toggle();
                //     $('#divowner').hide();
                //     $('#divdispensing').hide();
                // })
                // $(document).on("click", '.hdowner', function(){
                //     $('#divclient').hide();
                //     $('#divoil').hide();
                //     $('#divowner').toggle();
                //     $('#divdispensing').hide();
                // })
                // $(document).on("click", '.hddispensing', function(){
                //     $('#divclient').hide();
                //     $('#divoil').hide();
                //     $('#divowner').hide();
                //     $('#divdispensing').toggle();
                // })
                $('.hdclient').click(function(){
                    $('#divclient').toggle();
                    $('#divoil').hide();
                    $('#divowner').hide();
                    $('#divdispensing').hide();
                });
                $('.hdoil').click(function(){
                    $('#divclient').hide();
                    $('#divoil').toggle();
                    $('#divowner').hide();
                    $('#divdispensing').hide();
                });
                $('.hdowner').click(function(){

                    $('#divclient').hide();
                    $('#divoil').hide();
                    $('#divowner').toggle();
                    $('#divdispensing').hide();
                });
                $('.hddispensing').click(function(){
                    $('#divclient').hide();
                    $('#divoil').hide();
                    $('#divowner').hide();
                    $('#divdispensing').toggle();
                });
</script>
    <script>

        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
            content.style.display = "none";
            } else {
            content.style.display = "block";
            }
        });
        }
    </script>
                    <script>
                    $("#dropdownlist").change(function (event) {{
                        var selected = $(this).find(":selected");
                        var tmp = selected.val();   
                    $('#result').text(tmp);
                        }
                    });
                </script>
    <script>
        function NewTab(value) {
            window.open(value, "", "width=700,height=600");
        }
    </script>