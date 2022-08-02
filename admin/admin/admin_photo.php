<?php
	include '../includes/session.php';

	if(isset($_POST['upload'])){
		$id = strip_tags($_POST['id']);
		$filename = strip_tags($_FILES['photo']['name']);
		if(!empty($filename)){
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $filename=date('Y-m-d').'_'.time().'.'.$ext;
			move_uploaded_file($_FILES['photo']['tmp_name'], '../../images/'.$filename);	
		}
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("SELECT admin_photo from admin WHERE admin_id=:id");
			$stmt->execute(['id'=>$id]);
			foreach($stmt as $row)
			{
				unlink('../../images/'.$row['admin_photo']);
			}
			$stmt = $conn->prepare("UPDATE admin SET admin_photo=:photo WHERE admin_id=:id");
			$stmt->execute(['photo'=>$filename, 'id'=>$id]);
			$_SESSION['success'] = 'admin photo updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();

	}
	else{
		$_SESSION['error'] = 'Select admin to update photo first';
	}

	header('location: admin.php');
?>