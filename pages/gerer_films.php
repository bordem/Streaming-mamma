<?php
session_start(); 
include("db_connect.php");
?>

<!doctype html>
<html>
    <head>
        <title>Films</title>
        <meta charset="utf-8"  />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
        <link rel="stylesheet" href="style/style.css" />
		<script src="../scripts/boite_dialogue.js" type="text/javascript"></script>	
    </head>
    
    <body>
        <?php include('header.php'); ?>
        
        
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
        <?php
        
        if(isset($_POST['bouttonsrch'])){
            
            $titre = $_POST['titre'];
			$requete = mysqli_prepare($link, "SELECT titre, chemin, realisateur, anneesortie FROM films WHERE titre = ?") or die(mysqli_error($link));
			$requete->bind_param("s",$titre);

			$requete->execute();
			$requete->bind_result($titreRes,$cheminRes, $realisateurRes, $anneeRes);
			if (  $requete->fetch() == NULL){
				echo "<div class=\"error\">";
                echo "Le film \"".$titre."\" n'a pas été trouvé. Le titre exact est requis pour l'instant car je ne sais pas programmer !";
				echo "</div>";
            }
            else {
                echo "<table cellspacing=\"0\" border=\"1\"><tr><th>Titre</th><th>Chemin</th><th>Realisateur</th><th>Année de sortie</th></tr>";
                
                do {
				    echo "<tr><td>".$titreRes."</td><td>".$cheminRes."</td><td>".$realisateurRes."</td><td>".$anneeRes."</td></tr>";
			    } while($requete->fetch() );
			    echo "</table><br />";
            }
        }
        
        
        // MODIFICATION DE LA BD ---------------------------------------

        
        if(isset($_POST['bouttonsupr'])){ // SUPRESSION
            $titre = $_POST['titrefilm2'];
            
            $link = mysqli_connect("localhost",$_SESSION['link1'],$_SESSION['link2'],$_SESSION['link3']);
			
			
            $requete2 = mysqli_prepare($link, "DELETE FROM films WHERE titre = ?");
			$requete2->bind_param("s",$titre);
			$requete2->execute();

            
            if (mysqli_affected_rows($link) > 0) {
				echo "<div class=\"info\">";
                echo "Film supprimé avec succès.";
				echo "</div>";
            }
            else {
				echo "<div class=\"error\">";
                echo "Erreur dans la supression: " . mysqli_error($link)." Veuillez recommencer.";
				echo "</div>";
            }
        }
        ?>
        
        
        
        <!-- CORPS DE LA PAGE -->
        
            <h1>Chercher un film dans la base de données</h1><br />
            <form action="gerer_films.php" method="post">
                Titre (exact) : <input type="text" name="titre"/><br />
                <input type="submit" value="Envoyer" name="bouttonsrch"/>
            </form>
            
            <h1>Mettre à jour la base de données</h1><br />
            
            <form action="maj_bdd.php" method="post">
                <input type="submit" name="maj_bdd" value="Go !">
            </form>
            
            <h1>Ajouter un film</h1><br />
            <form action="upload_films.php" method="post" enctype="multipart/form-data">
                Ajouter le film* :<input type="file" name="mvToUpload" id="mvToUpload" required /><br />
                Titre* :<input type="text" name="titrefilm" required /><br />
                
                Catégorie* :
                    
                        <select name="categorie" required >
                           <option value="Action">Action</option>
                           <option value="Animes">Anime</option>
                           <option value="Comedie">Comédie</option>
                           <option value="Sciences_Fiction">SF</option>
                           <option value="Autre">Autre</option>
                        </select><br />
                        
                    Ajouter l'affiche du film :<input type="file" name="imgToUpload" id="imgToUpload" /><br />
                    Réalisateur :<input type="text" name="real"/><br />
					Année de sortie :<input type="text" name="sortie"/><br />
					
            <input type="submit" name="bouttonadd" value="Valider"/></form><br />
            
            <h1>Supprimer un film</h1><br />
            <form action="gerer_films.php" method="post">
                Titre : <input type="text" name="titrefilm2"/><br />
                <input type="submit" name="bouttonsupr" value="Valider"/>
            </form>
            <br />
        </main>
        <?php include('footer.html'); ?>
    </body>
</html>
