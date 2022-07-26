<!DOCTYPE html>
<?php
include 'includes/session.php';
include 'includes/header.php';
?>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <link rel="stylesheet" href="./style_nav_bar.css">

</head>
<style>
  body {
    background: linear-gradient(to right, rgba(235, 224, 232, 1) 52%, rgba(254, 191, 1, 1) 53%, rgba(254, 191, 1, 1) 100%);
    font-family: 'Roboto', sans-serif;
  }

  hr {
    display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    margin-left: auto;
    margin-right: auto;
    border-style: dot-dot-dash;
    border-width: 2px;
    color: #0E2231;
    width: 98%;
  }

  h3 {
    margin-left: 10px;
  }

  .hr_last {
    border-style: dot-dash;
    border-width: 4px;
    color: #181914;
    width: 98%;
  }

  div.scrollmenu {
    background-color: #333;
    overflow: auto;
    white-space: nowrap;
  }

  div.scrollmenu a {
    display: inline-block;
    text-align: center;
    padding: 14px;
    color: white;
    text-decoration: none;
    text-decoration-color: snow;
  }

  .back_ground {
    background-color: #777;
  }

  div.scrollmenu a:hover {
    background-color: #777;

  }

  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  td,
  th {
    border: px solid #dddddd;
    text-align: center;
    padding: 5px;
  }

 

  .amount-box>img {
    padding-top: 20px;
    width: 60px;
  }

  .amount {
    font-size: 55px;
    color:green;
  }

  .amount-box p {
    margin-top: 10px;
    margin-bottom: -10px;
  }

    
</style>

<body>
  <!-- partial:index.partial.html -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <center>
    <div style="background-color: #333;">
            <img src="logo.jpg" width="100%" height="70px">
    </div>
    <div style="background-color: #001a35;color: #89E6C4;"> WALLET </div>
  </center>
  <?php
  if (isset($_SESSION['error'])) {
    echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
    unset($_SESSION['error']);
  }
  if (isset($_SESSION['success'])) {
    echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
    unset($_SESSION['success']);
  }
  ?>
  <?php
  if (isset($_SESSION['vm_id'])) {
    $id = $_SESSION['vm_id'];
    $conn = $pdo->open();
    $stmt = $conn->prepare("SELECT user_amount,user_id FROM users WHERE user_delete = '0' AND user_id = $id ");
    $stmt->execute();
    foreach ($stmt as $row) { ?>
      <section class="content">
        <div class="modal-content" style="background-color:rgba(235, 224, 232, 0.900);box-shadow:1px 1px 8px #000000;">
          <div class="amount-box text-center">
            <img src="./images/wallet.png" alt="wallet">
            <p style="font-size:large;">Total Balance</p>
            <p class="amount" style="<?php if($row['user_amount']<=0) echo "color:red;";?>">&#8377;<?php echo $row['user_amount']; ?></p>
            <a href="recharge_form.php">
              <button type="button" style="width: 30%;height:35px;border:1.5px solid black;border-radius: 20px !important;margin:5% 2% 5% auto;color:#001a35;background-color:snow;  box-shadow: 2px 1px 4px #000000; " class="btn-sm">Add Money</button></a>
            <button type="button" style="width: 30%;height:35px;border:1.5px solid black;border-radius: 20px !important;margin:5% auto 5% 2%;color:#001a35;background-color:snow;  box-shadow: 2px 1px 4px #000000; "  class="btn-sm pay ">PAY FRIEND</button>
         
          </div>

        </div>
          <hr>
          
          
          <p style="font-size:large;padding-left: 10px;"><u><b>TRANSACTION</b></u></p>
<?php
if (isset($_SESSION['vm_id'])) {
    $id = $_SESSION['vm_id'];
    $conn = $pdo->open();
    $stmt = $conn->prepare("SELECT * FROM transaction WHERE transaction_user_id = $id ORDER BY transaction_id DESC LIMIT 7");
    $stmt->execute();
    foreach ($stmt as $row) { ?>
        <?php if ($row['transaction_amount'] < 0){
            $color = "red";
            $val="Debited from..";
        }else{
            $color = "green";
            $val="Credited to..";
         } ?>
        <div style="padding: 5px; margin: 5px; border-radius: 9px; border: 2px solid #001a35;background-color:white;">
            <table style="width:100%;">
                <tr>
                    <td style="float:left;font-size:large;">
                        <b><?php echo $row['transaction_send_to']; ?></b>
                    </td>
                    <td  style="width: 150px;color:<?php echo $color; ?>;">&#8377;<?php echo floatval($row['transaction_amount']); ?> /-</td>
                <tr>
                    <td><?php echo date("d-M-Y h:i:s A", strtotime($row['transaction_date'])); ?></td>
                    <td style="width: 150px;color:<?php echo $color; ?>;"><?php echo $val; ?> </td>
                <tr>
                </tr>
                </tr>
            </table>
        </div>
<?php }
} ?>


        </center>
      </section>
    <?php }
  } else { ?>
    <center>
      <h4 style="color:red">To View Your Account Balance:</h4>
      <a href="login.php">
        <button style=" background-color: #d24026; border: none; color: white; padding: 18px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 10px;">
          LOGIN</button>
      </a>

    </center>
  <?php } ?>
  <?php include 'account_modal.php'; ?>
  <br><br><br><br>
  <nav class="nav">


    <a href="index.php" class="nav__link ">
      <i class="material-icons nav__icon">home</i>
      <span class="nav__text">Home</span>
    </a>

    <a href="account.php" class="nav__link nav__link--active">
      <i class="material-icons nav__icon">account_balance_wallet</i>
      <span class="nav__text">Wallet</span>
    </a>

    <a href="cart.php" class="nav__link ">
      <?php
      if (isset($_SESSION['vm_id'])) {
        $user_id = $_SESSION['vm_id'];
        $stmt = $conn->prepare("SELECT * FROM cart WHERE cart_user_id=$user_id");
        $stmt->execute();
        $i = 0;
        foreach ($stmt as $row)
          $i++;
      ?>
        <b style="color:red;"><?php if ($i != 0) echo $i; ?></b>
      <?php } ?>
      <i class="material-icons nav__icon">shopping_cart</i>
      <span class="nav__text">Cart</span>
    </a>

    <a href="settings.php" class="nav__link">
      <i class="material-icons nav__icon">settings</i>
      <span class="nav__text">Settings</span>
    </a>
  </nav>
  <!-- partial -->
  <?php include 'includes/scripts.php'; ?>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#phone').keyup(function(ev) {
        var phone = $('#phone').val();
        if (phone) {
          $.ajax({
            type: 'POST',
            url: 'phone_cheak_ajaxData.php',
            data: 'phone=' + phone,
            success: function(html) {
              $('#phone_check').html(html);
            }
          });
        } else {
          $('#phone_check').html('');
        }
      });
    });
    $(function() {
      $(document).on('click', '.history', function(e) {
        e.preventDefault();
        $('#history').modal('show');
      });
      $(document).on('click', '.trasaction', function(e) {
        e.preventDefault();
        $('#trasaction').modal('show');
      });
      $(document).on('click', '.pay', function(e) {
        e.preventDefault();
        $('#pay').modal('show');
      });
      $(document).on('click', '.orders', function(e) {
        e.preventDefault();
        $('#orders').modal('show');
      });
    });
  </script>
</body>
<?php include './includes/req_end.php'; ?>

</html>