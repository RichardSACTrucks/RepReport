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
        </style>
    </head>

<!-- ============================================================================================================================= -->
<!--                                                            FORM START                                                         -->
<!-- ============================================================================================================================= -->
    <body>

        <div class="header">
            <h1><b>Eurol Lubricants</b></h1>
        </div>

        <div class="container">
            <form action="eurol-visit.php" method="post" name="eurolOil">
                <hr>
                <div class="mb-3">
                    <label for="lubricant" class="form-label"><b>Owner Information</b></label>
                    <textarea name='coolant-brand' class="form-control" id="coolant" rows="3"></textarea>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="lubricant" class="form-label"><b>Manager Information</b></label>
                    <textarea name='gearbox-brand' class="form-control" id="gearbox" rows="3"></textarea>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="lubricant" class="form-label"><b>Mechanic Information</b></label>
                    <textarea name='grease-brand' class="form-control" id="grease" rows="3"></textarea>
                </div>
                <hr>
                <input type="submit" name="Submit" class="close" onClick='window.self.close()' value="Save">
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


$('.close').click(function(){
    window.self.close();
});
</script>