<?php session_start();
$_SESSION['login'] = "visiteur";
$_SESSION['statut'] = "deconnecte";

$_SESSION['link1'] = "borde";
// $_SESSION['link1'] = "pi";
$_SESSION['link2'] = "tougrise";
// $_SESSION['link2'] = "raspberry";
$_SESSION['link3'] = "site_martin";
// $_SESSION['link3'] = "pi";


$_SESSION['link'] = mysqli_connect("localhost","pi","raspberry","site_martin"); ?>

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
			echo "Salut";
            $pass = $_POST['password'];
			echo "Salut";
            $link = mysqli_connect("localhost", $_SESSION['link1'], $_SESSION['link2'], $_SESSION['link3']);
			echo "Salut";            
			$requete = mysqli_query($link, "SELECT * FROM utilisateurs WHERE login = '".$pseudo."' AND passwd = '".$pass."'") or die(mysql_error());
			echo "Salut";
            if(mysqli_num_rows($requete) == 0) {
                echo "L'identifiant ou le mot de passe est incorrect. Le compte n'a pas été trouvé.";
            }
            else {
                $_SESSION['login'] = $pseudo;
                
                $stat = mysqli_query($_SESSION['link'], "SELECT statut FROM utilisateurs WHERE login = '".$pseudo."' AND passwd = '".$pass."'") or die(mysql_error());

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
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style/style.css" />
</head>
    
<body>
    <?php include('header.php'); ?>
    <main>
        <h1>On vous connait ?</h1>
        <div class="form-group">
        <form action="connexion.php" method="post">
            <div class="col-sm-12">
                <div class="col-sm-5"></div>
                <input class="col-sm-2" type="text" name="pseudo" value="" placeholder="Pseudo"/><br/>
                <div class="col-sm-5"></div>
            </div>
            
            <div class="col-sm-12">
                <div class="col-sm-5"></div>
                <input class="col-sm-2" type="password" name="password" value="" placeholder="Mot de passe"/><br/>
                <div class="col-sm-5"></div>
            </div>
             
            <input class ="boutton" type="submit" name="connexion" value="Connexion" />
        </form>
        </div>
    </main>
</body>
<?php include('footer.html'); ?>

</html>
