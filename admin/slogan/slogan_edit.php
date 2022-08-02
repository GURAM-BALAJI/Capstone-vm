<?php
	include '../includes/session.php';

	if(isset($_POST['edit'])){
		$id = strip_tags($_POST['id']);
		$slogan_sentance = strip_tags($_POST['slogan_sentance']);
		try{
			$stmt = $conn->prepare("UPDATE slogan SET slogan_sentance=:slogan_sentance WHERE slogan_id=:id");
			$stmt->execute(['slogan_sentance'=>$slogan_sentance, 'id'=>$id]);
			$_SESSION['success'] = 'slogan updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit slogan form first';
	}

	header('location: slogan.php');

?>