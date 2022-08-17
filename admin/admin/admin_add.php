<?php
include '../includes/session.php';

if (isset($_POST['add'])) {
	$name = test_input($_POST['name']);
	$email = test_input($_POST['email']);
	$password = test_input($_POST['password']);
	$address = test_input($_POST['address']);
	$contact = test_input($_POST['contact']);
	//Sanitizing inputs.
	if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		$_SESSION['error'] = "Invalid email format.";
	if (!validateMobileNumber($contact))
		$_SESSION['error'] = 'Invalid phone number format.';
	if (strlen($name) > 20)
		$_SESSION['error'] = 'Name should be less then 20 characters.';
	if (strlen($name) < 5)
		$_SESSION['error'] = 'Name should be more then 5 characters.';
	if (!isset($_SESSION['error'])) {
		$conn = $pdo->open();
		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM admin WHERE admin_email=:email");
		$stmt->execute(['email' => $email]);
		$row = $stmt->fetch();
		if ($row['numrows'] > 0) {
			$_SESSION['error'] = 'Email already taken';
		} else {
			date_default_timezone_set('Asia/Kolkata');
			$today = date('Y-m-d h:i:s a');
			$password = password_hash($password, PASSWORD_DEFAULT);
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
				try {
					$stmt = $conn->prepare("INSERT INTO admin (admin_email, admin_password, admin_name, admin_phone, admin_photo, admin_status,admin_updated_date,admin_added_date) VALUES (:email, :password, :name, :contact, :photo, :status, :admin_updated_date,:admin_added_date)");
					$stmt->execute(['email' => $email, 'password' => $password, 'name' => $name, 'contact' => $contact, 'photo' => $filename, 'status' => 1, 'admin_updated_date' => $today, 'admin_added_date' => $today]);
					$_SESSION['success'] = 'admin added successfully';
				} catch (PDOException $e) {
					$_SESSION['error'] = "Something Went Wrong.";
				}
			}
		}
		$pdo->close();
	}
} else {
	$_SESSION['error'] = 'Fill up admin form first';
}

header('location: admin.php');

function validateMobileNumber($mobile)
{
	if (!empty($mobile)) {
		$isMobileNmberValid = true;
		$mobileDigitsLength = strlen($mobile);
		if ($mobileDigitsLength < 10 || $mobileDigitsLength > 11) {
			$isMobileNmberValid = false;
		} else {
			if (!preg_match("/^[+]?[1-9][0-9]{9}$/", $mobile)) {
				$isMobileNmberValid = false;
			}
		}
		return $isMobileNmberValid;
	} else {
		return false;
	}
}
