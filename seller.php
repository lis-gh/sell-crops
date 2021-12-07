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
    <li><a href="#">MyAccount</a></li>
    <li><a href="sellprofile.php">MyProfile</a></li>
    </li>
    <li><a href="index.php" ><button class="btn1">Log Out</button></a></li>
  </ul>
</nav>
<br><br><br><br>
<h2>My current crops</h2><br><br>
<a href="resetcrop.php"><button class="btn" style="float: right;margin-right:50px">Reset MyCrops</button></a>
<br><br><br>
<?php

    require_once "dbcontact.php";
    session_start();
    $userid=$_SESSION['userid'];
   // echo $userid;
    $show=$database->prepare("SELECT crops.cropsid, crops.name, sellercrop.quantity, sellercrop.price FROM users INNER JOIN sellercrop INNER JOIN crops 
    ON users.userid=sellercrop.sellerid AND crops.cropsid=sellercrop.cropsid  
    WHERE users.userid=$userid ");
    $show->execute();
    echo '<table >
    <thead>
      <tr>
        <th>Crop ID</th>
        <th>Crop Name</th>
        <th>Quantity</th>
        <th>Price</th>
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
        <td>'.$data['cropsid'].'</td>
        <td>'.$data['name'].'</td>
        <td>'.$data['quantity'].'</td>
        <td>'.$data['price'].'</td>
       
      </tr>';
    }
      
}      

      echo '</tbody>
  </table>';
  

    ?>
<br><br><br>
<h2>My Reviews</h2><br>

<?php

    require_once "dbcontact.php";
  
    $show1=$database->prepare("SELECT comments.content, comments.date, users.username FROM users INNER JOIN comments
    ON users.userid=comments.buyerid   
    WHERE comments.sellerid=$userid ");
    $show1->execute();
    echo '<table >
    <thead>
      <tr>
        <th>Buyer UserName</th>
        <th>Comment</th>
        <th>Comment Date</th>
      </tr>
    </thead>
    <tbody>';
    if($show1->rowCount() ==0){
        echo '<tr >
        <td colspan=3 > no result</td>
        
      </tr>';
    }
     else{ 
    foreach($show1 AS $data1){
        echo '<tr>
        <td>'.$data1['username'].'</td>
        <td>'.$data1['content'].'</td>
        <td>'.$data1['date'].'</td>
       
      </tr>';
    }
      
}      

      echo '</tbody>
  </table>';
  

    ?>
    
    <br><br><br><br><br>
<h2>My Orders</h2><br>
<?php

    require_once "dbcontact.php";
  
    $show2=$database->prepare("SELECT orderid, quantity,cropname FROM  myorder  
    WHERE sellerid=$userid ");
    $show2->execute();
    echo '<table >
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Crop Name</th>
        <th>Crop Quantity</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>';
    if($show2->rowCount() ==0){
        echo '<tr >
        <td colspan=4 > no result</td>
        
      </tr>';
    }
     else{ 
    foreach($show2 AS $data2){
        echo '<tr>
        <td>'.$data2['orderid'].'</td>
        <td>'.$data2['cropname'].'</td>
        <td>'.$data2['quantity'].'</td>
        <td>
          <label >
            <input type="radio" name="action" > Confirm
          </label>
          <br>
          <label >
            <input type="radio" name="action" > Cancel
          </label>
        </td>
       
      </tr>';
    }
      
}      

      echo '</tbody>
  </table>';
  

    ?>
    
</body>
</html>