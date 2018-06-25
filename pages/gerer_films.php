<?php session_start(); ?>

<!doctype html>
<html>
    <head>
        <title>Films</title>
        <meta charset="utf-8"  />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
        <link rel="stylesheet" href="style/style.css" />
    </head>
    
    <body>
        <?php include('header.php'); ?>
        
        
        <?php
        // On vérifie le statut de l'utilisateur avant d'afficher la page
        
            if($_SESSION['statut'] != "admin") {
                echo ("<p>Désolé, cette page est uniquement accessible aux comptes administrateurs !</p>");
                include('footer.html');
                exit();
            }
			// RECHERCHE DANS LA BD ----------------------------------------
		?>
        <main class="gestion">;
        <?php
        $link1 = $_SESSION['link1'];
        $link2 = $_SESSION['link2'];
        $link3 = $_SESSION['link3'];
            
        $link = mysqli_connect("localhost",$link1,$link2,$link3);
        
        if(isset($_POST['bouttonsrch'])){
            
            $titre = $_POST['titre'];
            $requete3 = mysqli_query($link, "SELECT * FROM films WHERE titre = '".$titre."'") or die(mysql_error());

            if(mysqli_num_rows($requete3) == 0) {
                echo "Le film \"".$titre."\" n'a pas été trouvé. Le titre exact est requis pour l'instant car je ne sais pas programmer !<br/>";
            }
            else {
                echo "<table cellspacing=\"0\" border=\"1\"><tr><th>Titre</th><th>Chemin</th><th>Realisateur</th><th>Année de sortie</th></tr>";
                
                while ($row = mysqli_fetch_assoc($requete3)) {
				    echo "<tr><td>".$row['titre']."</td><td>".$row['chemin']."</td><td>".$row['realisateur']."</td><td>".$row['anneesortie']."</td></tr>";
			    }
			    echo "</table><br/>";
            }
        }
        
        
        // MODIFICATION DE LA BD ---------------------------------------

        
        if(isset($_POST['bouttonsupr'])){ // SUPRESSION
            $titre = $_POST['titrefilm2'];
            
            $link = mysqli_connect("localhost",$_SESSION['link1'],$_SESSION['link2'],$_SESSION['link3']);
            $requete2 = "DELETE FROM films WHERE titre = '".$titre."'";
            mysqli_query($link, $requete2);
            
            if (mysqli_affected_rows($link) > 0) {
                echo "Film supprimé avec succès.";
            }
            else {
                echo "Erreur dans la supression: " . mysqli_error($link)." Veuillez recommencer.";
            }
        }
        ?>
        
        
    

        
        <!-- CORPS DE LA PAGE -->
        
            <h1>Chercher un film dans la base de données</h1><br/>
            <form action="gerer_films.php" method="post">
                Titre (exact) : <input type="text" name="titre"/><br/>
                <input type="submit" value="Envoyer" name="bouttonsrch"/>
            </form>
            
            <h1>Mettre à jour la base de données</h1><br/>
            
            <form action="maj_bdd.php" method="post">
                <input type="submit" name="maj_bdd" value="Go !">
            </form>
            
            <h1>Ajouter un film</h1><br/>
            <form action="upload_films.php" method="post" enctype="multipart/form-data">
                Ajouter le film* :<input type="file" name="mvToUpload" id="mvToUpload" required /></br>
                Titre* :<input type="text" name="titrefilm" required /></br>
                
                Catégorie* :
                    
                        <select name="categorie" required >
                           <option value="Action">Action</option>
                           <option value="Animes">Anime</option>
                           <option value="Comedie">Comédie</option>
                           <option value="Sciences_Fiction">SF</option>
                           <option value="Autre">Autre</option>
                        </select></br>
                        
                    Ajouter l'affiche du film :<input type="file" name="imgToUpload" id="imgToUpload" /></br>
                    Réalisateur :<input type="text" name="real"/></br>
					Année de sortie :<input type="text" name="sortie"/></br>
					
            <input type="submit" name="bouttonadd" value="Valider"/></form><br/>
            
            <h1>Supprimer un film</h1><br/>
            <form action="gerer_films.php" method="post">
                Titre : <input type="text" name="titrefilm2"/><br/>
                <input type="submit" name="bouttonsupr" value="Valider"/>
            </form>
            <br/>
        </main>
        <?php include('footer.html'); ?>
    </body>
</html>
