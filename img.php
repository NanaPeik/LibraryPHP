<?php
  $db = mysqli_connect("localhost:3308", "root", "", "users");

  $msg = "";

  if (isset($_POST['upload'])) {

	$image = $_FILES['image']['name'];

	$image_text = mysqli_real_escape_string($db, $_POST['image_text']);
      $author = mysqli_real_escape_string($db, $_POST['author']);
      $price = mysqli_real_escape_string($db, $_POST['price']);

  	$target = "images/".basename($image);

  	$sql = "INSERT INTO books (image, image_text,author,price) VALUES ('$image', '$image_text','$author','$price')";

	  mysqli_query($db, $sql);

  	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}
  }
  $result = mysqli_query($db, "SELECT * FROM books");

  if(isset($_GET['delete'])){
    $string="delete from books where id='".$_GET['delete']."'";

    if(mysqli_query($db,$string)){

        header("Refresh:0;url=img.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Image Upload</title>
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
</style>
</head>
<body>
<div id="content">
  <?php
    while ($row = mysqli_fetch_array($result)) {
    $deleteurl="img.php?delete=".$row['id'];
      echo "<div id='img_div'>";
      	echo "<img src='images/".$row['image']."' >";
          echo "<p>აღწერა: ".$row['image_text']."</p>";
          echo "<p>ავტორი: ".$row['author']."</p>";
          echo "<p>ფასი: ".$row['price']."</p>";
          echo "<th><a  href='$deleteurl'>delete</a></th>";
      echo "</div>";
    }
  ?>
  <form method="POST" action="" enctype="multipart/form-data">
  	<input type="hidden" name="size" value="1000000">
  	<div>
  	  <input type="file" name="image">
  	</div>
  	<div>
      <textarea 
      	id="text" 
      	cols="40" 
      	rows="4" 
      	name="image_text" 
      	placeholder="Say something about this book..."></textarea>
  	</div>
      <div>
  	  <input type="text" name="author" placeholder="Author">
  	</div>
      <div>
  	  <input type="text" name="price" placeholder="Price">
  	</div>
  	<div>
  		<button type="submit" name="upload">POST</button>
  	</div>
  </form>
</div>
</body>
</html>