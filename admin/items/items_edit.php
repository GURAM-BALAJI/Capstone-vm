<?php
	include '../includes/session.php';

	if(isset($_POST['edit'])){
		$id = strip_tags($_POST['id']);
		$name = strip_tags($_POST['name']);
        $cost = strip_tags($_POST['cost']);
		date_default_timezone_set('Asia/Kolkata');
		$today = date('Y-m-d h:i:s a');
		try{
			$stmt = $conn->prepare("UPDATE items SET items_name=:name, items_cost=:cost, items_updated_date=:items_updated_date WHERE items_id=:id");
			$stmt->execute(['name'=>$name,'cost'=>$cost,'items_updated_date'=>$today, 'id'=>$id]);
			$_SESSION['success'] = 'Items updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit items form first';
	}

	header('location: items.php');

?>