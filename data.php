<?php
   //laeme funktsiooni failis
   require_once("function.php");
   
   // kas kasutaja on sisse loginud
   if(!isset($_SESSION["id_from_db"])) {
	   //suudan data lehel
	   header("Location: login.php");
   }
   //login välja
   if(isset($_GET["logout"])){
	   // kustutab kõik sessiooni muutujad
	   session_destroy();
	   
	   
	   header("Location: login.php");
	   
   }
   
  
?>

<p>
  Tere, <?php echo $_SESSION["user_email"];?>
  <a href= "?logout=1" >Logi välja</a>
</p>
