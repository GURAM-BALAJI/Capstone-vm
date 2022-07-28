<?php
include 'includes/session.php';
$conn = $pdo->open();

if (isset($_POST['login'])) {
	$_SESSION['email'] = $email = $_POST['email'];
	$_SESSION['password'] = $password = $_POST['password'];

	try {

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE user_email = :email");
		$stmt->execute(['email' => $email]);
		$row = $stmt->fetch();

		if ($row['numrows'] > 0) {

			if ($row['user_status']) {
				if (password_verify($password, $row['user_password'])) {
					$_SESSION['vm_user'] = 'True';
					$_SESSION['vm_id'] = $row['user_id'];
					unset($_SESSION['email']);
					unset($_SESSION['password']);
				} else {
					$_SESSION['error'] = 'Incorrect Password';
				}
			} else {
				$_SESSION['error'] = 'Account not activated.';
			}
		} else {
			$_SESSION['error'] = 'Email not found';
		}
	} catch (PDOException $e) {
		echo "There is some problem in connection: " . $e->getMessage();
	}
} else {
	$_SESSION['error'] = 'Input login credentails first';
}

$pdo->close();

header('location: login.php');
