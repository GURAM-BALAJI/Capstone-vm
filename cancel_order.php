<?php
include 'includes/session.php';
include './includes/req_start.php';

if (isset($_SESSION["vm_id"])) {
    $id = $_SESSION['vm_id'];

    $conn = $pdo->open();
    $stmt = $conn->prepare("SELECT * FROM orders WHERE orders_user_id = '$id' LIMIT 1");
    $stmt->execute();
    foreach ($stmt as $row) {
        if ($req_per == 1) {
            date_default_timezone_set('Asia/Kolkata');
            $today = date('Y-m-d h:i:s a');
            $orders_cost = explode(',', $row['orders_cost']);
            $update_qty = explode(',', $row['orders_qty']);
            $update_items = explode(',', $row['orders_items']);
            $cost = $i = 0;
            foreach ($update_items as $dis_id) {
                if (!empty($dis_id)) {
                    $cost += $orders_cost[$i] * $update_qty[$i];
                    $stmt_display = $conn->prepare("SELECT * FROM display_items WHERE display_id='$dis_id'");
                    $stmt_display->execute();
                    foreach ($stmt_display as $row_display)
                        $rem_qty = $row_display['display_items_qty'] + $update_qty[$i];
                    $stmt_display_update = $conn->prepare("UPDATE display_items SET display_items_qty=$rem_qty WHERE display_id=$dis_id");
                    $stmt_display_update->execute();
                }
                $i++;
            }
            $stmt_user = $conn->prepare("SELECT * FROM users WHERE user_id=$id");
            $stmt_user->execute();
            foreach ($stmt_user as $row_user) {
                $balance = $row_user['user_amount'] + $cost;
                $stmt_user_update = $conn->prepare("UPDATE users SET user_amount=$balance WHERE user_id=$id");
                $stmt_user_update->execute();
            }
            $stmt = $conn->prepare("INSERT INTO transaction (transaction_user_id,transaction_send_to,transaction_amount,transaction_added_by,transaction_type,transaction_date) VALUES (:transaction_user_id,:transaction_send_to,:transaction_amount,:transaction_added_by,:transaction_type,:transaction_date)");
            $stmt->execute(['transaction_user_id' => $id, 'transaction_send_to' => 'Refunded', 'transaction_amount' => $cost,  'transaction_added_by' => $id, 'transaction_type' => 1, 'transaction_date' => $today]);
            $stmt_user_update = $conn->prepare("UPDATE orders SET orders_delivered='2' WHERE orders_user_id = '$id' AND orders_id='" . $row['orders_id'] . "'");
            $stmt_user_update->execute();
            $stmt = $conn->prepare("DELETE FROM orders WHERE orders_id=:id AND orders_user_id=:user_id");
            $stmt->execute(['id' => $row['orders_id'], 'user_id' => $id]);
            $_SESSION['success'] = "Your Order Has Been Cancelled.";
        }
    }
}
header('location:cart.php');
