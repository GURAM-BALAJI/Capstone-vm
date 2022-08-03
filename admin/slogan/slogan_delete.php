<?php
	include '../includes/session.php';

	if(isset($_POST['delete'])){
		$id = strip_tags($_POST['id']);
		$conn = $pdo->open();
		try{
			$stmt = $conn->prepare("DELETE FROM slogan WHERE slogan_id=:id");
			$stmt->execute(['id'=>$id]);

			$_SESSION['success'] = 'slogan deleted successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select slogan to delete first';
	}

	header('location: slogan.php');
	
?>