<?php
session_start();
if(isset($_SESSION['username'])){
    $logOut= "Welcome: <b>" . $_SESSION['username'] .
    "<br><a href='logout.php'>Logout</a>";
}
else{
    echo "Not welcome";
    header("refresh:3;url=login.php");
}

    include 'database_connection.php';


if(isset($_POST['submit'])){

if(!$con){
    die("Connection failed " . mysqli_connect_error());
}

$uname = $_POST["username"];
$upass =$_POST["pass"];
$email = $_POST["mail"];
$vkey=md5(time().$uname);

$uname = mysqli_real_escape_string($con,$uname);

$upass = mysqli_real_escape_string($con,$upass);
$upass=md5($upass);

$email = mysqli_real_escape_string($con,$email);

  //რეგისტრირებული მომხმარებლის ინფორმაციის ფაილში ჩაწერა
  $myfile=fopen("usersInfoCreatedByAdmin.txt","a") or die("Unable to open file!");
  $txt=$uname."/".$upass."/".$email."/";
  fwrite($myfile,$txt);
  fclose($myfile);
	
if($uname!=null&&$upass!=null&&$email!=null){
    $success=mysqli_query($con, " INSERT INTO accounts (username,upassword,email,vkey,vierfied) 
    VALUES('$uname','$upass','$email','$vkey',1) ");
} else {
	echo '<script language="javascript">';
	echo 'alert("შეავსე ფორმის ყველა ველი")';
    echo '</script>';
    header("Refresh:0;url=productes.php");
    }

if($success){
	print "1 successfully added";
    header("Refresh:0;url=productes.php");
}
else
{
	print "Error: " . $sql . "<br>" . mysqli_error($con);
}
    mysqli_close($con);
}
//edit user table
$result=mysqli_query($con,"select * from accounts");
if(isset($_GET['delete'])){
    $string="delete from accounts where id='".$_GET['delete']."'";

    if(mysqli_query($con,$string)){

        header("Refresh:0;url=productes.php");
    }
}

if(isset($_GET['makeAdmin'])){
    $updateUserAsAdmin="UPDATE accounts set admin=1 where id='".$_GET['makeAdmin']."'";

    if(mysqli_query($con,$updateUserAsAdmin)){
        header("Refresh:0;url=productes.php");
    }
}
if(isset($_GET['remove'])){
    $updateUserAsAdmin="UPDATE accounts set admin=0 where id='".$_GET['remove']."'";

    if(mysqli_query($con,$updateUserAsAdmin)){
        header("Refresh:0;url=productes.php");
    }
}
$myf= file("usersInfoCreatedByAdmin.txt");
$str=$myf[0];
$arr=explode("/",$str);

    try {
        if(sizeof($arr)==0) {
            throw new Exception("File is empty");
        }
    }
    catch(Exception $e) {
        echo 'Message: ' .$e->getMessage();
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
    <link rel="stylesheet" href="styles/addUserStyles.css">

    <title>Edit Info</title>
    <style>
        body{
            margin:20px;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
        table{
            margin-left:1%;
            display: inline-block;
        }
        form{
            margin-left:300px;
            margin-bottom:50px;
        }
        div{
            margin:10px;
        }
        .books a{
            text-decoration:none;
            font-size:25px;
            color:#ff55fa;
        }
        .logout{
            margin:0 0 0 3%;
        }
        .logout, .books{
            width:47%;
            display:inline-block;
        }
        .books{
            float:right;
        }
    </style>
</head>
<body>

<div class="logout">
<?php
echo "<h4>".$logOut."</h4>";
?>
</div>

<div class="books">
        <a href="img.php">წიგნები</a>
</div>

    <form action="" method="post">
        <h4>Add User</h4>
        <hr>
        <div>
        სახელი: <input type="text" class="input" name="username">
        </div>
        <div>
        პაროლი: <input type="text" class="input" name="pass">
        </div>
        <div>
        მეილი: <input type="email" class="input" name="mail">
        </div>
        <div>
            <input type="submit" name="submit">
        </div>
    </form>

    <table>
	<tr>
	<th>username</th>
	<th>password</th>
    <th>email</th>
    <th>vierfied</th>
    <th>Create Date</th>
    <th>admin</th>
	<th>delete</th>
    <th>update</th>
    <th>remove</th>
	</tr>
	<?php
	while($row=mysqli_fetch_array($result)){
        $deleteurl="productes.php?delete=".$row['Id'];
        $updateurl="productes.php?makeAdmin=".$row['Id'];
        $removeurl="productes.php?remove=".$row['Id'];
		echo "<th>".$row['username']."</th>";
        echo "<th>".md5($row['upassword'])."</th> ";
        echo "<th>".$row['email']."</th> ";
        echo "<th>".$row['vierfied']."</th> ";
        echo "<th>".$row['createdate']."</th> ";
        echo "<th>".$row['admin']."</th> ";
        echo "<th><a  href='$deleteurl'>delete</a></th>";
        echo "<th><a  href='$updateurl'>make admin</a></th>";
        echo "<th><a  href='$removeurl'>remove admin</a></th></tr>";
	}
	?>
	</table>
    
    <div>
    <h4>ადმინის მიერ რეგისტრირებული მომხმარებლები</h4>
    
    </div>
<?php
for ($i=0; $i <sizeof($arr)-1; $i+=3) { 
  echo "<div>"."<p><i>username:</i> ".trim($arr[$i]) ."\t / <i>password:</i> ".trim($arr[$i+1])."\t / <i>email:</i> ".trim($arr[$i+2])."</p>"."</div>";
}
?>
</body>
</html>