<?php
if(isset($_GET['vkey'])){
    $vkey=$_GET['vkey'];

    include 'database_connection.php';

    $resultSet=mysqli_query($con,"select vierfied,vkey from accounts
                                where vierfied=0 and vkey='$vkey' limit 1");  
    if($resultSet->num_rows==1){
        $update=mysqli_query($con,"UPDATE accounts set vierfied=1
                            where vkey='$vkey' limit 1");
        if($update){
            echo "Your account has been verified. You may now login.";
        }else{
            echo mysqli_error($con);
        }
    }else{
        echo "This account invalid or already verified";
    }
}else{
    die("Something went wrong!");
}
?>
<html>
<head>
<link rel="stylesheet" href="styles/style.css" type="text/css">
</head>
<body>

</body>
</html>