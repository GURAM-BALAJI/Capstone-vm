<?php
include '../includes/session.php';

if (isset($_POST['add'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$address = $_POST['address'];
	$contact = $_POST['contact'];

	$conn = $pdo->open();

	$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM admin WHERE admin_email=:email");
	$stmt->execute(['email' => $email]);
	$row = $stmt->fetch();
	if ($row['numrows'] > 0) {
		$_SESSION['error'] = 'Email already taken';
	} else {
		date_default_timezone_set('Asia/Kolkata');
		$today = date('d-m-Y h:i:s a');
		$password = password_hash($password, PASSWORD_DEFAULT);
		$filename = $_FILES['photo']['name'];
		if (!empty($filename)) {
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$filename = date('Y-m-d') . '_' . time() . '.' . $ext;
			move_uploaded_file($_FILES['photo']['tmp_name'], '../../images/' . $filename);
		}
		try {
			$stmt = $conn->prepare("INSERT INTO admin (admin_email, admin_password, admin_name, admin_phone, admin_photo, admin_status,admin_updated_date,admin_added_date) VALUES (:email, :password, :name, :contact, :photo, :status, :admin_updated_date,:admin_added_date)");
			$stmt->execute(['email' => $email, 'password' => $password, 'name' => $name, 'contact' => $contact, 'photo' => $filename, 'status' => 1, 'admin_updated_date' => $today, 'admin_added_date' => $today]);
			$_SESSION['success'] = 'admin added successfully';
		} catch (PDOException $e) {
			$_SESSION['error'] = $e->getMessage();
		}
	}

	$pdo->close();
} else {
	$_SESSION['error'] = 'Fill up admin form first';
}

header('location: admin.php');
