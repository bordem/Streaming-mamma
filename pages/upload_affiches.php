<?php session_start(); ?>

<html>
    <head>
        <meta charset="utf-8" />
        <title>Le film</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
		<script src="../scripts/boite_dialogue.js" type="text/javascript"></script>	
        <link rel="stylesheet" href="style/style.css" />
    </head>
    
    <body>
        <!-- Haut de page -->
        <?php include('header.php'); ?>
    
        <main>
            <?php
            $target_dir = "../Films/affiche/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Check if file already exists
            /** if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }
            **/

            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Le fichier ne doit pas excéder 500 Ko. ";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg") {
                echo "Seul le format JPG est autorisé. ";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Désolé, le téléchargement n'a pas été effectué.";
                
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    rename("../Films/affiche/".basename( $_FILES["fileToUpload"]["name"]), "../Films/affiche/".$_POST["nom"].".jpg");
                    echo "Le fichier a bien été uploadé.<br/>";
                    
                } else {
                    echo "Désolé, il y a eu une erreur dans le téléchargement du fichier.<br/>";
                }
            }
            ?>
            
            <a href="lire_film.php?idfilm=<?php echo $_POST['id'] ?>">Revenir au film</a>
        </main>
        
        <!-- Bas de page (mentions légales, ...) -->
        <?php include('footer.html'); ?>
    </body>
</html>

