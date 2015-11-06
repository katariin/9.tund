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
	   
		  //FILE UPLOAD
		  
	$target_dir = "portfile_pics/";
	//profile_pics/Koala.png
	$target_file = $target_dir . $_SESSION["id_from_db"].".jpg";

	  if(isset($_POST["submit"])) {
		   $uploadOk = 1;
		   $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	// Check if image file is a actual image or fake image  
	// getimagesize anna mulle selle pildi suurus
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

// Check if file already exists
     if (file_exists($target_file)) {
         echo "Sorry, file already exists.";
         $uploadOk = 0;
}
// Check file size
      if ($_FILES["fileToUpload"]["size"] > 1024000) {
          echo "Sorry, your file is too large.";
          $uploadOk = 0;
}
// Allow certain file formats
       if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
           && $imageFileType != "gif" ) {
           echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
           $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
         if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {    //võttab temp kaustast, kontrollime kas selline fail sobib, ja siis suunatakse meile failisse
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
  
  }  
?>

<p>
  Tere, <?php echo $_SESSION["user_email"];?>
  <a href= "?logout=1" >Logi välja</a>
</p>

<h2>Profiilipilt</h2>

  <?php if(file_exists($target_file)): ?>
  
  <div=style ="
          width:200px;
		  height:200px;
		  background-image: url(<?=$target_file;?>);
		  background-position:center center;
		  background-size: cover;
  "></div>
  
  <img width=200 height=200 src="<?=$target_file;?>

  <?php else: ?>
  
  <p style="color:green"></p>
  

<form action="data.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>


  <?php endif; ?>