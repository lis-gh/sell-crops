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
    <li><a href="buyer.php">MyAccount</a></li>
    <li><a href="buyprofile.php">MyProfile</a></li>
    <li><a href="index.php" ><button class="btn1">Log Out</button></a></li>
  </ul>
</nav>
<br><br><br><br>
<h2>My Orders</h2>

<br>
<?php

    require_once "dbcontact.php";
    session_start();
    $userid=$_SESSION['userid'];
   //echo $userid;
    $show=$database->prepare("SELECT myorder.orderid, myorder.totalprice, myorder.date, users.username FROM users INNER JOIN myorder
    ON users.userid=myorder.sellerid   
    WHERE myorder.buyerid=$userid ");
    $show->execute();
    echo '<table >
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Seller Name</th>
        <th>Price</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>';
    if($show->rowCount() ==0){
        echo '<tr >
        <td colspan=4 > no result</td>
        
      </tr>';
    }
     else{ 
    foreach($show AS $data){
        echo '<tr>
        <td>'.$data['orderid'].'</td>
        <td>'.$data['username'].'</td>
        <td>'.$data['totalprice'].'</td>
        <td>'.$data['date'].'</td>
       
      </tr>';
    }   
      
}
      

      echo '</tbody>
  </table>';
  

    ?>
<br><br><br>
<h2>Available Sellers:</h2>

<br>
<?php

    require_once "dbcontact.php";
 
   //echo $userid;
    $show1=$database->prepare("SELECT * FROM users
    WHERE userstatus=1 ");
    $show1->execute();
    echo '<table >
    <thead>
      <tr>
        <th>Seller Name</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>';
    if($show1->rowCount() ==0){
        echo '<tr >
        <td colspan=2 > no result</td>
        
      </tr>';
    }
     else{ 
    foreach($show1 AS $data){
        echo '<tr>
        <td>'.$data['username'].'</td>
        <td> <form method="GET">
                <button class="btn " type="submit" name="view" value="'.$data['userid'].'">Order Now</button>
             </form></td>
       
       
      </tr>';
    }  
    if(isset($_GET['view'])){

        $_SESSION['sellerid']= $_GET['view'];
        header("Location:viewseller.php");
      } 
      
}
      

      echo '</tbody>
  </table>';
  

    ?>
    
</body>
</html>