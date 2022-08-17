<?php
include '../includes/session.php';

if (isset($_POST['add'])) {
	$name = test_input($_POST['name']);
	$email = test_input($_POST['email']);
	$password = test_input($_POST['password']);
	$address = test_input($_POST['address']);
	$contact = test_input($_POST['contact']);
	$amount = test_input($_POST['amount']);
	$by = test_input($admin['admin_id']);
	if ($amount >= 0 && $by > 0) {
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
			date_default_timezone_set('Asia/Kolkata');
			$today = date('Y-m-d h:i:s a');
			$date = date('Y-m-d');
			$conn = $pdo->open();

			$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE user_email=:email || user_phone=:phone");
			$stmt->execute(['email' => $email, 'phone' => $contact]);
			$row = $stmt->fetch();

			if ($row['numrows'] > 0) {
				$_SESSION['error'] = 'Email or phone number already taken.';
			} else {
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
						$stmt = $conn->prepare("INSERT INTO users (user_email, user_password, name,  user_phone, user_photo, user_status,  user_amount, user_added_date, user_updated_date) VALUES (:email, :password, :name, :contact, :photo, :status, :amount, :user_added_date, :user_updated_date)");
						$stmt->execute(['email' => $email, 'password' => $password, 'name' => $name, 'contact' => $contact, 'photo' => $filename, 'status' => 1, 'amount' => $amount, 'user_added_date' => $today, 'user_updated_date' => $today]);

						$stmt_user2 = $conn->prepare("SELECT user_id FROM users WHERE user_email=:email");
						$stmt_user2->execute(['email' => $email]);
						foreach ($stmt_user2 as $row1) {
							$user_id = $row1['user_id'];
						};

						$stmt = $conn->prepare("INSERT INTO transaction ( transaction_user_id, transaction_send_to, transaction_amount, transaction_added_by,transaction_type,transaction_date) VALUES (:transaction_user_id, :transaction_send_to, :transaction_amount, :transaction_added_by, :transaction_type,:transaction_date)");
						$stmt->execute(['transaction_user_id' => $user_id, 'transaction_send_to' => 'Added Manually', 'transaction_amount' => $amount,  'transaction_added_by' => $by, 'transaction_type' => 4, 'transaction_date' => $today]);

						$_SESSION['success'] = 'User added successfully';
					} catch (PDOException $e) {
						$_SESSION['error'] = "Something Went Wrong.";
					}
				}
			}

			$pdo->close();
		}
	} else {
		$_SESSION['error'] = 'Wrong Inputs.';
	}
} else {
	$_SESSION['error'] = 'Fill up user form first';
}

header('location: users.php');


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
