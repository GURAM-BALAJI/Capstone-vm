<?php
include '../includes/session.php';

if (isset($_POST['add'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$address = $_POST['address'];
	$contact = $_POST['contact'];
	$amount = $_POST['amount'];
	$by = $admin['admin_id'];
	date_default_timezone_set('Asia/Kolkata');
	$today = date('d-m-Y h:i:s a');
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
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$filename = date('Y-m-d') . '_' . time() . '.' . $ext;
			move_uploaded_file($_FILES['photo']['tmp_name'], '../../images/' . $filename);
		}
		try {
			$stmt = $conn->prepare("INSERT INTO users (user_email, user_password, name,  user_phone, user_photo, user_status,  user_amount, user_added_date, user_updated_date) VALUES (:email, :password, :name, :contact, :photo, :status, :amount, :user_added_date, :user_updated_date)");
			$stmt->execute(['email' => $email, 'password' => $password, 'name' => $name, 'contact' => $contact, 'photo' => $filename, 'status' => 1, 'amount' => $amount, 'user_added_date'=>$today, 'user_updated_date'=>$today ]);

			$stmt_user2 = $conn->prepare("SELECT user_id FROM users WHERE user_email=:email");
			$stmt_user2->execute(['email' => $email]);
			foreach ($stmt_user2 as $row1) {
				$user_id = $row1['user_id'];
			};

			$stmt = $conn->prepare("INSERT INTO transaction ( transaction_user_id, transaction_send_to, transaction_amount, transaction_method, transaction_added_by,transaction_type,transaction_date) VALUES (:transaction_user_id, :transaction_send_to, :transaction_amount, :transaction_method, :transaction_added_by, :transaction_type,:transaction_date)");
			$stmt->execute(['transaction_user_id' => $user_id, 'transaction_send_to' => 0, 'transaction_amount' => $amount, 'transaction_method' => 'login', 'transaction_added_by' => $by, 'transaction_type' => 0, 'transaction_date'=>$today]);

			$_SESSION['success'] = 'User added successfully';
		} catch (PDOException $e) {
			$_SESSION['error'] = $e->getMessage();
		}
	}

	$pdo->close();
} else {
	$_SESSION['error'] = 'Fill up user form first';
}

header('location: users.php');
