<?php session_start(); ?>

<!doctype html>


<html>
    <head>
        <meta charset="utf-8" />
        <title>Choix du film</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
            <!--BOOTSTRAP-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="style/style.css" />
    </head>
    
    <body>
        <!-- Haut de page -->
        <?php include('header.php'); ?>
        <main>



        <!-- On refuse l'accès si le visiteur n'est pas connecté -->
        <?php
            if ($_SESSION['statut'] != "admin" 
            && $_SESSION['statut'] != "user") {
                echo("<p>Vous devez être connecté pour accéder à cette page.</p>");
                include('footer.html');
                exit();
            }
         ?>



        
        <h1>Tous les films</h1> <br/>
        
        <!-- On affiche un tableau des films -->
        <table cellspacing="0" border="1">
            <?php 
            $link = mysqli_connect("localhost",$_SESSION['link1'],$_SESSION['link2'],$_SESSION['link3']);
            $requete = mysqli_query($link, "SELECT * FROM films");
            $i=0;
            while ($row = mysqli_fetch_assoc($requete)) {
                if($i%3 == 0)
				    echo "<tr>";
			?>
				    
            <p>
			    <td>
					<?php echo $row['titre']; ?></br>
					<a href=<?php echo "lire_film.php?idfilm=".$row['idfilm']; ?>>
						<img src="../images/<?php echo $row['affiche']; ?>">
					</a><br/>
					Année de sortie : <?php echo $row['anneesortie']; ?><br/>
					Réalisateur : <?php echo $row['realisateur']; ?><br/>
				</td>
			</p>
			
			<?php
			if($i%3==2)
			    echo "</tr>";
			$i=$i+1;
			}
		    ?>
		</table>
		
		</main>
		<!-- Bas de page (mentions légales, ...) -->
		<?php include('footer.html'); ?>
    </body>
</htlm>
