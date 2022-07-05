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

        img 
        {
          display:       block;
          margin-left:   auto;
          margin-right:  auto;        
        }

        button  
        {
           margin-left:   auto;
           margin-right:  auto;
           display:       block;
        }  

        .center 
        {
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
<!--                                                                    BUTTON                                                                   -->
<!-- =========================================================================================================================================== -->
            <!-- BUTTON -->
            <div class="choose_rep_class">

            <!-- BACK -->
            <form action="https://sacmarketing.co.za/rep/" method="POST">
                <button 
                type="submit" 
                name="submit" 
                value="back" 
                style="margin-top: 10px"> 
                &nbsp Back &nbsp
                </button> 
            </form>   

            <!-- PLAN WEEK -->
            <form action="https://sacmarketing.co.za/rep/rep-schedule/home.php" method="POST">
                <button 
                type="submit" 
                name="submit" 
                value="Plan_week" 
                style="margin-top: 10px"> 
                &nbsp Plan Week &nbsp
                </button> 
            </form>   

            </div>
<!-- =========================================================================================================================================== -->
<!--                                                            REP SCHEDULE TABLE                                                               -->
<!-- =========================================================================================================================================== -->
<!-- =========================================================== -->
<!--                            BODY ENDS                        -->
<!-- =========================================================== -->     
        </body> 
<!-- =========================================================================================================================================== -->
<!--                                                                DOM ENDS                                                                     -->
<!-- =========================================================================================================================================== -->
    </html>

