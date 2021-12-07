<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?> ">
    <title>Document</title>
    <style>
        body{
            background:linear-gradient(#00000067,#00000067), url('imgs/images.jfif') center;
            background-size: cover;
            background-repeat: no-repeat;
            width: 100%;
            height: 100vh;
            margin: 0px;

        }
    </style>
</head>
<body>


    <div class="register">
        <div  class="create">
           <h2>Don't Have acoount</h2>
           <form method="POST">
                <input type="text" name="uname" placeholder="Username"><br><br>
                <input type="email" name="mail" placeholder="E-mail"><br><br>
                <input type="password" name="pass" placeholder="Password"><br><br>
                <input type="number" name="phone" placeholder="Mobile Phone"><br><br>
                <input type="text" name="fname" placeholder="Full Name"><br>
                <h4>Select what you are:</h4>
                <input type="radio" id="seller" name="status" value="1">
                <label for="seller">Seller</label>
                <input type="radio" id="buyer" name="status" value="2">
                <label for="buyer">Buyer</label><br><br>
                <input type="submit" name="create" value="Register" class="btn">
            </form>
        </div>
        <div class="log">
            <h2>Login</h2>
           <form method="GET">
                <input type="email" name="mail" placeholder="E-mail" required><br><br>
                <input type="password" name="pass" placeholder="Password" required><br><br>
                <input type="submit" value="Login" name="log" class="btn">
            </form>
        </div>
    </div>


    <?php
    session_unset();
  if(isset($_GET['log'])){
    require_once "dbcontact.php";
    $mail=$_GET['mail'];
    $pass=$_GET['pass'];
    $check=$database->prepare("SELECT userid, userstatus FROM users WHERE email='$mail' AND password='$pass' ");
    $check->execute();
    if($check->rowCount() ==1){
    
    $getid=$check->fetch(PDO::FETCH_ASSOC);
    
    session_start();
    $_SESSION['userid']=$getid['userid'];
   // echo $getid['userid'];
   if($getid['userstatus']==0){
   header("Location:admin.php");}
   elseif($getid['userstatus']==1){
   header("Location:seller.php");}
   elseif($getid['userstatus']==2){
   header("Location:buyer.php");}
  }
  }
  elseif(isset($_POST['create'])){
    require_once "dbcontact.php";
    $fname=$_POST['fname'];
    $uname=$_POST['uname'];
    $mail=$_POST['mail'];
    $telnum=$_POST['phone'];
    $pass=$_POST['pass'];
    $status=$_POST['status'];
    $check=$database->prepare("SELECT * FROM users WHERE fname='$fname' AND username='$uname' ");
    $check->execute();
    if($check->rowCount() ==0){
    
    $adduser=$database->prepare("INSERT INTO users(username, email, password, mobile, fname, userstatus) 
                                 VALUES('$uname', '$mail', '$pass', '$telnum', ' $fname', '$status')");
    $adduser->execute();
    $gett=$database->prepare("SELECT userid FROM users WHERE fname='$fname' AND username='$uname' AND password='$pass'");
    $gett->execute();
    $gett=$gett->fetch(PDO::FETCH_ASSOC);
   
  
        session_start();
    $_SESSION['userid']=$gett;
    //echo $status;
   if($status==0){
       header("Location:admin.php");}
    elseif($status==1){
       header("Location:seller.php");}
    elseif($status==2){
       header("Location:buyer.php");}
   
    
       }
    
  }
  ?>


</body>
</html>