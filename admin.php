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
    <li><a href="admin.php">MyAccount</a></li>
    <li><a href="adminprofile.php">MyProfile</a>
    </li>
    <li><a href="index.php" ><button class="btn1">Log Out</button></a></li>
  </ul>
</nav>
<br><br><br><br>
<h2>Registered Users:</h2>

<br>

<?php

    require_once "dbcontact.php";
    session_start();
    $userid=$_SESSION['userid'];
   //echo $userid;
    $show1=$database->prepare("SELECT * FROM users
    WHERE userstatus=1 OR  userstatus=2");
    $show1->execute();
    echo '<table >
    <thead>
      <tr>
        <th>User Name</th>
        <th>Full Name</th>
        <th>E-Mail</th>
        <th>Mobile Phone</th>
        <th>User Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>';
    if($show1->rowCount() ==0){
        echo '<tr >
        <td colspan=6 > no result</td>
        
      </tr>';
    }
     else{ 
    foreach($show1 AS $data){
        echo '<tr>
        <td>'.$data['username'].'</td>
        <td>'.$data['fname'].'</td>
        <td>'.$data['email'].'</td>
        <td>'.$data['mobile'].'</td>
        <td>';
       
        if($data['userstatus']==1){
          echo "Seller";
        }
        if($data['userstatus']==2){
            echo "Buyer";
          }
          echo '</td>
        <td> <form method="GET">
                <button class="btn1 " type="submit" name="delete" value="'.$data['userid'].'">Delete</button>
             </form></td>
       
       
      </tr>';
    }  
    if(isset($_GET['delete'])){
        $userid= $_GET['delete'];
        $del=$database->prepare("DELETE FROM users WHERE userid=$userid ");
        $del->execute(); 
        header("Location:admin.php");
      } 
      
}
      

      echo '</tbody>
  </table>';
  

    ?>


<br><br><br><br>
<h2>Availabe Crops:</h2>

<br>

<?php

    require_once "dbcontact.php";
   
    $userid=$_SESSION['userid'];
   //echo $userid;
    $show=$database->prepare("SELECT crops.name,sellercrop.sellerid,sellercrop.sellcropid,sellercrop.quantity,sellercrop.price FROM sellercrop INNER JOIN crops
    ON sellercrop.cropsid=crops.cropsid
   ");
    $show->execute();
    echo '<table >
    <thead>
      <tr>
        <th>Crop Name</th>
        <th>Seller ID</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>';
    if($show->rowCount() ==0){
        echo '<tr >
        <td colspan=5 > no result</td>
        
      </tr>';
    }
     else{ 
    foreach($show AS $data){
        echo '<tr>
        <td>'.$data['name'].'</td>
        <td>'.$data['sellerid'].'</td>
        <td>'.$data['quantity'].'</td>
        <td>'.$data['price'].'</td>
        <td> <form method="POST">
                <button class="btn1 " type="submit" name="delete" value="'.$data['sellcropid'].'">Delete</button>
             </form></td>
       
       
      </tr>';
    }  
    if(isset($_POST['delete'])){
        $sellid= $_POST['delete'];
        $del1=$database->prepare("DELETE FROM sellercrop WHERE sellcropid=$sellid ");
        $del1->execute(); 
        header("Location:admin.php");
      } 
      
}
      

      echo '</tbody>
  </table>';
  

    ?>



    
</body>
</html>