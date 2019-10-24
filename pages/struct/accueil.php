<?php
session_start();
$_SESSION['partie']='neutres';
include("db_connect.php");

?>

<html>
	<head>
		<meta charset="utf-8" />
		<title>Accueil</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" type="image/x-icon" href="../../images/icon.ico" />
		<!--Feuille de style-->
		<link rel="stylesheet" href="../style/largeScreen/style.css" />
		<link rel="stylesheet" href="../style/largeScreen/choixMusic.css" />
		<link rel="stylesheet" href="../style/largeScreen/profil.css" />
		
		<link rel="stylesheet" href="../style/mobile/profil.css" />
		<link rel="stylesheet" href="../style/mobile/style.css" />
		<!--Script Javascript-->
		<script src="../../scripts/boite_dialogue.js" type="text/javascript"></script>
		<script src="../../scripts/autoCompletion.js" type="text/javascript"></script>
	</head>

	<body>
		<!-- Haut de page -->
		<?php include('header.php'); ?>
		
		
		<main>
			<?php
				//On refuse l'accès si le visiteur n'est pas connecté
				if ($_SESSION['statut'] != "admin" && $_SESSION['statut'] != "user") {
					echo "<div class=\"error\">Vous devez être connecté pour accéder à cette page.
						</div>";
					include('struct/footer.html');
					exit();
				}
			?>
			
				<a href="../movie_part/choix_film.php"><h1 id="GRANDTITRE">Derniers films ajoutés :</h1></a>
				
			<table class="historique">
				<tr>
			<?php
				$rqt1 = "SELECT idfilm, titre, affiche, anneesortie, realisateur FROM films WHERE 1 ORDER BY idfilm DESC LIMIT 4";
				$requete_films = mysqli_prepare($link, $rqt1) or die(mysqli_error($link));
				$requete_films -> bind_param();
				$requete_films -> execute();
				$requete_films -> bind_result($idfilm,$titre,$affiche,$anneesortie,$realisateur);
				while ( $requete_films->fetch() ) {
					?>	<td>
						<a href= "../movie_part/lire_film.php?idfilm= <?php echo $idfilm; ?>">
						<?php 
							echo "<div>".$titre."</div>";
							if(is_file($affiche)){
								echo "<img 
								title=\"Titre : $titre  ";
								if($anneesortie!=NULL){echo "\n Annee de sortie : $anneesortie";}
								if($realisateur!=NULL){echo "\n Realisateur : $realisateur";}
								echo "\" src=\"$affiche\">";
							}else{
								echo "<img src=\"../../images/unknown_poster.jpg\">";
							}
						?>
						</a><br />
						</td>
					<?php
				}
				$requete_films->close();
				?>
				</tr>
			</table>
			
			<a href="../music_part/choix_music.php"><h1>Derniere musique</h1></a>
			<table class="tableauMusic">
				<tr>
			<?php
				$rqt1 = "SELECT idmusic, titre, pochette, anneesortie, auteur FROM music WHERE 1 ORDER BY idmusic DESC LIMIT 4";
				$requete_music = mysqli_prepare($link, $rqt1) or die(mysqli_error($link));
				$requete_music -> bind_param();
				$requete_music -> execute();
				$requete_music -> bind_result($idmusic,$titre,$pochette,$anneesortie,$auteur);
				while ( $requete_music->fetch() ) {
					?>	<td>
						<a href= "../music_part/lire_music.php?idmusic= <?php echo $idmusic; ?>">
						<?php 
							echo "<div>".$titre."</div>";
							if(is_file($pochette)){
								echo "<img 
								title=\"Titre : $titre  ";
								if($anneesortie!=NULL){echo "\n Annee de sortie : $anneesortie";}
								if($auteur!=NULL){echo "\n Artiste : $auteur";}
								echo "\" src=\"$pochette\">";
							}else{
								echo "<img src=\"../../images/unknow_pochette.jpg\">";
							}
						?>
						</a><br />
						</td>
					<?php
				}
				$requete_films->close();
				?>
				</tr>
			</table>
			<h1>Ajout bientot d'une partie serie  </h1>
				
	</main>
	<!-- Bas de page (mentions légales, ...) -->
	<?php include('footer.html'); ?>
</html>
