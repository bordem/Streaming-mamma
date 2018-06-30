<?php

include("db_connect.php");
echo "<p>";
echo "titre : ".$_POST['titrefilm']."<br/>";
echo "categorie : ".$_POST['categorie']."<br/>";
echo "real : ".$_POST['real']."<br/>";
echo "sortie : ".$_POST['sortie']."<br/>";

$target_dir_mv = "../Films/".$_POST['categorie']."/";
echo "target directory : ".$target_dir_mv."<br/>";

$target_file_mv = $target_dir_mv.basename($_FILES["mvToUpload"]["name"]);
echo "target file : ".$target_file_mv."<br/>";

$uploadOk = true;

$movieFileType = strtolower(pathinfo($target_file_mv,PATHINFO_EXTENSION));
echo "movie file type : ".$movieFileType."<br/>";
echo "</p>";

// Check if file already exists
/** if (file_exists($target_file_img)) {
        echo "Sorry, file already exists.";
        $uploadOk = false;
    }
**/


// Allow certain file formats
if($movieFileType != "mp4" && $movieFileType != "ogv" && $movieFileType != "webm") {
    echo "<div class=\"error\">Le film doit être au format MP4, OGV ou WEBM.</div>";
    $uploadOk = false;
}


// Check if $uploadOk is false
if (!$uploadOk) {
    echo "<div class=\"error\">Désolé, le téléchargement n'a pas été effectué.</div>";
    
// if everything is ok, try to upload the file
} else {
    if (move_uploaded_file($_FILES["mvToUpload"], $target_file_mv)) {
        rename($target_dir_mv.basename( $_FILES["mvToUpload"]["name"]), $target_dir_mv.$_POST["titrefilm"]."jpg");
        echo "<div class=\"info\">Le fichier a bien été uploadé.</div>";
        
        // ajout du film dans la bd
        if(isset($_POST['bouttonadd'])) {
            $titre = $_POST['titrefilm'];
            $path = $target_dir_mv.$_POST["titrefilm"]."jpg";
            $realisateur = $_POST['real'];
            $anneesortie = $_POST['sortie'];
                
			$requete = mysqli_prepare($link, "INSERT INTO films (titre, chemin, realisateur, anneesortie) VALUES ( ?, ?, ?)");
			$requete->bind_param($titre,$path,$realisateur,$anneesortie);
            
            if ($requete->execute()) {
                echo "<div class=\"info\">Film ajouté dans la BDD avec succès.</div>";
            }
            else {
                echo "<div class=\"error\">Erreur dans l'ajout du film dans la BDD : " . mysqli_error($link)." Veuillez recommencer.</div>";
			}
			$requete->close();
        }
        
    } else {
        echo "<div class=\"error\">Le déplacement du fichier a echoué.</div>";
    }
}
?>

