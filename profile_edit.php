<?php
include 'includes/session.php';
include './includes/req_start.php';
if ($req_per == 1) {
	if (isset($_POST['edit'])) {
		$curr_password = $_POST['curr_password'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$name = $_POST['name'];
		$phone = $_POST['contact'];
		$photo = $_FILES['photo']['name'];
		if (password_verify($curr_password, $user['user_password'])) {
			$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM users WHERE (user_email=:email || user_phone=:phone) AND user_id!=:id");
			$stmt->execute(['email' => $email, 'phone' => $phone, 'id' => $user['user_id']]);
			$row = $stmt->fetch();

			if ($row['numrows'] > 0) {
				$_SESSION['error'] = 'Email or phone number already taken.';
			} else {
				if (!empty($photo)) {
					$ext = pathinfo($photo, PATHINFO_EXTENSION);
					$filename = $user['user_id'] . '_' . date('Y-m-d') . '_' . time() . '.' . $ext;
					move_uploaded_file($_FILES['photo']['tmp_name'], './images/' . $filename);
					$stmt = $conn->prepare("SELECT user_photo from users WHERE user_id=:id");
					$stmt->execute(['id' => $id]);
					foreach ($stmt as $row) {
						unlink('../../images/' . $row['user_photo']);
					}
				} else {
					$filename = $user['photo'];
				}

				if ($password == $user['user_password']) {
					$password = $user['user_password'];
				} else {
					$password = password_hash($password, PASSWORD_DEFAULT);
				}

				$conn = $pdo->open();

				try {
					date_default_timezone_set('Asia/Kolkata');
					$today = date('d-m-Y h:i:s a');
					$stmt = $conn->prepare("UPDATE users SET user_email=:email, user_password=:password, name=:name, user_photo=:photo,  user_phone=:phone, user_updated_date=:user_updated_date WHERE user_id=:id");
					$stmt->execute(['email' => $email, 'password' => $password, 'name' => $name, 'photo' => $filename, 'phone' => $phone, 'user_updated_date' => $today, 'id' => $user['user_id']]);

					$_SESSION['success'] = 'Account updated successfully';
				} catch (PDOException $e) {
					$_SESSION['error'] = $e->getMessage();
				}
			}
			$pdo->close();
		} else {
			$_SESSION['error'] = 'Incorrect password';
		}
	} else {
		$_SESSION['error'] = 'Fill up required details first';
	}
}
header('location:profile.php');
