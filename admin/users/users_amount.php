<?php
	include '../includes/session.php';

	if(isset($_POST['add'])){
		$id = $_POST['id'];
		$add_amount = $_POST['add_amount'];
		date_default_timezone_set('Asia/Kolkata');
		$today = date('d-m-Y h:i:s a');
		$date = date('Y-m-d');
		$conn = $pdo->open();
		$stmt = $conn->prepare("SELECT user_amount FROM users WHERE user_id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();
			$amount = $row['user_amount'];
        $by=$admin['admin_id'];
        $amount=intval($add_amount)+intval($amount);
		try{
			$stmt = $conn->prepare("UPDATE users SET user_amount=:amount, updated_by_id=:by WHERE user_id=:id");
			$stmt->execute(['amount'=>$amount, 'by'=>$by, 'id'=>$id]);
            
             $stmt = $conn->prepare("INSERT INTO transaction ( transaction_user_id, transaction_send_to, transaction_amount, transaction_method, transaction_added_by, transaction_type,transaction_date,date_transaction) VALUES (:transaction_user_id, :transaction_send_to, :transaction_amount, :transaction_method, :transaction_added_by, :transaction_type,:transaction_date,:date_transaction)");
$stmt->execute(['transaction_user_id'=>$id, 'transaction_send_to'=>'Added Manually', 'transaction_amount'=>$add_amount, 'transaction_method'=>'add amount', 'transaction_added_by'=>$by, 'transaction_type'=>0, 'transaction_date'=>$today, 'date_transaction'=>$date]);
            
			$_SESSION['success'] = $add_amount.' Rs updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up money user form first';
	}

	header('location: users.php');

?>