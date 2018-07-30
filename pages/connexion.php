<?php
	session_start();
	$_SESSION['statut']='other';
	include("db_connect.php");


?>
<!doctype html>
<html>
<head>
    <title>Connexion</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
    <link rel="stylesheet" href="style/style.css" />
		<script src="../scripts/boite_dialogue.js" type="text/javascript"></script>	
</head>
<body>
    <?php include('header.php'); ?>
    <main>
        <div id="formulaireConnexion">
        <h1>On vous connait ?</h1>
<?php
if(isset($_POST['connexion'])) { // bouton connexion cliqué
    if(empty($_POST['pseudo'])) {
        echo "<span class=\"error\">Le champ Identifiant est vide.</span><br />";
    }
	else if(empty($_POST['password'])) {
		echo "<span class=\"error\">Le champ Mot de passe est vide.</span><br />";
	}
	else {
		$pseudo = $_POST['pseudo'];
		$pass = $_POST['password'];
		$requete = mysqli_prepare($link, "SELECT statut, idUsr FROM utilisateurs WHERE login = ? AND passwd = PASSWORD(?)") or die(mysqli_error($link));
		$requete->bind_param("ss", $pseudo, $pass);
		$requete->execute();
		$requete->bind_result($stat, $idusr);
		$requete->fetch();
		$requete->close();

		if( empty($stat) ){ 
			echo "<span class=\"error\">L'identifiant ou le mote de passe est incorrect.</span><br/>";
		}
		else {
			$_SESSION['login'] = $pseudo;
			$_SESSION['statut'] = $stat;
			$_SESSION['userId'] = $idusr;
			mysqli_close($link);
			header("Location: choix_film.php"); // Redirection du navigateur
		}
	}
}
?>
        <form action="connexion.php" method="post">
		<input type="text" name="pseudo" value="<?php echo (isset($_POST['pseudo']) ? $_POST['pseudo'] : ""); ?>" placeholder="Pseudo"/><br/> 
                <input type="password" name="password" value="" placeholder="Mot de passe"/><br/>
            <input class ="boutton" type="submit" name="connexion" value="Connexion" />
        </form>
        </div>
    </main>
</body>
<?php include('footer.html'); ?>

</html>
