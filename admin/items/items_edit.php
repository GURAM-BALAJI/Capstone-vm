<?php
include '../includes/session.php';

if (isset($_POST['edit'])) {
	$id = test_input($_POST['id']);
	$name = test_input($_POST['name']);
	$cost = test_input($_POST['cost']);
	if ($id > 0 && $cost > 0) {
		date_default_timezone_set('Asia/Kolkata');
		$today = date('Y-m-d h:i:s a');
		try {
			$stmt = $conn->prepare("UPDATE items SET items_name=:name, items_cost=:cost, items_updated_date=:items_updated_date WHERE items_id=:id");
			$stmt->execute(['name' => $name, 'cost' => $cost, 'items_updated_date' => $today, 'id' => $id]);
			$_SESSION['success'] = 'Items updated successfully';
		} catch (PDOException $e) {
			$_SESSION['error'] = "Something Went Wrong.";
		}

		$pdo->close();
	} else {
		$_SESSION['error'] = 'Wrong Inputs.';
	}
} else {
	$_SESSION['error'] = 'Fill up edit items form first';
}

header('location: items.php');
