<?php
	include '../includes/session.php';

	if(isset($_POST['save'])){
		$message= strip_tags($_POST['message']);
		$win = strip_tags($_POST['win']);
		$share = strip_tags($_POST['share']);

		$conn = $pdo->open();
		try{
			$stmt = $conn->prepare("UPDATE message SET message=:message WHERE message_id=:id");
			$stmt->execute([ 'message'=>$message,  'id'=>1]);
            $stmt = $conn->prepare("UPDATE message SET message=:win WHERE message_id=:id");
			$stmt->execute([ 'win'=>$win,  'id'=>2]);
			$stmt = $conn->prepare("UPDATE message SET message=:share WHERE message_id=:id");
			$stmt->execute([ 'share'=>$share,  'id'=>3]);
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