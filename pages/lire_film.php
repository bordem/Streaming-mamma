<?php
session_start();
include("db_connect.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

?>

<html>
    <head>
        <meta charset="utf-8" />
        <title>Le film</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
        <link rel="stylesheet" href="style/style.css" />
    </head>

    <body>
        <!-- Haut de page -->
		<?php include('header.php'); ?>
        
        
        <main>
            <?php
            	//On refuse l'accès si le visiteur n'est pas connecté
                if ($_SESSION['statut'] != "admin" && $_SESSION['statut'] != "user") {
					echo("<p>Vous devez être connecté pour accéder à cette page.</p>");
					echo("<a href=\"connexion.php\">se connecter</a>");
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
												VALUES (?, ?, NOW() )");// or die(mysqli_error($link));
				$requete->bind_param("ii",$idFilm,$userId);
                $requete->execute();
                
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
				
					// S'il n'existe pas, on ajoute le tag
					if( empty($nomTag) ){
						$requete2=mysqli_prepare($link,"INSERT INTO `tags`(`nomTag`) 
														VALUES ( ? )") or die(mysqli_error($link));
						$requete2->bind_param("s",$tagAInserer);
						if ($requete2->execute()) {
                			//echo "Tags ajoutés";
            			}
            			else {
                			echo "Erreur dans l'ajout: " . mysqli_error($link)." Veuillez recommencer.";
						}
					}
					else {
	                	//echo "Ce tag existe deja";
    	            }
                
					$rqt= mysqli_prepare($link,"SELECT idTag 
												FROM tags 
												WHERE nomTag= ?") or die(mysqli_error($link));
					$rqt->bind_param("s",$tagAInserer);
					$rqt->execute();
					$rqt->bind_result($idTag);
					$rqt->fetch();
					$requete3=mysqli_prepare($link,"INSERT INTO `occurenceTags`(`idFilm`, `idTag`) 
													VALUES (?,?)") or die(mysqli_error($link));
					$requete3->bind_param("ii",$idFilm,$idTag);
	                if ($requete3->execute()) {
    	            	//echo "Tags ajouter aux occurences";
        	    	}
            	}
	            //On récupère le titre et le chemin du film        
				$requete = mysqli_prepare($link, "SELECT titre,chemin 
												FROM films 
												WHERE idfilm= ? ") or die(mysqli_error($link)); 
				$requete->bind_param("i",$idFilm);
				$requete->execute();
				$requete->bind_result($titre_du_film, $chemin_du_film);
				// il peut paraître étrange de récupérer les élément de la db dans une boucle, mais si ce n'est pas fait, la prochaine requete ( les tags ) échoue ( à cause d'une histoire de synchronisation avec le serveur mysql)
				while ( $requete->fetch() );
			?>
            
            
            <!-- On affiche le film -->
            <h1 class="titreFilm"><?php echo $titre_du_film; ?></h1><br/>
            
            <video id="video" height="240" width="360" autoplay controls>
            	<source src="<?php echo $chemin_du_film; ?>" type="video/mp4">
            	<source src="<?php echo $chemin_du_film; ?>" type="video/webm"> 
            	<source src="<?php echo $chemin_du_film; ?>" type="video/ogg"> 
            </video>
            
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
                    echo $nomTag." ";
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
