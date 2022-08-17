<?php
include '../includes/session.php';

if (isset($_POST['add'])) {
	$name = test_input($_POST['name']);
	$cost = test_input($_POST['cost']);
	$conn = $pdo->open();
	if ($cost > 0) {
		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM items WHERE items_name=:name AND items_delete=:items_delete");
		$stmt->execute(['name' => $name, 'items_delete' => 0]);
		$row = $stmt->fetch();
		if ($row['numrows'] > 0) {
			$_SESSION['error'] = 'Items already exist';
		} else {
			try {
				$filename = $_FILES['photo']['name'];
				if (!empty($filename)) {
					$file_type = $_FILES['photo']['type']; //returns the mimetype
					$allowed = array("image/jpeg", "image/gif", "image/png");
					if (!in_array($file_type, $allowed)) {
						$_SESSION['error'] = 'Only jpg, gif, and png files are allowed.';
					} else {
						$ext = pathinfo($filename, PATHINFO_EXTENSION);
						$filename = date('Y-m-d') . '_' . time() . '.' . $ext;
						move_uploaded_file($_FILES['photo']['tmp_name'], '../../items_images/' . $filename);
					}
				}
				if (!isset($_SESSION['error'])) {
					date_default_timezone_set('Asia/Kolkata');
					$today = date('Y-m-d h:i:s a');
					$stmt = $conn->prepare("INSERT INTO items (items_name,items_image,items_cost,items_add_date,items_updated_date) VALUES (:name, :photo, :cost,:items_add_date,:items_updated_date)");
					$stmt->execute(['name' => $name, 'photo' => $filename, 'cost' => $cost, 'items_add_date' => $today, 'items_updated_date' => $today]);
					$_SESSION['success'] = 'Items added successfully';
				}
			} catch (PDOException $e) {
				$_SESSION['error'] = "Something Went Wrong.";
			}
		}
		$pdo->close();
	} else {
		$_SESSION['error'] = 'Wrong Inputs.';
	}
} else {
	$_SESSION['error'] = 'Fill up items form first';
}

header('location: items.php');
