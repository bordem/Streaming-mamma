<?php session_start();
$_SESSION['partie']='music';
include('../struct/db_connect.php');
?>

<html>
	<head>
		<meta charset="utf-8" />
		<title>Le film</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" type="image/x-icon" href="../../images/icon.ico" />
 		<!--Script javascript-->
 		<script src="../../scripts/boite_dialogue.js" type="text/javascript"></script>	
		<!--Feuille de style-->
		<link rel="stylesheet" href="../style/largeScreen/style.css" />
		<link rel="stylesheet" href="../style/mobile/style.css" />
	</head>
	
	<body>
		<!-- Haut de page -->
		<?php include('../struct/header.php'); ?>
	
		<main>
			<br />
			<br />
			<?php
			$idmusic=$_GET['idmusic'];
			
			$target_dir = "../../Musics/pochette/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = true;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			// Check if file already exists
			/** if (file_exists($target_file)) {
					echo "<div class=\"error\">";
					echo "Sorry, file already exists.";
					echo "</div>";
					$uploadOk = false;
				}
			**/

			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 500000) {
				echo "<div class=\"error\">";
				echo "Le fichier ne doit pas excéder 500 Ko.";
				echo "</div>";
				$uploadOk = false;
			}
			else{
				echo "Le fichier est d'une taille acceptable<br />";
			}
			//echo $idmusic;

			// Allow certain file formats
			if($imageFileType != "jpg") {
				echo "Seul le format JPG est autorisé. <br />";
				$uploadOk = false;
			}

			// Check if $uploadOk is false
			if (!$uploadOk) {
				echo "Désolé, le téléchargement ne peut pas être effectué. <br />";
				
			// if everything is ok, put it in the db
			} else {
				/*echo "<br />";
				echo $_FILES["fileToUpload"]["tmp_name"];*/
				$result=move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
				if ($result) {
					rename($target_file, "../../Musics/pochette/".$idmusic.".jpg");
					
					$commande = "chmod 777 ../../Musics/pochette/".$idmusic.".jpg";
					//echo $commande;
					exec($commande);
					echo "<center><h1>Le fichier a bien été uploadé.</h1></center><br/>";
					
				} else {
					echo "<center><h1>Désolé, il y a eu une erreur dans le téléchargement du fichier.</h1></center><br />";
				}
				$chemin="../../Musics/pochette/".$idmusic.".jpg";
				$requete = mysqli_prepare($link, "	UPDATE `music` 
													SET `pochette`= ? 
													WHERE idmusic = ?") or die(mysqli_error($link)); 
				$requete->bind_param("ss",$chemin,$idmusic);
				$requete->execute();
				$requete->close();
			}
			?>
			<br />
			<center><a href="lire_music.php?idmusic=<?php echo $idmusic ?>"><h1>Revenir a la musique</h1></a></center>
			<br/>
			<?php
	   			/*echo $_FILES['fileToUpload']['type'];
				echo $_FILES['fileToUpload']['name'];*/
			?>
			
		</main>
		
		<!-- Bas de page (mentions légales, ...) -->
		<?php include('../struct/footer.html'); ?>
	</body>
</html>

