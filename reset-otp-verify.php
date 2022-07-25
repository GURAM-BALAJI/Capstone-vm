<?php
include 'includes/session.php';
if(isset($_POST['check-reset-otp'])){
    if(isset($_SESSION['email'])){
    $email=$_SESSION['email'];
        $otp_code =$_POST['otp'];
 $conn = $pdo->open();
 $stmt = $conn->prepare("SELECT * FROM users WHERE user_email='$email'");
$stmt->execute();
foreach($stmt as $row){
    if(strval($row['user_code'])==strval($otp_code)){
        $id=$row['user_id'];
            $stmt = $conn->prepare("UPDATE users SET user_code=:code WHERE user_id=:id");
			$stmt->execute(['code'=>0, 'id'=>$id]);
                header('location: new-password.php');
                exit();
        }else{
            $_SESSION['error'] = "You've entered incorrect code!";
        header('location: reset-code.php');
        
        }}
$pdo->close();
    }else{
       header('location: index.php'); 
    }}else{
header('location: index.php'); 
}
?>