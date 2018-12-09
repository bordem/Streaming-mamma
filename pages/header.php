<link rel="stylesheet" href="style/largeScreen/header.css" />
<header>
	<!-- Titre cliquable si connecté -->
    <?php
        if ($_SESSION['statut'] != 'admin' && $_SESSION['statut'] != 'user') {
            echo "<a href=\"../pages/connexion.php\"> <img id=\"logo\" src=\"../images/logo.svg\"><h1 id=\"banniere\"> Streaming Mamma</h1></a>";
        } else {
            echo "<a href=\"choix_film.php?pages=0\"><img id=\"logo\" src=\"../images/logo.svg\"><h1 id=\"banniere\">Streaming Mamma</h1></a>";
        }
    ?>
    
    <!-- Pseudo et image de profil si connecté -->
    <?php
    if ($_SESSION['statut'] == 'admin' || $_SESSION['statut'] == 'user') {?>
        <a href="profil.php">
            <div id="ongletUtilisateur">
            <?php 
            	echo $_SESSION['login'];
            	
            	//Changement
            	/*$requete = mysqli_prepare($link, "SELECT imagePath 
												FROM utilisateurs 
												WHERE idusr=?") or mysqli_error($link);
				$requete->bind_param("s",$_SESSION['login']); 
				$requete->execute();
				$requete->bind_result($path);
				$requete->fetch();
				echo $path;*/?>
				<img id="imageProfil" src="../images/profil_photo_basique.jpg">
		       	
	        </div>
        </a>
    
    <?php
    }
    echo "<nav class=\"grid-container\">";
    if ($_SESSION['statut'] == "user") {
        echo"
                <div class=\"item1\"><a href= \"choix_film.php?pages=0\">Tous les films</a></div>
                <div class=\"item2\"><a href= \"connexion.php\">Déconnexion</a></div>";
    
    }
    if ($_SESSION['statut'] == "admin") {
       echo "
       			<div class=\"item1\"><a href= \"choix_film.php?pages=0\">Tous les films</a></div>
                <div class=\"item2\"><a href= \"gerer_membres.php\">Gérer les membres</a></div>
                <div class=\"item3\"><a href= \"gerer_films.php\">Gérer les films</a></div>
                <div class=\"item4\"><a href= \"connexion.php\">Déconnexion</a></div>";
    }
    echo "</nav>";
    ?>
	
</header>

