<?php
include '../includes/session.php';


if (isset($_POST['save'])) {
	$curr_password = test_input($_POST['curr_password']);
	$email = test_input($_POST['email']);
	$password = test_input($_POST['password']);
	$name = test_input($_POST['name']);
	$photo = test_input($_FILES['photo']['name']);
	//Sanitizing inputs.
	if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		$_SESSION['error'] = "Invalid email format.";
	if (strlen($name) > 20)
		$_SESSION['error'] = 'Name should be less then 20 characters.';
	if (strlen($name) < 5)
		$_SESSION['error'] = 'Name should be more then 5 characters.';
	if (!isset($_SESSION['error'])) {
		if (password_verify($curr_password, $admin['admin_password'])) {
			if (!empty($photo)) {
				$file_type = $_FILES['photo']['type']; //returns the mimetype
				$allowed = array("image/jpeg", "image/gif", "image/png");
				if (!in_array($file_type, $allowed)) {
					$_SESSION['error'] = 'Only jpg, gif, and png files are allowed.';
				} else {
					move_uploaded_file($_FILES['photo']['tmp_name'], '../../images/' . $photo);
					$filename = $photo;
					$stmt = $conn->prepare("SELECT admin_photo from admin WHERE admin_id=:id");
					$stmt->execute(['id' => $id]);
					foreach ($stmt as $row) {
						unlink('../../images/' . $row['admin_photo']);
					}
				}
			} else {
				$filename = $admin['admin_photo'];
			}
			if (!isset($_SESSION['error'])) {
				if ($password == $admin['admin_password']) {
					$password = $admin['admin_password'];
				} else {
					$password = password_hash($password, PASSWORD_DEFAULT);
				}

				$conn = $pdo->open();

				try {
					date_default_timezone_set('Asia/Kolkata');
					$today = date('Y-m-d h:i:s a');
					$stmt = $conn->prepare("UPDATE admin SET admin_email=:email, admin_password=:password, admin_name=:name, admin_photo=:photo,admin_updated_date=:admin_updated_date WHERE admin_id=:id");
					$stmt->execute(['email' => $email, 'password' => $password, 'name' => $name, 'photo' => $filename, 'admin_updated_date' => $today, 'id' => $admin['admin_id']]);

					$_SESSION['success'] = 'Account updated successfully';
				} catch (PDOException $e) {
					$_SESSION['error'] = "Something Went Wrong.";
				}

				$pdo->close();
			}
		} else {
			$_SESSION['error'] = 'Incorrect password';
		}
	}
} else {
	$_SESSION['error'] = 'Fill up required details first';
}

header('location: ../home/home.php');


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
