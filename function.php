<?php
        
		require_once("../configglobal.php");
		require_once("user.class.php");
		
		$database = "if15_jekavor"
		
		session_start();
		
        $mysqli = new mysqli($servername, $server_username, $server_password, $database);

		//Uus instant klassist User
		$User = new User($mysqli);
		
		//var_dump($User_connection);
		
		
		
?>		
	