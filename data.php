<?php
   //laeme funktsiooni failis
   require_once("function.php");
   
   // kas kasutaja on sisse loginud
   if(!isset($_SESSION["id_from_db"])) {
	   //suudan data lehel
	   header("Location: login.php");
   }
   //login v�lja
   if(isset($_GET["logout"])){
	   // kustutab k�ik sessiooni muutujad
	   session_destroy();
	   
	   
	   header("Location: login.php");
	   
   }
   
  
?>

<p>
  Tere, <?php echo $_SESSION["user_email"];?>
  <a href= "?logout=1" >Logi v�lja</a>
</p>
