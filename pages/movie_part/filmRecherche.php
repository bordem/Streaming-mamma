<?php 
session_start();
$_SESSION['partie']='movie';
include("../struct/db_connect.php");
?>

<!doctype html>


<html>
	<head>
		<meta charset="utf-8" />
		<title>Choix du film</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" type="image/x-icon" href="../../images/icon.ico" />
		<!--Feuille de style-->
		<link rel="stylesheet" href="../style/largeScreen/style.css" />
		<link rel="stylesheet" href="../style/largeScreen/rechercheFilm.css" />
		<link rel="stylesheet" href="../style/mobile/style.css" />
		<!--Script Javascript-->
		<script src="../../scripts/boite_dialogue.js" type="text/javascript"></script>
		<script src="../../scripts/autoCompletion.js" type="text/javascript"></script>
	</head>
	
	<body>
		<!-- Haut de page -->
		<?php 
			include('../struct/header.php');
			include('../struct/Cvector.php');
		?>
		<main>



		<!-- On refuse l'accès si le visiteur n'est pas connecté -->
		<?php
			if ($_SESSION['statut'] != "admin" 
			&& $_SESSION['statut'] != "user") {
				echo("<div class=\"error\">Vous devez être connecté pour accéder à cette page.</div>");
				include('footer.html');
				exit();
			}
			$tagCherche = "";
			$i=0;
			$GETTAG = $_GET['tag'];
			if(isset($_POST['tagCherche'])){
				$tagCherche = $_POST['tagCherche'];
			}
			if($tagCherche == ""){
				$tagCherche = $GETTAG;
			}
				
			echo " <h1>Resultat de la recherche pour : ".$tagCherche."</h1>";
		 ?>
		 
		 
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
		<!-- On affiche un tableau des films -->
		
		
		<table id="tableauFilmsRecherche">
			<?php
			$vector = new vector;
			$rqt = "SELECT films.idfilm,titre,anneesortie,realisateur,affiche
					FROM films JOIN occurenceTags on films.idfilm=occurenceTags.idFilm 
					JOIN tags USING(idTag)
					WHERE nomTag=?";
			$requete = mysqli_prepare($link, $rqt) or die(mysqli_error($link));
			$requete->bind_param("s",$tagCherche);
			$requete->execute();
			$requete->bind_result($idFilm, $titre, $annesortie, $realisateur, $affiche);
			while ($requete->fetch()) {
				$vector->add($idFilm,NULL);
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
					echo "<img src=\"../../images/unknown_poster.jpg\">";
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
				$existeDeja=FALSE;
				for($k=0;$k<$vector->size();$k++){
					if($idFilm == $vector->at1($k)){
						$existeDeja=TRUE;
					}
				}
				if($existeDeja==FALSE){
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
										echo "<img src=\"../../images/unknown_poster.jpg\">";
									}
									?>
								</a>
							</td>
			<?php 
					$i++;
				}else{
					//echo "Presence de doublon";
				}
				if($i%3==2){
					echo "</tr>";
				}
			}?>
		</table>
		<?php $rqt2->close(); ?>
		</main>
		<!-- Bas de page (mentions légales, ...) -->
		<?php include('../struct/footer.html'); ?>
	</body>
</html>
