<?php
	include '../includes/session.php';

	if(isset($_POST['activate'])){
		$id = strip_tags($_POST['id']);
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("UPDATE users SET user_status=:status WHERE user_id=:id");
			$stmt->execute(['status'=>1, 'id'=>$id]);
			$_SESSION['success'] = 'User activated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();

	}
	else{
		$_SESSION['error'] = 'Select user to activate first';
	}

	header('location: users.php');
?>