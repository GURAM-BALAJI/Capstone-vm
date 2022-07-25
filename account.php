<!DOCTYPE html>
<?php
include 'includes/session.php';
include 'includes/header.php';
?>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <title></title>
  <link rel="stylesheet" href="./style_nav_bar.css">

</head>
<style>
  body {
    background-color: #cfcfd2;
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
</style>

<body>
  <!-- partial:index.partial.html -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <center>
    <div style="background-color: #333;">
      <table>
        <tr>
          <th>
            <img src="newmain.jpg" width="100%" height="100px">
          </th>
        </tr>
      </table>
    </div>
    <div style="background-color: #001a35;color: #89E6C4;"> ACCOUNT </div>
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
        <div class="modal-content">
          <div class="modal-body">
            <center>
              <h2>Your Balance:</h2>
              <h1 style="color:green;">&#8377;<?php echo $row['user_amount']; ?></h1>
            </center>
          </div>
        </div>
        <center>
          <hr>
          <a href="form.php">
          <button style="width:95%;height:50px;font-family:monospace;" class="btn btn-primary btn-sm btn-flat">RECHARGE</button></a>
          <hr>
          <button style="width:95%;height:50px;font-family:monospace;" class="btn btn-primary btn-sm pay btn-flat">Pay To Friend</button>
          <hr>
          <button style="width:95%;height:50px;font-family:monospace;" class="btn btn-primary btn-sm orders btn-flat">Present Orders</button>
          <hr>
          <button style="width:95%;height:50px;font-family:monospace;" class="btn btn-primary btn-sm history btn-flat">Orders History</button>
          <hr>
          <button style="width:95%;height:50px;font-family:monospace;" class="btn btn-primary btn-sm trasaction btn-flat">Trasactions</button>
          <hr>

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
  <script>
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

</html>