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
			$i=0; 
			$tagCherche = $_POST['tagCherche'];
			echo " <h1>Resultat de la recherche pour : ".$tagCherche."</h1>";
			$rqt = "SELECT films.idfilm,titre,anneesortie,realisateur,affiche
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
								<?php echo $titre; ?><br />
								<!--Verification que le film est une affiche importé sinon affichage de l'affiche par defaut-->
								<?php if(is_file($affiche)){ ?>
									<img src="<?php echo $affiche; ?>">
								<?php 
								}else{
									echo "<img src=\"../images/unknown_poster.jpg\">";
								}
								?>
							</a><br />
							<?php //echo $anneesortie; ?><br />
							<?php //echo $realisateur; ?><br />
						</td>
			
						<?php
						if($i%3==2)
							echo "</tr>";
						$i++;				
				}
					
			$rqt2=mysqli_prepare($link,"SELECT idfilm,titre,affiche FROM films WHERE titre LIKE ?");
			$tagCherche = "%$tagCherche%";
			$rqt2->bind_param("s",$tagCherche);
			$rqt2->execute();
			$rqt2->bind_result($idFilm, $titre, $affiche);
			while ( $rqt2->fetch() ){
				if($i%3 == 0)
					echo "<tr>";
				?>			
						<td>
							<a href=<?php echo "lire_film.php?idfilm=".$idFilm; ?>>
								<?php echo $titre; ?><br />
								<!--Verification que le film est une affiche importé sinon affichage de l'affiche par defaut-->
								<?php if(is_file($affiche)){ ?>
									<img src="<?php echo $affiche; ?>">
								<?php 
								}else{
									echo "<img src=\"../images/unknown_poster.jpg\">";
								}
								?>
							</a>
						</td>
			<?php 
				if($i%3==2){
					echo "</tr>";
				}
				$i++;
			}?>
		</table>
		<?php $rqt2->close(); ?>
		</main>
		<!-- Bas de page (mentions légales, ...) -->
		<?php include('footer.html'); ?>
	</body>
</html>
