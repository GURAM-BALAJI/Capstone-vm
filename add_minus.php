<?php
include 'includes/session.php';
if (!isset($_POST['remove'])) {
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $conn = $pdo->open();
    $stmt = $conn->prepare("SELECT * FROM cart left join display_items on cart_spring_id=display_spring_id WHERE cart_id='$id'");
    $stmt->execute();
    foreach ($stmt as $row) {
        if ($row['display_items_qty'] != '0') {
            $qty = $row['cart_qty'];
            if ($row['display_items_qty'] > $qty) {
                if (isset($_POST['add']))
                    $qty = $qty + 1;
                else
                if ($qty > 1)
                    $qty = $qty - 1;
            } else {
                if (isset($_POST['add'])){
                    $qty = $row['display_items_qty'];
                    $_SESSION['error'] = "Stock Is Limited.";
            }else
                if ($qty > 1)
                    $qty = $qty - 1;
            }
            $stmt = $conn->prepare("UPDATE cart SET cart_qty=:qty WHERE cart_id=:id");
            $stmt->execute(['qty' => $qty, 'id' => $id]);
        } else {
            $stmt = $conn->prepare("DELETE FROM cart WHERE cart_id=:id");
            $stmt->execute(['id' => $id]);
            $_SESSION['error'] = "Out Of Stock.";
        }
    }
    $pdo->close();
}
}else{
    $id = $_POST['id'];
    $conn = $pdo->open();
    $stmt = $conn->prepare("DELETE FROM cart WHERE cart_id=:id");
    $stmt->execute(['id' => $id]);
    $_SESSION['error'] = "Item deleted.";
}
header('location: cart.php');