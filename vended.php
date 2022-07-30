<?php
include 'includes/session.php';
include './includes/req_start.php';
if ($req_per == 1) {
    if (isset($_SESSION['vm_id'])) {
        $id = $_SESSION['vm_id'];
        $conn = $pdo->open();
        $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM orders WHERE orders_delivered=:delivered");
        $stmt->execute(['delivered' => 1]);
        $row = $stmt->fetch();
        if ($row['numrows'] > 0) {
            $_SESSION['error'] = 'Please wait a movement others are vending.';
            header('location:vend_now.php');
            exit();
        } else {
            $order_id = $_POST['order_id'];
            $stmt_user_update = $conn->prepare("UPDATE orders SET orders_delivered='1' WHERE orders_user_id = '$id' AND orders_delivered='0' AND orders_id='$order_id'");
            $stmt_user_update->execute();
            echo "Vended Successfully.";
            echo "<a href='./index.php'><button>GO BACK</button></a>";
        }
    }
}else{
    header('location:index.php');
}
