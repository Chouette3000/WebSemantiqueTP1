<!DOCTYPE html> 
<html> 
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<body>
	<?php  
		session_start();  
		if(isset($_SESSION['idUser']))
		{
			echo "<h2>Bonjour ".$_SESSION['nom']." ".$_SESSION['prenom']."</h2>";
	?> 
			<img src="<?php echo unserialize($_SESSION['profilepic']);?>" id="picture" alt="profilePic" > 
			<a href="logout.php">Logout</a>
	<?php 
		}
		else{
			include "login.php";
		}
	?>  
</body>
	
</html> 