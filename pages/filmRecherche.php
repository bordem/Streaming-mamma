<?php session_start(); ?>

<!doctype html>


<html>
    <head>
        <meta charset="utf-8" />
        <title>Choix du film</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
        <link rel="stylesheet" href="style/style.css" />
		<script src="../scripts/boite_dialogue.js" type="text/javascript"></script>	
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
        <!-- On affiche un tableau des films -->
        
        
        <table id="tableauFilms">
            <?php 
            $tagCherche = $_POST['tagCherche'];
            echo " <h1>Resultat de la recherche pour : ".$tagCherche."</h1>";
            $link1 = $_SESSION['link1'];
            $link2 = $_SESSION['link2'];
            $link3 = $_SESSION['link3'];
            
            $link = mysqli_connect("localhost",$link1,$link2,$link3);
			$requete = mysqli_prepare($link, "SELECT `idTag` FROM `tags` WHERE `nomTag`= ?");
			$requete->bind_param("s",$tagCherche);
			$requete->execute();
            while ($row = mysqli_fetch_assoc($requete)) {
                $idTag=$row['idTag'];
				$requete2 = mysqli_prepare($link, "SELECT `idFilm` FROM `occurenceTags` WHERE `idTag`= ?");
				$requete2->bind_param("s",$idTag);
				$requete2->execute();
				while ($row2 = mysqli_fetch_assoc($requete2)) {
					$idFilms=$row2['idFilm'];
					$requete3 = mysqli_prepare($link,"SELECT * FROM `films` WHERE `idfilm`= ?");
					$requete3->bind_param("s",$idFilms);
					$requete3->execute();
					while ($row3 = mysqli_fetch_assoc($requete3)) {
						if($i%3 == 0)
						    echo "<tr>";
						?>
						
				    	<p>
							<td>
								<a href=<?php echo "lire_film.php?idfilm=".$row3['idfilm']; ?>>
									<?php echo $row3['titre']; ?></br>
									<img src="../images/<?php echo $row3['affiche']; ?>">
								</a><br/>
								<?php echo $row3['anneesortie']; ?><br/>
								<?php echo $row3['realisateur']; ?><br/>
							</td>
						</p>
			
						<?php
						if($i%3==2)
							echo "</tr>";
						$i=$i+1;				
					}
				
				}
			}
			?>
		</table>
		
		</main>
		<!-- Bas de page (mentions légales, ...) -->
		<?php include('footer.html'); ?>
    </body>
</htlm>
