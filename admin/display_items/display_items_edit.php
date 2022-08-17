<?php
include '../includes/session.php';

if (isset($_POST['edit'])) {
	$conn = $pdo->open();
	$id = test_input($_POST['id']);
	$qty = test_input($_POST['edit_qty']);
	if ( $id > 0 && $qty >= 0) {
		date_default_timezone_set('Asia/Kolkata');
		$today = date('Y-m-d h:i:s a');
		try {
			$stmt = $conn->prepare("UPDATE display_items SET display_items_qty=:qty,display_items_updated_date=:display_items_updated_date WHERE display_spring_id=:id");
			$stmt->execute(['qty' => $qty, 'display_items_updated_date' => $today, 'id' => $id]);
			$_SESSION['success'] = 'Display items updated successfully';
		} catch (PDOException $e) {
			$_SESSION['error'] = "Something Went Wrong.";
		}
		$pdo->close();
	} else {
		$_SESSION['error'] = 'Wrong Inputs.';
	}
} else {
	$_SESSION['error'] = 'Fill up edit display items form first';
}

header('location: display_items.php');
