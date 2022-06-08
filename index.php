    <!-- EDITED, SPACED AND COMMENTED BY KEVIN 2021/09/02  -->

    <?php
// =====================================================================================================================================
//                                                          IMPORTS INCLUDES
// =====================================================================================================================================
    session_start();
    //$dir = dirname($_SERVER['PHP_SELF']);
    $dir = 'https://sacmarketing.co.za/Richard/RepReport/';
    $thisfile = htmlspecialchars($_SERVER["PHP_SELF"]);
// =====================================================================================================================================
//                                                          USER VALIDATION
// =====================================================================================================================================

    // LOGIN BUTTON CLICKED
    if ( $_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] == "login")
    {
        // DBCON NON WRITE
        require '../../globals/dbcon.inc';
    
        // TXT BOX TO LOACAL VAR
        $un = trim($_POST['username']);
        $pw = trim($_POST['password']);

        // SELECT USER ID AND LEVEL
        $sql = "SELECT 
                id,
                level,
                password 
                FROM sacstaff 
                WHERE name = '$un' 
                AND level > '10';";

        // QRY BUILDER
        $qry = mysqli_query($dbcon,$sql) or die("SQL ERROR: $sql");

        // IF CONNECTION SUCCESFULL
        if ( mysqli_num_rows($qry) > 0 )
        {
            // SEARCH DB FOR USER
            while ( $row = mysqli_fetch_assoc($qry) )
            {
                $rid = $row['id'];
                $lv = $row['level'];
                $hpw = $row['password'];

                //echo "$hpw<br>";

                // IF A MATCH FOUND DECRYPT PASSWORD
                if ( password_verify($pw, $hpw) )
                {
                    // IF MATCH FOUND GET ROW ID
                    session_start();
                    $_SESSION['sacmr'] = $rid;
                    // 60	1 minute	60
                    // 60	1 hour		3600
                    // 24	1 day		86400
                    // 7	1 week		604800

                    // SET THE SESSION ROW ID
                    setcookie('sacmr', $rid, time() + (86400 * 3), '/rep');
                    //include 'geolocate.js';

                    // DIRECT TP HOME
                    header("location: $dir/home.php");
                    exit;
                }

                // NO MATCH FOUND FOR PW
                else 
                {
                    $msg = "Bad Credentials.";
                    header("location: $dir/index.php?notice=$msg");
                }
            }
        }

        // // IF CONNECTION UNSUCCESFULL NO MATCH FOR USER
        else 
        {
            $msg = "Invalid Credentials.";
            header("location: $dir/index.php?notice=$msg");
            exit;
        }   
    }

    // IF COOKIES ALLREADY SET GOTO HOME
    else if ( isset($_COOKIE['sacmr']))
    {
    $rid = $_COOKIE["sacmr"];
    $_SESSION['sacmr'] = "$rid";
    header("location: $dir/home.php");
    exit;
    }

    // IF SESSION ALLREADY SET GOTO HOME
    else if ( isset($_SESSION["sacmr"]))
    {
    header("location: $dir/home.php");
    exit;
    }

    // ELSE DISPLAY THE LOGIN PAGE
    else 
    {

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
        <link rel="stylesheet" href="
        <?php 
        echo $dir.'/includes/repstyle.css'; 
        ?>">

        <script type='text/javascript'> 
        if(history.replaceState) history.replaceState({}, 
        "", "/rep/"); // show only root url</script>
    </head>
<!-- =================================================================================================================================== -->
<!--                                                           BODY                                                                      -->
<!-- =================================================================================================================================== -->
    <body>
        <section>
            <!-- SPACER -->
            <div class="h64">
            </div>

            <!-- PICTURE -->
            <div class="txt-ctr">
                <img src="includes/saclogo.png">
            </div>

            <!-- SPACER -->
            <div class="h16"> 
            </div>

    <?php
            // ECHO MESSAGE FOR INVALID CREDENTIALS
            $msg = $_GET['notice'];
            if ( $msg != "" )
            { 
                echo "<p><i>$msg</i></p>"; 
            } 
            else 
            { 
                echo "<p> </p>"; 
            }
    ?>
            <!-- UPDATE NOTICE COMMENT/UNCOMMENT -->
            <!--h2 class="red"><b>This app is currently being updated. Please refrain from logging in until this message has disappeared.</b></h2-->

            <!-- FORM(TO ACCEPT INPUT) -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <!-- USERNAME LABEL -->
				<label>Username: </label><br>

                <!-- TEXT BOX FOR USER NAME (ID = 'username') -->
				<input required name="username" class="input" type="text" autofocus>

                <!-- SPACER -->
				<div class="h32"> 
                </div>

                <!-- LABEL FOR PASSWORD -->
				<label>Password: </label><br>

                <!-- TEXT BOX FOR USER NAME (ID = 'password') -->
				<input required name="password" class="input" type="password" >
                
                <!-- SPACER -->
				<div class="h32"> 
                </div>

                <!-- SPACER -->
                <div class="h16"> 
                </div>
                <!-- BUTTON FOR LOGIN -->
				<button class="btnLogin" type="submit" name="submit" value="login">LOGIN</button>

                <!-- SPACER -->
                <div class="h32"> 
                </div>

                <!-- LINK TO FORGOT PASSWORD -->
                <div class="txt-ctr link"><a href="../mysac/loginpage-password-request.php?this=<?php echo $thisfile; ?>">Forgot your password?</a></div>
            </form>

        </section>
        <!-- SPACER -->
        <div class="h64"> 
        </div>

    </body>
    </html>

    <?php
    }
    ?>