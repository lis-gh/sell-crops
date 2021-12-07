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
<h2>My current crops</h2><br><br>
<form method="POST">
    <select  name="crops" style="padding: 10px;border-radius:30px;margin-right: 30px;">
    <option >--select crop--</option>
    <option value="1">apple</option>
    <option value="2">potato</option>
    <option value="3">grapes</option>
    <option value="4">lemon</option>
    <option value="5">tomato</option>
    </select>
    <input type="text"  name="quant" placeholder="enter quantaty of crop" style="margin-right: 30px;">
    <input type="text"  name="price" placeholder="enter price of crop" style="margin-right: 30px;">
    <input type="submit" class="btn" value="Add Crops" name="add">
</form>

<?php
 require_once "dbcontact.php";
 session_start();
 $userid=$_SESSION['userid'];
 //echo $userid;
  if(isset($_POST['add'])){
   
    $cropid=$_POST['crops'];
    $quant=$_POST['quant'];
    $price=$_POST['price'];
   // echo $userid;
    $insert=$database->prepare("INSERT INTO sellercrop (cropsid,sellerid,quantity, price) 
    VALUES ('$cropid','$userid','$quant', '$price') ");
     $insert->execute();
     header("Location:resetcrop.php");
  }

   // echo $userid;
    $show=$database->prepare("SELECT crops.cropsid, crops.name, sellercrop.quantity, sellercrop.price FROM users INNER JOIN sellercrop INNER JOIN crops 
    ON users.userid=sellercrop.sellerid AND crops.cropsid=sellercrop.cropsid  
    WHERE users.userid=$userid ");
    $show->execute();
    echo '<br><br><br>
    <table >
    <thead>
      <tr>
        <th>Crop ID</th>
        <th>Crop Name</th>
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
        $cropid=$data['cropsid'];
        echo '<tr>
        <form method="GET">
        <td>'.$data['cropsid'].'</td>
        <td>'.$data['name'].'</td>
        <td> <input type="text"  name="quant" value="'.$data['quantity'].'"></td>
        <td> <input type="text"  name="price" value="'.$data['price'].'"></td>
        <td>
        <button class="btn1 " type="submit" name="delete" value="'.$data['cropsid'].'">delete</button>
        <button class="btn " type="submit" name="edit" value="'.$data['cropsid'].'">edit</button>
        </td>
      </tr></form>';
    }

    if(isset($_GET['delete'])){

        $cropid= $_GET['delete'];
        $del=$database->prepare("DELETE FROM sellercrop WHERE cropsid=$cropid AND sellerid=$userid");
        $del->execute(); 
        header("Location:resetcrop.php");

      }
      elseif(isset($_GET['edit'])){
        $cropid= $_GET['edit'];
        $newquant=$_GET['quant'];
        $newprice=$_GET['price'];
        $update=$database->prepare("UPDATE sellercrop SET quantity='$newquant', price='$newprice'
        WHERE cropsid=$cropid AND sellerid=$userid");
          $update->execute();

       
       
        header("Location:resetcrop.php");
      }
      
}      

      echo '</tbody>
  </table>';
  

    ?>

    
</body>
</html>