<!DOCTYPE html>
<html>
	<head>
		<meta charset=utf-8 />
		<title>Pictionnary</title>
		<link rel="stylesheet" href="css/styles.css" >
	</head>
	<body 
		<?PHP include("header.php"); ?>
		<div class="w3-container w3-center">
			<h2 class="w3-blue">PICTIONNARY</h2>
			<?PHP
			if(isset($_GET['erreur']) && !empty($_GET['erreur']))
				echo "<h3>".$_GET['erreur']."</h3"; 
			?>

			<a href="paint.php" class="w3-button w3-green">Dessiner !</a>
			
				<?PHP
				if(isset($_SESSION['idUser'])){
					try {
					    // Connect to server and select database.
					    $dbh = new PDO('mysql:host=localhost;dbname=pictionnary', 'test', 'test');
							$sql = $dbh->query("SELECT id, commandesDessin, dessin FROM drawings WHERE idUser='".$_SESSION['idUser']."'");
							echo "<table>";
							while ($result = $sql->fetch())
								echo "<tr><td><a href=\"guess.php?id=".$result['id']."\" class=\"w3-button\" style=\"height:400px\" ><img src=\"".$result['dessin']."\" /></a></td></tr>";
							echo "</table>";
					} catch (PDOException $e) {
					    print "Erreur !: " . $e->getMessage() . "<br/>";
					    $dbh = null;
					    die();
					}
				}
				?>
			
		</div>
	</body>
</html>
