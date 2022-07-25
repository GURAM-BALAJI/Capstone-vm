<?php
use PHPMailer\PHPMailer\PHPMailer;
	include 'includes/session.php';

	if(isset($_POST['email'])){
		$_SESSION['email']=$email = $_POST['email'];
		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE user_email=:email");
		$stmt->execute(['email'=>$email]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
            try{
    $code = rand(999999, 111111);
$stmt = $conn->prepare("UPDATE users SET user_code=:code WHERE user_email=:email");
			$stmt->execute(['code'=>$code, 'email'=>$email]);
    
        $message = "<center><h1>Your Password reset code is</h1><h2>$code</h2><br><br><br><hr>If you has not sent please ignore this mail.<h2>esewin.in</h2></center>";
        require_once "PHPMailer/PHPMailer.php";
        require_once "PHPMailer/SMTP.php";
        require_once "PHPMailer/Exception.php";
		 $mail = new PHPMailer();			  
				        //Server settings
			        $mail->isSMTP();
        $mail->Host = "smtp.hostinger.com";
        $mail->SMTPAuth = true;
        $mail->Username = "noreplay@esewin.in"; //enter you email address
        $mail->Password = 'Noreplay@123'; //enter you email password
        $mail->Port = 587;           
				        $mail->SMTPOptions = array(
				            'ssl' => array(
				            'verify_peer' => false,
				            'verify_peer_name' => false,
				            'allow_self_signed' => true
				            )
				        );                                                       

				        $mail->setFrom('noreplay@esewin.in','Vending Machine');
				        
				        //Recipients
				        $mail->addAddress($email);              
				       
				        //Content
				        $mail->isHTML(true);                                            
				        $mail->Subject = 'Password Reset Code';
				        $mail->Body = $message;

				        if($mail->send())
                        $_SESSION['success']="We've sent a reset code to your email - $email";
                        else
                        $_SESSION['error']="Mail can`t be sent please cheak your email.";
                
                        $_SESSION['email'] = $email;
                        header('location: reset-code.php');
                        exit();
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
                 header('location: forgot-password.php');
			}
			
		}else{
$_SESSION['error'] = 'Email don`t exist';
        }
		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up user form first';
	}

	header('location: forgot-password.php');

?>