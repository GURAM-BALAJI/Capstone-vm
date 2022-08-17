<?php
include 'includes/session.php';
include './includes/req_start.php';
if ($req_per == 1) {
	if (isset($_POST['edit'])) {
		$conn = $pdo->open();
		$curr_password = test_input($_POST['curr_password']);
		$email = test_input($_POST['email']);
		$password = test_input($_POST['password']);
		$name = test_input($_POST['name']);
		$phone = test_input($_POST['contact']);
		$photo = test_input($_FILES['photo']['name']);
		//Sanitizing inputs.
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			$_SESSION['error'] = "Invalid email format.";
		if (!validateMobileNumber($phone))
			$_SESSION['error'] = 'Invalid phone number format.';
		if (strlen($name) > 20)
			$_SESSION['error'] = 'Name should be less then 20 characters.';
		if (strlen($name) < 5)
			$_SESSION['error'] = 'Name should be more then 5 characters.';
		if (!isset($_SESSION['error'])) {
			if (password_verify($curr_password, $user['user_password'])) {
				$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM users WHERE (user_email=:email || user_phone=:phone) AND user_id!=:id");
				$stmt->execute(['email' => $email, 'phone' => $phone, 'id' => $user['user_id']]);
				$row = $stmt->fetch();

				if ($row['numrows'] > 0) {
					$_SESSION['error'] = 'Email or phone number already taken.';
				} else {
					if (!empty($photo)) {
						$file_type = $_FILES['photo']['type']; //returns the mimetype
						$allowed = array("image/jpeg", "image/gif", "image/png");
						if (!in_array($file_type, $allowed)) {
							$_SESSION['error'] = 'Only jpg, gif, and png files are allowed.';
						} else {
							$ext = pathinfo($photo, PATHINFO_EXTENSION);
							$filename = $user['user_id'] . '_' . date('Y-m-d') . '_' . time() . '.' . $ext;
							move_uploaded_file($_FILES['photo']['tmp_name'], './images/' . $filename);
							$stmt = $conn->prepare("SELECT user_photo from users WHERE user_id=:id");
							$stmt->execute(['id' => $user['user_id']]);
							foreach ($stmt as $row) {
								unlink('./images/' . $row['user_photo']);
							}
						}
					} else {
						$filename = $user['photo'];
					}
					if (!isset($_SESSION['error'])) {
						if ($password == $user['user_password']) {
							$password = $user['user_password'];
						} else {
							$password = password_hash($password, PASSWORD_DEFAULT);
						}

						try {
							date_default_timezone_set('Asia/Kolkata');
							$today = date('Y-m-d h:i:s a');
							$stmt = $conn->prepare("UPDATE users SET user_email=:email, user_password=:password, name=:name, user_photo=:photo,  user_phone=:phone, user_updated_date=:user_updated_date WHERE user_id=:id");
							$stmt->execute(['email' => $email, 'password' => $password, 'name' => $name, 'photo' => $filename, 'phone' => $phone, 'user_updated_date' => $today, 'id' => $user['user_id']]);

							$_SESSION['success'] = 'Account updated successfully';
						} catch (PDOException $e) {
							$_SESSION['error'] = "Something Went Wrong.";
						}
					}
				}
			} else {
				$_SESSION['error'] = 'Incorrect password';
			}
			$pdo->close();
		}
	} else {
		$_SESSION['error'] = 'Fill up required details first';
	}
}
header('location:MyProfile');

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
