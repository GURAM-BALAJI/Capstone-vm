<?php
include 'includes/session.php';
$redirect = 0;
if (isset($_SESSION['vm_id'])) {
    $id = $_SESSION['vm_id'];
    $conn = $pdo->open();
    $flag = 0;
    $stmt_semopher = $conn->prepare("SELECT * FROM semopher WHERE semopher_id=1");
    $stmt_semopher->execute();
    foreach ($stmt_semopher as $row_semopher) {
        $lock = $row_semopher['semopher_value'];
        if ($lock == 0) {
            $stmt_semopher = $conn->prepare("UPDATE semopher SET semopher_value=1 WHERE semopher_id=1");
            $stmt_semopher->execute();
        }
    }
    if ($lock == 0) {
        $total = 0;
        $stmt_check = $conn->prepare("SELECT * FROM cart left join display_items on display_spring_id=cart_spring_id left join items on items_id=display_items_id WHERE cart_user_id=:cart_user_id");
        $stmt_check->execute(['cart_user_id' => $id]);
        foreach ($stmt_check as $row_check) {
            $flag++;
            if ($row_check['display_items_qty'] >= $row_check['cart_qty']) {
                if ($flag == 1) {
                    $qty_array = $row_check['cart_qty'];
                    $item_array = $row_check['display_id'];
                    $cost_array = $row_check['items_cost'];
                } else {
                    $qty_array .= ',' . $row_check['cart_qty'];
                    $item_array .= ',' . $row_check['display_id'];
                    $cost_array .= ',' . $row_check['items_cost'];
                }
                $total += $row_check['cart_qty'] * $row_check['items_cost'];
            } else {
                $pdo->close();
                $_SESSION['error'] = 'Try Agian.';
                header('location: cart.php');
                exit();
            }
        }
        if ($flag == 0)
            $_SESSION['error'] = 'Cart Is Empty.';
        else {
            $stmt_user = $conn->prepare("SELECT * FROM users WHERE user_id=$id");
            $stmt_user->execute();
            foreach ($stmt_user as $row_user)
                if ($row_user['user_amount'] >= $total) {
                    $redirect = 1;
                    do {
                        $orders_otp = rand(9999, 1111);
                        $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM orders WHERE orders_otp=:orders_otp");
                        $stmt->execute(['orders_otp' => $orders_otp]);
                        $row = $stmt->fetch();
                    } while ($row['numrows']);
                    $update_qty = explode(',', $qty_array);
                    $update_items = explode(',', $item_array);
                    $i = 0;
                    foreach ($update_items as $dis_id) {
                        if (!empty($dis_id)) {
                            $stmt_display = $conn->prepare("SELECT * FROM display_items WHERE display_id='$dis_id'");
                            $stmt_display->execute();
                            foreach ($stmt_display as $row_display)
                                $rem_qty = $row_display['display_items_qty'] - $update_qty[$i];
                            $stmt_display_update = $conn->prepare("UPDATE display_items SET display_items_qty=$rem_qty WHERE display_id=$dis_id");
                            $stmt_display_update->execute();
                        }
                        $i++;
                    }
                    date_default_timezone_set('Asia/Kolkata');
                    $today = date('d-m-Y h:i:s a');
                    $date = date('Y-m-d');
                    $stmt = $conn->prepare("INSERT INTO orders (orders_qty,orders_cost,orders_items, orders_otp,orders_user_id,orders_date) VALUES (:orders_qty,:orders_cost,:orders_items,:orders_otp,:orders_user_id,:orders_date)");
                    $stmt->execute(['orders_qty' => $qty_array, 'orders_cost' => $cost_array, 'orders_items' => $item_array, 'orders_otp' => $orders_otp, 'orders_user_id' => $id, 'orders_date'=>$today]);
                    $stmt = $conn->prepare("DELETE FROM cart WHERE cart_user_id=:id");
                    $stmt->execute(['id' => $id]);
                    $balance = $row_user['user_amount'] - $total;
                    $stmt_user_update = $conn->prepare("UPDATE users SET user_amount=$balance WHERE user_id=$id");
                    $stmt_user_update->execute();
                    $stmt = $conn->prepare("INSERT INTO transaction (transaction_user_id,transaction_send_to,transaction_amount,transaction_method,transaction_added_by,transaction_type,transaction_date,) VALUES (:transaction_user_id,:transaction_send_to,:transaction_amount,:transaction_method,:transaction_added_by,:transaction_type,:transaction_date,:transaction_date)");
                    $stmt->execute(['transaction_user_id' => $id, 'transaction_send_to' => 'Order', 'transaction_amount' => $total, 'transaction_method' => 'Ordered', 'transaction_added_by' => $id, 'transaction_type'=>1, 'transaction_date'=>$today, 'transaction_date'=>$date]);
                } else
                    $_SESSION['error'] = 'Insufficient Balance.';
            $stmt_semopher = $conn->prepare("UPDATE semopher SET semopher_value=0 WHERE semopher_id=1");
            $stmt_semopher->execute();
            $pdo->close();
        }
    }
}
if ($redirect == 1)
    header('location: otp_display.php?otp=' . $orders_otp . '');
else
    header('location: cart.php');
