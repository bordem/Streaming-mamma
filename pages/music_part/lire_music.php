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
		<link rel="stylesheet" href="../style/largeScreen/lireMusic.css" />
		<link rel="stylesheet" href="../style/largeScreen/style.css" />
		
		<link rel="stylesheet" href="../style/mobile/lireMusic.css" />
		<link rel="stylesheet" href="../style/mobile/style.css" />
		<!--Script Javascript-->
		<script src="../../scripts/boite_dialogue.js" type="text/javascript"></script>
		<script src="../../scripts/autoCompletion.js" type="text/javascript"></script>
	</head>

	<body>
		<!-- Haut de page -->
		<?php include('../struct/header.php');?>
		<main>
		
			
			<?php
				//On refuse l'accès si le visiteur n'est pas connecté
				if ($_SESSION['statut'] != "admin" && $_SESSION['statut'] != "user") {
					echo "<div class=\"error\">Vous devez être connecté pour accéder à cette page.
						</div>";
					include('../struct/footer.html');
					exit();
				}
				
				$loginUser=$_SESSION['login'];
				$userId = $_SESSION['userId'];
				$idmusic=$_GET['idmusic'];
				
				if(isset($_POST['sel_name'])){
					$idmusic=$_POST['sel_name'];
				}
				if(isset($_POST['recherche'])){
					//echo $_POST['recherche'];
					$requete = mysqli_prepare($link, "	SELECT `idmusic` FROM `music` WHERE `titre`= ? ");
					$requete->bind_param("s",$_POST['recherche']);
					$requete->execute();
					$requete->bind_result($idmusic);
					$requete->fetch();
					$requete->close();
					//echo "A".$idmusic."B";
				}
				if(isset($_POST['changeMetadataDate'])){
					$nouvelleDate=$_POST['newdate'];
					$requete=mysqli_prepare($link,	"UPDATE `music` 
													SET `anneesortie`= ? 
													WHERE `idmusic`= ?") or die(mysqli_error($link));
					$requete->bind_param("ii",$nouvelleDate,$idmusic);
					$requete->execute();
					$requete->close();
					
					$requete=mysqli_prepare($link,	"SELECT chemin
													FROM music 
													WHERE idmusic= ? ") or die(mysqli_error($link));
					$requete->bind_param("i",$idmusic);
					$requete->execute();
					$requete->bind_result($chemin_de_music);
					$requete->fetch();
					$requete->close();
					
					$commande = "exiftool -createdate=\"".$nouvelleDate.":00:00 00:00:00\" ".$chemin_du_film;
					exec($commande);
				}
			
			
			//$note=$_GET['note'];
			$requete = mysqli_prepare($link, "	SELECT `idmusic`,`titre`, `auteur`, `album`, `chemin`, `pochette`, `anneesortie` 
												FROM `music` 
												WHERE 1");
			$requete->bind_param();
			$requete->execute();
			$requete->bind_result($id,$titre, $auteur, $album, $chemin , $pochette,$anneesortie);
			?>
			
			<h1>Media player</h1>
			<div id="media-player">
				<div class="autocomplete">
					<form autocomplete="off" id="recherche_id" action="lire_music.php" method="post">
					Recherche :
							<input id="completion" type="text" name="recherche">
							<input type="submit" value="&#128270" />
					</form>
				</div>
				<div id="list_music">
					<form name="myform" action="lire_music.php" method="post">
						<select id="sel_id" name="sel_name" onChange="this.form.submit();" size="20">
							<!--<option selected disabled>Titre</option>-->
							<?php
							while ($requete->fetch()) {
								echo "<option name=\"option\" value=\"".$id."\">".$titre."</option>";
							}
							$requete->close();
							?>
						</select>
					</form>
				</div>
				<script>
				/*An array containing all the country names in the world:*/
				var tabFilms = [
					<?php
						$requete = mysqli_prepare($link, "SELECT `titre`,`auteur` FROM music WHERE 1");
						$requete->execute();
						$requete->bind_result($titre,$auteur);
						while ($requete->fetch()) {
							echo "\"".$titre."\",";
						}
						$requete->close();
						
					?>
				];
				/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
				autocomplete(document.getElementById("completion"), tabFilms);
			</script> 
				<?php
				$requete = mysqli_prepare($link, "	SELECT `titre`, `auteur`, `album`, `chemin`, `pochette`, `anneesortie` 
													FROM `music` 
													WHERE `idmusic`=?");
				$requete->bind_param("i",$idmusic);
				$requete->execute();
				$requete->bind_result($titre, $auteur, $album, $chemin , $pochette ,$anneesortie);
				$requete->fetch();
				$requete->close();
				//echo $pochette;
				?>
				<div id="media_data">
					<?php
					$pochette = str_replace(" ", "_", $pochette);
					if(is_file($pochette)){
					?>
						<img id="pochette" src=<?php echo $pochette;?>>
					<?php
					}else{
					?>
						<img id="pochette" src="../../images/unknow_pochette.jpg">
					<?php
					}
					echo "<div id=\"titre\">".$titre."</div> <div id=\"artist\">".$auteur."</div> ".$album." ".$anneesortie;
					?>

				</div>
				<audio autoplay controls>
					<source src=<?php echo $chemin;?> type="audio/mpeg">
				</audio>
			</div>
			<div>
				<form action="upload_pochette.php?idmusic=<?php echo $idmusic;?>" method="post" enctype="multipart/form-data">
					Ajouter une affiche :
					<input type="file" name="fileToUpload" id="fileToUpload" />
					<input type="hidden" name="nom" value="<?php echo $titre;?>" />
					<input type="submit" value="Go !" name="submit" />
					
				</form>
			</div>
			
	</main>
	<!-- Bas de page (mentions légales, ...) -->
	<?php include('../struct/footer.html'); ?>
</html>
