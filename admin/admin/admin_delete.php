<?php
	include '../includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		try{
			date_default_timezone_set('Asia/Kolkata');
			$today = date('d-m-Y h:i:s a');
			$stmt = $conn->prepare("UPDATE admin set admin_delete='1',admin_updated_date=:admin_updated_date WHERE admin_id=:id");
			$stmt->execute([,'admin_updated_date'=>$today,'id'=>$id]);

			$_SESSION['success'] = 'admin deleted successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select admin to delete first';
	}

	header('location: admin.php');
	
?>


