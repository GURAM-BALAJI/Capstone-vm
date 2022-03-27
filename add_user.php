<?php
use PHPMailer\PHPMailer\PHPMailer;
	include 'includes/session.php';

	if(isset($_POST['email'])){
		$_SESSION['name']=$name = $_POST['name'];
		$_SESSION['email']=$email = $_POST['email'];
		$_SESSION['contact']=$contact = $_POST['contact'];
		$_SESSION['password']=$password = $_POST['password'];
		$cpassword = $_POST['cpassword'];
		date_default_timezone_set('Asia/Kolkata');
		$today = date('d-m-Y h:i:s a');
		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM users WHERE user_email=:email || user_phone=:phone");
		$stmt->execute(['email'=>$email, 'phone'=>$contact]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Email or phone number already taken.';
		}
		else{
            if($password == $cpassword){
			$password = password_hash($password, PASSWORD_DEFAULT);
        
try{
    $code = rand(999999, 111111);
$stmt = $conn->prepare("INSERT INTO users (user_email, user_password, name, user_phone,  user_code, user_added_date, user_updated_date) VALUES (:email, :password, :name, :contact, :user_code, :user_added_date, :user_updated_date)");
$stmt->execute(['email'=>$email, 'password'=>$password, 'name'=>$name, 'contact'=>$contact,  'user_code'=>$code, 'user_added_date'=>$today, 'user_updated_date'=>$today ]);
    
        $message = "<center><h1>Your verification code is</h1><h2>$code</h2><br><br><br><hr>If you has not sent please ignore this mail.<h2>esewin.in</h2></center>";
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
				        $mail->Subject = 'Verification Code:';
				        $mail->Body = $message;

				        if($mail->send())
                        $_SESSION['success']="We've sent a verification code to your email - $email";
                        else
                        $_SESSION['error']="Mail can`t be sent please cheak your mail.";
                $_SESSION['user-otp'] = $email;
    $_SESSION['email']=$email;
    header('location: user-otp.php');
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
                 header('location: sign_up.php');
			}
        }else{
             $_SESSION['error'] = "Confirm password not matched!";  
            }}
		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up user form first';
	}

	header('location: sign_up.php');
