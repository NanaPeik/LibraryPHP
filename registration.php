<?php
$error=NULL;
if(isset($_POST['submit'])){

  $u = $_POST['u'];
  $e = $_POST['e'];
  $p = $_POST['p'];


  //რეგისტრირებული მომხმარებლის ინფორმაციის ფაილში ჩაწერა
  $myfile=fopen("users.txt","a") or die("Unable to open file!");
  $txt=$u."/".$e."/".$p."\n";
  fwrite($myfile,$txt);
  fclose($myfile);

  if(strlen($u)<1){
    $error="<p>Your username must be at least 5 characters</p>";
  }elseif($e==null||$p==null){
    $error .="<p>fill all filds</p>";
  }else{
    
    include 'database_connection.php';


    if(!$con){
      die("Connection failed " . mysqli_connect_error());
    }
    $u = mysqli_real_escape_string($con,$u);
    $e = mysqli_real_escape_string($con,$e);
    $p = mysqli_real_escape_string($con,$p);

    $vkey=md5(time().$u);
    $p=md5($p);

    $insert = " INSERT INTO accounts (username,upassword,email,vkey) 
    VALUES('$u','$p','$e','$vkey') ";


    if(mysqli_query($con, $insert)){

        $to=$e;
        $subject="Email Verification";
        $message="<a href='http://localhost/backside/verify.php?vkey=$vkey'>Register Account</a>";
        $headers = 'From: nana.peikrishvili104@ens.tsu.edu.ge' . 
        "\r\n"."MIME-Version: 1.0 "."\r\n" .
        'Content-type: text/html; charset=UTF-8'."\r\n";

      
        mail($to,$subject,$message,$headers);
        if(mail($to,$subject,$message,$headers)){
          header('location:login.php');

        }
    }
    else
    {
      print "Error: " . $insert . "<br>" . mysqli_error($con);
    }
      mysqli_close($con);
  }
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

  <label><h3>Registration</h3></label>
  <label>
    <p class="label-txt">ENTER YOUR EMAIL</p>
    <input type="email" class="input" name="e" required>
    <div class="line-box">
      <div class="line"></div>
    </div>
  </label>
  <label>
    <p class="label-txt">ENTER YOUR NAME</p>
    <input type="text" class="input" name="u" required>
    <div class="line-box">
      <div class="line"></div>
    </div>
  </label>
  <label>
    <p class="label-txt">ENTER YOUR PASSWORD</p>
    <input type="password" class="input" name="p" required>
    <div class="line-box">
      <div class="line"></div>
    </div>
  </label>
  
    <button type="submit" id="button" name="submit">Submit</button>
    <hr>
    <a href="login.php">LogIn</a>
    <!-- logIn.html -->
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
<?php
echo $error;
?>