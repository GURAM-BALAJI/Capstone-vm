    <?php
    include 'includes/session.php';
    include 'includes/header.php';
    ?>
    <html lang="en">

    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta charset="UTF-8">
      <title></title>
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
    </style>

    <body>
      <center>
        <div style="background-color: #333;">
                <img src="logo.jpg" width="100%" height="70px">
        </div>
        <div style="background-color: #001a35;color: #89E6C4;"> Update Profile </div>
      </center>
      <section class="content">
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
        if (isset($_SESSION['vm_id'])) { ?>
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body">
                <center>
                  <img style="width:100px;height:100px;" src="<?php echo (!empty($user['user_photo'])) ? 'images/' . $user['user_photo'] : 'images/profile.jpg'; ?>" class="img-circle" alt="User Image">
                </center>
                <form class="form-horizontal" method="POST" action="profile_edit.php" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="email" name="email" value="<?php echo $user['user_email']; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>

                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="password" name="password" value="<?php echo $user['user_password']; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="contact" class="col-sm-3 control-label">Contact Info</label>

                    <div class="col-sm-9">
                      <input type="tel" class="form-control" id="contact" name="contact" value="<?php echo $user['user_phone']; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="photo" class="col-sm-3 control-label">Photo</label>

                    <div class="col-sm-9">
                      <input type="file" id="photo" name="photo">
                    </div>
                  </div>
                  <hr>

                  <div class="form-group">
                    <label for="curr_password" class="col-sm-3 control-label">Current Password</label>

                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="curr_password" name="curr_password" placeholder="input current password to save changes" required>
                    </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
                </form>
              </div>
            </div>
          </div>
        <?php } else { ?>
          <center>
            <h4 style="color:red">To View Your Profile:</h4>
            <a href="login.php">
              <button style=" background-color: #d24026; border: none; color: white; padding: 18px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 10px;">
                LOGIN</button>
            </a>
          </center>
        <?php } ?>
      </section>

      <br><br><br><br>
      <nav class="nav">

        <a href="index.php" class="nav__link ">
          <i class="material-icons nav__icon">home</i>
          <span class="nav__text">Home</span>
        </a>

        <a href="account.php" class="nav__link ">
          <i class="material-icons nav__icon">account_balance_wallet</i>
          <span class="nav__text">Wallet</span>
        </a>

        <a href="cart.php" class="nav__link">
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

        <a href="settings.php" class="nav__link nav__link--active">
          <i class="material-icons nav__icon">settings</i>
          <span class="nav__text">Settings</span>
        </a>

      </nav>
    </body>
    <?php include 'includes/scripts.php'; ?>
    <?php include './includes/req_end.php'; ?>
    </html>