<?php  

$drawingCommands=stripslashes($_POST['drawingCommands']);
$picture=stripslashes($_POST['picture']);

try {
    // Connect to server and select database.
	session_start();
    $dbh = new PDO('mysql:host=localhost;dbname=pictionnary', 'test', 'test');  
	$sql = $dbh->prepare("INSERT INTO drawings(idUser, commandesDessin, dessin)
						  VALUES(:idUser, :commandesDessin, :dessin)");  
	$sql->bindValue(":idUser", $_SESSION['idUser']);  
	$sql->bindValue(":commandesDessin", !empty($drawingCommands) ? $drawingCommands : "NULL" );
	$sql->bindValue(":dessin", !empty($picture) ? $picture : "NULL" );
      if (!$sql->execute()) {
          echo "PDO::errorInfo():<br/>";
          $err = $sql->errorInfo();
          print_r($err);
      }
      else
        header("Location: main.php");
    }
    
catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    $dbh = null;
    die();
}
header("Location: main.php");
?>
