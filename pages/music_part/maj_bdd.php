<?php
session_start();
$_SESSION['partie']='music';
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
					if($value != ".." && $value != '.' && $value != ".Trash-1000" && $value != "pochette"){
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
							if ($format == "mp3") {
								$vector->add($value,$dir);
							}
						}
						//echo $value;
					}
				}
				return $vector;
			}

			//MAIN
			

			//Initialisation de mes variables
			$vectorMusicUSB = new vector;
			$vectorMusicBDD = new vector;
			$vectorMusicChemin = new vector;
			$nbTab=0;
			$dir = '../../Musics';
			$dirAffiche = '../../Musics/pochette';
			$musics = array();

			//vectorMusicUSB est rempli par le contenu du fichier contenu dans le disque
			$vectorMusicUSB = showDir($dir,$nbTab,$vectorMusicUSB);
			$vectorMusicChemin->setTab($vectorMusicUSB->getTab());

			//Affichage sur la page !
			print("<br />");print("<br />");print("<br />");print("<br />");print("<br />");
			print("<br /><h1>Musiques sur le disque :</h1>");
			print("<br />");
			$musics = $vectorMusicUSB->getTab();
			for($i=0;$i<count($musics);$i++)
			{
				echo "<br />".$musics[$i][0];
			}
			echo "\n";
			print("<br />");
			print("<br /><h1>Musiques dans la base de donnée :</h1>");
			print("<br />");
			
			$rqtAfficher = mysqli_query($link, "SELECT * FROM music") or die(mysql_error());
			while ($row = mysqli_fetch_assoc($rqtAfficher)) {
				$titre=$row['titre'];
				$chemin=$row['chemin'];
				$vectorMusicBDD->add($titre,$chemin);
				echo " -> ".$titre." <br />";
			}
			
			//FIN Affichage des musiques dans la base de donnees au debut processus !
			
			print("<br />");
			print("<br /><h1>Insertion dans la base de donnée :</h1>");
			print("<br />");
			
			//Insertion dans la base de donnée si le film n'existe pas '
			for($i=0;$i<$vectorMusicUSB->size();$i++){
				$nomMusic=NULL;
				$existeDeja=false;
				
				//EXTRACT METADATA TITLE
				$title=NULL;
				$commande = "exiftool -b -Title ".$vectorMusicUSB->at2($i)."/".$vectorMusicUSB->at1($i);
				$title = exec($commande);
				if($title[0]== " "){
					$title = substr($title,1); 
				}
				if($title != NULL){
					$nomMusic=$title;
					$vectorMusicUSB->set($i,$nomMusic,$vectorMusicUSB->at2($i));
				}
				
				
				$nomMusic=explode(".",$vectorMusicUSB->at1($i));
				$nomMusic=$nomMusic[0];
				for($j=0;$j<$vectorMusicBDD->size();$j++){
					if($nomMusic==$vectorMusicBDD->at1($j)){
						$existeDeja = true;
						//echo "Cette musique existe deja : ".$nomMusic."<br />";
					}
				}
				
				/*
				*		EXTRACT METADATA
				*/
				
				
				
				$artiste=NULL;
				$commande = "exiftool -b -Artist ".$vectorMusicUSB->at2($i)."/".$vectorMusicChemin->at1($i);
				$artiste = exec($commande);
				
				/*
				$annee=NULL;
				$commande = "exiftool -b -Artist ".$vectorMusicUSB->at2($i)."/".$vectorMusicUSB->at1($i);
				$annee = exec($commande);
				*/
				
				$album=NULL;
				$commande = "exiftool -b -Album ".$vectorMusicUSB->at2($i)."/".$vectorMusicChemin->at1($i);
				$album = exec($commande);
				
				$cheminMusic = $vectorMusicUSB->at2($i)."/".$vectorMusicChemin->at1($i);
				
				echo "Chemin : ".$cheminMusic." <br />";
				$cheminAffiche = $dirAffiche."/".$nomMusic."";
				$new_string = str_replace(" ", "_", $cheminAffiche);
				$chemin=NULL;
				
				//Changement pour chemin , sinon plante a cause des espace
				
				$commande = "exiftool -a -Picture ".$vectorMusicUSB->at2($i)."/".$vectorMusicChemin->at1($i);
				if(exec($commande)!=NULL){
					$commande = "exiftool -b -Picture ".$vectorMusicUSB->at2($i)."/".$vectorMusicChemin->at1($i)." > ".$new_string;
					echo $commande."<br />";
					$chemin = exec($commande);
					exec("chmod 777 ".$new_string);
				}
				//echo "Creation image <br />";
				
				
				
				$rqtInsertion = mysqli_prepare($link,"INSERT INTO `music`(`chemin`,`pochette`,`titre`,`auteur`,`album`) VALUES ( ?, ?, ?, ?,?)") or die(mysql_error());
				if($existeDeja == false){
					$rqtInsertion->bind_param("sssss",$cheminMusic, $cheminAffiche, $nomMusic, $artiste,$album);
					$rqtInsertion->execute();
					$rqtInsertion->close();
					//echo "Chemin de l'affiche : ".$cheminAffiche."<br />";
					//echo "Chemin de la musique : ".$cheminMusic."<br />";
					echo "Ajout de : ".$nomMusic."<br />";
					
					
					//echo "<br />Rajout des tags initiaux :<br />";
					$input = array();
					$input=explode("/",$cheminMusic);
					//Supprimer le dernier élément à $input
					array_splice($input, -1);
					array_splice($input, 0, 3);
					
					/*for($j=0;$j<count($input);$j++)
					{
						echo $input[$j]."<br />";
					}*/
					
					$requete=mysqli_prepare($link,"	SELECT idmusic
													FROM music 
													WHERE titre = ?") or die(mysqli_error($link));
					$requete->bind_param("s",$nomMusic);
					$requete->execute();
					$requete->bind_result($idMusic);
					$requete->fetch();
					$requete->close();
						//echo "ID music : ".$idMusic." de la musique ".$nomMusic."<br />";
						//echo "<br />";
					
					/*for($j=0;$j<count($input);$j++){
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
																INTO `occurenceTags`(`idMusic`, `idTag`) 
																VALUES (?,?)")or die(mysqli_error($link));
							$requete->bind_param("ss",$idMusic,$idTag);
							$requete->execute();
							$requete->fetch();
							$requete->close();
						}else{
							echo "Le tag".$input[$j]." existe deja <br />";
							$requete = mysqli_prepare($link,"	INSERT 
																INTO `occurenceTags`(`idMusic`, `idTag`) 
																VALUES (?,?)")or die(mysqli_error($link));
							$requete->bind_param("ss",$idMusic,$idTag);
							$requete->execute();
							$requete->fetch();
							$requete->close();
							echo $idTag;
						}
					}*/
				}
				
				
				
			}
			
			/*echo "Affichage tableau vectorMusicUSB <br />";
			for($j=0;$j<$vectorMusicUSB->size();$j++){
				echo $vectorMusicUSB->at1($j)."<br />";
			}*/
			
			// supprimer de la bdd les musics qui ne sont plus sur le disque
			print("<br />");
			echo "<br /><h1>Suppression de la base de données</h1><br />";
			print("<br />");
			
			for($i=0;$i<$vectorMusicBDD->size();$i++){
				//echo "VectorMusicBDD[".$i."]";
				$aSupprimer=true;
				$nomMusic=explode(".",$vectorMusicBDD->at1($i));
				$nomMusic=$nomMusic[0];
				//print("<br /> COMPARAISON : ".$nomMusic."<br />");
				
				for($j=0;$j<$vectorMusicUSB->size();$j++){
					
					//echo "VectorMusicBDD[".$i."] : ".$vectorMusicBDD->at1($i)." >< VectorMusicUSB[".$j."] : ".$vectorMusicUSB->at1($j)."<br />";
					//echo " ___".$vectorMusicUSB->at1($j)."___<br />";
					$nomMusicUSB=explode(".",$vectorMusicUSB->at1($j));
					$nomMusicUSB=$nomMusicUSB[0];
					//echo "><".$nomMusicUSB."<br />";
					
					//echo "VectorMusicBDD[".$i."] : ".$vectorMusicBDD->at1($i)." >< VectorMusicUSB[".$j."] : ".$nomMusicUSB."<br />";

					if($nomMusic==$nomMusicUSB){
						$aSupprimer = false;
					}
				}
				if($aSupprimer==false){
					echo "Cette musique existe des deux cotés  : ".$nomMusic."<br />";
				}
				$rqtSuppression = mysqli_prepare($link,"DELETE FROM `music` WHERE `titre` = ?") or die(mysql_error());
				if($aSupprimer == true){
					$rqtSuppression->bind_param("s",$nomMusic);
					$rqtSuppression->execute();
					$rqtSuppression->close();
					echo "<br /> Enlevement de : ".$nomMusic."<br /><br />";
				}
			}
			
			print("<br />");
			print("<br /><h1>FIN</h1>");
			print("<br />");
		?>

	   <?php include('../struct/footer.html'); ?> 
	</body>
</html>
