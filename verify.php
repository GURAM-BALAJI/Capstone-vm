<?php
include 'includes/session.php';
$conn = $pdo->open();

if (isset($_POST['login'])) {
	$_SESSION['email'] = $email = strip_tags($_POST['email']);
	$_SESSION['password'] = $password = strip_tags($_POST['password']);

	try {

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE user_email = :email");
		$stmt->execute(['email' => $email]);
		$row = $stmt->fetch();

		if ($row['numrows'] > 0) {

			if ($row['user_status']) {
				if (password_verify($password, $row['user_password'])) {
					$_SESSION['vm_user'] = 'True';
					$_SESSION['vm_id'] = $row['user_id'];
					date_default_timezone_set('Asia/Kolkata');
					$today = date('Y-m-d h:i:s a');
					$sessionss_cookies_id =  bin2hex(random_bytes(8)) . $row['user_id'] . time();
					$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM sessionss WHERE sessionss_user_id = :sessionss_user_id");
					$stmt->execute(['sessionss_user_id' => $row['user_id']]);
					$row1 = $stmt->fetch();
					if ($row1['numrows'] > 0) {
						$stmt_sessions = $conn->prepare("UPDATE sessionss SET sessionss_cookies_id=:sessionss_cookies_id,sessionss_created_date=:sessionss_created_date WHERE sessionss_user_id = :user_id");
						$stmt_sessions->execute(['sessionss_cookies_id' => $sessionss_cookies_id, 'sessionss_created_date' => $today, 'user_id' => $row['user_id']]);
					} else {
						$stmt_sessions = $conn->prepare("INSERT INTO sessionss (sessionss_cookies_id, sessionss_created_date, sessionss_user_id) VALUES (:sessionss_cookies_id, :sessionss_created_date, :sessionss_user_id)");
						$stmt_sessions->execute(['sessionss_cookies_id' => $sessionss_cookies_id, 'sessionss_created_date' => $today, 'sessionss_user_id' => $row['user_id']]);
					}
					setcookie('keep_id', $sessionss_cookies_id, time() + 60 * 60 * 24 * 30);
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