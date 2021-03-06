<?php


class User {
	
	     //privaatne muutuja
		 private $connection;
		   
		 //funktsioon, mis k�ivitub siis, kui
          // on ! NEW User();

         function __construct($mysqli){
			 
			 // see connection on uut muutuja 
			 //selle classi muutuja
			 $this->connection = $mysqli;
			 
		 }		  
		   
		function createUser($create_email, $password_hash){ {

         // teen objekti, et saada tagasi  kas errori(id, message) v�i successi (message)
        $response = new StdClass();		 
		
		//kas selline email on juba olemas
		$stmt = $this->connection->prepare("SELECT email FROM user_sample WHERE email = ?");
		$stmt->bind_param("s", $create_email);
		$stmt->execute();
		
		if ($stmt->fetch()) {
			
			//saadan tagasi errori
			$error = new StdClass();
			$error->id=0;
			$error->message = "Selline e-postiga kasutaja on juba olemas";
			
			//panen error responsile k�lge
			$response->essror = $error;
			
			return $response;
			
			//*************************
			//****OLULINE***********
			//**********************
			//panen eelmise k�su kinni
			$stmt->close();
			
		}
		 
			
		$stmt = $this->connection->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		$stmt->bind_param("ss", $create_email, $password_hash);
		
		
		if($stmt->execute()){
			//educalt salvestas
			$success = new StdClass();
			$success ->message = "Kasutaja edukalt salvestanud";
			
			$user = new StdClass();
			$user->id=$id_from_db;
			$user->email=$email_from_db;
			
			$success->user = $user;
			
			$response->success = $success;
		
        }else{
			// midagi l�ks katki
			$error = new StdClass();
			$error->id =1;
			$error->message = "Midagi l�ks katki!";
			
			//panen errori responsile k�lge
			$response->error = $error;
		}
		
		}
		//saada tagasi vastuse, kas success v�i error
		
		$stmt->close();
		
		return $response;
		
		
				
	}  
		   
		function loginUser($email, $password_hash){
		

		 $response = new StdClass();		
		
		$stmt = $this->connection->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $password_hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		   
		// ei ole sellist kasutajat - !
		if(!$stmt->fetch()){
			
			// saadan tagasi errori
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Sellise e-postiga kasutajat ei ole olemas!";
			
			//panen errori responsile k�lge
			$response->error = $error;
			
			return $response;
		}
		
		// p�rast returni enam koodi edasi ei vaadata funktsiooni
		
		$stmt->close();
		
		$stmt = $this->connection->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $password_hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			// edukalt sai k�tte
			$success = new StdClass();
			$success->message = "Kasutaja edukalt sisse logitud";
			
			$response->success = $success;
			
		}else{
			// midagi l�ks katki
			$error = new StdClass();
			$error->id =1;
			$error->message = "Vale parool!";
			
			//panen errori responsile k�lge
			$response->error = $error;
		}
		
		$stmt->close();
		
		return $response;
	}
}?>






