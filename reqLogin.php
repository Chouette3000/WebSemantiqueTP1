<?php  

$email= isset($_POST['email']) ? stripslashes($_POST['email']) : "";  
$password = isset($_POST['password']) ? stripslashes($_POST['password']) : "" ;

try{  
    // Connect to server and select database.  
    $dbh = new PDO('mysql:host=localhost;dbname=pictionnary', 'test', 'test');  
	$sql = $dbh->prepare("SELECT u.id as idUser, u.email as email, u.nom as nom, u.prenom as prenom, u.couleur as couleur, u.profilepic as profilepic
						  FROM USERS u
						  WHERE email = :email 
						  AND password = :password
						"); 
	$sql->bindValue(":email", $email);  
    $sql->bindValue(":password", $password); 
	$sql->execute();	
	if($sql->rowCount() < 1){ 
		header("Location: login.php?email=".$email."&erreur=".urlencode("Identifiants incorrects"));
	}  
    else{ 	
		// ici démarrer une session  
		session_start();
		$infos = $sql->fetch(PDO::FETCH_ASSOC);
		$_SESSION['idUser']=  $infos['idUser']; 
		$_SESSION['email']=  $infos['email']; 
		$_SESSION['nom']=  $infos['nom']; 
		$_SESSION['prenom']=  $infos['prenom']; 
		$_SESSION['couleur']=  $infos['couleur']; 
		$_SESSION['profilepic']=  serialize($infos['profilepic']);  			
		// ici,  rediriger vers la page main.php
		header("Location: main.php");		
    }  
    $dbh = null;  

} 
catch (PDOException $e) 
{  
	print "Erreur !: " . $e->getMessage() . "<br/>";  
	$dbh = null;  
	die();     
}
?>  