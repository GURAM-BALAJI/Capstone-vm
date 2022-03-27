<?php
	include '../includes/session.php';

    if(isset($_GET['submit'])){
    $id=$_GET['id'];
        try{
				$stmt = $conn->prepare("UPDATE contact SET contact_view=:cview WHERE contact_id=:id");
				$stmt->execute(['cview'=>1, 'id'=>$id]);
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}

			$pdo->close();
}
header('location: ../contact/contact.php');
			?>