<!DOCTYPE html> 
<?php
	include "header.php";
?>	
<html>  
<head>  
    <meta charset=utf-8 />  
    <title>Pictionnary - Inscription</title>
	<link rel="stylesheet" media="screen" href="css/styles.css" >  	
</head>  
<body>  
  
<h2>Inscrivez-vous</h2>  
<?php if(isset($_GET['erreur'])) echo "<h2>".$_GET['erreur']."</h2>";?>
<form class="inscription" action="req_inscription.php" method="post" name="inscription">  
    <span class="required_notification">Les champs obligatoires sont indiqués par *</span>  
    <ul>   
        <li>  
            <label for="email">E-mail : </label>  
            <input type="email" name="email" value="" id="email" autofocus required />            
            <span class="form_hint">Format attendu "name@something.com"</span>  
        </li>  
        <li>  
            <label for="prenom">Prénom :</label>  
            <input type="text" name="prenom" id="prenom" value="<?PHP if(isset($_GET['prenom'])) echo $_GET['prenom']; ?>" placeholder="votre prénom" required />  
        </li>
		<li>  
            <label for="nom">Nom :</label>  
            <input type="text" name="nom" id="nom" value="<?PHP if(isset($_GET['nom'])) echo $_GET['nom']; ?>" required />  
        </li>
		<li>  
            <label for="nom">Téléphone :</label>  
            <input type="tel" name="tel" id="tel" value="<?PHP if(isset($_GET['tel'])) echo $_GET['tel']; ?>" />  
        </li>
		<li>  
            <label for="website">site Web :</label>  
            <input type="url" name="website" id="website" value="<?PHP if(isset($_GET['website'])) echo $_GET['website']; ?>" />  
        </li>
		<li>  
            <label>sexe :</label>  
            <input type="radio" name="sexe" value="F" <?PHP if(isset($_GET['sexe'])){ if($_GET['sexe'] == 'F') echo "checked"; } ?> >Femme<br>
			<input type="radio" name="sexe" value="H" <?PHP if(isset($_GET['sexe'])){ if($_GET['sexe'] == 'H') echo "checked"; } ?> > Homme<br>
        </li>
		<li>  
            <label for="birthdate">Date de naissance:</label>  
            <input type="date" name="birthdate" id="birthdate" value="<?PHP if(isset($_GET['birthdate'])) echo $_GET['birthdate']; ?>" placeholder="JJ/MM/AAAA" onchange="computeAge()" required/>  
            <script>  
                computeAge = function(e) { 				
                    try{  
                       var birthday = new Date(document.getElementById('birthdate').valueAsDate);
						var date = new Date();					
						var age = date.getFullYear() - birthday.getFullYear();
						console.log(age);
						var ageInput = document.getElementById('age');
						ageInput.value = age;  
                    } catch(e) {   
						document.getElementById("birthdate").value = "";
                    }  
                }  
            </script> 
			</script>
			<span class="form_hint">Format attendu "JJ/MM/AAAA"</span>  
        </li>  
        <li>  
            <label for="age">Age:</label>  
            <input type="number" name="age" id="age" disabled/>               
        </li>  
		<li>  
            <label for="ville">ville :</label>  
            <input type="text" name="ville" id="ville" value="<?PHP if(isset($_GET['ville'])) echo $_GET['ville']; ?>" />  
        </li>
		<li>  
            <label for="taille">taille en mètre:</label>  
            <input type="range" name="taille" id="taille" min="0" max="2.5" step="0.1" value="<?PHP if(isset($_GET['taille'])) echo $_GET['taille']; ?>" />  
        </li>
		<li>  
            <label for="couleur">couleur préférée :</label>  
            <input type="color" name="couleur" id="couleur" value="<?PHP $var = isset($_GET['couleur']) ? $_GET['couleur'] : "black"; echo $var; ?>" />  
        </li>
		<li>  
            <label for="profilepicfile">Photo de profil:</label>  
            <input type="file" id="profilepicfile" onload="loadProfilePic(this)" onchange="loadProfilePic(this)"/>  
            <span class="form_hint">Choisissez une image.</span>  
            <input type="hidden" name="profilepic" id="profilepic" value="<?PHP if(isset($_GET['profilepic'])) echo $_GET['profilepic']; ?>" />  
            <!-- l'input profilepic va contenir l'image redimensionnée sous forme d'une data url -->   
            <!-- c'est cet input qui sera envoyé avec le formulaire, sous le nom profilepic -->  
            <canvas id="preview" width="0" height="0"></canvas>  
            <!-- le canvas (nouveauté html5), c'est ici qu'on affichera une visualisation de l'image.   
			on pourrait afficher l'image dans un élément img, mais le canvas va nous permettre également   
            de la redimensionner, et de l'enregistrer sous forme d'une data url -->  
            <script>  
                function loadProfilePic(e) {  
	// on récupère le canvas où on affichera l'image  
	var canvas = document.getElementById("preview");  
	var ctx = canvas.getContext("2d");  
	// on réinitialise le canvas: on l'efface, et déclare sa largeur et hauteur à 0  
	ctx.setFillColor = "white";  
	ctx.fillRect(0,0,canvas.width,canvas.height);  
	canvas.width=0;  
	canvas.height=0;  
	// on récupérer le fichier: le premier (et seul dans ce cas là) de la liste  
	var file = document.getElementById("profilepicfile").files[0];  
	// l'élément img va servir à stocker l'image temporairement  
	var img = document.createElement("img");  
	// l'objet de type FileReader nous permet de lire les données du fichier.  
	var reader = new FileReader();  
	// on prépare la fonction callback qui sera appelée lorsque l'image sera chargée  
	reader.onload = function(e) {  
		//on vérifie qu'on a bien téléchargé une image, grâce au mime type  
		if (!file.type.match(/image.*/)) {  
			// le fichier choisi n'est pas une image: le champs profilepicfile est invalide, et on supprime sa valeur  
			document.getElementById("profilepicfile").setCustomValidity("Il faut télécharger une image.");  
			document.getElementById("profilepicfile").value = "";  
		}  
		else {  
			// le callback sera appelé par la méthode getAsDataURL, donc le paramètre de callback e est une url qui contient   
			// les données de l'image. On modifie donc la source de l'image pour qu'elle soit égale à cette url  
			// on aurait fait différemment si on appelait une autre méthode que getAsDataURL.  
			img.src = e.target.result;  
			// le champs profilepicfile est valide  
			document.getElementById("profilepicfile").setCustomValidity("");  
			var MAX_WIDTH = 96;  
			var MAX_HEIGHT = 96;  
			var width = img.width;  
			var height = img.height;  

			var width = MAX_WIDTH;  
			var height = MAX_HEIGHT;  
			  
			canvas.width = width;  
			canvas.height = height * (img.height / img.width);  
			// on dessine l'image dans le canvas à la position 0,0 (en haut à gauche)  
			// et avec une largeur de width et une hauteur de height  
			ctx.drawImage(img, 0, 0, width, height * (img.height / img.width));  
			// on exporte le contenu du canvas (l'image redimensionnée) sous la forme d'une data url  
			var dataurl = canvas.toDataURL("image/png");  
			// on donne finalement cette dataurl comme valeur au champs profilepic  
			document.getElementById("profilepic").value = dataurl;  
		};  
	}  
	// on charge l'image pour de vrai, lorsque ce sera terminé le callback loadProfilePic sera appelé.  
	reader.readAsDataURL(file);  
}  
            </script>  
        </li>  
		<li>
			<label for="mdp1">Mot de passe :</label>  
            <input type="password" name="password" id="mdp1" pattern="\w{6,8}" onkeyup="validateMdp2()" placeholder = "votre mot de passe" value="<?PHP if(isset($_GET['password'])) echo $_GET['password']; ?>" title = "Le mot de passe doit contenir de 6 à 8 caractères alphanumériques." required>  
           
             <span class="form_hint">De 6 à 8 caractères alphanumériques.</span>  
        </li>  
        <li>  
            <label for="mdp2">Confirmez mot de passe :</label>  
            <input type="password" id="mdp2" required onkeyup="validateMdp2()" value="<?PHP if(isset($_GET['password'])) echo $_GET['password']; ?>" placeholder="retapez le mot de passe" required>   
            <span class="form_hint">Les mots de passes doivent être égaux.</span>  
            <script>  
                validateMdp2 = function(e) {  
                    var mdp1 = document.getElementById('mdp1');  
                    var mdp2 = document.getElementById('mdp2');  
					var validityState = mdp1.validity;
					if (validityState.valid && mdp1.value == mdp2.value) { 
						console.log("OK");  
                        // ici on supprime le message d'erreur personnalisé, et du coup mdp2 devient valide.  
                        document.getElementById('mdp2').setCustomValidity('');  
                    } else {  
						console.log("NOT OK");
                        // ici on ajoute un message d'erreur personnalisé, et du coup mdp2 devient invalide.  
                        document.getElementById('mdp2').setCustomValidity('Les mots de passes doivent être égaux.');  
                    }  
                }  
            </script>  
        <li>  
            <input id="submit" type="submit" value="Soumettre Formulaire">  
        </li>  
    </ul>  
</form>    
</body>  
</html>  