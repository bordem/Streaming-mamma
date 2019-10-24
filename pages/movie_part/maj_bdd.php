<?php
session_start();
$_SESSION['partie']='movie';
include("../struct/db_connect.php");
?>

<!doctype html>
<html>
	<head>
		<title>Mise à jour BDD</title>
		<meta charset="utf-8"  />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
		<!--Script javascript-->
		<script src="../../scripts/boite_dialogue.js" type="text/javascript"></script>	
		<!--Feuille de style-->
		<link rel="stylesheet" href="../style/largeScreen/style.css" />
		<link rel="stylesheet" href="../style/mobile/style.css" />
	</head>
	
	<body>
		<?php
			include('../struct/header.php');
			include('../struct/Cvector.php');
			
			///////////////////////////////////////
			//Permet de chercher dans un truc USB//
			///////////////////////////////////////
			function showDir($dir,$nbTabulation,&$vector)
			{
				$files1 = scandir($dir);
				for($j=0;$j<count($files1);$j++){
					$value = $files1[$j];
					//echo $value;
					if($value != ".." && $value != '.' && $value != ".Trash-1000" && $value != "affiche"){
						/////////////////////////////////////////////////
						//Enleve le format de la video si besoin
						//$value=explode(".",$value);
						//$value=$value[0];
						////////////////////////////////////////////////
			
						//echo $value;
						/////ECHO LES TABULATIONS POUR FAIRE L'ARBRE
						/*for($i=0;$i<$nbTab;$i++){
							echo "	";
						}*/
						//echo $value."\n";
						if(is_dir($dir."/".$value)){
							//echo $dir."/".$value;
							
							showDir($dir."/".$value,$nbTabulation+1,$vector);
						}
						else{
							$format=explode(".",$value);
							$format=$format[1];
							if ($format == "mp4" || $format == "ogv" || $format == "webm") {
								$vector->add($value,$dir);
							}
						}
						//echo $value;
					}
				}
				return $vector;
			}

			//MAIN
			$rqtAfficher = mysqli_query($link, "SELECT * FROM films") or die(mysql_error());

			//Initialisation de mes variables
			$vectorFilmUSB = new vector;
			$vectorFilmBDD = new vector;
			$nbTab=0;
			$dir = '../../Films';
			$dirAffiche = '../../Films/affiche';
			$films = array();

			//vectorFilmUSB est rempli par le contenu du fichier contenu dans le disque
			$vectorFilmUSB = showDir($dir,$nbTab,$vectorFilmUSB);


			//Affichage sur la page !
			print("<br />");print("<br />");print("<br />");print("<br />");print("<br />");
			print("<br /><h1>Film sur le disque :</h1>");
			print("<br />");
			$films = $vectorFilmUSB->getTab();
			for($i=0;$i<count($films);$i++)
			{
				echo "<br />".$films[$i][0];
			}
			echo "\n";
			print("<br />");
			print("<br /><h1>Film dans la base de donnée :</h1>");
			print("<br />");
			while ($row = mysqli_fetch_assoc($rqtAfficher)) {
				$titre=$row['titre'];
				$chemin=$row['chemin'];
				$vectorFilmBDD->add($titre,$chemin);
				echo "-> ".$titre."<br />";
			}
			//FIN Affichage sur la page des films present dans la base de données
			
			print("<br />");
			print("<br /><h1>Insertion dans la base de donnée :</h1>");
			print("<br />");

			//Insertion dans la base de donnée si le film n'existe pas '
			for($i=0;$i<$vectorFilmUSB->size();$i++){
				$existeDeja=false;
				$nomFilm=explode(".",$vectorFilmUSB->at1($i));
				$nomFilm=$nomFilm[0];
				for($j=0;$j<$vectorFilmBDD->size();$j++){
					if($nomFilm==$vectorFilmBDD->at1($j)){
						$existeDeja = true;
						echo "<br /> Ce film existe deja : ".$nomFilm;
					}
				}
				
				//Recuperation des donnees depuis les metadonnees
				//$commande = "exitfool -createdate ".$cheminFilm;
				//$date = exec($commande);
				
				
				$rqtInsertion = mysqli_prepare($link,"INSERT INTO `films`(`chemin`,`affiche`,`titre`) VALUES ( ?, ?, ?)") or die(mysql_error());
				if($existeDeja == false){
					$cheminFilm = $vectorFilmUSB->at2($i)."/".$vectorFilmUSB->at1($i);
					$cheminAffiche = $dirAffiche."/".$nomFilm.".jpg";
					$rqtInsertion->bind_param("sss",$cheminFilm, $cheminAffiche, $nomFilm);
					$rqtInsertion->execute();
					$rqtInsertion->close();
					echo "<br /> Ajout de : ".$nomFilm."<br />";
					
					
					//echo "<br />Rajout des tags initiaux :<br />";
					$input = array();
					$input=explode("/",$cheminFilm);
					//Supprimer le dernier élément à $input
					array_splice($input, -1);
					array_splice($input, 0, 3);
					
					/*for($j=0;$j<count($input);$j++)
					{
						echo $input[$j]."<br />";
					}*/
					
					$requete=mysqli_prepare($link,"	SELECT idfilm
													FROM films 
													WHERE titre = ?") or die(mysqli_error($link));
					$requete->bind_param("s",$nomFilm);
					$requete->execute();
					$requete->bind_result($idFilm);
					$requete->fetch();
					$requete->close();
						//echo "ID film : ".$idFilm." du film ".$nomFilm."<br />";
					
					
					for($j=0;$j<count($input);$j++){
						$idTag=NULL;
						
						$requete=mysqli_prepare($link,"	SELECT idTag 
														FROM tags 
														WHERE nomTag = ?") or die(mysqli_error($link));
						$requete->bind_param("s",$input[$j]);
						$requete->execute();
						$requete->bind_result($idTag);
						$requete->fetch();
						$requete->close();
						echo "Tag : ".$input[$j]." - ".$idTag."<br />";
						
						if($idTag == NULL){
						
							echo "Le tag ".$input[$j]." n'existe pas<br />";
							$requete = mysqli_prepare($link,"	INSERT 
																INTO `tags`(`nomTag`) 
																VALUES (?)")or die(mysqli_error($link));
							$requete->bind_param("s",$input[$j]);
							$requete->execute();
							$requete->fetch();
							$requete->close();
							
							$requete=mysqli_prepare($link,"	SELECT idTag 
															FROM tags 
															WHERE nomTag = ?") or die(mysqli_error($link));
							$requete->bind_param("s",$input[$j]);
							$requete->execute();
							$requete->bind_result($idTag);
							$requete->fetch();
							$requete->close();
							
							$requete = mysqli_prepare($link,"	INSERT 
																INTO `occurenceTags`(`idFilm`, `idTag`) 
																VALUES (?,?)")or die(mysqli_error($link));
							$requete->bind_param("ss",$idFilm,$idTag);
							$requete->execute();
							$requete->fetch();
							$requete->close();
						}else{
							echo "Le tag".$input[$j]." existe deja <br />";
							$requete = mysqli_prepare($link,"	INSERT 
																INTO `occurenceTags`(`idFilm`, `idTag`) 
																VALUES (?,?)")or die(mysqli_error($link));
							$requete->bind_param("ss",$idFilm,$idTag);
							$requete->execute();
							$requete->fetch();
							$requete->close();
							echo $idTag;
						}
					}
				}
				
				
				
			}
			
			/*echo "Affichage tableau vectorFilmUSB <br />";
			for($j=0;$j<$vectorFilmUSB->size();$j++){
				echo $vectorFilmUSB->at1($j)."<br />";
			}*/
			
			// supprimer de la bdd les films qui ne sont plus sur le disque
			print("<br />");
			echo "<br /><h1>Suppression de la base de données</h1><br />";
			print("<br />");
			for($i=0;$i<$vectorFilmBDD->size();$i++){
				$aSupprimer=true;
				$nomFilm=explode(".",$vectorFilmBDD->at1($i));
				$nomFilm=$nomFilm[0];
				//print("<br /> Comparaison : ".$nomFilm);
				for($j=0;$j<$vectorFilmUSB->size();$j++){
					$nomFilmUSB=explode(".",$vectorFilmUSB->at1($i));
					$nomFilmUSB=$nomFilmUSB[0];
					//echo "><".$nomFilmUSB."<br />";
					if($nomFilm==$nomFilmUSB){
						$aSupprimer = false;
						//echo "<br /> Ce film existe  : ".$nomFilm;
					}
				}
				$rqtInsertion = mysqli_prepare($link,"DELETE FROM `films` WHERE `titre` = ?") or die(mysql_error());
				if($aSupprimer == true){
					$rqtInsertion->bind_param("s",$nomFilm);
					$rqtInsertion->execute();
					echo "<br /> Enlevement de : ".$nomFilm;
				}
			}
			
		?>

	   <?php include('../struct/footer.html'); ?> 
	</body>
</html>
