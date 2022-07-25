<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
?>



<!DOCTYPE html>
<html>

<head>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');


    body {
      background: linear-gradient(to right, rgba(235, 224, 232, 1) 52%, rgba(254, 191, 1, 1) 53%, rgba(254, 191, 1, 1) 100%);
      font-family: 'Roboto', sans-serif;
    }

    .card {
      border: none;
      max-width: 450px;
      border-radius: 15px;
      margin: 150px 0 150px;
      padding: 35px;
      padding-bottom: 20px !important;
    }

    .heading {
      color: #322F2F;
      font-size: 20px;
      font-weight: bold;
    }



    img:hover {
      cursor: pointer;
    }

    .text-warning {
      font-size: 12px;
      font-weight: 500;
      color: #edb537 !important;
    }

    #cno {
      transform: translateY(-10px);
    }

    input {
      border-bottom: 1.5px solid #E8E5D2 !important;
      font-weight: bold;
      border-radius: 0;
      border: 0;

    }

    .form-group input:focus {
      border: 0;
      outline: 0;
    }

    .col-sm-5 {
      padding-left: 40%;
    }

    .btn {
      background: #F3A002 !important;
      border: none;
      border-radius: 30px;
      margin-top: 2rem;
    }

    .btn:focus {
      box-shadow: none;
    }

    .but {
      border-radius: 10px;
      font-size: small;
    }

    .but:hover {
      background-color: #F7D178;

    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }

    .rupee-img {
      position: relative;
      left: 17px;
      top: 2px;
      height: 14px;
      width: 10px;
      display: inline-block;
      background-image: url('rupee.png');
    }
  </style>
</head>

<body>

  <form method="post" action="pgRedirect.php">
    <div class="container-fluid">
      <div class="row d-flex justify-content-center">
        <div class="col-sm-12">
          <div class="card mx-auto">
            <p class="heading">Add Money To Wallet</p>
            <div class="form-group mb-3">
              <p class="text-warning mb-0 col-sm-12">RECHARGE</p>
              <span class="rupee-img">&#8377;</span>
              <input type="number" style="padding-left:12px ;" name="price" id="price" placeholder="Enter Amount" required value="100" oninput="onchange_price()">
            </div>
            <div class="form-group mb-2">
              <p class="text-warning mb-1" style="font-size: 10px;padding-left:12px ;">Recommended</p>
              <center>
                <input type="button" class="but" value="+ &#8377;100" onclick="onclickbutton_100()">
                <input type="button" class="but" value="+ &#8377;200" onclick="onclickbutton_200()">
                <input type="button" class="but" value="+ &#8377;400" onclick="onclickbutton_400()">
                <input type="button" class="but" value="+ &#8377;500" onclick="onclickbutton_500()">
                <input type="button" class="but" value="+ &#8377;1000" onclick="onclickbutton_1000()">
              </center>
            </div>
            <input type="submit" class="btn btn-primary" id="pay" value="Proceed To Add +100">
            <input type="hidden" name="INDUSTRY_TYPE_ID" value="Retail">
            <input type="hidden" name="CHANNEL_ID" value="WEB">
            <input type="hidden" name="order_id" value="<?php echo  "ORDS" . rand(10000, 99999999) ?>">

          </div>
        </div>
      </div>
    </div>
    </div>

  </form>


</body>
<script>
  function onchange_price() {
    document.getElementById('pay').value = "Proceed To Add +" + document.getElementById('price').value;
  }

  function onclickbutton_100() {
    val = document.getElementById('price').value;
    if (val == "")
      val = 0;
    document.getElementById('price').value = parseInt(val) + 100;
    document.getElementById('pay').value = "Proceed To Add +" + document.getElementById('price').value;
  }

  function onclickbutton_200() {
    val = document.getElementById('price').value;
    if (val == "")
      val = 0;
    document.getElementById('price').value = parseInt(val) + 200;
    document.getElementById('pay').value = "Proceed To Add +" + document.getElementById('price').value;
  }

  function onclickbutton_400() {
    val = document.getElementById('price').value;
    if (val == "")
      val = 0;
    document.getElementById('price').value = parseInt(val) + 400;
    document.getElementById('pay').value = "Proceed To Add +" + document.getElementById('price').value;
  }

  function onclickbutton_500() {
    val = document.getElementById('price').value;
    if (val == "")
      val = 0;
    document.getElementById('price').value = parseInt(val) + 500;
    document.getElementById('pay').value = "Proceed To Add +" + document.getElementById('price').value;
  }
  document.getElementById('pay').value = "Proceed To Add +" + document.getElementById('price').value;

  function onclickbutton_1000() {
    val = document.getElementById('price').value;
    if (val == "")
      val = 0;
    document.getElementById('price').value = parseInt(val) + 1000;
    document.getElementById('pay').value = "Proceed To Add +" + document.getElementById('price').value;
  }
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</html>