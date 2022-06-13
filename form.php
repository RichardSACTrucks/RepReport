<?php

session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js">
    </script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
    <link rel="stylesheet" src="/assests/formSheet.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
    
    <style>
    /* Media Queries: Tablet Landscape */
    @media screen and (max-width: 1060px) {
        #primary {
            width: 67%;
        }

        #secondary {
            width: 30%;
            margin-left: 3%;
        }
    }

    @media screen and (max-width: 768px) {
        #primary {
            width: 100%;
        }

        #secondary {
            width: 100%;
            margin: 0;
            border: none;
        }
    }

    .radio-inline {
        position: relative;
        display: flex;
        padding-left: 7%;
        margin-bottom: 0;
        font-weight: 400;
        vertical-align: middle;
        cursor: pointer;
    }

    .header {
        padding: 30px;
        text-align: center;
        color: black;
        font-size: 30px;
    }

    body {
        background-image: url('assests/img_truck.png');
        background-repeat: no-repeat;
        background-size: contain;
        background-repeat: no-repeat;
        background-attachment: fixed;
        margin: 0px;
    }

    .container {
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        color: #f1f1f1;
        width: 100%;
        height: 100%;
        padding: 2%;
        width: 50%;
    }
    </style>
</head>

<body>
    <div class="header">
        <img src="includes/saclogo.png" alt="saclogo.png">
        <h1><b>Eurol Hunter App</b></h1>
    </div>

    <div class="container">
        <form action="" method="POST">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><b>Customer</b></label>
                <p>Enter Customer Name</p>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="customer"
                    placeholder="name">
            </div>
            <hr>

            <label class="form-label"><b>Truck brands</b></label>
            <select name = 'subject[]' class="form-select" id="select-trucks-type">
                <option value=" Volvo">Volvo</option>
                <option value="Scania">Scania</option>
                <option value="Mercedes">Mercedes</option>
                <option value="MAN">MAN</option>
                <option value="DAF">DAF</option>
                <option value="BPW">BPW</option>
                <option value="Henred">Henred</option>
                <option value="Isuzu MCV">Isuzu MCV</option>
                <option value="Hino">Hino</option>
                <option value="UD">UD</option>
                <option value="Toyota">Toyota</option>
                <option value="Ford">Ford</option>
                <option value="Nissan">Nissan</option>
                <option value="Mazda">Mazda</option>
                <option value="Sprinter">Sprinter</option>
            </select>
            <?php
            // Retrieving each selected option
            foreach ($_POST['subject'] as $subject){
                echo "You selected $subject<br/>";
            }
            ?>
            <hr>
            <label class="form-label"><b>Nr of trucks</b></label>
            <select class="form-select">
                <option value="Volvo">1-10</option>
                <option value="Scania">11-30</option>
                <option value="Mercedes">31-60</option>
                <option value="MAN">61-90</option>
                <option value="DAF">91-120</option>
                <option value="BPW">121-200</option>
                <option value="Henred">201-500</option>
                <option value="Isuzu MCV">501-1000</option>
                <option value="Hino">10001+</option>
            </select>
            <hr>
            <label class="form-label"><b>Main truck brands</b></label>
            <select class="form-select">
                <option value="Volvo">Volvo</option>
                <option value="Scania">Scania</option>
                <option value="Mercedes">Mercedes</option>
                <option value="MAN">MAN</option>
                <option value="DAF">DAF</option>
                <option value="BPW">BPW</option>
                <option value="Henred">Henred</option>
                <option value="Isuzu MCV">Isuzu MCV</option>
                <option value="Hino">Hino</option>
                <option value="UD">UD</option>
                <option value="Toyota">Toyota</option>
                <option value="Ford">Ford</option>
                <option value="Nissan">Nissan</option>
                <option value="Mazda">Mazda</option>s
                <option value="Sprinter">Sprinter</option>
            </select>
            <hr>
            <label for="radioForm2" class="form-label"><b>Volume of lubricants (per month)</b></label>
            <div class="form-check">
                <div class="radio-inline">
                    <label class="radio-inline" for="exampleRadios1">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                            value="option1" checked> 0-100 L
                    </label>
                    <br>

                    <label class="radio-inline" for="exampleRadios2">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                            value="option2"> 101-1k L
                    </label>
                    <br>

                    <label class="radio-inline" for="exampleRadios3">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3"
                            value="option3">1k - 5k L
                    </label>
                    <br>

                    <label class="radio-inline" for="exampleRadios4">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4"
                            value="option4"> 5k - 10k L
                    </label>
                    <br>

                    <label class="radio-inline" for="exampleRadios5">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios5"
                            value="option5"> 10k L+
                    </label>
                </div>
            </div>
            <hr>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label"><b>Grease - Coolant - Gear Oil
                        Brands</b></label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <hr>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label"><b>Lubricant brand names</b></label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <hr>
            <label for="radioForm2" class="form-label"><b>Current change intervals</b></label>
            <div class="form-check">
                <div class="radio-inline">

                    <label class="radio-inline" for="exampleRadios1">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                            value="option1" checked>10k - 20k km
                    </label>
                    <br>

                    <label class="radio-inline" for="exampleRadios2">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                            value="option2"> 20k - 40k km
                    </label>
                    <br>

                    <label class="radio-inline" for="exampleRadios3">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                            value="option2">40k - 60k km
                    </label>
                    <br>

                    <label class="radio-inline" for="exampleRadios4">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                            value="option2">60k+ km
                    </label>
                </div>
            </div>
            <hr>
            <label for="radioForm2" class="form-label"><b>Pack size preference</b></label>
            <div class="form-check">
                <div class="radio-inline">

                    <label class="radio-inline" for="exampleRadios1">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                            value="option1" checked> 1L
                    </label>
                    <br>

                    <label class="radio-inline" for="exampleRadios2">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                            value="option2"> 2L
                    </label>
                    <br>

                    <label class="radio-inline" for="exampleRadios3">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                            value="option2">5L
                    </label>
                    <br>

                    <label class="radio-inline" for="exampleRadios3">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                            value="option2"> 25L
                    </label>
                    <br>

                    <label class="radio-inline" for="exampleRadios4">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                            value="option2"> 200L
                    </label>
                    <br>

                    <label class="radio-inline" for="exampleRadios5">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                            value="option2"> Other
                    </label>
                </div>
            </div>
            <hr>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><b>Other pack size preference</b></label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="custom pack size">
            </div>
            <hr>
            <label for="exampleFormControlInput1" class="form-label"><b>Contract?</b></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                    Yes
                </label>
                <br>
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                <label class="form-check-label" for="flexRadioDefault2">
                    No
                </label>
            </div>
            <hr>
            <div class="mb-3">
                <label for="startDate"><b>Contract end date</b></label>
                <input id="startDate" class="form-control" type="date" />
            </div>
            <hr>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><b>Lubrication dispensing type</b></label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="custom pack size">
            </div>
            <hr>
            <script type="text/javascript">
            $(".planMainY").click(function() {
                $(".OEM").hide();
            });
            $(".planMainY").click(function() {
                $(".OEM").show();
            });
            </script>
            <label for="exampleFormControlInput1" class="form-label"><b>Maintenance plan?</b></label>
            <div class="form-check">
                <input class="form-check-input planMainY" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                    Yes
                </label>
                <br>
                <input class="form-check-input planMainN" type="radio" name="flexRadioDefault" id="flexRadioDefault2"
                    checked>
                <label class="form-check-label" for="flexRadioDefault2">
                    No
                </label>
            </div>
            <hr>
            <div class="mb-3 OEM">
                <label for="exampleFormControlInput1" class="form-label"><b>Which OEM brand?</b></label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="custom pack size">
            </div>
            <hr>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><b>Owner Name</b></label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="custom pack size">
            </div>
            <hr>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><b>Contact Name</b></label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="custom pack size">
            </div>
            <hr>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><b>Engine oil product name</b></label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="custom pack size">
            </div>
            <hr>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><b>Gear oil product name</b></label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="custom pack size">
            </div>
            <hr>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><b>Coolant product name</b></label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="custom pack size">
            </div>
            <hr>
            <label for="exampleFormControlInput1" class="form-label"><b>Actions Taken</b></label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Quote provided
                </label>
                <br>
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                <label class="form-check-label" for="flexCheckChecked">
                    Catalogue provided
                </label>
                <br>
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                <label class="form-check-label" for="flexCheckChecked">
                    Sale made
                </label>
                <br>
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                <label class="form-check-label" for="flexCheckChecked">
                    Brochure provided
                </label>
                <br>
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                <label class="form-check-label" for="flexCheckChecked">
                    None
                </label>
            </div>
            <hr>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Send me a copy of my responses
                </label>
            </div>
            <hr>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><b>Email address</b></label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="custom pack size">
            </div>
            <hr>
            <input type="submit" name="Submit" value="Save">
            <input type="reset" value="Cancel">
        </form>
    </div>
</body>

</html>