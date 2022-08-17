<?php
include '../includes/session.php';

if (isset($_POST['upload'])) {
	$id = test_input($_POST['id']);
	$filename = $_FILES['photo']['name'];
	if ($id > 0) {
		if (!empty($filename)) {
			$file_type = $_FILES['photo']['type']; //returns the mimetype
			$allowed = array("image/jpeg", "image/gif", "image/png");
			if (!in_array($file_type, $allowed)) {
				$_SESSION['error'] = 'Only jpg, gif, and png files are allowed.';
			} else {
				date_default_timezone_set('Asia/Kolkata');
				$today = date('Y-m-d h:i:s a');
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$filename = date('Y-m-d') . '_' . time() . '.' . $ext;
				move_uploaded_file($_FILES['photo']['tmp_name'], '../../items_images/' . $filename);
			}
		}
		if (!isset($_SESSION['error'])) {
			$conn = $pdo->open();
			try {
				$stmt = $conn->prepare("SELECT items_image from items WHERE items_id=:id");
				$stmt->execute(['id' => $id]);
				foreach ($stmt as $row) {
					unlink('../../items_images/' . $row['items_image']);
				}
				$stmt = $conn->prepare("UPDATE items SET items_image=:photo,items_updated_date=:items_updated_date WHERE items_id=:id");
				$stmt->execute(['photo' => $filename, 'items_updated_date' => $today, 'id' => $id]);
				$_SESSION['success'] = 'Item photo updated successfully';
			} catch (PDOException $e) {
				$_SESSION['error'] = "Something Went Wrong.";
			}
			$pdo->close();
		}
	} else {
		$_SESSION['error'] = 'Wrong Inputs.';
	}
} else {
	$_SESSION['error'] = 'Select Item to update photo first';
}

header('location: items.php');
