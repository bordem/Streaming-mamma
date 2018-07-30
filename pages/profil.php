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
	<?php include('header.php'); ?>
	
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
		</p>
		
		<h1>Derniers films regardés</h1>
		
		<!-- Supression des films vus dans la BDD -->
		<div>
			<form action="profil.php" method="post">
				<input type="submit" value="Supprimer mon historique" name="suppr_hist" />
				
			<?php 
				/*if(isset($_POST['suppr_hist'])){
					$requete_suppr = mysqli_prepare($link, "DELETE FROM historiqueFilms 
															WHERE idusr=?") or die(mysqli_error($link);
					$requete_suppr->bind_param("i",$idusr);
					$requete_suppr->execute();
					$requete_suppr->fetch();
					$requete_suppr->close();
					echo "<span class=\"info\">Historique supprimé !</span>";
				}*/
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
							echo "<td>
							<a href=lire_film.php?idfilm=".$idfilm.">".
							$titre."</br>
							<img src=\"".$affiche."\">
							</a><br/>
							</td>";
							$i++;
						}
					}
					$requete_films->close();
				?>
				</tr>
			</table>
			
			<h1>Films proposés</h1>
			<!-- TODO --> 
		
	</main>
	<?php include('footer.html'); ?>
</body>
</html>
