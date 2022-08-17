<?php
include '../includes/session.php';

if (isset($_POST['add'])) {
	$id = test_input($_POST['id']);
	if ($id > 0) {
		$add_amount = test_input($_POST['add_amount']);
		date_default_timezone_set('Asia/Kolkata');
		$today = date('Y-m-d h:i:s a');
		$date = date('Y-m-d');
		$conn = $pdo->open();
		$stmt = $conn->prepare("SELECT user_amount FROM users WHERE user_id=:id");
		$stmt->execute(['id' => $id]);
		$row = $stmt->fetch();
		$amount = $row['user_amount'];
		$by = $admin['admin_id'];
		$amount = intval($add_amount) + intval($amount);
		try {
			$stmt = $conn->prepare("UPDATE users SET user_amount=:amount, updated_by_id=:by WHERE user_id=:id");
			$stmt->execute(['amount' => $amount, 'by' => $by, 'id' => $id]);
			$stmt = $conn->prepare("INSERT INTO transaction ( transaction_user_id, transaction_send_to, transaction_amount, transaction_added_by, transaction_type,transaction_date) VALUES (:transaction_user_id, :transaction_send_to, :transaction_amount, :transaction_added_by, :transaction_type,:transaction_date)");
			$stmt->execute(['transaction_user_id' => $id, 'transaction_send_to' => 'Added Manually', 'transaction_amount' => $add_amount,  'transaction_added_by' => $by, 'transaction_type' => 4, 'transaction_date' => $today]);

			$_SESSION['success'] = $add_amount . ' Rs updated successfully';
		} catch (PDOException $e) {
			$_SESSION['error'] = "Something Went Wrong.";
		}
		$pdo->close();
	} else {
		$_SESSION['error'] = 'Wrong Inputs.';
	}
} else {
	$_SESSION['error'] = 'Fill up money user form first';
}

header('location: users.php');
