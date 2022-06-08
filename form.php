<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<header>
    <img src="includes/saclogo.png" alt="saclogo.png">

</header>

<body>

    <div class="container" style="width:50%">
        <h2>Rep Report</h2>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>

        <form action="" method="get">

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><b>Customer</b></label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="name">
            </div>
            <hr>
            <label class="form-label"><b>Nr of trucks</b></label>
            <input type="text" class="form-control" id="exampleForm1" placeholder="Number of trucks">
            <select class="form-select" multiple="multiple" id="exampleForm1" aria-label="Default select example"
                id="exampleForm">
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
            <label class="form-label"><b>Truck brands</b></label>
            <script>

            </script>
            <input type="text" class="form-control" id="exampleForm" placeholder="brands">
            <select name="options[]" id="edit-states1-id" data-placeholder="Placeholder..." class="form-select multiple"
                multiple="multiple">
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
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1"
                    checked>
                <label class="form-check-label" for="exampleRadios1">
                    0-100 L
                </label>
                <br>
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                <label class="form-check-label" for="exampleRadios2">
                    101-1k L
                </label>
                <br>
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                <label class="form-check-label" for="exampleRadios2">
                    1k - 5k L
                </label>
                <br>
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                <label class="form-check-label" for="exampleRadios2">
                    5k - 10k L
                </label>
                <br>
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                <label class="form-check-label" for="exampleRadios2">
                    10k L+
                </label>
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
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1"
                    checked>
                <label class="form-check-label" for="exampleRadios1">
                    10k - 20k km
                </label>
                <br>
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                <label class="form-check-label" for="exampleRadios2">
                    20k - 40k km
                </label>
                <br>
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                <label class="form-check-label" for="exampleRadios2">
                    40k - 60k km
                </label>
                <br>
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                <label class="form-check-label" for="exampleRadios2">
                    60k+ km
                </label>
            </div>
            <hr>
            <label for="radioForm2" class="form-label"><b>Pack size preference</b></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1"
                    checked>
                <label class="form-check-label" for="exampleRadios1">
                    1L
                </label>
                <br>
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                <label class="form-check-label" for="exampleRadios2">
                    2L
                </label>
                <br>
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                <label class="form-check-label" for="exampleRadios2">
                    5L
                </label>
                <br>
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                <label class="form-check-label" for="exampleRadios2">
                    25L
                </label>
                <br>
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                <label class="form-check-label" for="exampleRadios2">
                    200L
                </label>
                <br>
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                <label class="form-check-label" for="exampleRadios2">
                    Other
                </label>
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
        </form>
    </div>
</body>

</html>