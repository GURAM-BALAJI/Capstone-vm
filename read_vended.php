<?php
include 'includes/session.php';
$conn = $pdo->open();
$s = $conn->prepare("SELECT * FROM orders WHERE orders_delivered=:delivered LIMIT 1");
$s->execute(['delivered' => 1]);
foreach ($s as $r) {
    echo $r['orders_items'] . '/' . $r['orders_qty'];
    $stmt = $conn->prepare("DELETE FROM orders WHERE orders_id=:id");
    $stmt->execute(['id' => $r['orders_id']]);
}
$pdo->close();
