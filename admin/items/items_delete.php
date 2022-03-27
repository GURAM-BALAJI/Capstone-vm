<?php
	include '../includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		date_default_timezone_set('Asia/Kolkata');
		$today = date('d-m-Y h:i:s a');
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("UPDATE items set items_delete='1',items_updated_date=:items_updated_date WHERE items_id=:id");
			$stmt->execute(['id'=>$id, 'items_updated_date'=>$today]);

			$_SESSION['success'] = 'Items deleted successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select items to delete first';
	}

	header('location: items.php');
	
?>