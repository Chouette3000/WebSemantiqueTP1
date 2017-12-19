<?php  
session_start();  
if(!isset($_SESSION['idUser'])) {  
    header("Location: main.php");  
} else {  
 // ici, récupérer la liste des commandes dans la table DRAWINGS avec l'identifiant $_GET['id']  
  
  $id=stripslashes($_GET['id']);
  $commands="";
  try {
     // Connect to server and select database.
     $dbh = new PDO('mysql:host=localhost;dbname=pictionnary', 'test', 'test');
     $sql = $dbh->query("SELECT commandesDessin 
						 FROM drawings WHERE id='".$id."'");
     $result = $sql->fetch();
	// l'enregistrer dans la variable $commands
     if (isset($result['commandesDessin']) && !empty($result['commandesDessin']))
	 // l'enregistrer dans la variable $commands 
       $commands = $result['commandesDessin']; 
	   
  } catch (PDOException $e) {
     print "Erreur !: " . $e->getMessage() . "<br/>";
     $dbh = null;
     die();
  }
}  
  
?>  
<!DOCTYPE html>  
<html>  
<head>  
    <meta charset=utf-8 />  
    <title>Pictionnary</title>  
    <link rel="stylesheet" media="screen" href="css/styles.css" >  
    <script>  
        // la taille et la couleur du pinceau  
        var size, color;  
        // la dernière position du stylo  
        var x0, y0;  
        // le tableau de commandes de dessin à envoyer au serveur lors de la validation du dessin  
        var drawingCommands = JSON.parse('<?php echo $commands;?>');  
  
        window.onload = function() {  
            var canvas = document.getElementById('myCanvas');  
            canvas.width = 400;  
            canvas.height= 400;  
            var context = canvas.getContext('2d');  
  
            var start = function(c) {  
				console.log("start");
				color = c.color;
				size = c.size;
				x0 = c.x;
				y0 = c.y;
				context.beginPath();				
				context.strokeStyle=color;
				context.lineWidth = 1;
				context.arc(x0, y0, size/2, 0, 2 * Math.PI);
				context.stroke();
            }  
  
			var draw = function(c) {
				console.log("draw");
				context.beginPath();
				context.strokeStyle=color;
				context.lineWidth = 1;
				context.arc(c.x, c.y, size/2, 0, 2 * Math.PI);
				context.stroke();
			}

			var stop = function(c) {
				console.log("stop");
				if(x0 != null && y0 != null){					
					context.beginPath();
					context.moveTo(x0, y0);
					context.strokeStyle=color;
					context.lineWidth = size;
					context.lineTo(c.x, c.y);
					context.stroke();
					x0 = null;
					y0 = null;
				}
			}

			var clear = function() {
				console.log("clear");
				context.clearRect(0, 0, canvas.width, canvas.height);
			}
  
            // étudiez ce bout de code  
            var i = 0;  
            var iterate = function() {  
                if(i>=drawingCommands.length)  
                    return;  
                var c = drawingCommands[i];  
                switch(c.command) {  
                    case "start":  
                        start(c);  
                        break;  
                    case "draw":  
                        draw(c);  
                        break;  
					case "stop":
						stop(c);
						break;
                    case "clear":  
                        clear();  
                        break;  
                    default:  
                        console.error("cette commande n'existe pas "+ c.command);  
                }  
                i++;  
                setTimeout(iterate,30);  
            };    
            iterate();    
        };  
  
    </script>  
</head>  
<body>  
<canvas id="myCanvas"></canvas>  
</body>  
</html>  