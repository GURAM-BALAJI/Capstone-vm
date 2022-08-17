<?php
include '../includes/session.php';
$conn = $pdo->open();

if (isset($_POST['login'])) {
	$email = test_input($_POST['email']);
	$password = test_input($_POST['password']);
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		try {
			$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM admin WHERE admin_email = :email");
			$stmt->execute(['email' => $email]);
			$row = $stmt->fetch();
			if ($row['numrows'] > 0) {
				if ($row['admin_status']) {
					if (password_verify($password, $row['admin_password'])) {
						$_SESSION['vm_admin'] = 'True';
						$_SESSION['vm_id_admin'] = $row['admin_id'];
					} else {
						$_SESSION['error'] = 'Invalid.';
					}
				} else {
					$_SESSION['error'] = 'Invalid.';
				}
			} else {
				$_SESSION['error'] = 'Invalid.';
			}
		} catch (PDOException $e) {
			echo "There is some problem in connection: " . "Something Went Wrong.";
		}
	} else {
		$_SESSION['error'] = "Invalid email format.";
	}
} else {
	$_SESSION['error'] = 'Input login credentails first';
}

$pdo->close();

header('location: index.php');
