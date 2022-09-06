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
      .file-upload {
        background-color: #ffffff;
        width: 90%;
        margin: 0 auto;
        padding: 10px;
      }

      .file-upload-btn {
        width: 100%;
        margin: 0;
        color: #fff;
        background: #1FB264;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #15824B;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
      }

      .file-upload-btn:hover {
        background: #1AA059;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
      }

      .file-upload-btn:active {
        border: 0;
        transition: all .2s ease;
      }

      .file-upload-content {
        display: none;
        text-align: center;
      }

      .file-upload-input {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
      }

      .image-upload-wrap {
        margin-top: 20px;
        border: 4px dashed #1FB264;
        position: relative;
      }

      .image-dropping,
      .image-upload-wrap:hover {
        background-color: #1FB264;
        border: 4px dashed #ffffff;
      }

      .image-title-wrap {
        padding: 0 15px 15px 15px;
        color: #222;
      }

      .drag-text {
        text-align: center;
      }

      .drag-text h3 {
        font-weight: 100;
        text-transform: uppercase;
        color: #15824B;
        padding: 60px 0;
      }

      .file-upload-image {
        max-height: 200px;
        max-width: 200px;
        margin: auto;
        padding: 20px;
      }

      .remove-image {
        width: 200px;
        margin: 0;
        color: #fff;
        background: #cd4535;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #b02818;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
      }

      .remove-image:hover {
        background: #c13b2a;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
      }

      .remove-image:active {
        border: 0;
        transition: all .2s ease;
      }


      body {
        background:
          <?php if (isset($_COOKIE["theme"]))
            echo "linear-gradient( to right, #c6eaff 50%, #38b6ff 50%, #c6eaff 0%, #38b6ff 0%)";
          else
            echo "linear-gradient(to right, rgba(235, 224, 232, 1) 52%, rgba(254, 191, 1, 1) 53%, rgba(254, 191, 1, 1) 100%)";
          ?>;
        font-family: 'Roboto', sans-serif;
      }

      .nav__link--active {
        color:
          <?php if (isset($_COOKIE["theme"]))
            echo "#38b6ff";
          else
            echo "rgba(254, 191, 1, 1)";
          ?>;
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
        if (isset($_SESSION['vm_user'])) { ?>
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body">
                <center>
                  <img style="width:140px;height:140px;padding:20px;" src="<?php echo (!empty($user['user_photo'])) ? 'images/' . $user['user_photo'] : 'images/profile.jpg'; ?>" class="img-circle" alt="User Image">
                </center>
                <form class="form-horizontal" method="POST" action="profile_edit.php" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>" autocomplete="OFF">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="email" name="email" value="<?php echo $user['user_email']; ?>" autocomplete="OFF">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>

                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="password" name="password" value="<?php echo $user['user_password']; ?>" autocomplete="OFF">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="contact" class="col-sm-3 control-label">Contact Info</label>

                    <div class="col-sm-9">
                      <input type="tel" class="form-control" id="contact" name="contact" value="<?php echo $user['user_phone']; ?>" autocomplete="OFF">
                    </div>
                  </div>
                  <div class="form-group">
                    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
                    <div class="file-upload">
                      <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>

                      <div class="image-upload-wrap">
                        <input class="file-upload-input" type='file' onchange="readURL(this);"  id="photo" name="photo" accept="image/*" />
                        <div class="drag-text">
                          <h3>Drag and drop a file or select add Image</h3>
                        </div>
                      </div>
                      <div class="file-upload-content">
                        <img class="file-upload-image" src="#" alt="your image" />
                        <div class="image-title-wrap">
                          <button type="button" onclick="removeUpload()" class="remove-image">Remove </button>
                        </div>
                      </div>
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
            <a href="LogMe">
              <button style=" background-color: #d24026; border: none; color: white; padding: 18px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 10px;">
                LOGIN</button>
            </a>
          </center>
        <?php } ?>
      </section>

      <br><br><br><br>
      <nav class="nav">

        <a href="MyHome" class="nav__link ">
          <i class="material-icons nav__icon">home</i>
          <span class="nav__text">Home</span>
        </a>

        <a href="MyWallet" class="nav__link ">
          <i class="material-icons nav__icon">account_balance_wallet</i>
          <span class="nav__text">Wallet</span>
        </a>

        <a href="MyCart" class="nav__link">
          <?php
          $i = 0;
          if (isset($_SESSION['vm_id'])) {
            $conn = $pdo->open();
            $stmt = $conn->prepare("SELECT * FROM cart WHERE cart_user_id=:user_id");
            $stmt->execute(['user_id' => $_SESSION['vm_id']]);
            foreach ($stmt as $row)
              $i++;
          ?>

          <?php $pdo->close();
          } ?>
          <div class="container_cart">
            <i class="material-icons nav__icon">shopping_cart</i>
            <?php if ($i != 0) { ?>
              <span class="badge_cart"><?php echo $i; ?></span>
            <?php } ?>
          </div>
          <span class="nav__text">Cart</span>
        </a>

        <a href="MySettings" class="nav__link nav__link--active">
          <i class="material-icons nav__icon">settings</i>
          <span class="nav__text">Settings</span>
        </a>

      </nav>
    </body>
    <script>
      function readURL(input) {
        if (input.files && input.files[0]) {

          var reader = new FileReader();

          reader.onload = function(e) {
            $('.image-upload-wrap').hide();

            $('.file-upload-image').attr('src', e.target.result);
            $('.file-upload-content').show();

            $('.image-title').html(input.files[0].name);
          };

          reader.readAsDataURL(input.files[0]);

        } else {
          removeUpload();
        }
      }

      function removeUpload() {
        $('.file-upload-input').replaceWith($('.file-upload-input').clone());
        $('.file-upload-content').hide();
        $('.image-upload-wrap').show();
      }
      $('.image-upload-wrap').bind('dragover', function() {
        $('.image-upload-wrap').addClass('image-dropping');
      });
      $('.image-upload-wrap').bind('dragleave', function() {
        $('.image-upload-wrap').removeClass('image-dropping');
      });
    </script>
    <?php include 'includes/scripts.php'; ?>
    <?php include './includes/req_end.php'; ?>

    </html>