<?php
	include '../includes/session.php';

	if(isset($_POST['save'])){
		$message= $_POST['message'];
		$win = $_POST['win'];

		$conn = $pdo->open();
		try{
			$stmt = $conn->prepare("UPDATE message SET message=:message WHERE message_id=:id");
			$stmt->execute([ 'message'=>$message,  'id'=>1]);
            $stmt = $conn->prepare("UPDATE message SET message=:win WHERE message_id=:id");
			$stmt->execute([ 'win'=>$win,  'id'=>2]);
			$_SESSION['success'] = 'Message updated successfully';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit user form first';
	}

	header('location: message.php');

?>