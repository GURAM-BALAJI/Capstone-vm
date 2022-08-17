<?php
include '../includes/session.php';

if (isset($_POST['upload'])) {
	$id = test_input($_POST['id']);
	if ($id > 0) {
		$filename = $_FILES['photo']['name'];
		if (!empty($filename)) {
			$file_type = $_FILES['photo']['type']; //returns the mimetype
			$allowed = array("image/jpeg", "image/gif", "image/png");
			if (!in_array($file_type, $allowed)) {
				$_SESSION['error'] = 'Only jpg, gif, and png files are allowed.';
			} else {
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$filename = date('Y-m-d') . '_' . time() . '.' . $ext;
				move_uploaded_file($_FILES['photo']['tmp_name'], '../../images/' . $filename);
			}
		}
		if (!isset($_SESSION['error'])) {
			$conn = $pdo->open();

			try {
				$stmt = $conn->prepare("SELECT user_photo from users WHERE user_id=:id");
				$stmt->execute(['id' => $id]);
				foreach ($stmt as $row) {
					unlink('../../images/' . $row['user_photo']);
				}
				$stmt = $conn->prepare("UPDATE users SET user_photo=:photo WHERE user_id=:id");
				$stmt->execute(['photo' => $filename, 'id' => $id]);
				$_SESSION['success'] = 'User photo updated successfully';
			} catch (PDOException $e) {
				$_SESSION['error'] = "Something Went Wrong.";
			}

			$pdo->close();
		}
	} else {
		$_SESSION['error'] = 'Wrong Inputs.';
	}
} else {
	$_SESSION['error'] = 'Select user to update photo first';
}

header('location: users.php');
