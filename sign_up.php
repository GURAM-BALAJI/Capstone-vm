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
    <title>  Sign In </title>
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>
      <style>
    body {
  background-image: url('img.jpg');
}
    </style>
    <body>
         <div class="login-box">
             <a  href="index.php" style=" color: #ff1c1c;float:right;text-decoration: none;">X</a>
           <h2>Sign In</h2>
           <form action="add_user.php" method="post" onsubmit="myclick();">
             <div class="user-box">
        <input type="text" name="name" required value="<?php if(isset($_SESSION['name'])) echo $_SESSION['name']; ?>"/>
               <label>Full Name</label>
             </div>
               <div class="user-box">
               <input type="email" name="email" required value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?>"/>
               <label>Email</label>
             </div>
               <div class="user-box">
               <input type="tel" name="contact" required value="<?php if(isset($_SESSION['contact'])) echo $_SESSION['contact']; ?>"/>
               <label>Contact</label>
             </div>
             <div class="user-box">
               <input type="password" name="password" required value="<?php if(isset($_SESSION['password'])) echo $_SESSION['password']; ?>"/>
               <label>Password</label>
                  <div class="user-box">
                 <input type="password" name="cpassword" required/>
               <label>Confirm Password</label>
             </div>
                                  
              <center> <?php
      if(isset($_SESSION['error'])){
        echo "
          <div class='text-center' style='color:red;'>
            <p>".$_SESSION['error']."</p> 
          </div>
        ";
        unset($_SESSION['error']);
      }
    ?></center></div>
             <a >
               <span></span>
               <span></span>
               <span></span>
               <span></span>
                <input type="submit" name="signup" value="SIGN UP" id="signup"
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
                             font-size: 18px;"></a>
           </form><br>
           <a  href="login.php" style="color:aquamarine;text-decoration: none;">I have account already,<b> Click Me..</b> </a>
         </div>
        <script type="text/javascript">
    function myclick(){
        document.getElementById('signup').disabled="true";
    }
    </script>
    </body>
    </html>