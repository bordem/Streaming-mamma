<?php session_start();
$_SESSION['login'] = "visiteur";
$_SESSION['statut'] = "deconnecte";

$_SESSION['link1'] = "pi";
$_SESSION['link2'] = "raspberry";
$_SESSION['link3'] = "pi";


$link1 = $_SESSION['link1'];
$link2 = $_SESSION['link2'];
$link3 = $_SESSION['link3'];

$link = mysqli_connect("localhost",$link1,$link2,$link3); ?>

<!doctype html>
<html>
<?php

if(isset($_POST['connexion'])) { // bouton connexion cliqué
    if(empty($_POST['pseudo'])) {
        echo "Le champ Identifiant est vide.";
    }
    else {
        if(empty($_POST['password'])) {
            echo "Le champ Mot de passe est vide.";
        }
        else {
			echo "Salut";
            $pseudo = $_POST['pseudo'];
            $pass = $_POST['password'];
            $link = mysqli_connect("localhost", $_SESSION['link1'], $_SESSION['link2'], $_SESSION['link3']);           
			$requete = mysqli_query($link, "SELECT * FROM utilisateurs WHERE login = '".$pseudo."' AND passwd = '".$pass."'") or die(mysql_error());
            if(mysqli_num_rows($requete) == 0) {
                echo "L'identifiant ou le mot de passe est incorrect. Le compte n'a pas été trouvé.";
            }
            else {
                $_SESSION['login'] = $pseudo;
                
                $stat = mysqli_query($link, "SELECT statut FROM utilisateurs WHERE login = '".$pseudo."' AND passwd = '".$pass."'") or die(mysql_error());

                while ($row = mysqli_fetch_assoc($stat)) {
					echo "statut : {$row['statut']} <br>";
					$stat = $row['statut'];
					echo $stat;
				}
				
				$_SESSION['statut'] = $stat;
                header("Location: choix_film.php"); // Redirection du navigateur
                mysqli_close($_SESSION['link']);
            
            }
        }
    }
}
?>

<head>
    <title>Connexion</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
    <link rel="stylesheet" href="style/style.css" />
</head>
    
<body>
    <?php include('header.php'); ?>
    <main>
        <div id="formulaireConnexion">
        <h1>On vous connait ?</h1>
        <form action="connexion.php" method="post">
                <input type="text" name="pseudo" value="" placeholder="Pseudo"/><br/>
                <input type="password" name="password" value="" placeholder="Mot de passe"/><br/>
            <input class ="boutton" type="submit" name="connexion" value="Connexion" />
        </form>
        </div>
    </main>
</body>
<?php include('footer.html'); ?>

</html>
