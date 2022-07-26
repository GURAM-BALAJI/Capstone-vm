<!doctype html>
<?php
include 'includes/session.php'; 
if(isset($_SESSION['user-otp']))
    header('location:user-otp.php');
if(isset($_SESSION['vm_user']))
        header('location: index.php');
?>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=0.70">
<meta charset="utf-8">
    <title>  Login </title>
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <style>
    body {
      background: linear-gradient(to right, rgba(235, 224, 232, 1) 52%, rgba(254, 191, 1, 1) 53%, rgba(254, 191, 1, 1) 100%);
    font-family: 'Roboto', sans-serif;
}
    </style>
    <body>
         <div class="login-box">
             <a  href="index.php" style=" color: #ff1c1c;float:right;text-decoration: none;">X</a>
 
           <h2>Login</h2>
           <form action="verify.php" method="post">
             <div class="user-box">
               <input type="text" name="email" required="" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?>">
               <label>Email</label>
             </div>
             <div class="user-box">
               <input type="password" name="password" required="" value="<?php if(isset($_SESSION['password'])) echo $_SESSION['password']; ?>">
               <label>Password</label>
               </div>
             <div class="user-box">
                 <a href="forgot-password.php" style="font-size:10px;">Forgot Password..?</a>
             </div>
                               <center>  <?php
      if(isset($_SESSION['error'])){
        echo "
          <div class='text-center' style='color:red;'>
            <p>".$_SESSION['error']."</p> 
          </div>
        ";
        unset($_SESSION['error']);
      }
        if(isset($_SESSION['success'])){
        echo "
          <div class='text-center' style='color:green;'>
            <p>".$_SESSION['success']."</p> 
          </div>
        ";
        unset($_SESSION['success']);
      }
    ?></center>
             <a  style="float:right;">
               <span></span>
               <span></span>
               <span></span>
               <span></span>
               <input type="submit" name="login" value="LOG IN"
                      style="border:none;
                      background:none;
                      outline: none;
                      transition: .5s;
                      letter-spacing: 4px;
                      display: inline-block;
                      color: #03e9f4;
                      text-transform: uppercase;
                      font-weight: 600;
                      text-decoration: none;
                      overflow: hidden;
                      font-size: 18px;
" >
             </a>
           </form><br><br><br><br><br>
           <center>
           <a  href="sign_up.php" 
                     style="color:aquamarine;text-decoration: none;">
                      I dont have an account, <b>Create New</b>
             </a>
           </center>
         </div>
    </body>
    </html>