<!-- Kevin Phillip Alers -->
<!-- =========================================================================================================================================== -->
<!--                                                                   Connector                                                                 -->
<!-- =========================================================================================================================================== -->
    <?php  

    session_start();

    $link = mysqli_connect("localhost","webbasic","W#Bb65!c");
            mysqli_select_db($link,"sacdev");

        // IF CONNECTION FAIL
        if ( $link -> connect_errno)
        {
            echo "connection failure";
        }

        // IF SESSION VALID SETS A LOCAL VAR TO THE VALUE OF THE SESSION WHICH IS THE USER ID
        if ( isset($_SESSION['sacmr']) )
        {
            $sesid = $_SESSION['sacmr'];        
        }

        // COMPARES THE DB USERID TO THAT OF THE SESSION USER ID
        $userqry = mysqli_query($link,
                "SELECT 
                id      ,
                name    ,
                surname ,
                branch  ,
                level 
                FROM sacstaff 
                WHERE id =  {$sesid}");

        // POPULATES lOCAL VARS WITH USER DATA
        while($row = mysqli_fetch_array($userqry))
        {
            $userID     = $row["id"];
            $userName   = $row["name"];
            $userSName  = $row["surname"];
            $userBranch = $row["branch"];
            $userlevel  = $row["level"];
        }
    
    ?>
<!-- =========================================================================================================================================== -->
<!--                                                                DOCUMENT HEADER                                                              -->
<!-- =========================================================================================================================================== -->
    <!DOCTYPE html>

    <html lang="en">

        <meta charset="UTF-8">
        <title>Rep Manager</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/mysac/mysac01.css"> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script> 
<!-- =========================================================================================================================================== -->
<!--                                                                    STYLE                                                                    -->
<!-- =========================================================================================================================================== -->
    <style>

        h1  {text-align: center;}
        h2  {text-align: center;}
        p   {text-align: center;}
        div {text-align: center;}

        /* Image */
        img 
        {
          display:       block;
          margin-left:   auto;
          margin-right:  auto;        
        }
        /* BUTTON */
        button  
        {
           margin-left:   auto;
           margin-right:  auto;
           display:       block;
        }  

        .center {
                    margin-left: auto;
                    margin-right: auto;
                }

    </style>
<!-- =========================================================================================================================================== -->
<!-- =========================================================================================================================================== -->
<!--                                                                    BODY                                                                     -->
<!-- =========================================================================================================================================== -->
        <body>
 
            <!-- PAGE HEADER -->
            <h1>My Schedule</h1>

            <!-- DISPLAYS USERNAME, PASSWORD AND BRANCH -->
            <h2><?php echo "" .$userName. " " .$userSName. " (" .$userBranch. ") " ?></h2>

<!-- =========================================================================================================================================== -->
<!--                                                          BUTTON                                                                             -->
<!-- =========================================================================================================================================== -->
            <!-- BUTTON -->
            <div class="choose_rep_class">

            <!-- LOGOUT -->
            <form action="https://sacmarketing.co.za/rep/home.php" method="POST">
                <button 
                type="submit" 
                name="submit" 
                value="Plan_Delivery" 
                style="margin-top: 10px"
                onclick="GottoPage()"> 
                &nbsp Back &nbsp
                </button> 
            </form>   

            </div>
<!-- =========================================================================================================================================== -->
<!--                                                            REP SCHEDULE TABLE                                                               -->
<!-- =========================================================================================================================================== -->
    <div style="overflow:auto; margin-top:50px;">

    <!-- SEARCHES DB FOR SELECTED REP-->
    <?php 

    // GET CURRENT MONTH TO BE USED IN SELECTING THE REP SCEDULE 
    $month = date('m'); 
    $Today = date('d');

    echo $month;


    // SELECTS REP CODE BASED ON REP NAME, SURNAME, BRANCH 
    $res = mysqli_query($link, "SELECT
                        id         ,
                        user       ,
                        name       ,
                        client_id  ,
                        client_name,
                        date       ,
                        dayname    ,
                        branch
                        FROM
                        rep_schedule
                        WHERE
                        name = '".$userName."'
                        AND branch = '".$userBranch."'
                        AND substring(date, 6,2) = '".$month."'
                        ORDER BY date ASC
                        ");

    if($link->query($res) === true)
    {       
        // PROMPTS THE USER WHEN QRY SUC                          
        //echo "updated Successful";  
    }                       

    else
    {
        // echo("Error description: " . $link -> error);
        // echo "Failed To write" . mysqli_connect_error();
    }

                        
    ?>
                
    <!-- TABLE START -->
    <table id="" style="border:outset;width:350px;" class="center">
        <thead>

            <!-- COLLUMN HEADERS -->
            <tr>                
                <th style="width: 5PX;">Date   </th>
                <th style="width: 5PX;">Day    </th>
                <th style="width: 5PX;">Client </th>
            </tr> 

        </thead>
                    
        <?php

            // WHILE THE QRY $RES IS BEING EXECUTED
            // POPULATE VARS
            while($row = mysqli_fetch_array($res))
            {
                $rowid       = $row["id"          ];
                $user        = $row["user"        ];
                $name        = $row["name"        ];
                $client_id   = $row["client_id"   ];
                $client_name = $row["client_name" ];
                $date        = $row["date"        ];
                $dayname     = $row["dayname"     ];
                $branch      = $row["branch"      ];     
                
                // CHANGES THE DATE VARIABLE TO ONY SHOW DAY
                $day = substr("$date", 8, -8);
                $id  = $row['id'];

                echo $date;
                
        ?>

        <tbody>
            <tr>                     
                <td> <?php echo $day     ;              ?> </td>
                <td> <?php echo $dayname ;              ?> </td>
                <td> <?php echo $row    ["client_name"] ?> </td>                
            </tr>
        </tbody>

            <?php
            }
            
            ?>
                
    </Table> 
    </div>   

<!-- =========================================================== -->
<!--                            BODY ENDS                        -->
<!-- =========================================================== -->     
        </body> 
<!-- =========================================================================================================================================== -->
<!--                                                                SCRIPTS                                                                      -->
<!-- =========================================================================================================================================== -->
    <script>
       
    </script>
<!-- =========================================================================================================================================== -->
<!--                                                                DOM ENDS                                                                     -->
<!-- =========================================================================================================================================== -->
    </html>

