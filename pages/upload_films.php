<?php
include("db_connect.php");
echo "<p>";
$titre = $_POST['titrefilm'];
$categorie = $_POST['categorie'];
$realisateur = $_POST['real'];
$sortie = $_POST['sortie'];
$film = $_FILES["mvToUpload"];
$affiche = $_FILES["imgToUpload"];

echo "Titre : ".$titre."<br/>";
echo "Categorie : ".$categorie."<br/>";
echo "Réalisateur : ".$realisateur."<br/>";
echo "Sortie : ".$sortie."<br/>";


//FILM
$dossierCible = "../Films/".$categorie."/";
echo "Dossier cible où le film doit etre enregistré : ".$dossierCible."<br/>";

//AFFICHE
$dossierAfficheCible = "../Films/affiche/";
echo "Dossier cible où l'affiche' doit etre enregistré : ".$dossierAfficheCible."<br/>";

//FILM
$fichierCible = $dossierCible.basename($film["name"]);
echo "Fichier cible : ".$fichierCible."<br/>";

//AFFICHE
$afficheCible = $dossierAfficheCible.basename($affiche["name"]);
echo "L'affiche doit se retrouver a ce chemin : ".$afficheCible."<br/>";

$uploadOk = true;

//FILM
//Verification de l'extension du fichier
$movieFileType = strtolower(pathinfo($fichierCible,PATHINFO_EXTENSION));
echo "Extension du fichier film : ".$movieFileType."<br/>";
echo "</p>";
// N'autorise que les fichiers de types mp4 ogv et webm'
if($movieFileType != "mp4" && $movieFileType != "ogv" && $movieFileType != "webm") {
	echo "<div class=\"error\">Le film doit être au format MP4, OGV ou WEBM.</div>";
	$uploadOk = false;
}


// Verifie que les autres étapes se soient bien passé
if (!$uploadOk) {
	echo "<div class=\"error\">Désolé, le téléchargement n'a pas été effectué.</div>";
	
//Si tout est OK on essaye d'upload le fichier'
}else{
	if (move_uploaded_file($film["tmp_name"], $fichierCible)){
		rename($dossierCible.basename( $film["name"]), $dossierCible.$titre.".".$movieFileType);
		echo "<div class=\"info\">Le fichier a bien été uploadé.</div>";
		
		move_uploaded_file($affiche["tmp_name"], $afficheCible);
		$cheminAffiche = $dossierAfficheCible.$titre.".jpg";
		rename($dossierAfficheCible.basename( $affiche["name"]), $cheminAffiche);
		echo "<div class=\"info\">L'affiche a bien été uploadé.</div>";
		
		// Ajout du film dans la bd
		if(isset($_POST['bouttonadd'])) {
			$titre = $_POST['titrefilm'];
			$path = $dossierCible.$titre.".".$movieFileType;
			$realisateur = $_POST['real'];
			$anneesortie = $_POST['sortie'];
			
			$requete = mysqli_prepare($link, "INSERT INTO films (affiche, titre, chemin, realisateur, anneesortie) VALUES ( ?, ?, ?, ?, ?)");
			$requete->bind_param("sssss",$cheminAffiche,$titre,$path,$realisateur,$anneesortie);
			
			if ($requete->execute()) {
				echo "<div class=\"info\">Film ajouté dans la BDD avec succès.</div>";
			}
			else {
				echo "<div class=\"error\">Erreur dans l'ajout du film dans la BDD : " . mysqli_error($link)." Veuillez recommencer.</div>";
			}
			$requete->close();
		}
	}else{
		echo "<div class=\"error\">Le déplacement du film a echoué.</div>";
	}
}
	header('Location:gerer_films.php');
	exit();

?>

