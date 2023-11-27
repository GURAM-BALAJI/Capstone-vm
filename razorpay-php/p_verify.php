<?php

require('config.php');
include '../includes/session.php';

require('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false) {
    $api = new Api($keyId, $keySecret);

    try {
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature'],
        );

        $api->utility->verifyPaymentSignature($attributes);
    } catch (SignatureVerificationError $e) {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true) {
    $id = $_SESSION['vm_id'];
    if ($id > 0 && $_POST['razorpay_amount'] > 0) {
        $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM transaction WHERE transaction_send_to=:transaction_send_to ");
        $stmt->execute(['transaction_send_to' => $_SESSION['razorpay_order_id']]);
        $row = $stmt->fetch();

        if ($row['numrows'] > 0) {
            echo 'Already added.';
        } else {
            $add_amount = $_POST['razorpay_amount'] / 100;
            date_default_timezone_set('Asia/Kolkata');
            $today = date('Y-m-d h:i:s a');
            $date = date('Y-m-d');
            $conn = $pdo->open();
            $stmt = $conn->prepare("SELECT user_amount FROM users WHERE user_id=:id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch();
            $amount = $row['user_amount'];
            $amount = intval($add_amount) + intval($amount);
            try {
                $stmt = $conn->prepare("UPDATE users SET user_amount=:amount WHERE user_id=:id");
                $stmt->execute(['amount' => $amount, 'id' => $id]);
                $stmt = $conn->prepare("INSERT INTO transaction ( transaction_user_id, transaction_send_to, transaction_amount, transaction_added_by, transaction_type,transaction_date,transaction_status) VALUES (:transaction_user_id, :transaction_send_to, :transaction_amount, :transaction_added_by, :transaction_type,:transaction_date,:transaction_status)");
                $stmt->execute(['transaction_user_id' => $id, 'transaction_send_to' => $_SESSION['razorpay_order_id'], 'transaction_amount' => $add_amount,  'transaction_added_by' => $id, 'transaction_type' => 3, 'transaction_date' => $today, 'transaction_status' => 'TXN_Success']);
                $html = "<p>Your payment Successfull.</p>";
            } catch (PDOException $e) {
                $_SESSION['error'] = "Something Went Wrong.";
                $stmt = $conn->prepare("INSERT INTO transaction ( transaction_user_id, transaction_send_to, transaction_amount, transaction_added_by, transaction_type,transaction_date,transaction_status) VALUES (:transaction_user_id, :transaction_send_to, :transaction_amount, :transaction_added_by, :transaction_type,:transaction_date,:transaction_status)");
                $stmt->execute(['transaction_user_id' => $id, 'transaction_send_to' => $_SESSION['razorpay_order_id'], 'transaction_amount' => $add_amount,  'transaction_added_by' => $id, 'transaction_type' => 2, 'transaction_date' => $today, 'transaction_status' => 'TXN_Failed']);
            }
            $pdo->close();
        }
    } else {
        $_SESSION['error'] = 'Wrong Inputs.';
    }
} else {
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
}

echo $html;
header('location: ../MyWallet');
