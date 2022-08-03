<?php
	include '../includes/session.php';

	if(isset($_POST['edit'])){
		$conn = $pdo->open();
		$id = strip_tags($_POST['id']);
		$qty = strip_tags($_POST['edit_qty']);
		date_default_timezone_set('Asia/Kolkata');
		$today = date('Y-m-d h:i:s a');
		try{
			$stmt = $conn->prepare("UPDATE display_items SET display_items_qty=:qty,display_items_updated_date=:display_items_updated_date WHERE display_spring_id=:id");
			$stmt->execute(['qty'=>$qty,'display_items_updated_date'=>$today, 'id'=>$id]);
			$_SESSION['success'] = 'Display items updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit display items form first';
	}

	header('location: display_items.php');

?>