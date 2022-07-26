<?php
include 'includes/session.php';
include './includes/req_start.php';
if ($req_per == 1) {
if (isset($_POST['pay'])) {
    $phone = $_POST['phone'];
    $amount = $_POST['amount'];
    $curr_password = $_POST['password'];
    $users_id = $_SESSION['vm_id'];
    if (password_verify($curr_password, $user['user_password'])) {
        $conn = $pdo->open();
        try {
            $win = '';
            $stmt_user1 = $conn->prepare("SELECT user_amount,user_id,user_phone FROM users WHERE user_id=:id");
            $stmt_user1->execute(['id' => $users_id]);
            foreach ($stmt_user1 as $row2) {
                $user_amount = $row2['user_amount'];
                if ($user_amount >= $amount) {
                    $sender_amount = $row2['user_amount'];
                    $sender_phone = $row2['user_phone'];
                }
            }
            $stmt_user2 = $conn->prepare("SELECT * FROM users WHERE user_phone=:phone");
            $stmt_user2->execute(['phone' => $phone]);
            foreach ($stmt_user2 as $row1) {
                $reciver_amount = $row1['user_amount'];
                $reciver_id = $row1['user_id'];
            }
            if ($reciver_id != $users_id) {
                if (isset($sender_amount)) {
                    if (isset($reciver_id)) {
                        date_default_timezone_set('Asia/Kolkata');
                        $today = date('Y-m-d h:i:s a');
                        $date = date('Y-m-d');
                        $stmt = $conn->prepare("INSERT INTO transaction (transaction_user_id, transaction_send_to, transaction_amount, transaction_method, transaction_added_by, transaction_type, transaction_date) VALUES (:transaction_user_id, :transaction_send_to, :transaction_amount, :transaction_method, :transaction_added_by, :transaction_type, :transaction_date)");
                        $stmt->execute(['transaction_user_id' => $users_id, 'transaction_send_to' => $phone, 'transaction_amount' => '-' . $amount, 'transaction_method' => 'pay friend', 'transaction_added_by' => $users_id, 'transaction_type' => 2, 'transaction_date' => $today]);
                        $stmt = $conn->prepare("INSERT INTO transaction ( transaction_user_id, transaction_send_to, transaction_amount, transaction_method, transaction_added_by, transaction_type, transaction_date) VALUES (:transaction_user_id, :transaction_send_to, :transaction_amount, :transaction_method, :transaction_added_by, :transaction_type, :transaction_date)");
                        $stmt->execute(['transaction_user_id' => $reciver_id, 'transaction_send_to' => $sender_phone, 'transaction_amount' => $amount, 'transaction_method' => 'pay friend', 'transaction_added_by' => $users_id, 'transaction_type' => 2, 'transaction_date' => $today]);
                        $amount1 = $sender_amount - $amount;
                        $stmt = $conn->prepare("UPDATE users SET user_amount=:amount WHERE user_id=:id");
                        $stmt->execute(['amount' => $amount1, 'id' => $users_id]);
                        $amount2 = $reciver_amount + $amount;
                        $stmt = $conn->prepare("UPDATE users SET user_amount=:amount WHERE user_id=:id");
                        $stmt->execute(['amount' => $amount2, 'id' => $reciver_id]);
                        $_SESSION['success'] = '&#8377;' . $amount . ' Paid successfully to ' . $phone;
                    } else {
                        $_SESSION['error'] = 'Phone Number Does Not Exist.';
                    }
                } else {
                    $_SESSION['error'] = 'Insufficient Balance.';
                }
            } else {
                $_SESSION['error'] = 'You cant transfar to your account.';
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        $pdo->close();
    } else {
        $_SESSION['error'] = 'Incorrect Password.';
    }
} else {
    $_SESSION['error'] = 'Fill up form first';
}
}
header('location: account.php');
