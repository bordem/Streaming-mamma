<?php
session_start();
include("db_connect.php");

?>

<html>
	<head>
		<meta charset="utf-8" />
		<title>Le film</title>
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
			<?php
				//On refuse l'accès si le visiteur n'est pas connecté
				if ($_SESSION['statut'] != "admin" && $_SESSION['statut'] != "user") {
					echo "<div class=\"error\">Vous devez être connecté pour accéder à cette page.
						</div>";
					include('footer.html');
					exit();
				}

				//Ajout du tag dans la BDD
				/*Ajout a l'historique du film regarder*/
				$loginUser=$_SESSION['login'];
				$userId = $_SESSION['userId'];
				$idFilm=$_GET['idfilm'];

				date_default_timezone_set('UTC');
				$requete = mysqli_prepare($link,"INSERT INTO historiqueFilms (idfilm, idusr, date) 
												VALUES (?, ?, NOW() )") or die(mysqli_error($link));
				$requete->bind_param("ii",$idFilm,$userId);
				$requete->execute();
				$requete->close();				
				/*Ajout de l'affiche au film par l'utilisateur root*/
					/*$target_dir = "../Films/affiche/";
					$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
					$uploadOk = true;
					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

					// Check if file already exists
					// if (file_exists($target_file)) {
					//		echo "<div class=\"error\">";
					//		echo "Sorry, file already exists.";
					//		echo "</div>";
					//		$uploadOk = false;
					//	}
					//

					// Check file size
					if ($_FILES["fileToUpload"]["size"] > 500000) {
						echo "<div class=\"error\">Le fichier ne doit pas excéder 500 Ko.</div>";
						$uploadOk = false;
					}

					// Allow certain file formats
					if($imageFileType != "jpg") {
						echo "<div class=\"error\">";
						echo "Seul le format JPG est autorisé. ";
						echo "</div>";
						$uploadOk = false;
					}

					// Check if $uploadOk is false
					if (!$uploadOk) {
						echo "<div class=\"error\">";
						echo "Désolé, le téléchargement n'a pas été effectué.";
						echo "</div>";
						
					// if everything is ok, put it in the db
					} else {
						if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
							rename("../Films/affiche/".basename( $_FILES["fileToUpload"]["name"]), "../Films/affiche/".$_POST["nom"].".jpg");
							echo "<div class=\"info\">";
							echo "Le fichier a bien été uploadé.<br/>";
							echo "</div>";
							
						} else {
							echo "<div class=\"error\">";
							echo "Désolé, il y a eu une erreur dans le téléchargement du fichier.";
							echo "</div>";
						}
					}*/
				
				/*Ajout des tags au film*/
				if(isset($_POST['ajouttag'])){
					// On cherche si le tag existe déjà dans la BDD
					$tagAInserer=$_POST['nomtag'];
					$requete1=mysqli_prepare($link,"SELECT nomTag 
													FROM tags 
													WHERE nomTag= ?") or die(mysqli_error($link));
					$requete1->bind_param("s",$tagAInserer);
					$requete1->execute();
					$requete1->bind_result($nomTag);
					$requete1->fetch();
					$requete1->close();	
					// S'il n'existe pas, on ajoute le tag
					if( empty($nomTag) ){
						$requete2=mysqli_prepare($link,"INSERT INTO tags(nomTag) 
														VALUES ( ? )") or die(mysqli_error($link));
						$requete2->bind_param("s",$tagAInserer);
						if (!$requete2->execute()) {
							echo "<div class=\"error\">Erreur dans l'ajout: ".mysqli_error($link).
								" Veuillez recommencer.</div>";
						}
					}
					else {
						echo "<div class=\"info\">Ce tag existe deja.</div>";
					}
					$requete1->close();

					$rqt= mysqli_prepare($link,"SELECT idTag 
												FROM tags 
												WHERE nomTag= ?") or die(mysqli_error($link));
					$rqt->bind_param("s",$tagAInserer);
					$rqt->execute();
					$rqt->bind_result($idTag);
					$rqt->fetch();
					$rqt->close();
					$requete3=mysqli_prepare($link,"INSERT INTO occurenceTags(idFilm, idTag) 
													VALUES (?,?)") or die(mysqli_error($link));
					$requete3->bind_param("ii",$idFilm,$idTag);
					if ( !$requete3->execute()) {
						echo "<div class=\"error\">Erreur dans l'ajout du tag.</div>";
					}
					$requete3->close();
				}
				//On récupère le titre et le chemin du film		
				$requete = mysqli_prepare($link, "SELECT titre,chemin
												FROM films 
												WHERE idfilm= ? ") or die(mysqli_error($link)); 
				$requete->bind_param("i",$idFilm);
				$requete->execute();
				$requete->bind_result($titre_du_film, $chemin_du_film);
				$requete->fetch();
				$requete->close();
			?>
			
			
			<!-- On affiche le film -->
			<h1><?php echo $titre_du_film; ?></h1><br/>
			
			<video height="240" width="360" autoplay controls>
				<source src="<?php echo $chemin_du_film; ?>" type="video/mp4">
				<source src="<?php echo $chemin_du_film; ?>" type="video/webm"> 
				<source src="<?php echo $chemin_du_film; ?>" type="video/ogg"> 
			</video>
			
			<!-- Affichage des données du film -->
			<div id="infoFilm">
				<h2>Info:</h2>
				<?php 
					/*Intégrer image, année et réalisateur*/
					$requete = mysqli_prepare($link, "SELECT `affiche`,`titre`,`realisateur`,`anneesortie` FROM `films` WHERE `idfilm`=?") or mysqli_error($link);
					$requete->bind_param("i",$idFilm); 
					$requete->execute();
					$requete->bind_result($affiche,$titre,$realisateur,$annee);
					$requete->fetch();
					echo "Titre : ".$titre."<br/>";
					if ($annee<>""){
						echo "Annee de sortie : ".$annee."<br/>";
					}else{
						echo "Annee de sortie : Inconnu <br/>";
					}
					if ($realisateur<>""){
						echo "Realisateur : ".$realisateur."<br/>";
					}else{
						echo "Realisateur : Inconnu <br/>";
					}
					if (is_file($affiche)){
						echo "<img src=\"$affiche\">";
					}else{
						echo "<img src=\"../images/unknown_poster.jpg\">";
					}
					$requete->close();
				?>
			</div>
			<!-- Affichage des tags attachés au film -->
			<div>
				Tag :
				<?php
				$requete = mysqli_prepare($link, "SELECT nomTag 
												FROM occurenceTags 
												JOIN tags using(idTag) 
												WHERE idFilm=?") or mysqli_error($link);
				$requete->bind_param("i",$idFilm); 
				$requete->execute();
				$requete->bind_result($nomTag);
				while ( $requete->fetch() ) {
					echo "<a href=\"\">".$nomTag."</a> ";
				}
				?>
			</div>
			
			<!-- Ajout de tag -->
			<div>
				<form action="lire_film.php?idfilm=<?php echo $idFilm?>" method="post">
					Ajouter un tag pour <?php echo $titre_du_film; ?> :
					<input type="text" name="nomtag" placeholder="Votre tag" />
					<input type="submit" name="ajouttag" value="Go !" />
				</form>
			</div>
			
			<!-- Vérification du statut d'aministrateur : ajout de l'affiche du film -->
			<?php
				if($_SESSION['statut'] != "admin") {
					echo "</main>";
					include('footer.html');
					exit();
				}
			?>
			<div>
				<form action="upload_affiches.php" method="post" enctype="multipart/form-data">
					Ajouter une affiche :
					<input type="file" name="fileToUpload" id="fileToUpload" />
					<input type="submit" value="Go !" name="submit" />
					<input type="hidden" value="<?php echo $titre_du_film; ?>" name="nom" />
					<input type="hidden" value="<?php echo $idFilm; ?>" name="id" />
				</form>
			</div>
			
			
			
	</main>
	<!-- Bas de page (mentions légales, ...) -->
	<?php include('footer.html'); ?>
</html>
