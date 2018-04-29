<?php session_start(); ?>

<html>
    <head>
        <meta charset="utf-8" />
        <title>Le film</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="style/style.css" />
    </head>

    <body>
        <!-- Haut de page -->
        <?php include('header.php'); ?>
        
        
        
        
        
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
            $link = mysqli_connect("localhost",$_SESSION['link1'],$_SESSION['link2'],$_SESSION['link3']);
            $requete = mysqli_query($link, "SELECT * FROM films WHERE idfilm=".$_GET['idfilm']) or die(mysql_error());
            while ($row = mysqli_fetch_assoc($requete)) {                       
                $titre_du_film = $row['titre'];
                $chemin_du_film = $row['chemin'];
            }
        ?>
        
        
        <!-- On affiche le film -->
        <h1><?php echo $titre_du_film; ?></h1><br/>
        <?php //echo $chemin_du_film; ?>
        <p><video width="50%" controls>
            <source src="<?php echo $chemin_du_film; ?>" type="video/webm">
            
            Votre navigateur ne supporte pas la vidéo. Mettez le à jour ou utilisez un autre navigateur.
        </video></p>
    </body>
    
    
    <!-- Bas de page (mentions légales, ...) -->
    <?php include('footer.html'); ?>
</html>
