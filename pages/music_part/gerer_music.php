<?php
session_start();
$_SESSION['partie']='music';
include("../struct/db_connect.php");
?>

<!doctype html>
<html>
	<head>
		<title>Gestion des musiques</title>
		<meta charset="utf-8"  />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="shortcut icon" type="image/x-icon" href="../../images/icon.ico" />
		<!--Feuille de style-->
		<link rel="stylesheet" href="../style/largeScreen/style.css" />
		<link rel="stylesheet" href="../style/mobile/style.css" />
		<link rel="stylesheet" href="../style/largeScreen/gestion.css" />
		<!--Script javascript-->
		<script src="../../scripts/boite_dialogue.js" type="text/javascript"></script>	
	</head>
	
	<body>
		<?php include('../struct/header.php'); ?>
		
		
		<?php
		// On vérifie le statut de l'utilisateur avant d'afficher la page
		
			if($_SESSION['statut'] != "admin") {
				echo ("<div class=\"error\">Désolé, cette page est uniquement accessible aux comptes administrateurs !</div>");
				include('footer.html');
				exit();
			}
			// RECHERCHE DANS LA BD ----------------------------------------
		?>
		<main class="gestion">
			<h1>Chercher une musique dans la base de données</h1><br />
		<?php
		
		if(isset($_POST['bouttonsrch'])){
			
			$titre = $_POST['titre'];
			$requete = mysqli_prepare($link, "SELECT idmusic, titre, chemin FROM music WHERE titre LIKE ?") or die(mysqli_error($link));
			$titre = "%".$titre."%";
			$requete->bind_param("s",$titre);

			$requete->execute();
			$requete->bind_result($idRes,$titreRes,$cheminRes);
			if (  $requete->fetch() == NULL){
				echo "<div class=\"error\">";
				echo "La musique n'a pas été trouvé !";
				echo "</div>";
			}
			else {
				echo "<table cellspacing=\"0\" border=\"1\"><tr><th>Titre</th><th>Chemin</th></tr>";
				
				do {
					echo "<tr><td><a href=\"lire_music.php?idmusic=".$idRes."\">".$titreRes."</a></td><td>".$cheminRes."</td></tr>";
				} while($requete->fetch() );
				echo "</table><br />";
			}
			$requete->close();
		}
		
		
		// MODIFICATION DE LA BD ---------------------------------------
		
		if(isset($_POST['bouttonsupr'])){ // SUPRESSION
			
			$titre = $_POST['titrefilm2'];
			$requete = mysqli_prepare($link, "SELECT `idmusic` FROM `music` WHERE `titre`= ?");
			$requete->bind_param("s",$titre);
			$requete->execute();
			$requete->bind_result($id);
			$requete->close();
			
			$requete = mysqli_prepare($link, "DELETE FROM music WHERE titre = ?");
			$requete->bind_param("s",$titre);
			$requete->execute();
			$requete->close();
			
			if (mysqli_affected_rows($link) > 0) {
				echo "<div class=\"info\">";
				echo "Film supprimé avec succès.";
				echo "</div>";
				//Supprimer aussi 
				/*$requete = mysqli_prepare($link, "DELETE FROM `historiqueFilms` WHERE `idfilm`= ?");
				$requete->bind_param("s",$id);
				$requete->execute();
				$requete->close();
				
				$requete = mysqli_prepare($link, "DELETE FROM `occurenceTags` WHERE `idFilm`= ?");
				$requete->bind_param("s",$id);
				$requete->execute();
				$requete->close();*/
			}
			else {
				echo "<div class=\"error\">";
				echo "Erreur dans la supression: " . mysqli_error($link)." Veuillez recommencer.";
				echo "</div>";
			}
		}
		if(isset($_POST['supprall'])){
			$requete = mysqli_prepare($link, "TRUNCATE `music`;");
			$requete->execute();
			$requete->close();
			
			$commande = "rm ../../Musics/pochette/*";
			exec($commande);
			/*
			$requete = mysqli_prepare($link, "DELETE FROM `occurenceTags`");
			$requete->execute();
			$requete->close();
			
			$requete = mysqli_prepare($link, "DELETE FROM `notes`");
			$requete->execute();
			$requete->close();
			
			$requete = mysqli_prepare($link, "DELETE FROM `historiqueFilms`");
			$requete->execute();
			$requete->close();
			*/
			/*
			$requete = mysqli_prepare($link, "DELETE FROM `tags`");
			$requete->execute();
			$requete->close();
			*/
		}
		?>
		
		
		
		<!-- CORPS DE LA PAGE -->
			<form action="gerer_music.php" method="post">
				Titre (exact) : <input type="text" name="titre"/><br />
				<input type="submit" value="Envoyer" name="bouttonsrch"/>
			</form>
			
			<h1>Mettre à jour la base de données</h1><br />
			
			<form action="maj_bdd.php" method="post">
				<input type="submit" name="maj_bdd" value="Go !">
			</form>
			
			<h1>Ajouter un musique</h1><br />
			<form action="upload_music.php" method="post" enctype="multipart/form-data">
				Titre* :<input type="text" name="titrefilm" required /><br />
				Réalisateur :<input type="text" name="real"/><br />
				Année de sortie :<input type="text" name="sortie"/><br />
				Ajouter le musique :<input type="file" name="mvToUpload" id="mvToUpload" required /><br />
				Ajouter l'affiche de la musique :<input type="file" name="imgToUpload" id="imgToUpload" /><br />
			<input type="submit" name="bouttonadd" value="Valider"/></form><br />
			
			<h1>Supprimer une musique</h1><br />
			<form action="gerer_music.php" method="post">
				Titre : <input type="text" name="titrefilm2"/><br />
				<input type="submit" name="bouttonsupr" value="Valider"/>
			</form>
			<br />
			
			<h1>Supprimer la base de donnees</h1><br />
			<form action="gerer_music.php" method="post">
				<input type="submit" name="supprall" onclick="return confirm('Etes vous sur ?')" value="Valider">
			</form>
		</main>
		<?php include('../struct/footer.html'); ?>
	</body>
</html>
