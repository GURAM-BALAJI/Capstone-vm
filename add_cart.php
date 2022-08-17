<?php
include 'includes/session.php';
include './includes/req_start.php';
if ($req_per == 1) {
    if ($_POST['qty'] != 0) {
        $cart_spring_id = test_input($_POST['id']);
        $cart_qty = test_input($_POST['qty']);
        $cart_user_id = $_SESSION['vm_id'];
       //Sanitizing inputs.
        if ($cart_spring_id > 0 && $cart_qty > 0 && $cart_user_id > 0) {
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
                        $today = date('Y-m-d h:i:s a');
                        $stmt = $conn->prepare("INSERT INTO cart (cart_spring_id, cart_qty, cart_user_id,cart_added_date) VALUES (:cart_spring_id, :cart_qty, :cart_user_id, :cart_added_date)");
                        $stmt->execute(['cart_spring_id' => $cart_spring_id, 'cart_qty' => $cart_qty, 'cart_user_id' => $cart_user_id, 'cart_added_date' => $today]);
                        if (!isset($_POST['buy_now']))
                            $_SESSION['success'] = "Added To Cart.";
                    } catch (PDOException $e) {
                        $pdo->close();
                        $_SESSION['error'] = "Something Went Wrong.";
                        header('location: MyHome');
                    }
                }
                $pdo->close();
                if (isset($_POST['buy_now'])) {
                    header('location: MyCart');
                    exit(1);
                }
            } else {
                $_SESSION['error'] = 'Out of Stock.';
            }
        } else {
            $_SESSION['error'] = 'Wrong Inputs.';
        }
    } else {
        $_SESSION['error'] = 'Out of Stock.';
    }
}
header('location: MyHome');
