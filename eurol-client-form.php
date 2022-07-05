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
            <h1><b>Eurol Clients</b></h1>
        </div>

        <div class="container">
            <form action="eurol-visit.php" method="post" name="eurolClient">
                <!-- CUSTOMER NAME -->
                <div class="mb-3">

                    <label for="exampleFormControlInput1" class="form-label"><b>Customer</b></label>
                    <p>Enter Customer Name</p>

                    <input type="text" class="form-control" id="exampleFormControlInput1" name="customer" placeholder="Client Name"/>
                </div>
                <hr>
<!-- TRUCK BRANDS -->
                <label class="form-label"><b>Truck Brands</b></label>
                <select name='trucks[]' class="form-select" id="dropdownlist">
                    <option value=" Volvo"   >Volvo </option>
                    <option value="Scania"   >Scania      </option>
                    <option value="Mercedes" >Mercedes    </option>
                    <option value="MAN"      >MAN         </option>
                    <option value="DAF"      >DAF         </option>
                    <option value="BPW"      >BPW         </option>
                    <option value="Henred"   >Henred      </option>
                    <option value="Isuzu MCV">Isuzu    MCV</option>
                    <option value="Hino"     >Hino        </option>
                    <option value="UD"       >UD          </option>
                    <option value="Toyota"   >Toyota      </option>
                    <option value="Ford"     >Ford        </option>
                    <option value="Nissan"   >Nissan      </option>
                    <option value="Mazda"    >Mazda       </option>
                    <option value="Sprinter" >Sprinter    </option>
                    <option value="Sprinter" >Renault     </option>
                    <option value="Sprinter" >Iveco       </option>
                    <option value="Sprinter" >FAW         </option>
                </select>

                <div id="result" ></div>
                <script>
                    $("#dropdownlist").change(function (event) {{
                        var selected = $(this).find(":selected");
                        var tmp = selected.val();   
                    $('#result').text(tmp);
                        }
                    });
                </script>

                <?php
                    if(!empty($EurolClient)){
               
                    echo "<div class='container'>";
                    echo "<table border='1'>

                    <tr>
                    
                    <th>Eurol Client</th>

                    <th>Amount</th>

                    </tr>";
                    
                      echo "<tr>";
                    
                      echo "<td>" . $EurolClient . "</td>";

                      echo "<tb><button onclick='increment()'>+</button> <button onclick='decrement()'>-</button><input id=demoInput type=number></tb>";

                      echo "</tr>";
                    
                      echo "</table>";
                    
                      echo "</div>";
            }
            ?>
                
<!-- NUMBER OF TRUCK -->
                <hr>
                <label class="form-label"><b>Number Of Trucks</b></label>
                <select class="form-select" name='num_of_trucks'>
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
                            <input class="form-check-input" type="radio" name="luberadio" id="volumeRadios1"
                                value="0-100 L" checked> 0-100 L
                        </label>
                        <br>

                        <label class="radio-inline" for="volumeRadios2">
                            <input class="form-check-input" type="radio" name="luberadio" id="volumeRadios2"
                                value="101-1k L"> 101-1k L
                        </label>
                        <br>

                        <label class="radio-inline" for="volumeRadios3">
                            <input class="form-check-input" type="radio" name="luberadio" id="volumeRadios3"
                                value="1k - 5k L">1k - 5k L
                        </label>
                        <br>

                        <label class="radio-inline" for="volumeRadios4">
                            <input class="form-check-input" type="radio" name="luberadio" id="volumeRadios4"
                                value="5k - 10k L"> 5k - 10k L
                        </label>
                        <br>

                        <label class="radio-inline" for="volumeRadios5">
                            <input class="form-check-input" type="radio" name="luberadio" id="volumeRadios5"
                                value="10k L+"> 10k L+
                        </label>
                        
                    </div>

                </div>
                <hr>
                <input type="file" accept="images/*" capture="camera" name="files[]" multiple="multiple">
                    <hr>
                <input type="submit" name="Submit" value="Save">
            </form>
            <hr>
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
</script>
 <script>
   function increment() {
      document.getElementById('demoInput').stepUp();
   }
   function decrement() {
      document.getElementById('demoInput').stepDown();
   }
</script>
<!--<button onclick="increment()">+</button> <button onclick="decrement()">-</button><input id=demoInput type=number> -->