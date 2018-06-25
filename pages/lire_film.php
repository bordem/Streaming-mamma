<?php session_start(); ?>

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
            <!-- Ajout du tag dans la BDD -->
            <?php
            
            	$link1 = $_SESSION['link1'];
                $link2 = $_SESSION['link2'];
                $link3 = $_SESSION['link3'];
                
                $link = mysqli_connect("localhost",$link1,$link2,$link3);
            
            
            	/*Ajout a l'historique du film regarder*/
            	$loginUser=$_SESSION['login'];
            	$idFilm=$_GET['idfilm'];
                $requete1="SELECT idusr FROM utilisateurs WHERE login='".$loginUser."'";
                $rqt = mysqli_query($link,$requete1) or die(mysql_error());
            	while ($row = mysqli_fetch_assoc($rqt)) {                       
                    $idUser = $row['idusr'];
                }
                date_default_timezone_set('UTC');
                //echo date("Y-m-d");
                $newRQT="INSERT INTO `historiqueFilms`(`idfilm`, `idusr`,`date`) VALUES (".$idFilm.",".$idUser.",NOW())";
                //echo $newRQT;
               	mysqli_query($link, $newRQT)or die(mysql_error());
                
                
                /*Ajout des tags au film*/
            if(isset($_POST['ajouttag'])){
                // On cherche si le tag existe déjà dans la BDD
                $tagAInserer=$_POST['nomtag'];
                $requete1="SELECT nomTag FROM tags WHERE nomTag='".$tagAInserer."'";
                $rqt = mysqli_query($link,$requete1) or die(mysql_error());
                $num_rows = mysqli_num_rows($rqt);
                // S'il n'existe pas, on ajoute le tag
                if($num_rows==0){
                        $requete2="INSERT INTO `tags`(`nomTag`) VALUES ('".$tagAInserer."')";
                        if (mysqli_query($link, $requete2)) {
                			//echo "Tags ajouter";
            			}
            			else {
                			echo "Erreur dans l'ajout: " . mysqli_error($_SESSION['link'])." Veuillez recommencer.";
            			}
                }
                else
                {
                	//echo "Ce tag existe deja";
                }
                
                $rqt="SELECT idTag FROM tags WHERE nomTag='".$tagAInserer."'";
                $rqt = mysqli_query($link,$rqt) or die(mysql_error());
                while ($row = mysqli_fetch_assoc($rqt)) {
                    $idTag = $row['idTag'];
                }
                $newRQT="INSERT INTO `occurenceTags`(`idFilm`, `idTag`) VALUES (".$idFilm.",".$idTag.")";
                if (mysqli_query($link, $newRQT)) {
                	//echo "Tags ajouter aux occurences";
            	}
            }
            ?>
        
            <!-- On refuse l'accès si le visiteur n'est pas connecté -->
            <?php
                if ($_SESSION['statut'] != "admin" 
                && $_SESSION['statut'] != "user") {
                    echo("<p>Vous devez être connecté pour accéder à cette page.</p>");
                    include('footer.html');
                    exit();
                }
             ?>
            
            
            <!-- On récupère le titre et le chemin du film -->
            <?php
            
                $requete = mysqli_query($link, "SELECT * FROM films WHERE idfilm=".$_GET['idfilm']) or die(mysql_error());
                while ($row = mysqli_fetch_assoc($requete)) {                       
                    $titre_du_film = $row['titre'];
                    $chemin_du_film = $row['chemin'];
                }
            ?>
            
            
            <!-- On affiche le film -->
            <h1 class="titreFilm"><?php echo $titre_du_film; ?></h1><br/>
            <?php //echo $chemin_du_film; ?>
            
            <video id="video" height="240" width="360" autoplay controls>
            	<source src="<?php echo $chemin_du_film; ?>" type="video/mp4">
            	<source src="<?php echo $chemin_du_film; ?>" type="video/webm"> 
            	<source src="<?php echo $chemin_du_film; ?>" type="video/ogg"> 
            </video>
            
            <!-- Affichage des tags attachés au film -->
            <div>
                Tag : 
                <?php
                $requete = mysqli_query($link, "SELECT nomTag
                                                FROM occurenceTags
                                                NATURAL JOIN tags 
                                                WHERE idFilm=".$_GET['idfilm']) or die(mysql_error());
                while ($row = mysqli_fetch_assoc($requete)) {
                    echo $row[nomTag]." ";
                    
                }
                ?>
            </div>
            
            <!-- Ajout de tag -->
            <div>
                <form action="lire_film.php?idfilm=<?php echo $_GET['idfilm']?>" method="post">
                    Ajouter un tag pour <?php echo $titre_du_film; ?> :
                    <input type="text" name="nomtag" placeholder="Votre tag" />
                    <input type="submit" name="ajouttag" value="Go !" />
                </form>
            </div>
            
            <!-- Vérification du statut d'aministrateur : ajout de l'affiche du film -->
            <?php
            if($_SESSION['statut'] != "admin") {
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
                    <input type="hidden" value="<?php echo $_GET['idfilm']; ?>" name="id" />
                </form>
            </div>
            
            
            
    </main>
    <!-- Bas de page (mentions légales, ...) -->
    <?php include('footer.html'); ?>
</html>
