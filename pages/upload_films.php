<?php
echo "titre : ".$_POST['titrefilm']."<br/>";
echo "categorie : ".$_POST['categorie']."<br/>";
echo "real : ".$_POST['real']."<br/>";
echo "sortie : ".$_POST['sortie']."<br/>";

$target_dir_mv = "../Films/".$_POST['categorie']."/";
echo "target directory : ".$target_dir_mv."<br/>";

$target_file_mv = $target_dir_mv.basename($_FILES["mvToUpload"]["name"]);
echo "target file : ".$target_file_mv."<br/>";

$uploadOk = 1;

$movieFileType = strtolower(pathinfo($target_file_mv,PATHINFO_EXTENSION));
echo "movie file type : ".$movieFileType."<br/>";


// Check if file already exists
/** if (file_exists($target_file_img)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
**/


// Allow certain file formats
if($movieFileType != "mp4" && $movieFileType != "ogv" && $movieFileType != "webm") {
    echo "Le film doit être au format MP4, OGV ou WEBM. ";
    $uploadOk = 0;
}


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Désolé, le téléchargement n'a pas été effectué.";
    
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["mvToUpload"], $target_file_mv)) {
        rename($target_dir_mv.basename( $_FILES["mvToUpload"]["name"]), $target_dir_mv.$_POST["titrefilm"]."jpg");
        echo "Le fichier a bien été uploadé.";
        
        // ajout du film dans la bd
        if(isset($_POST['bouttonadd'])) {
            $titre = $_POST['titrefilm'];
            $path = $target_dir_mv.$_POST["titrefilm"]."jpg";
            $realisateur = $_POST['real'];
            $anneesortie = $_POST['sortie'];
                
            $requete = "INSERT INTO films (titre, chemin, realisateur, anneesortie) VALUES ('".$titre."','".$path."','".$realisateur."','".$anneesortie."')";
            $link = mysqli_connect("localhost",$_SESSION['link1'],$_SESSION['link2'],$_SESSION['link3']);
            
            if (mysqli_query($link, $requete)) {
                echo "Film ajouté dans la BDD avec succès.";
            }
            else {
                echo "Erreur dans l'ajout du film dans la BDD : " . mysqli_error($link)." Veuillez recommencer.";
            }
        }
        
    } else {
        echo "Désolé, il y a eu une erreur dans le téléchargement du fichier.";
    }
}
?>

