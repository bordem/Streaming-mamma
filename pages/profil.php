<?php 
	session_start();
	include("db_connect.php");
?>

<!doctype html>

<html>
<head>
	<meta charset="utf-8" />
		<title>Mon profil</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
		<link rel="stylesheet" href="style/style.css" />
		<script src="../scripts/boite_dialogue.js" type="text/javascript"></script>	
</head>
<body>
	<?php 	include('header.php'); 
			include('Cvector.php');
	?>
	
	<main>
	<?php 
	
		// On refuse l'accès si le visiteur n'est pas connecté
			if ($_SESSION['statut'] != "admin" 
			&& $_SESSION['statut'] != "user") {
			echo("<p class=\"error\">Vous devez être connecté pour accéder à cette page.</p>
				</main>");
				include('footer.html');
				exit();
			}

			$idusr=$_SESSION['userId'];

			if(isset($_POST['profil'])) { // bouton connexion cliqué
				if(!empty($_POST['pseudo'])) {
					$nouveauPseudo=$_POST['pseudo'];
					$requetePseudo = "UPDATE `utilisateurs` SET `login`= \"".$nouveauPseudo."\"  WHERE `idusr`=".$idusr."";
					mysqli_query($link, $requetePseudo);
				}
				if(!empty($_POST['prenom'])) {
					$nouveauPrenom=$_POST['prenom'];
					$requetePrenom = "UPDATE `utilisateurs` SET `prenom`= \"".$nouveauPrenom."\"  WHERE `idusr`=".$idusr."";
					mysqli_query($link, $requetePrenom);
				}
				if(!empty($_POST['nom'])) {
					$nouveauNom=$_POST['nom'];
					$requeteNom = "UPDATE `utilisateurs` SET `nom`= \"".$nouveauNom."\"  WHERE `idusr`=".$idusr."";
					mysqli_query($link, $requeteNom);
				}
			
			}


		 ?>
			 
		<h1>Mon profil</h1>
		<p>
			<?php
			$requete_nomPrenom = mysqli_prepare($link, "SELECT nom, prenom 
														FROM utilisateurs 
														WHERE idusr=?") or die(mysqli_error($link));
			$requete_nomPrenom->bind_param("i",$idusr);
			$requete_nomPrenom->execute();
			$requete_nomPrenom->bind_result($nom, $prenom);
			$requete_nomPrenom->fetch();
			$requete_nomPrenom->close();
			?>
			Pseudo : <?php echo $_SESSION['login']; ?></br>
			Nom : <?php echo $nom; ?></br>
			Prenom :<?php echo $prenom; ?></br>
			</br>
			<!-- Edition du profil avec changement de toutes les données -->
			<div>
				<form action="profil.php" method="post"><br />
					Veuillez saisir votre surnom :
					<input type="text" name="pseudo" value="" /><br />
					Veuillez saisir votre prénom :
					<input type="text" name="prenom" value="" /><br />
					Veuillez saisir votre nom :
					<input type="text" name="nom" value="" /><br />
					
					<input type="submit" value="Editer profil" name="profil" />
				</form>
			</div>
			
		</p>
		
		<h1>Derniers films regardés</h1>

		<!-- Supression des films vus dans la BDD -->
			<div id="buttonHistorique">
				<form action="profil.php" method="post">
					<input type="submit" value="Supprimer mon historique" name="suppr_hist" />
					
				<?php 
					if(isset($_POST['suppr_hist']))
					{
						$rqtSuppression = "DELETE FROM historiqueFilms WHERE idusr=".$idusr;
						mysqli_query($link, $rqtSuppression);
						echo "<span class=\"info\">Historique supprimé !</span>";
					}
				?>
				</form>
			</div>

<?php
				// On récupère les films regardés par cet utisateur
				$rqt1="SELECT idfilm, titre, affiche 
					FROM historiqueFilms JOIN films USING(idfilm) 
					WHERE idusr= ? ORDER BY date DESC";
				$requete_films = mysqli_prepare($link, $rqt1) or die(mysqli_error($link));
				$requete_films->bind_param("i",$idusr);
				$requete_films->execute();
				$requete_films->bind_result($idfilm,$titre,$affiche);

			?>
			
			
			
			<!-- Affichage -->
			<table id="historique">
				<tr>
					<?php
					$i = 0;
					while ( $requete_films->fetch() ) { 
						// On affiche les 5 derniers films disctincts
						if ($i<=4) {
							?>	<td>
										
										<a href= "lire_film.php?idfilm= <?php echo $idfilm; ?>">
											<?php echo $titre; ?>
											<?php if(is_file($affiche)){ ?>
												<img src="<?php echo $affiche; ?>">
											<?php 
											}else{
												echo "<img src=\"../images/unknown_poster.jpg\">";
											}
											?>
										</a>
										<br/>
									</td>
							<?php $i++;
						}
					}
					
					
								
					
					
					
					$requete_films->close();
				?>
				</tr>
			</table>			
			<h1>Films proposés</h1>
			<!-- TODO -->
			<?php
			//echo "chier";
			$vectorTag = new vector;
			$tabFilm=array();
			$k=0;
			$rqtPredictionStr = "SELECT `idfilm` FROM `historiqueFilms` WHERE `idusr`=".$idusr;
			//echo $rqtPredictionStr;
			$rqtPrediction=mysqli_query($link, $rqtPredictionStr);
			while ($row = mysqli_fetch_assoc($rqtPrediction))
			{
				$tabFilm[$k]=$IDfilm;
				$k++;
				$IDfilm=$row['idfilm'];
				//echo "L'id du film : ".$IDfilm."</br>";
				$rqtPredictionStr2 = "SELECT idTag FROM `occurenceTags` WHERE `idFilm`=".$IDfilm;
				//echo $rqtPredictionStr2;
				$rqtPrediction2=mysqli_query($link, $rqtPredictionStr2);
				while ($row2 = mysqli_fetch_assoc($rqtPrediction2))
				{
					//echo "L'id du Tag : ".$row2['idTag']."</br>";
					$TagExisteDeja=false;
					for($i=0;$i<$vectorTag->size();$i++)
					{
						//Si le tag existe deja on incrémente son nombre de 1
						$elementAComparer = $vectorTag->at1($i);
						//echo "Element : ".$elementAComparer."</br>";
						if($elementAComparer==$row2['idTag']){
							$TagExisteDeja=true;
							//echo "True </br>";
							$vectorTag->set($i,$row2['idTag'],$vectorTag->at2($i)+1);
							//echo "Le tag existe deja </br>";
						}
					}
					//sinon on crée un nouveau tag dans le tableau
					if($TagExisteDeja==false){
						$vectorTag->add($row2['idTag'],1);
						//echo "Le tag n'existe pas </br>";
					}
					
				}
			}
			//echo "Je sors de la boucle </br>";
			//Tri a bulle selon les tags les plus visionne
			for($i=0;$i<$vectorTag->size();$i++){
				//echo $i." ".$vectorTag->at1($i)." ".$vectorTag->at2($i)." </br>";
				for($j=0;$j<$vectorTag->size()-1;$j++){
					//echo " </br>".$vectorTag->at2($i).">".$vectorTag->at2($j);
					//echo "</br>";
					if($vectorTag->at2($j)>$vectorTag->at2($j+1))
					{
							$Switch=array();
							$Switch2=array();
							$Switch[0]=$vectorTag->at1($j+1);
							$Switch2[0]=$vectorTag->at2($j+1);
							$vectorTag->set($j+1,$vectorTag->at1($j),$vectorTag->at2($j));
							$vectorTag->set($j,$Switch[0],$Switch2[0]);
					}
				}
			}
			//Verification du tri a bulle
			/*for($i=0;$i<$vectorTag->size();$i++){
				echo $i." ".$vectorTag->at1($i)." ".$vectorTag->at2($i)." </br>";
			}*/
			
			
			/*
				Recherche du film avec les mêmes tags que ceux regarder par la personne
			*/
			for($i=0;$i<$vectorTag->size();$i++){
				$rechercheSuggestion ="SELECT `idFilm` FROM `occurenceTags` WHERE `idTag`=";
			}
			?>
	</main>
	<?php include('footer.html'); ?>
</body>
</html>
