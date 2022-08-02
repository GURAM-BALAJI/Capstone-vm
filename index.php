<!DOCTYPE html>
<?php
include 'includes/session.php';
include 'includes/header.php';
?>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Vending Machine</title>
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

    h5 {
        margin-left: 10px;
        color: darkgreen;
        font-family: bold;
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

    p {
        float: right;
        color: darkgray;
        margin-top: -10px;
    }
</style>

<body>
    <!-- partial:index.partial.html -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <center>
        <div style="background-color: #333;">
            <img src="logo.jpg" width="100%" height="70px">
        </div>


        <div style="background-color: #001a35;color: #89E6C4;">ITEMS</div>
        <?php
        $conn = $pdo->open();
        $stmt = $conn->prepare("SELECT * FROM message");
        $stmt->execute();
        foreach ($stmt as $row) {
            if ($row['message_id'] == 1 && !empty($row['message'])) { ?>
                <marquee style="color:yellow;"><?php echo $row['message']; ?></marquee>
            <?php }
            if ($row['message_id'] == 2 && !empty($row['message'])) { ?>
                <marquee style="color:yellow;"><?php echo $row['message']; ?></marquee>
        <?php }
        } ?>
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
    </center>
    <section class="content">
        <div class="modal-content">
            <div class="modal-body">
                <table style="width: 100%;">
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM display_items WHERE display_items_qty>:display_items_qty");
                    $stmt->execute(['display_items_qty' => 0]);
                    foreach ($stmt as $row) {
                        $items_id = $row['display_items_id'];
                        $stmt1 = $conn->prepare("SELECT * FROM items WHERE items_id=:items_id");
                        $stmt1->execute(['items_id' => $items_id]);
                        foreach ($stmt1 as $row1) {
                    ?>
                            <form method="POST" action="add_cart.php">
                                <tr>
                                    <td rowspan="3" style="padding-right:0.8rem;"> <img src="./items_images/<?php echo $row1['items_image']; ?>" height="150rem" width="150rem"> </td>
                                    <td colspan="2">
                                        <?php echo "<h2 style='text-transform: uppercase;'>" . $row1['items_name'] . "</h2>"; ?>
                                    </td>
                                <tr>
                                    <td>
                                        <?php echo "<b style='font-size:2rem;'> &#8377;" . $row1['items_cost'] . "</b>"; ?>
                                    </td>
                                    <td>
                                        <select name="qty" class="form-control" style="float: right;">
                                            <?php
                                            $qty = $row['display_items_qty'];
                                            for ($i = 1; $i <= $qty; $i++)
                                                if ($i == 1)
                                                    echo "<option value='$i'>$i Item</option>";
                                                else
                                                    echo "<option value='$i'>$i Items</option>";
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 0.5rem;">
                                        <input type="hidden" name="id" value="<?php echo $row['display_spring_id']; ?>">
                                        <button name='add_cart' class='btn btn-warning btn' style="font-size:0.9rem"><i class='fa fa-cart-plust'></i>Add To Cart</button>
                                        <button name='buy_now' style='float:right;font-size:0.9rem' class='btn btn-success btn'>Buy
                                            Now</button>
                                    </td>
                                </tr>
                            </form>
                        <?php } ?>
                        <tr>
                            <td colspan="3">
                                <hr>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <?php if (!isset($_SESSION['vm_user'])) { ?>
            <center style="margin-top:4rem;">
                <?php
                $conn = $pdo->open();
                try {
                    $stmt = $conn->prepare("SELECT * FROM slogan ORDER BY RAND() LIMIT 1");
                    $stmt->execute(); ?>
                    <h4 style="color:red;font-size:30px;font-family: cursive;text-transform: capitalize;"><?php
                                                                                                            foreach ($stmt as $row)
                                                                                                                echo $row['slogan_sentance']; ?></h4>
                <?php } catch (PDOException $e) {
                    $_SESSION['error'] = $e->getMessage();
                }
                $pdo->close(); ?>
                <a href="login.php">
                    <button style=" background-color: #d24026; border: none; color: white; padding: 18px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 10px;">
                        LOGIN</button>
                </a>
            </center>
        <?php } ?>
    </section>

    <br><br><br><br>
    <nav class="nav">

        <a href="index.php" class="nav__link nav__link--active">
            <i class="material-icons nav__icon">home</i>
            <span class="nav__text">Home</span>
        </a>

        <a href="account.php" class="nav__link">
            <i class="material-icons nav__icon">account_balance_wallet</i>
            <span class="nav__text">Wallet</span>
        </a>
        <a href="cart.php" class="nav__link">
            <?php
            $i = 0;
            if (isset($_SESSION['vm_id'])) {
                $stmt = $conn->prepare("SELECT * FROM cart WHERE cart_user_id=:user_id");
                $stmt->execute(['user_id' => $_SESSION['vm_id']]);
                foreach ($stmt as $row)
                    $i++;
            ?>

            <?php } ?>
            <div class="container_cart">
                <i class="material-icons nav__icon">shopping_cart</i>
                <?php if ($i != 0) { ?>
                    <span class="badge_cart"><?php echo $i; ?></span>
                <?php } ?>
            </div>
            <span class="nav__text">Cart</span>
        </a>

        <a href="settings.php" class="nav__link">
            <i class="material-icons nav__icon">settings</i>
            <span class="nav__text">Settings</span>
        </a>

    </nav>
    <!-- partial -->

</body>
<?php include 'includes/scripts.php'; ?>
<?php include './includes/req_end.php'; ?>

</html>