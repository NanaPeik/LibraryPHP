<?php

if(isset($_COOKIE["login"])){
    $logOut= "Welcome: <b>" . $_COOKIE["login"] .
    "<br><a href='logout.php'>Logout</a>";
}
else{
    echo "Not welcome";
    header("refresh:3;url=login.php");
}

include 'database_connection.php';

  $result = mysqli_query($con, "SELECT * FROM books");

?>
<!DOCTYPE html>
<html>
<head>
<title>Books</title>
<style type="text/css">
   #content{
   	width: 50%;
   	margin: 20px auto;
   	border: 1px solid #cbcbcb;
   }
   form{
   	width: 50%;
   	margin: 20px auto;
   }
   form div{
   	margin-top: 5px;
   }
   #img_div{
   	width: 80%;
   	padding: 5px;
   	margin: 15px auto;
   	border: 1px solid #cbcbcb;
   }
   #img_div:after{
   	content: "";
   	display: block;
   	clear: both;
   }
   img{
   	float: left;
   	margin: 5px;
   	width: 300px;
   	height: 140px;
   }
   .logout{
       margin:3% 0 0 3%;
   }
</style>
</head>
<body>
<div class="logout">
<?php
echo "<h3>".$logOut."</h3>";
?>
</div>
<div id="content">
  <?php
    while ($row = mysqli_fetch_array($result)) {
      echo "<div id='img_div'>";
      	echo "<img src='images/".$row['image']."' >";
          echo "<p>აღწერა: ".$row['image_text']."</p>";
          echo "<p>ავტორი: ".$row['author']."</p>";
          echo "<p>ფასი: ".$row['price']."</p>";
      echo "</div>";
    }
  ?>
</div>
</body>
</html>