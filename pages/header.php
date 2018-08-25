<header>
	<!-- Titre cliquable si connecté -->
    <?php
        if ($_SESSION['statut'] != 'admin' && $_SESSION['statut'] != 'user') {
            echo "<a href=\"../pages/connexion.php\"> <img id=\"logo\" src=\"../images/logo.jpg\"><h1 id=\"banniere\"> Streaming Mamma</h1></a>";
        } else {
            echo "<a href=\"choix_film.php\"><img id=\"logo\" src=\"../images/logo.jpg\"><h1 id=\"banniere\">Streaming Mamma</h1></a>";
        }
    ?>
    
    <!-- Pseudo et image de profil si connecté -->
    <?php
    if ($_SESSION['statut'] == 'admin' || $_SESSION['statut'] == 'user') {?>
        <a href="profil.php">
            <div id="ongletUtilisateur">
            <?php echo $_SESSION['login'];?>
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

