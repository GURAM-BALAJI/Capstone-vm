<?php
	include '../includes/session.php';


	if(isset($_POST['save'])){
		$curr_password = $_POST['curr_password'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$name = $_POST['name'];
		$photo = $_FILES['photo']['name'];
		if(password_verify($curr_password, $admin['admin_password'])){
			if(!empty($photo)){
				move_uploaded_file($_FILES['photo']['tmp_name'], '../../images/'.$photo);
				$filename = $photo;	
				$stmt = $conn->prepare("SELECT admin_photo from admin WHERE admin_id=:id");
				$stmt->execute(['id'=>$id]);
				foreach($stmt as $row)
				{
					unlink('../../images/'.$row['admin_photo']);
				}
			}
			else{
				$filename = $admin['admin_photo'];
			}

			if($password == $admin['admin_password']){
				$password = $admin['admin_password'];
			}
			else{
				$password = password_hash($password, PASSWORD_DEFAULT);
			}

			$conn = $pdo->open();

			try{
				date_default_timezone_set('Asia/Kolkata');
		$today = date('d-m-Y h:i:s a');
				$stmt = $conn->prepare("UPDATE admin SET admin_email=:email, admin_password=:password, admin_name=:name, admin_photo=:photo,admin_updated_date=:admin_updated_date WHERE admin_id=:id");
				$stmt->execute(['email'=>$email, 'password'=>$password, 'name'=>$name, 'photo'=>$filename,'admin_updated_date'=>$today, 'id'=>$admin['admin_id']]);

				$_SESSION['success'] = 'Account updated successfully';
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}

			$pdo->close();
			
		}
		else{
			$_SESSION['error'] = 'Incorrect password';
		}
	}
	else{
		$_SESSION['error'] = 'Fill up required details first';
	}

	header('location: ../home/home.php');

?>