<?php

session_start(); 
include("db_connect.php");

?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Choix du film</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
		<link rel="stylesheet" href="style/largeScreen/style.css" />
<link rel="stylesheet" href="style/mobile/style.css" />
		<script src="../scripts/boite_dialogue.js" type="text/javascript"></script>	
    </head>
    
    <body>
        <!-- Haut de page -->
        <?php 	include('header.php');?>
        <main>

        <?php
        	// On refuse l'accès si le visiteur n'est pas connecté -->
            if ($_SESSION['statut'] != "admin" 
            && $_SESSION['statut'] != "user") {
                echo("<div class=\"error\">Vous devez être connecté pour accéder à cette page.</div></main>");
                include('footer.html');
                exit();
            }
         $idpages=$_GET['pages'];
         ?>
        
        <h1>Tous les films</h1> <br />
        <div id="searchbar">
            <form action="filmRecherche.php" method="post">
            	<input type="text" name="tagCherche" placeholder="Rechercher"/>
                <input type="submit" value="OK" />    
            </form>
        </div>

		<?php
			$rqt ="SELECT COUNT(*) FROM films";
			$requete = mysqli_query($link,$rqt);
			while ($row = mysqli_fetch_assoc($requete)) {
				$nbTotalFilms=$row['COUNT(*)'];
				//echo "Nombre de films au total : ".$nbTotalFilms;
			}
		?>		
		<!-- Tableau des films -->
		<table id="tableauFilms">
			<?php 
				$nbfilmparpages=15;
				$numeropages=0;
				$requete = mysqli_prepare($link, "SELECT idfilm, titre, affiche, anneesortie, realisateur FROM films LIMIT ? OFFSET ?");
				$prod=$nbfilmparpages*$idpages;
				$requete->bind_param("ss",$nbfilmparpages,$prod);
				$requete->execute();
				$requete->bind_result($idfilm, $titre, $affiche, $anneesortie, $realisateur);
				$i=0;
				
				while ($requete->fetch()) {
					if($i%3 == 0)
					echo "<tr>";
				?>
					<td>
						<?php
							echo "<a href=\"lire_film.php?idfilm=$idfilm\">";
							echo "$titre<br />";
							// Verification que le film est une affiche importé sinon affichage de l'affiche par defaut
							if (is_file($affiche)){
								echo "<img src=\"$affiche\">";
							}else{
								echo '<img src="../images/unknown_poster.jpg"';
							}
							echo "</a><br />";
							//echo "$anneesortie<br />";
							//echo "$realisateur<br />";
						?>
					</td>
				<?php
					if($i%3==2){
						echo "</tr>";
					}
					$i=$i+1;
				}
			?>
		</table>
		<?php $requete->close() ?>
		<div class="pagination">
		<?php
		
			$nbPages=$nbTotalFilms/$nbfilmparpages;
			for($i=0;$i<$nbPages;$i++){
				echo "<a href=\"choix_film.php?pages=$i\">$i</a>";
			}
		?>
		</div>
		
		</main>
		<!-- Bas de page (mentions légales, ...) -->
		<?php include('footer.html'); ?>
	</body>
</html>
