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
				echo("<div class=\"error\">Vous devez être connecté pour accéder à cette page.</div>");
				include('footer.html');
				exit();
			}
		 ?>		
		<!-- On affiche un tableau des films -->
		
		
		<table id="tableauFilms">
			<?php 
			$tagCherche = $_POST['tagCherche'];
			echo " <h1>Resultat de la recherche pour : ".$tagCherche."</h1>";
			$rqt = "SELECT films.idfilm,titre,anneesortie,realisateur, affiche
					FROM films JOIN occurenceTags on films.idfilm=occurenceTags.idFilm 
					JOIN tags USING(idTag)
					WHERE nomTag=?";
			$requete = mysqli_prepare($link, $rqt) or die(mysqli_error($link));
			$requete->bind_param("s",$tagCherche);
			$requete->execute();
			$requete->bind_result($idFilm, $titre, $annesortie, $realisateur, $affiche);
				while ($requete->fetch()) {
						if($i%3 == 0)
							echo "<tr>";
						?>
						
						<td>
							<a href=<?php echo "lire_film.php?idfilm=".$idfilm; ?>>
								<?php echo $titre; ?></br>
								<img src="../images/<?php echo $affiche; ?>">
							</a><br/>
							<?php echo $anneesortie; ?><br/>
							<?php echo $realisateur; ?><br/>
						</td>
			
						<?php
						if($i%3==2)
							echo "</tr>";
						$i++;				
					}
			?>
		</table>
		
		</main>
		<!-- Bas de page (mentions légales, ...) -->
		<?php include('footer.html'); ?>
	</body>
</html>
