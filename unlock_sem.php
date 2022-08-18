<?php
include 'includes/session.php';
$conn = $pdo->open();
$stmt_semopher = $conn->prepare("UPDATE semopher SET semopher_value=:semopher WHERE semopher_id=:semopher_id");
$stmt_semopher->execute(['semopher' => 0, 'semopher_id' => 1]);
$pdo->close();
