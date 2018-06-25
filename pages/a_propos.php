<?php session_start();?>

<!doctype html>
<html>
    <head>
        <title>A propos</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
                
        <link rel="stylesheet" href="style/style.css" />
    </head>

    <body>
        <?php include('header.php');?>
        <main>
        	<h2>/!\ Développement en cours ! </h2>
        	<section>
        		<strong>Streaming mamma </strong>est un site de streaming en local qui permet de lire les vidéos stockés sur le disque dur de Martin BORDE </br>
        		Il est hébergé sur une Raspberry Pi 3.</br>
        		
				Pour concevoir le site , nous avons utilisé différents langages :
				<ul>
					<li>HTML5</li>
					<li>CSS3</li>
					<li>PHP5</li>
					<li>MySQL</li>
				</ul>
				</br>
				Les vidéos qui peuvent être incluses sur le site doivent être au format suivant :
				<ul>
					<li>.mp4</li>
					<li>.ogv</li>
					<li>.webm</li>
				</ul>
				</br>
				Le format des affiches 
				<ul>
					<li>Type d'image jpeg(JPEG)</li>
					<li>Largeur : 215 pixels</li>
					<li>Hauteur : 290 pixels</li>
				</ul>
				Note : les affiches peuvent être récupérer sur allociné
				
				
				Le site devra bientôt héberger des séries.
				
        	</section>
        </main>
        <?php include('footer.html');?>
    </body>
</html>
