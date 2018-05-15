<header class="jumbotron jumbotron-fluid">
    <h1>Streaming Mamma</h1>
    <!-- Salut, <?php echo $_SESSION['login'] ?> -->
    
    <?php
    if ($_SESSION['statut'] == "user") {
        echo "<nav class=\"row col-sm-12\">
                <div class=\"col-sm-6 text-center\"><a href= \"choix_film.php\">Tous les films</a></div>
                <div class=\"col-sm-6 text-center\"><a href= \"../pages/connexion.php\">Déconnexion</a></div>
             </nav>";
    }
    
    else if ($_SESSION['statut'] == "admin") {
       echo "<nav class=\"row col-sm-12\">
                <div class=\"col-sm-3 text-center\"><a href= \"gerer_membres.php\">Gérer les membres</a></div>
                <div class=\"col-sm-3 text-center\"><a href= \"gerer_films.php\">Gérer les films</a></div>
                <div class=\"col-sm-3 text-center\"><a href= \"choix_film.php\">Tous les films</a></div>
                <div class=\"col-sm-3 text-center\"><a href= \"../pages/connexion.php\">Déconnexion</a></div>
             </nav>"; 
    }
    ?>
    
</header>
