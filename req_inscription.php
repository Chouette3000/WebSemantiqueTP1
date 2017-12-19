<?php  
	include "header.php";

// récupérer les éléments du formulaire  
// et se protéger contre l'injection MySQL (plus de détails ici: http://us.php.net/mysql_real_escape_string)  
$email= isset($_POST['email']) ? stripslashes($_POST['email']) : "";  
$password = isset($_POST['password']) ? stripslashes($_POST['password']) : "" ;  
$nom = isset($_POST['nom']) ? stripslashes($_POST['nom']): "";  
$prenom = isset($_POST['prenom']) ? stripslashes($_POST['prenom']): "";  
$tel = isset($_POST['tel']) ? stripslashes($_POST['tel']) : "";  
$website = isset($_POST['website']) ? stripslashes($_POST['website']): ""; 
$sexe = array_key_exists('sexe',$_POST) ? stripslashes($_POST['sexe']) : "";  
$birthdate= isset($_POST['birthdate']) ? stripslashes($_POST['birthdate']) : "";  
$ville= isset($_POST['ville']) ? stripslashes($_POST['ville']): "";  
$taille= isset($_POST['taille']) ? stripslashes($_POST['taille']): "";  
$couleur= isset($_POST['couleur']) ? substr(stripslashes($_POST['couleur']),1): "";  
$profilepic= isset($_POST['profilepic']) ? stripslashes($_POST['profilepic']): "";  

try {  
    // Connect to server and select database.  
    $dbh = new PDO('mysql:host=localhost;dbname=pictionnary', 'test', 'test');  
  
    // Vérifier si un utilisateur avec cette adresse email existe dans la table.  
    // En SQL: sélectionner tous les tuples de la table USERS tels que l'email est égal à $email.  
    $sql = $dbh->query("SELECT id 
						FROM USERS
						WHERE email='".$email."'");  
	if($sql->rowCount() >= 1){ 
		header("Location: inscription.php?email=".$email."&password=".$password."&nom=".$nom."&website=".$website."&prenom=".$prenom."&tel=".$tel."&birthdate=".$birthdate."&sexe=".$sexe."&ville=".$ville."&taille=".$taille."&couleur=".$couleur."&profilepic=".htmlspecialchars($profilepic)."&erreur=".urlencode("Utilisateur déjà existant"));
	
		// rediriger l'utilisateur ici, avec tous les paramètres du formulaire plus le message d'erreur  
        // utiliser à bon escient la méthode htmlspecialchars http://www.php.net/manual/fr/function.htmlspecialchars.php          
		// et/ou la méthode urlencode http://php.net/manual/fr/function.urlencode.php  
    }  
    else {  
        // Tenter d'inscrire l'utilisateur dans la base  
        $sql = $dbh->prepare("INSERT INTO users (email, password, nom, prenom, tel, website, sexe, birthdate, ville, taille, couleur, profilepic) "  
                . "VALUES (:email, :password, :nom, :prenom, :tel, :website, :sexe, :birthdate, :ville, :taille, :couleur, :profilepic)");  
        $sql->bindValue(":email", $email);  
        $sql->bindValue(":password", $password);   
        $sql->bindValue(":nom", ($nom == "") ? NULL : $nom);   
        $sql->bindValue(":prenom", ($prenom == "") ? NULL : $prenom);   
        $sql->bindValue(":tel", ($tel == "") ? NULL : $tel);   
        $sql->bindValue(":website", ($website == "") ? NULL : $website);   
        $sql->bindValue(":birthdate", ($birthdate == "") ? NULL : $birthdate);   
        $sql->bindValue(":ville", ($ville == "") ? NULL : $ville);   
        $sql->bindValue(":taille", ($taille == "") ? NULL : $taille);   
        $sql->bindValue(":profilepic", ($profilepic == "") ? NULL : $profilepic);
        $sql->bindValue(":couleur", ($couleur == "") ? NULL : $couleur); 
        $sql->bindValue(":sexe", ($sexe == "" || $sexe == "F" || $sexe == "H") ? $sexe : NULL); 
		// n.b., notez: birthdate est au bon format ici, ce serait pas le cas pour un SGBD Oracle par exemple  
        // idem pour la couleur, attention au format ici (7 caractères, 6 caractères attendus seulement)  
        // idem pour le sexe, attention il faut être sûr que c'est bien 'H', 'F', ou ''  
  
        // on tente d'exécuter la requête SQL, si la méthode renvoie faux alors une erreur a été rencontrée.  
        if (!$sql->execute()) {  
            echo "PDO::errorInfo():<br/>";  
            $err = $sql->errorInfo();  
            print_r($err);  
        } else {  
  
            // ici démarrer une session  
			session_start();
            // ensuite on requête à nouveau la base pour l'utilisateur qui vient d'être inscrit, et   
            $sql = $dbh->query("SELECT u.id as idUser, u.email as email, u.nom as nom, u.prenom as prenom, u.couleur as couleur, u.profilepic as profilepic
								FROM USERS u 
								WHERE u.email='".$email."'");  
            if ($sql->rowCount()<1) {  
                header("Location: inscription.php?erreur=".urlencode("un problème est survenu"));  
            }  
            else {  
				$infos = $sql->fetch(PDO::FETCH_ASSOC);
				$_SESSION['idUser']=  $infos['idUser']; 
				$_SESSION['email']=  $infos['email']; 
				$_SESSION['nom']=  $infos['nom']; 
				$_SESSION['prenom']=  $infos['prenom']; 
				$_SESSION['couleur']=  $infos['couleur']; 
				$_SESSION['profilepic']=  serialize($infos['profilepic']);                  
            }  			
            // ici,  rediriger vers la page main.php
			header("Location: main.php");		
        }  
        $dbh = null;  
    }  
} catch (PDOException $e) {  
    print "Erreur !: " . $e->getMessage() . "<br/>";  
    $dbh = null;  
    die();  
} 
?>  
<script>profilepic.JSON.stringify</script> 
