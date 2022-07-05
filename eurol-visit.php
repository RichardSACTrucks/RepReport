
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
            <form action="" method="POST">
                 <button href="eurol-client-form.php" target="_blank" type="submit" onclick="NewTab('eurol-client-form.php')">Client and Truck Details</button>
                <?php
                    if(!empty($EurolClient)){
               
                    echo "<div class='container'>";
                    echo "<form action='warranty-form.php' method='POST'>";
                    echo "<input type='hidden' id='value' name='value' value='".$RFCinput."'>";
                    echo "<table border='1'>

                    <tr>
                    
                    <th>Eurol Client</th>
                    
                    <th>Verify</th>
                    
                    </tr>";
                    
                      echo "<tr>";
                    
                      echo "<td>" . $EurolClient . "</td>";
                
                      echo "</tr>";
                    
                      echo "</table>";
                echo "</form>";
               
            }
// =============================================================================================================================================
//                                                             END OF CALL
// =============================================================================================================================================
                ?>
                <hr>
                 <button href="eurol-oil-form.php" target="_blank" type="submit" onclick="NewTab('eurol-oil-form.php')">Lubricants Details</button>
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
<!-- OTHER PACK RADIO -->

                <button style="margin-top: 10PX;" type="button" class="collapsible">Other Pack Size</button>
                    <div class="content">
                        <div id="hider" class="mb-3">
                                <label id="hider" for="exampleFormControlInput1" class="form-label"><b>Other pack size preference</b></label>
                                <input name='otherpack' id="hider" type="text" class="form-control" id="exampleFormControlInput1"
                                    placeholder="custom pack size">
                        </div>
                </div>
<!-- CONTRACT -->
                <hr>
                <label for="contract" class="form-label"><b>Contract?</b></label>

                <button style="margin-top: 10PX;" type="button" class="collapsible">Yes/No</button>
                    <div class="content">
                    <hr>
                        <div class="mb-3">
                            <label for="startDate"><b>Contract end date</b></label>
                            <input name='contract' id="startDate" class="form-control" type="date" />
                        </div>

                    </div>
<!-- DISPENSE TYPE -->
                <hr>
                <div class="mb-3">
                    <label for="dispensing" class="form-label"><b>Lubrication Dispensing Type</b></label>
                    <input name="lubrication_dispensing_type" type="text" class="form-control" id="dispensing"
                        placeholder="Dispensing Type">
                </div>
<!-- MAINTENANCE PLAN -->
                <hr>

                <label for="exampleFormControlInput1" class="form-label"><b>Maintenance Plan?</b></label>

                <button style="margin-top: 10PX;" type="button" class="collapsible">Yes/No</button>
                    <div class="content">
                        <hr>
                        <div class="mb-3 OEM">
                            <label for="exampleFormControlInput1" class="form-label"><b>Which OEM brand?</b></label>
                            <input name='maintenance' type="text" class="form-control" id="OEM exampleFormControlInput1"
                                placeholder="Which OEM brand?">
                        </div>

                    </div>
<!-- OWNER -->
                <hr>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label"><b>Owner Name</b></label>
                    <input name='owner' type="text" class="form-control" id="Owner exampleFormControlInput1"
                        placeholder="Owner Name">
                </div>
<!-- CONTACT NAME -->
                <hr>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label"><b>Contact Name</b></label>
                    <input name='contact_name'type="text" class="form-control" id="contactName exampleFormControlInput1"
                        placeholder="Contact Name">
                </div>
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
<!-- ============================================================================================================================= -->
<!--                                                   ACCEPTS FORM INPUT/WRITE DATA                                               -->
<!-- ============================================================================================================================= -->
<?php
// POST
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            // BUTTON CLICKED
            if(empty($_POST["Save"]))
            {
// CUSTOMER NAME
                if(empty($_POST["customer"]))
                {
                    echo "name fail";
                }
                else
                {
                    $client_name = ($_POST["customer"]);

                    // echo "<br>Client Name: " .$client_name;
// TRUCK TYPE(ARRAY)
                    if(empty($_POST["subject"]))
                    {
                        echo "<br>truck selection failed ";
                    }
                    else
                    {
                        $truck_type = ($_POST["subject"]);

                        // echo "<br>Truck Brands :" .$truck_type;
// NUM OF TRUCKS
                        if(empty($_POST["num_of_trucks"]))
                        {
                            echo "<br>num of trucks fails";
                        }
                        else
                        {
                            $num_of_trucks = ($_POST["num_of_trucks"]); 

                            // echo "<br>Number Of Trucks :" .$num_of_trucks;
// MAIN TRUCKS
                            if(empty($_POST["maintruckbrands"]))
                            {
                                echo "<br>failed main truck brands";
                            }
                            else
                            {
                                $main_trucks = ($_POST["maintruckbrands"]); 

                                // echo "<br>Main Truck Brands : " .$main_trucks;
// VOLUME OF LUBE
                                if(empty($_POST["luberadio"]))
                                {          
                                    echo "<br>failed echo $luberadio;";    
                                }
                                else
                                {
                                    $luberadio = ($_POST["luberadio"]);    
                                    
                                    // echo "<br>Lube Per Month :" .$luberadio;
// grease-coolant-gear oil
                                    if(empty($_POST["grease-coolant-gearoil"]))
                                    {  
                                        echo "<br>failed grease-coolant-gearoil";    
                                    }
                                    else
                                    {

                                        $grease = ($_POST["grease-coolant-gearoil"]); 
                                        
                                        // echo "<br>grease-coolant-gearoil :" .$grease;
// LUBE BRAND
                                        if(empty($_POST["lubricant-brand"]))
                                        { 
                                            echo "<br>failed lubricant-brand";                      
                                        }
                                        else
                                        {
                                            $lubricant_brand = ($_POST["lubricant-brand"]); 
                                        
                                            // echo "<br>lubricant-brand :" .$lubricant_brand;      
// CHANGE INTERVAL
                                            if(empty($_POST["changeinterval"]))
                                            { 
                                                echo "<br>failed change interval";                      
                                            }
                                            else
                                            {
                                                $changeinterval = ($_POST["changeinterval"]); 
                                        
                                                // echo "<br>changeinterval :" .$changeinterval;  
// PACK SIZE
                                                if(empty($_POST["packradio"]))
                                                { 
                                                    echo "<br>failed change packradio";                      
                                                }
                                                else
                                                {
                                                    $packradio = ($_POST["packradio"]); 
                                                    $otherpack = ($_POST["otherpack"]); 

                                                    // echo "<br>packradio :" .$packradio;
// contract
                                                    $contract = ($_POST["contract"]); 

                                                    // echo "<br>contract :" .$contract ;                                                     
// lubrication_dispensing_type
                                                    if(empty($_POST["lubrication_dispensing_type"]))
                                                    { 
                                                        echo "<br>failed lubrication_dispensing_type";                      
                                                    }
                                                    else
                                                    {
                                                        $lubrication_dispensing_type = ($_POST["lubrication_dispensing_type"]); 

                                                        // echo "<br>lubrication_dispensing_type :" .$lubrication_dispensing_type ;  
// maintenance
                                                        $maintenance = ($_POST["maintenance"]); 

                                                        // echo "<br>maintenance :" .$maintenance ;  
// owner
                                                        if(empty($_POST["owner"]))
                                                        { 
                                                            echo "<br>failed owner";                      
                                                        }
                                                        else
                                                        {
                                                            $owner = ($_POST["owner"]); 

                                                            // echo "<br>owner :" .$owner ; 
// contact_name
                                                            if(empty($_POST["contact_name"]))
                                                            { 
                                                                echo "<br>failed contact_name";                      
                                                            }
                                                            else
                                                            {
                                                                $contact_name = ($_POST["contact_name"]); 

                                                                // echo "<br>contact_name :" .$contact_name ; 
// oil_name
                                                                if(empty($_POST["oil_name"]))
                                                                { 
                                                                    echo "<br>failed oil_name";                      
                                                                }
                                                                else
                                                                {
                                                                    $oil_name = ($_POST["oil_name"]); 

                                                                    // echo "<br>oil_name :" .$oil_name ; 
// gear_oil_name
                                                                    if(empty($_POST["gear_oil_name"]))
                                                                    { 
                                                                        echo "<br>failed gear_oil_name";                      
                                                                    }
                                                                    else
                                                                    {
                                                                        $gear_oil_name = ($_POST["gear_oil_name"]); 

                                                                        // echo "<br>gear_oil_name :" .$gear_oil_name ; 
// coolant_name
                                                                        if(empty($_POST["coolant_name"]))
                                                                        { 
                                                                            echo "<br>failed coolant_name";                      
                                                                        }
                                                                        else
                                                                        {
                                                                            $coolant_name = ($_POST["coolant_name"]); 

                                                                            // echo "<br>coolant_name :" .$coolant_name ; 
// actionradio
                                                                            if(empty($_POST["actionradio"]))
                                                                            { 
                                                                                echo "<br>failed actionradio";                      
                                                                            }
                                                                            else
                                                                            {
                                                                                $actionradio = ($_POST["actionradio"]); 

                                                                                // echo "<br>actionradio :" .$actionradio ; 
// INSERT INTO TABLE
                    
                        // IMPLODE TRUCK BRAND MULTI SELECT ARRAY
                        $truck_type_multi = implode( ',' , $truck_type);

                        //INSERT DATA INTO DELIVERY TABLE
                        $insert_visit = "INSERT INTO
                        clients_repvisits_eurol
                        (   
                            client_name,
                            truck_brands,
                            num_of_trucks,
                            main_truck_brands,
                            volume_of_lube,
                            grease_coolant_gear_brands,
                            lube_brand_names,
                            current_change_intervals,
                            pack_size_pref,
                            pack_size_pref_other,
                            contract,
                            lube_dispense_type,
                            maintenance_plan,
                            owner_name,
                            contact_name,
                            engine_oil_product_name,
                            gear_oil_product_name,
                            coolant_product_name,
                            actions_taken
                        )
                        values
                        (
                            '$client_name'                ,
                            '$truck_type_multi'           ,
                            '$num_of_trucks'              ,
                            '$main_trucks'                ,
                            '$luberadio'                  ,
                            '$grease'                     ,
                            '$lubricant_brand'            ,
                            '$changeinterval'             ,
                            '$packradio'                  ,
                            '$otherpack'                  ,
                            '$contract'                   ,
                            '$lubrication_dispensing_type',
                            '$maintenance'                ,
                            '$owner'                      ,
                            '$contact_name'               ,
                            '$oil_name'                   ,
                            '$gear_oil_name'              ,
                            '$coolant_name '              ,
                            '$actionradio  '
                        )";

                        if($dbcon->query($insert_visit) === true)
                        {       
                            // PROMPTS THE USER WHEN DATA SAVED SUCCESFULLY                             
                            echo "<br> Visit Added Successfully"; 
                                             
                        }
                        else
                        {
                            echo("Error description: "    . $dbcon               -> error);
                            echo "Failed To Load Invoice" . mysqli_connect_error(        );
                        }   

                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }  
                                                        } 
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }                           
                            }
                        }
                    }
                }              
            }
        }
    ?>
<!-- ============================================================================================================================ -->
<!--                                                        SCRIPT                                                                -->
<!-- ============================================================================================================================ -->
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
        function NewTab(value) {
            window.open(value, "", "width=700,height=600");
        }
    </script>