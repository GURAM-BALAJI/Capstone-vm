<?php
include './conn.php';
session_start();
if (!isset($_SESSION['vm_user'])) {
	if (isset($_COOKIE['keep_id'])){
		$stmt = $conn->prepare("SELECT * FROM sessionss WHERE sessions_cookies_id = :sessions_cookies_id");
		$stmt->execute(['sessions_cookies_id' => $_COOKIE['keep_id']]);
		$row1 = $stmt->fetch();
		if ($row1['numrows'] == 1) {
			$_SESSION['vm_user'] = 'True';
			$_SESSION['vm_id'] = $row1['sessions_user_id'];
		} else {
			header('location:logout.php');
			exit();
		}
	}
}
if (isset($_SESSION['vm_user'])) {
	$conn = $pdo->open();
	try {
		$stmt = $conn->prepare("SELECT user_amount,user_id,user_photo,name,user_email,user_password,user_phone FROM users WHERE user_id=:id");
		$stmt->execute(['id' => $_SESSION['vm_id']]);
		$user = $stmt->fetch();
	} catch (PDOException $e) {
		echo "There is some problem in connection: " . $e->getMessage();
	}
	$pdo->close();
}
