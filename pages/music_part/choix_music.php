<?php
session_start();
$_SESSION['partie']='music';
include("../struct/db_connect.php");

?>

<html>
	<head>
		<meta charset="utf-8" />
		<title>La musique</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" type="image/x-icon" href="../../images/icon.ico" />
		<!--Feuille de style-->
		<link rel="stylesheet" href="../style/largeScreen/choixMusic.css" />
		<link rel="stylesheet" href="../style/largeScreen/style.css" />
		
		<link rel="stylesheet" href="../style/mobile/style.css" />
		<link rel="stylesheet" href="../style/mobile/choixMusic.css" />
		<!--Script Javascript-->
		<script src="../../scripts/boite_dialogue.js" type="text/javascript"></script>
		<script src="../../scripts/autoCompletion.js" type="text/javascript"></script>
	</head>

	<body>
		<!-- Haut de page -->
		<?php include('../struct/header.php'); ?>
		
		
		<main>
			<?php
				//On refuse l'accès si le visiteur n'est pas connecté
				if ($_SESSION['statut'] != "admin" && $_SESSION['statut'] != "user") {
					echo "<div class=\"error\">Vous devez être connecté pour accéder à cette page.
						</div>";
					include('../footer.html');
					exit();
				}
				$rqt ="SELECT COUNT(*) FROM music";
				$requete = mysqli_query($link,$rqt);
				while ($row = mysqli_fetch_assoc($requete)) {
					$nbTotalMusics=$row['COUNT(*)'];
					//echo "Nombre de films au total : ".$nbTotalFilms;
				}
				$nbmusicparpages=15;
				$nbPages=((int)($nbTotalMusics/$nbmusicparpages));
				$idpages=$_GET['pages'];
				if($idpages<0){
					header('Location:choix_music.php?pages=0');
				}
				else if($idpages > $nbPages ){
					header('Location:choix_music.php?pages='.$nbPages.'');
				}
				
				?>
				<h1>Musique :</h1>
				<table class="tableauMusic">
				<?php 
					$numeropages=0;
					$requete = mysqli_prepare($link, "SELECT `idmusic`, `titre`, `auteur`, `album`, `chemin`, `pochette`, `anneesortie` FROM `music` LIMIT ? OFFSET ?");
					$prod=$nbmusicparpages*$idpages;
					$requete->bind_param("ss",$nbmusicparpages,$prod);
					$requete->execute();
					$requete->bind_result($idmusic, $titre, $auteur,$album, $chemin, $pochette,$anneesortie);
					$i=0;
					
					while ($requete->fetch()) {
						if($i%3 == 0)
						echo "<tr>";
					?>
						<td>
							<?php
								$pochette = str_replace(" ", "_", $pochette);
								echo "<a href=\"lire_music.php?idmusic=$idmusic\">";
								echo "$titre<br />";
								// Verification que le film est une affiche importé sinon affichage de l'affiche par defaut
								if (is_file($pochette)){
									echo "<img 
									title=\"Titre : $titre  ";
									if($anneesortie!=NULL){echo "\n Annee de sortie : $anneesortie";}
									if($auteur!=NULL){echo "\n Auteur : $auteur";}
									echo "\" src=\"$pochette\">";
								}else{
									echo '<img src="../../images/unknow_pochette.jpg"';
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
				$n=0;
				echo "<a title=\" -5 \" href=\"choix_music.php?pages=".$n = -5.0+$idpages."\">&lt;&lt;</a>";
				echo "<a title=\" -1 \"href=\"choix_music.php?pages=".$n = -1.0+$idpages."\">&lt;</a>";
				echo "<a href=\"choix_music.php?pages=".$n = $idpages     ."\">".$n = $idpages+1.0 ."</a>";
				echo "<a title=\" +1 \"href=\"choix_music.php?pages=".$n = 1.0+$idpages ."\">&gt;</a>";
				echo "<a title=\" +5 \"href=\"choix_music.php?pages=".$n = 5.0+$idpages."\">&gt;&gt;</a>";
			?>
			</div>
			
			
	</main>
	<!-- Bas de page (mentions légales, ...) -->
	<?php include('../struct/footer.html'); ?>
</html>
