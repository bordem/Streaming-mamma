<?php
session_start();
?>
<link rel="stylesheet" href="../style/largeScreen/header.css" />
<link rel="stylesheet" href="../style/largeScreen/header.css" />
<link rel="stylesheet" href="../style/mobile/header.css" />
<header>
	<!-- Titre cliquable si connecté -->
	<?php
		if(!isset($_SESSION['statut'])){
			$_SESSION['statut']=NULL;
		}
		if ($_SESSION['statut'] != 'admin' && $_SESSION['statut'] != 'user') {
			echo "<a href=\"../struct/connexion.php\"> <img id=\"logo\" src=\"../../images/logo.svg\"><h1 id=\"banniere\"> Streaming Mamma</h1></a>";
		} else {
			echo "<a href=\"../struct/accueil.php\"><img id=\"logo\" src=\"../../images/logo.svg\"><h1 id=\"banniere\">Streaming Mamma</h1></a>";
		}
	?>
	
	<!-- Pseudo et image de profil si connecté -->
	<?php
	if ($_SESSION['statut'] == 'admin' || $_SESSION['statut'] == 'user') {?>
		<a href="../gestion/profil.php">
			<div id="ongletUtilisateur">
			<?php 
				echo "<div dir=\"rtl\" id=\"loginProfil\">".$_SESSION['login']."</div>";
				//Changement
				$path="";
				$requete = mysqli_prepare($link, "SELECT imagePath 
												FROM utilisateurs 
												WHERE idusr=?") or mysqli_error($link);
				$requete->bind_param("s",$_SESSION['userId']); 
				$requete->execute();
				$requete->bind_result($path);
				$requete->fetch();
				$requete->close();
				//echo $path;
				if($path == ""){?>
					<img id="imageProfil" src="../../images/profil_photo_basique.jpg">
			<?php
				}else{?>
					<img id="imageProfil" src="<?php echo $path;?>">
				<?php
				}
			?>
			</div>
		</a>
	
	<?php
	}
	echo "<nav class=\"grid-container\">";
	if ($_SESSION['statut'] == "user") {
		echo "<div class=\"item1\"><a href= \"../struct/accueil.php\">Accueil</a></div>";
		echo "<div class=\"item2\"><a href= \"../movie_part/choix_film.php?pages=0\">Tous les films</a></div>";
		echo "<div class=\"item3\"><a href= \"../music_part/choix_music.php?pages=0\">Toutes les musiques</a></div>";
		echo "<div class=\"item4\"><a href= \"../struct/connexion.php\">Déconnexion</a></div>";
	
	}
	if ($_SESSION['statut'] == "admin") {
			/*TODO
			A mettre en place : Un systeme qui sait dans quelle partie on se trouve 
			Du genre :  - sectfilm
				- sectmusic
				- sectserie
				- sectneutre
			Peut etre a  rajouter aux sessions
			Plus simple que actuellement voir dessous
			*/
			echo "<div id=\"cacheMobile\" class=\"item1\"><a href= \"../struct/accueil.php\">Accueil</a></div>";
				if($_SESSION['partie']=='movie'){
					echo "<div class=\"item2\"><a href= \"../movie_part/choix_film.php?pages=0\">Tous les films</a></div>";
				}elseif($_SESSION['partie']=='music'){
					echo "<div class=\"item2\"><a href= \"../music_part/choix_music.php\">Toutes les musiques</a></div>";
				}else{
					echo "<div class=\"item2\"><a href= \"../movie_part/choix_film.php?pages=0\">Tous les films</a></div>";
				}
			echo "<div class=\"item3\"><a href= \"../gestion/gerer_membres.php\">Gérer les membres</a></div>";
				if($_SESSION['partie']=='movie' || $_SESSION['partie']=='neutre'){
					echo"<div class=\"item4\"><a href= \"../movie_part/gerer_films.php\">Gérer les films</a></div>";
				}elseif($_SESSION['partie']=='music'){
					echo"<div class=\"item4\"><a href= \"../music_part/gerer_music.php\">Gérer les musiques</a></div>";
				}
			echo "<div class=\"item5\"><a href= \"../struct/connexion.php\">Déconnexion</a></div>";
	}
	echo "</nav>";
	?>
	
</header>

