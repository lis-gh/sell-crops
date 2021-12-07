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
<h2>Customers Reviews of this Seller</h2>
<form method="POST" >
    <input type="text"  name="content" placeholder="write your review..." style="margin-left: 50px;">
    <input type="date"  name="date"  style="margin-right: 30px;margin-left: 30px;">
    <input type="submit" class="btn" value="Add your review" name="add">
</form>
<br>
<?php

    require_once "dbcontact.php";
    session_start();
    $userid=$_SESSION['userid'];
    $sellerid=$_SESSION['sellerid'];
   
   if(isset($_POST['add'])){
   
    $content=$_POST['content'];
    $date=$_POST['date'];
   // echo $userid;
    $insert=$database->prepare("INSERT INTO comments (sellerid,buyerid,content, date) 
    VALUES ('$sellerid','$userid','$content', '$date') ");
     $insert->execute();
     header("Location:viewseller.php");
  }
    $show=$database->prepare("SELECT  comments.content, comments.date, users.username FROM users INNER JOIN comments
    ON users.userid=comments.buyerid   
    WHERE comments.sellerid=$sellerid ");
    $show->execute();
    echo '<table >
    <thead>
      <tr>
        <th>Customer Name</th>
        <th>Review</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>';
    if($show->rowCount() ==0){
        echo '<tr >
        <td colspan=3 > no result</td>
        
      </tr>';
    }
     else{ 
    foreach($show AS $data){
        echo '<tr>
        <td>'.$data['username'].'</td>
        <td>'.$data['content'].'</td>
        <td>'.$data['date'].'</td>
       
      </tr>';
    }   
      
}
      

      echo '</tbody>
  </table>';
  

    ?>
<br><br><br>
<h2>Available Crops of this Seller:</h2>

<br>
<?php

    require_once "dbcontact.php";

    $show1=$database->prepare("SELECT crops.name, sellercrop.quantity, sellercrop.price FROM crops INNER JOIN sellercrop
    ON crops.cropsid=sellercrop.cropsid   
    WHERE sellercrop.sellerid=$sellerid ");
    $show1->execute();
    echo '<table >
    <thead>
      <tr>
        <th>Crop Name</th>
        <th>Price</th>
        <th>Quantity</th>
      </tr>
    </thead>
    <tbody>';
    if($show1->rowCount() ==0){
        echo '<tr >
        <td colspan=3 > no result</td>
        
      </tr>';
    }
     else{ 
    foreach($show1 AS $data){
        echo '<tr>
        <td>'.$data['name'].'</td>
        <td>'.$data['price'].'</td>
        <td>'.$data['quantity'].'</td>
       
       
      </tr>';
    }  
      
}
      echo '</tbody>
  </table>';
    ?>
<br><br><br>
<form method="GET" name="form1">
  <fieldset>
    <legend>Make Order:</legend>
    <label for="fname">Crop:</label><br>
    <select  name="crops" id="crop" style="padding: 10px;border-radius:30px;margin-right: 30px;"  onchange="cal()">
    <option >--select crop--</option>
    <?php
      require_once "dbcontact.php";

      $show1=$database->prepare("SELECT crops.name, sellercrop.quantity, sellercrop.price FROM crops INNER JOIN sellercrop
      ON crops.cropsid=sellercrop.cropsid   
      WHERE sellercrop.sellerid=$sellerid ");
      $show1->execute();
         foreach($show1 AS $data){
            echo '
            <option value="'.$data['price'].'">'.$data['name'].'</option>';
        }  
    ?>

    </select><br><br><br>
    <input type="text" name="crop" id="cropname" hidden>
    <label for="lname">Quantity:</label><br>
    <input type="number" min="0" id="quant" name="quant" placeholder="How many Kelos..." required onchange="cal()"><br><br>
    <label for="lname">Order Date:</label><br>
    <input type="date" name="date"  required ><br><br>
    <input type="number"   name="total" placeholder="Total Price" style="border: none;" ><br><br>
    <input type="submit" class="btn" value="Order" name="order">
  </fieldset>
</form>
    
<?php
if(isset($_GET['order'])){
    $crop = $_GET['crop'];
    $date=$_GET['date'];
    $price=$_GET['total'];
    $quant=$_GET['quant'];
   // echo $userid;
   $insert=$database->prepare("INSERT INTO myorder (sellerid,buyerid,cropname,quantity,totalprice,date) 
   VALUES ('$sellerid','$userid',' $crop','$quant','$price', '$date') ");
   $insert->execute();
    // echo  $crop;
  }

?>

<script>
    function cal(){
        var crop=document.getElementById('crop').value;
        var quant=document.getElementById('quant').value;
        var cropn=document.getElementById('cropname');
        document.form1.total.value=Number(crop)*Number(quant);
        var cr=document.getElementById('crop');
        var cropname=cr.options[cr.selectedIndex].text;
        cropn.value=cropname;
        
    }

   
</script>
</body>
</html>