<?php

include 'database_connection.php';

if(isset($_POST['submit'])){

if(!$con){
	die("Connection failed " . mysqli_connect_error());
}


$uname = stripcslashes($_POST["uname"]);
$uname = mysqli_real_escape_string($con,$uname);


$upass = stripcslashes($_POST["upass"]);
$upass = mysqli_real_escape_string($con,$upass);
$upass=md5($upass);

      $resultSet=mysqli_query($con,"select * from accounts where username = '$uname' 
          And upassword = '$upass' and admin = 1 limit 1");

      if($resultSet->num_rows!=0){
          session_start();
          $_SESSION['username'] = $_POST["uname"];
          echo 'hi, '.$_SESSION['username']."<br>";
        
          header('location:productes.php');
      }else{
          echo "You can't login as admin";
      }

    mysqli_close($con);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="styles/style.css">
    <title>Inebe.ge</title>
</head>
<body>

<form  action="" method="post">
    <label><h3>Log In As Admin</h3></label>
  <label>
    <p class="label-txt">ENTER YOUR NAME</p>
    <input type="text" class="input" name="uname">
    <div class="line-box">
      <div class="line"></div>
    </div>
  </label>
  <label>
    <p class="label-txt">ENTER YOUR PASSWORD</p>
    <input type="password" class="input" name="upass">
    <div class="line-box">
      <div class="line"></div>
    </div>
  </label>
  
    <button type="submit" name="submit">submit</button>
    <hr>
    <a href="registration.php" >Registration</a>
    <br>
 
</form>
<script>
    $(document).ready(function(){

$('.input').focus(function(){
  $(this).parent().find(".label-txt").addClass('label-active');
});

$(".input").focusout(function(){
  if ($(this).val() == '') {
    $(this).parent().find(".label-txt").removeClass('label-active');
  };
});

});
</script>
</body>

</html>