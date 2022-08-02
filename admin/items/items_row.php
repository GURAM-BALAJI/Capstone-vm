<?php 
	include '../includes/session.php';

	if(isset($_POST['id'])){
		$id = strip_tags($_POST['id']);
		
		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT * FROM items WHERE items_id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();
		
		$pdo->close();

		echo json_encode($row);
	}
?>