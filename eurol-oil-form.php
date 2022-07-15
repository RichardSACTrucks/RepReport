<?php
    /*************************************************************************
    *   Program ID:
    *   Program Desc:           A module for the rep app to be used by the eurl rep
    *   Author:                 Richard Ross/Kevin Alers
    *   Date created:
    *   Project ID:
    *
    *   ==========  =========== ============================================

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
        input{
            width: 100%;
        }
        </style>
    </head>

<!-- ============================================================================================================================= -->
<!--                                                            FORM START                                                         -->
<!-- ============================================================================================================================= -->
    <body>

        <div class="header">
            <h1 id="hdoil"><b>Eurol Lubricants</b></h1>
        </div>

        <div class="container">
            <form action="eurol-visit.php" method="post" name="eurolOil">
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
            </form>
        </div>
</body>
</html>



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

var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function() {
    if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
        window.self.close();
    }
}


</script>