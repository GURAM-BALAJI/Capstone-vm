<?php

use PHPMailer\PHPMailer\PHPMailer;

include 'includes/session.php';

if (isset($_POST['email'])) {
	$_SESSION['name'] = $name = strip_tags($_POST['name']);
	$_SESSION['email'] = $email = strip_tags($_POST['email']);
	$_SESSION['contact'] = $contact = strip_tags($_POST['contact']);
	$_SESSION['password'] = $password = strip_tags($_POST['password']);
	$cpassword = strip_tags($_POST['cpassword']);
	date_default_timezone_set('Asia/Kolkata');
	$today = date('Y-m-d h:i:s a');
	$conn = $pdo->open();

	$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM users WHERE user_email=:email || user_phone=:phone");
	$stmt->execute(['email' => $email, 'phone' => $contact]);
	$row = $stmt->fetch();

	if ($row['numrows'] > 0) {
		$_SESSION['error'] = 'Email or phone number already taken.';
	} else {
		if ($password == $cpassword) {
			$password = password_hash($password, PASSWORD_DEFAULT);
			$token = bin2hex(random_bytes(15));
			try {

				$stmt = $conn->prepare("INSERT INTO users (user_email, user_password, name, user_phone,  user_token, user_added_date, user_updated_date) VALUES (:email, :password, :name, :contact, :user_token, :user_added_date, :user_updated_date)");
				$stmt->execute(['email' => $email, 'password' => $password, 'name' => $name, 'contact' => $contact,  'user_token' => $token, 'user_added_date' => $today, 'user_updated_date' => $today]);

				$message =  "<center><h1> Click the  below link or Button to activate account </h1><a href='http://localhost/vending-machine-in-php/mail_verify.php?token=$token'>
				<button style='background-color: #4CAF50;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;' >Active Now</button></a>
				<br><br><br><hr>If you has not sent please ignore this mail.<h2>7softsolution.com</h2></center>";
				require_once "PHPMailer/PHPMailer.php";
				require_once "PHPMailer/SMTP.php";
				require_once "PHPMailer/Exception.php";
				$mail = new PHPMailer();
				//Server settings
				$mail->isSMTP();
				$mail->Host = "smtp.hostinger.com";
				$mail->SMTPAuth = true;
				$mail->Username = "support@streaminginvitation.com"; //enter you email address
				$mail->Password = 'SI@7softsolution'; //enter you email password
				$mail->Port = 587;
				$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
					)
				);

				$mail->setFrom('support@streaminginvitation.com', 'Vending Machine');

				//Recipients
				$mail->addAddress($email);

				//Content
				$mail->isHTML(true);
				$mail->Subject = 'Verification Code:';
				$mail->Body = $message;

				if ($mail->send()) {
					$_SESSION['success'] = "We've sent a verification link to your email
                         - $email";
				} else {
					$_SESSION['error'] = "Mail can`t be sent please cheak your mail.";
				}
				unset($_SESSION['name']);
				unset($_SESSION['email']);
				unset($_SESSION['contact']);
				unset($_SESSION['password']);
				$_SESSION['mailAuth'] = 'true';
				header('location: mailAuth.php');
				exit();
			} catch (PDOException $e) {
				$_SESSION['error'] = $e->getMessage();
				header('location: sign_up.php');
			}
		} else {
			$_SESSION['error'] = "Confirm password not matched!";
		}
	}
	$pdo->close();
} else {
	$_SESSION['error'] = 'Fill up user form first';
}

header('location: sign_up.php');
