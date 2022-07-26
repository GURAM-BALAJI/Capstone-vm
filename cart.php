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
            <table>
                <tr>
                    <th>
                        <img src="logo.jpg" width="100%" height="100px">
                    </th>
                </tr>
            </table>
        </div>


        <div style="background-color: #001a35;color: #89E6C4;">CART</div>
        <?php
        if (isset($_SESSION['vm_id'])) {
            $user_id = $_SESSION['vm_id'];
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
                     $stmt = $conn->prepare("SELECT * FROM cart left join display_items on display_spring_id=cart_spring_id WHERE cart_user_id=$user_id");
                     $stmt->execute();
                     foreach ($stmt as $row111) {
                        $id=$row111['cart_id'];
                        $qty = $row111['display_items_qty'];
                        if($qty==0){
                        $stmt = $conn->prepare("DELETE FROM cart WHERE cart_id=:id");
                        $stmt->execute(['id' => $id]);
                        }elseif($row111['display_items_qty']<$row111['cart_qty']){
                        $stmt = $conn->prepare("UPDATE cart SET cart_qty=:qty WHERE cart_id=:id");
                        $stmt->execute(['qty' => $qty, 'id' => $id]);
                        }
                    }
                    $total = $i = 0;
                    $stmt = $conn->prepare("SELECT * FROM cart left join display_items on display_spring_id=cart_spring_id WHERE cart_user_id=$user_id");
                    $stmt->execute();
                    foreach ($stmt as $row11) {
                        $i = 1;
                        $items_id = $row11['display_items_id'];
                        $stmt1 = $conn->prepare("SELECT * FROM items WHERE items_id=$items_id");
                        $stmt1->execute();
                        foreach ($stmt1 as $row1) {
                    ?>
                    <tr>
                        <td rowspan="3"> <img src="./items_images/<?php echo $row1['items_image']; ?>" height="150px"
                                width="150px"> </td>
                        <td colspan="2">
                            <?php echo "<h2 style='text-transform: uppercase;'>" . $row1['items_name'] . "</h2>"; ?>
                        </td>
                    <tr>
                        <td colspan="2">
                            <form method="POST" action="add_minus.php">
                                <center>
                                    <input type="hidden" name="id" value="<?php echo $row11['cart_id']; ?>">
                                    <?php if($row11['cart_qty']=='1'){?>
                                    <input style="background-color:aliceblue;border: none;" type="submit" name="remove"
                                        value="&#10060;">
                                    <?php }else{?>
                                    <input style="background-color: #d24026;border: none;" type="submit" name="minus"
                                        value=" - ">
                                    <?php }?>
                                    &nbsp;
                                    <input type="text" name="qty" size="1" onfocus="blur()"
                                        value="<?php echo $row11['cart_qty']; ?>">
                                    &nbsp;
                                    <input style="background-color:chartreuse;border: none;" type="submit" name="add"
                                        value=" + ">
                                </center>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Sub-Total
                        </td>
                        <td>
                            <?php
                                    $total += $row11['cart_qty'] * $row1['items_cost'];
                                    echo '<b>&#8377;' . $row11['cart_qty'] * $row1['items_cost'] . '</b>'; ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3">
                            <hr>
                        </td>
                    </tr>
                    <?php 
                    }
                    if ($i == 1){?>
                    <tr>
                        <th colspan='2'>
                            <center>TOTAL:</center>
                        </th>
                        <th>
                            <center>&#8377;<?php echo $total; ?></center>
                        </th>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan='2'>
                            <button
                                style="width:95%;height:50px;font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;border-radius:25px;;"
                                class="btn btn-success btn-sm buy btn-flat">Buy Now</button>
                        </td>
                    </tr>
                    <?php }
                    ?>
                </table>
                <?php if ($i == 0) {
                    echo "<center><h1>Your Stomach Is Empty.</h1>";
                    echo "<img src='./images/hunger.png'>";
                    echo "<h2>Order Somthing..</h2></center>";
                }
                ?>
            </div>
        </div>
    </section>
    <?php } else { ?>
    <center>
        <h4 style="color:red">To View Your Cart :</h4>
        <a href="login.php">
            <button
                style=" background-color: #d24026; border: none; color: white; padding: 18px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 10px;">
                LOGIN</button>
        </a>

    </center>
    <?php } ?>
    <br><br><br><br>
    <nav class="nav">

        <a href="index.php" class="nav__link ">
            <i class="material-icons nav__icon">home</i>
            <span class="nav__text">Home</span>
        </a>

        <a href="account.php" class="nav__link">
            <i class="material-icons nav__icon">account_balance_wallet</i>
            <span class="nav__text">Wallet</span>
        </a>

        <a href="cart.php" class="nav__link nav__link--active">
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

</body>
<?php include './cart_module.php'; ?>
<?php include 'includes/scripts.php'; ?>
<script>
$(function() {
    $(document).on('click', '.buy', function(e) {
        e.preventDefault();
        $('#buy').modal('show');
    });
});
</script>

</html>