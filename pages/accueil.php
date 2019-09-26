<?php
session_start();
include("db_connect.php");

?>

<html>
	<head>
		<meta charset="utf-8" />
		<title>Accueil</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
		<link rel="stylesheet" href="style/largeScreen/style.css" />
		<link rel="stylesheet" href="style/largeScreen/profil.css" />
		<link rel="stylesheet" href="style/mobile/profil.css" />
		<link rel="stylesheet" href="style/mobile/style.css" />
		<script src="../scripts/boite_dialogue.js" type="text/javascript"></script>
		<script src="../scripts/autoCompletion.js" type="text/javascript"></script>
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
					include('footer.html');
					exit();
				}
			?>
			
				<h1>Derniers films ajoutés :</h1>
				
				<table class="historique">
				<tr>
			<?php
				$rqt1 = "SELECT idfilm, titre, affiche FROM films WHERE 1 ORDER BY idfilm DESC LIMIT 4";
				$requete_films = mysqli_prepare($link, $rqt1) or die(mysqli_error($link));
				$requete_films -> bind_param();
				$requete_films -> execute();
				$requete_films -> bind_result($idfilm,$titre,$affiche);
				while ( $requete_films->fetch() ) {
					?>	<td>
						<a href= "lire_film.php?idfilm= <?php echo $idfilm; ?>">
						<?php 
							echo "<div>".$titre."</div>";
							if(is_file($affiche)){
								echo "<img src=\"$affiche\">";
							}else{
								echo "<img src=\"../images/unknown_poster.jpg\">";
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
			<h1>Ajout bientot d'une partie musique</h1>
			<h1>Ajout bientot d'une partie serie  </h1>
				
	</main>
	<!-- Bas de page (mentions légales, ...) -->
	<?php include('footer.html'); ?>
</html>
