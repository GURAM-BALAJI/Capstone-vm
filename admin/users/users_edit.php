<?php
	include '../includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$contact = $_POST['contact'];

		$conn = $pdo->open();
		$stmt = $conn->prepare("SELECT * FROM users WHERE user_id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();
		date_default_timezone_set('Asia/Kolkata');
		$today = date('d-m-Y h:i:s a');
		$date = date('Y-m-d');
		
	$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE user_email=:email || user_phone=:phone");
	$stmt->execute(['email' => $email, 'phone' => $contact]);
	$row = $stmt->fetch();

	if ($row['numrows'] > 0) {
		$_SESSION['error'] = 'Email or phone number already taken.';
	} else {
		if($password == $row['password']){
			$password = $row['password'];
		}
		else{
			$password = password_hash($password, PASSWORD_DEFAULT);
		}

		try{
			$stmt = $conn->prepare("UPDATE users SET user_email=:email, user_password=:password, name=:name, user_phone=:contact,user_added_date=:user_added_date,user_updated_date=:user_updated_date WHERE user_id=:id");
			$stmt->execute(['email'=>$email, 'password'=>$password, 'name'=>$name, 'contact'=>$contact, 'user_added_date'=>$today, 'user_updated_date'=>$today, 'id'=>$id]);
			$_SESSION['success'] = 'User updated successfully';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
	}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit user form first';
	}

	header('location: users.php');
