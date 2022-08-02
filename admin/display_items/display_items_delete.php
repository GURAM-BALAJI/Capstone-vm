<?php
	include '../includes/session.php';

	if(isset($_POST['delete'])){
		$id = strip_tags($_POST['id']);
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("DELETE FROM display_items WHERE display_spring_id=:id");
			$stmt->execute(['id'=>$id]);

			$_SESSION['success'] = 'Display items deleted successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select display items to delete first';
	}

	header('location: display_items.php');
	
?>