<?php
include 'includes/session.php';
if (isset($_SESSION['vm_id'])){
    include './includes/req_start.php';
if ($req_per == 1) {
if ($_POST['qty'] != 0) {
    $cart_spring_id = $_POST['id'];
    $cart_qty = $_POST['qty'];
    $cart_user_id = $_SESSION['vm_id'];

    $conn = $pdo->open();
    $stmt_check = $conn->prepare("SELECT COUNT(*) AS numrows FROM display_items WHERE display_spring_id=:cart_spring_id && display_items_qty>=:display_items_qty");
    $stmt_check->execute(['cart_spring_id' => $cart_spring_id, 'display_items_qty' => $cart_qty]);
    $row_check = $stmt_check->fetch();
    if ($row_check['numrows'] > 0) {
        $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM cart WHERE cart_spring_id=:cart_spring_id && cart_user_id=:cart_user_id");
        $stmt->execute(['cart_spring_id' => $cart_spring_id, 'cart_user_id' => $cart_user_id]);
        $row = $stmt->fetch();

        if ($row['numrows'] > 0) {
            $_SESSION['error'] = 'Already item is in cart.';
        } else {
            try {
                date_default_timezone_set('Asia/Kolkata');
                $today = date('d-m-Y h:i:s a');
                $stmt = $conn->prepare("INSERT INTO cart (cart_spring_id, cart_qty, cart_user_id,cart_added_date) VALUES (:cart_spring_id, :cart_qty, :cart_user_id, :cart_added_date)");
                $stmt->execute(['cart_spring_id' => $cart_spring_id, 'cart_qty' => $cart_qty, 'cart_user_id' => $cart_user_id, 'cart_added_date'=>$today]);
                if (!isset($_POST['buy_now']))
                    $_SESSION['success'] = "Added To Cart.";
            } catch (PDOException $e) {
                $_SESSION['error'] = $e->getMessage();
                header('location: index.php');
            }
        }
        $pdo->close();
        if (isset($_POST['buy_now'])) {
            header('location: cart.php');
            exit(1);
        }
    }else {
        $_SESSION['error'] = 'Out of Stock.';
    }
} else {
    $_SESSION['error'] = 'Out of Stock.';
}
}
}
header('location: index.php');