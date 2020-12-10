<?php
	if(isset($_COOKIE["login"])){
		
		setcookie("login","",time()-1);
		setcookie("password","",time()-1);
		setcookie("email","",time()-1);
		header("Location: login.php");
    }
    session_start();
    if(isset($_SESSION["username"])){

        unset($_SESSION['username']);
        session_destroy();
        header("Location: login.php");
	}
	

?>