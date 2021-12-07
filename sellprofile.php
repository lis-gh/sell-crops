<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?> ">

    <title>Document</title>
</head>
<body>

<nav>
  <ul>
    <li><a href="seller.php">MyAccount</a></li>
    <li><a href="sellprofile.php">MyProfile</a></li>
    </li>
    <li><a href="index.php" ><button class="btn1">Log Out</button></a></li>
  </ul>
</nav>
<br><br><br><br>
<?php

    require_once "dbcontact.php";
    session_start();
    $userid=$_SESSION['userid'];
   // echo $userid;
    $show=$database->prepare("SELECT users.username, users.email, users.password, users.mobile, users.fname FROM users  
    WHERE users.userid=$userid ");
    $show->execute();
    echo '<form method="GET">';
    if($show->rowCount() ==1){
      
      foreach($show AS $data){
        echo '
        <fieldset>
            <legend>Personalia:</legend>
            <label for="fname">User Name:</label><br>
            <input type="text"  name="uname" value="'.$data['username'].'"><br>
            <label for="lname">Full Name:</label><br>
            <input type="text"  name="fname" value="'.$data['fname'].'"><br><br>
            <label for="lname">Mobile Phone:</label><br>
            <input type="number" name="mobile" value="'.$data['mobile'].'"><br><br>
            <label for="lname">E-Mail:</label><br>
            <input type="email"  name="mail" value="'.$data['email'].'"><br><br>
            <label for="lname">Password:</label><br>
            <input type="password"  name="pass" value="'.$data['password'].'"><br><br>
            <input type="submit" class="btn" value="Update" name="edit">
        </fieldset>
        ';
        if(isset($_GET['edit'])){
            $newuname=$_GET['uname'];
            $newfname=$_GET['fname'];
            $newnum=$_GET['mobile'];
            $newmail=$_GET['mail'];
            $newpass=$_GET['pass'];
            
            require_once "dbcontact.php";
            $update=$database->prepare("UPDATE users SET username='$newuname', email='$newmail',password='$newpass', mobile='$newnum' , fname='$newfname'
            WHERE userid=$userid");
              $update->execute();
              header("Location:sellprofile.php");

        }      
    }
      
}      

      echo '</form>';
  

    ?>
    
</body>
</html>