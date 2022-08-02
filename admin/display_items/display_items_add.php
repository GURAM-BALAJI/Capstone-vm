<?php
	include '../includes/session.php';

	if(isset($_POST['add'])){
		$spring_id = strip_tags($_POST['spring_id']);
		$items_id = strip_tags($_POST['items_id']);
		$qty = strip_tags($_POST['qty']);
		$conn = $pdo->open();
		date_default_timezone_set('Asia/Kolkata');
		$today = date('Y-m-d h:i:s a');
		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM display_items WHERE display_spring_id=:spring_id");
		$stmt->execute(['spring_id'=>$spring_id]);
		$row = $stmt->fetch();
		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Spring already exist';
		}
		else{
			try{
				$stmt = $conn->prepare("INSERT INTO display_items (display_spring_id,display_items_id,display_items_qty,display_items_add_date,display_items_updated_date) VALUES (:spring_id, :items_id, :qty,:display_items_add_date,:display_items_updated_date)");
				$stmt->execute(['spring_id'=>$spring_id, 'items_id'=>$items_id, 'qty'=>$qty,'display_items_add_date'=>$today,'display_items_updated_date'=>$today]);
				$_SESSION['success'] = 'Display items added successfully';
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up display items form first';
	}

	header('location: display_items.php');

?>