<?php
	include '../includes/session.php';

	if(isset($_POST['upload'])){
		$id = $_POST['id'];
		$filename = $_FILES['photo']['name'];
		if(!empty($filename)){
			date_default_timezone_set('Asia/Kolkata');
			$today = date('d-m-Y h:i:s a');
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $filename=date('Y-m-d').'_'.time().'.'.$ext;
			move_uploaded_file($_FILES['photo']['tmp_name'], '../../items_images/'.$filename);	
		}
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("UPDATE items SET items_image=:photo,items_updated_date=:items_updated_date WHERE items_id=:id");
			$stmt->execute(['photo'=>$filename,'items_updated_date'=>$today, 'id'=>$id]);
			$_SESSION['success'] = 'Item photo updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();

	}
	else{
		$_SESSION['error'] = 'Select Item to update photo first';
	}

	header('location: items.php');
?>