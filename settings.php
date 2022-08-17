<!DOCTYPE html>
<?php
include 'includes/session.php';
include 'includes/header.php';
?>
<html lang="en" oncontextmenu="return false">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="./style_nav_bar.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<style>
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
        width: 95%;
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


    .topnav {
        overflow: hidden;
    }

    .topnav a {
        float: left;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
    }

    .topnav a:hover {
        background-color: #932e3e;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
        border: 2px solid #fff;
        border-radius: 25px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(254, 191, 1, 1);
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: #fff;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #38b6ff;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #000;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>

<body>
    <!-- partial:index.partial.html -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <center>
        <div style="background-color: #333;">
            <img src="logo.jpg" width="100%" height="70px">
        </div>
        <div style="background-color: #001a35;color: #89E6C4;"> SETTINGS </div>
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
    if (isset($_SESSION['vm_user'])) { ?>
        <section class="content">
            <div class="modal-content">
                <div class="modal-body">
                    <center>
                        <img style="margin-top:2rem;width:12rem;height:12rem;border:1px solid black;box-shadow:1px 2px 8px #000000;" src="<?php echo (!empty($user['user_photo'])) ? 'images/' . $user['user_photo'] : 'images/profile.jpg'; ?>" class="img-circle" alt="User Image">
                        <h1 style="text-transform:uppercase;font-size: 5rem;"><?php echo $user['name']; ?></h1>
                        <hr style="margin-bottom:2rem;">
                        <b style="font-size:x-large;float:left;margin-left:10%;">Theme</b>
                        <label class="switch" style="float: right;margin-right:10%;">
                            <input type="checkbox" id="toggleTheme" <?php if (isset($_COOKIE["theme"])) {
                                                                        echo "checked";
                                                                    } ?>>
                            <span class="slider round"></span>
                        </label>
                        <hr style="margin-bottom:2rem;">
                        <a href="MyProfile"><button style="border-radius:3rem;width:40%;margin:2%;height:13rem;color:#454646;font-size:3rem;box-shadow:1px 1px 8px gray;"><i class="fa fa-user" style="padding: 0.7rem;" aria-hidden="true"></i><br />Profile</button></a>
                        <a href="MyContact"><button style="border-radius:3rem;width:40%;margin:2%;height:13rem;color:#454646;font-size:3rem;box-shadow:1px 1px 8px gray;"><i class="fa fa-commenting" style="padding: 0.7rem;" aria-hidden="true"></i><br />Contact</button></a>
                        <?php
                        $conn = $pdo->open();
                        try {
                            $stmt = $conn->prepare("SELECT * FROM message WHERE message_id=:message_id");
                            $stmt->execute(['message_id' => 3]);
                        ?>
                            <button onclick="window.open('whatsapp://send?text=<?php foreach ($stmt as $row) echo $row['message']; ?>')" style="border-radius:3rem;width:40%;margin:2%;height:13rem;color:#454646;font-size:3rem;box-shadow:1px 1px 8px gray;"><i class="fa fa-share-alt" style="padding: 0.7rem;" aria-hidden="true"></i><br />Share </button>
                        <?php } catch (PDOException $e) {
                            $_SESSION['error'] = "Something Went Wrong.";
                        }  ?>
                        <a href="our_team/YourLove"><button style="border-radius:3rem;width:40%;margin:2%;height:13rem;color:#454646;font-size:3rem;box-shadow:1px 1px 8px gray;"><i class="fa fa-users" style="padding: 0.7rem;" aria-hidden="true"></i><br />Team</button></a>
                        <a href="Out"><button style="border-radius:3rem;width:85%;margin:2%;height:7rem;color:white;font-size:x-large;margin-bottom:2rem;background-color:red;"><i class="fa fa-sign-out" aria-hidden="true"></i> LOG OUT</button></a>
                    </center>
                </div>
            </div>
        </section>
    <?php } else { ?>
        <center style="margin-top:20rem;">
            <?php
            $conn = $pdo->open();
            try {
                $stmt = $conn->prepare("SELECT * FROM slogan ORDER BY RAND() LIMIT 1");
                $stmt->execute(); ?>
                <h4 style="color:red;font-size:30px;font-family: cursive;text-transform: capitalize;"><?php
                                                                                                        foreach ($stmt as $row)
                                                                                                            echo $row['slogan_sentance']; ?></h4>
            <?php } catch (PDOException $e) {
                $_SESSION['error'] = "Something Went Wrong.";
            }
            $pdo->close(); ?>
            <a href="LogMe">
                <button style=" background-color: #d24026; border: none; color: white; padding: 18px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 10px;">
                    LOGIN</button>
            </a>
        </center>
    <?php } ?>
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
    <!-- partial -->
</body>
<script>
    $("#toggleTheme").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).attr('value', 'true');
            document.cookie = "theme=pradeep_color; Max-Age=" + 365 * 24 * 60 * 60;
        } else {
            $(this).attr('value', 'false');
            document.cookie = 'theme=; Max-Age=0';
        }
        location.reload();
    });
  
</script>
<?php include './includes/req_end.php'; ?>

</html>