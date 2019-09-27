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
		<script src="../scripts/autoCompletion.js" type="text/javascript"></script>
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
			$rqt ="SELECT COUNT(*) FROM films";
			$requete = mysqli_query($link,$rqt);
			while ($row = mysqli_fetch_assoc($requete)) {
				$nbTotalFilms=$row['COUNT(*)'];
				//echo "Nombre de films au total : ".$nbTotalFilms;
			}
			$nbfilmparpages=15;
			$nbPages=((int)($nbTotalFilms/$nbfilmparpages));
			$idpages=$_GET['pages'];
			if($idpages<0){
				header('Location:choix_film.php?pages=0');
			}
			else if($idpages > $nbPages ){
				header('Location:choix_film.php?pages='.$nbPages.'');
			}
		//var_dump($_GET['pages']);
		?>
		
		<h1>Tous les films</h1> <br />
		<div id="searchbar">
			<form autocomplete="off" action="filmRecherche.php" method="post">
				<div class="autocomplete">
					<input id="completion" type="text" name="tagCherche" placeholder="Rechercher"/>
				</div>
				<input type="submit" value="OK" />	
			</form>
		</div>
		
		<script>
			/*An array containing all the country names in the world:*/
			var tabFilms = [
				<?php
					$requete = mysqli_prepare($link, "SELECT titre FROM films WHERE 1");
					$requete->execute();
					$requete->bind_result($titre);
					while ($requete->fetch()) {
						echo "\"".$titre."\",";
					}
					$requete->close();
					
					$requete = mysqli_prepare($link, "SELECT nomTag FROM tags WHERE 1");
					$requete->execute();
					$requete->bind_result($tag);
					while ($requete->fetch()) {
						echo "\"".$tag."\",";
					}
					$requete->close();
				?>
			];
			/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
			autocomplete(document.getElementById("completion"), tabFilms);
		</script> 
		
		<ul id ="Categorie">
		<h3>Catégorie</h3>
			<li><a href="filmRecherche.php?tag=action">Action</a></li>
			<li><a href="filmRecherche.php?tag=animes">Animation</a></li>
			<li><a href="filmRecherche.php?tag=comedie">Comedie</a></li>
			<li><a href="filmRecherche.php?tag=documentaire">Documentaire</a></li>
			<li><a href="filmRecherche.php?tag=policier">Policier</a></li>
			<li><a href="filmRecherche.php?tag=sciencesfiction">Sciences-fiction</a></li>
			<li><a href="filmRecherche.php?tag=western">Western</a></li>

		</ul>
		
		
		<!-- Tableau des films -->
		<table id="tableauFilms">
			<?php 
				$numeropages=0;
				$requete = mysqli_prepare($link, "SELECT idfilm, titre, affiche, anneesortie, realisateur FROM films LIMIT ? OFFSET ? ");
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
			$n=0;
			echo "<a title=\" -5 \" href=\"choix_film.php?pages=".$n = -5.0+$idpages."\">&lt;&lt;</a>";
			echo "<a title=\" -1 \"href=\"choix_film.php?pages=".$n = -1.0+$idpages."\">&lt;</a>";
			echo "<a href=\"choix_film.php?pages=".$n = $idpages     ."\">".$n = $idpages+1.0 ."</a>";
			echo "<a title=\" +1 \"href=\"choix_film.php?pages=".$n = 1.0+$idpages ."\">&gt;</a>";
			echo "<a title=\" +5 \"href=\"choix_film.php?pages=".$n = 5.0+$idpages."\">&gt;&gt;</a>";
		?>
		</div>
		
		</main>
		<!-- Bas de page (mentions légales, ...) -->
		<?php include('footer.html'); ?>
	</body>
</html>
