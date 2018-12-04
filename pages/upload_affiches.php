<?php session_start(); ?>

<html>
    <head>
        <meta charset="utf-8" />
        <title>Le film</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
 		<script src="../scripts/boite_dialogue.js" type="text/javascript"></script>	
        <link rel="stylesheet" href="style/largeScreen/style.css" />
        <link rel="stylesheet" href="style/mobile/style.css" />
    </head>
    
    <body>
        <!-- Haut de page -->
        <?php include('header.php'); ?>
    
        <main>
            <?php
            $target_dir = "../Films/affiche/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = true;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Check if file already exists
            /** if (file_exists($target_file)) {
					echo "<div class=\"error\">";
                    echo "Sorry, file already exists.";
					echo "</div>";
                    $uploadOk = false;
                }
            **/

            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "<div class=\"error\">";
                echo "Le fichier ne doit pas excéder 500 Ko.";
                echo "</div>";
                $uploadOk = false;
            }
            else{
            	echo "Le fichier est d'une taille acceptable";
            }

            // Allow certain file formats
            if($imageFileType != "jpg") {
				echo "<div class=\"error\">";
                echo "Seul le format JPG est autorisé. ";
				echo "</div>";
                $uploadOk = false;
            }

            // Check if $uploadOk is false
            if (!$uploadOk) {
				echo "<div class=\"error\">";
                echo "Désolé, le téléchargement ne peut pas être effectué.";
				echo "</div>";
                
            // if everything is ok, put it in the db
            } else {
				echo $_FILES["fileToUpload"]["tmp_name"];
				$result=move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                if ($result) {
                    rename($target_file, "../Films/affiche/".$_POST["nom"].".jpg");
					echo "<div class=\"info\">";
                    echo "Le fichier a bien été uploadé.<br/>";
					echo "</div>";
                    
                } else {
					echo "<div class=\"error\">";
                    echo "Désolé, il y a eu une erreur dans le téléchargement du fichier.";
					echo "</div>";
                }
            }
            ?>
            
            <a href="lire_film.php?idfilm=<?php echo $_POST["id"] ?>">Revenir au film</a>
            <br/>
            <?php
           		echo $_FILES['fileToUpload']['type'];
           		echo $_FILES['fileToUpload']['name'];
            ?>
            
        </main>
        
        <!-- Bas de page (mentions légales, ...) -->
        <?php include('footer.html'); ?>
    </body>
</html>

