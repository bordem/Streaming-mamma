<?php
session_start();
$_SESSION['partie']='neutre';
include("../struct/db_connect.php");
?>

<!doctype html>
<html>
    
    <head>
        <title>Membres</title>
        <meta charset="utf-8"  />
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="shortcut icon" type="image/x-icon" href="../../images/icon.ico" />
		<!--Feuille de style-->
		<link rel="stylesheet" href="../style/largeScreen/style.css" />
        <link rel="stylesheet" href="../style/mobile/style.css" />
        <!--Script Javascript-->
        <script src="../../scripts/boite_dialogue.js" type="text/javascript"></script>	
    </head>
    
    <body>
    
        <?php include('../struct/header.php'); ?>
        <main class="gestion">
        
        
        <?php
        // On vérifie le statut de l'utilisateur avant d'afficher la page
        
            if($_SESSION['statut'] != "admin") {
                echo ("<p class=\"error\">Désolé, cette page est uniquement accessible aux comptes administrateurs !</p>");
                include('footer.html');
                exit();
            }
        ?>



        <?php

        // MODIFICATION DE LA BD -------------------------------------------------

        if(isset($_POST['ajout'])) {
            $pseudo = $_POST['login_add'];
            $pass = $_POST['password'];
            $stat = $_POST['statut'];
            $nom = $_POST['nom_add'];
            $prenom = $_POST['prenom_add'];

			$requete = mysqli_prepare($link, "INSERT INTO utilisateurs (login, passwd, prenom, nom, statut) VALUES (?, PASSWORD(?),?,?,?)") or die(mysqli_error($link));
			$requete->bind_param("sssss", $pseudo, $pass, $nom, $prenom, $stat);
            if (mysqli_execute($requete)) {
                echo "<span class=\"info\">Membre ajouté avec succès.</span>";
            }
            else {
                echo "<span class=\"error\">Erreur dans l'ajout: " . mysqli_error($_SESSION['link'])." Veuillez recommencer.</span>";
            }
			$requete->close();
        }

        if(isset($_POST['supression'])) {
            $pseudo = $_POST['login_sup'];
            
			$requete2 = mysqli_prepare($link,"DELETE FROM utilisateurs WHERE login = ?") or die(mysqli_error($link));
			$requete2->bind_param("s",$pseudo);
            if (mysqli_execute($requete2)) {
                echo "<span class=\"info\">Membre supprimé avec succès.</span>";
            } else {
                echo "<span class=\"error\">Erreur dans la supression: " . mysqli_error($link)." Veuillez recommencer.</span>";
            }
			$requete2->close();
        }
        ?>


        <h1>Tous les membres</h1><br/>
        <?php

            // TABLEAU DES MEMBRES -----------------------------------------------    
            
            $rqtAfficher = mysqli_query($link, "SELECT * FROM utilisateurs") or die(mysql_error());
            
            echo "<table cellspacing=\"0\" border=\"1\"><tr><th>Pseudo</th><th>Statut</th><th>Prénom</th><th>Nom</th></tr>";
            while ($row = mysqli_fetch_assoc($rqtAfficher)) {
		        echo "<tr><td>".$row["login"]."</td><td>".$row["statut"]."</td><td>".$row['prenom']."</td><td>".$row['nom']."</td></tr>";
	        }
			$rqtAfficher->close();
			echo"</table><br/>";

        ?>
        


        <!-- FORMULAIRE---------------------------------------------->
       
        <h1>Ajouter un membre</h1><br/>
            
        <form action="gerer_membres.php" method="post">
        <table>
            <tr><td>Login :</td>
                <td><input name="login_add" type="text"></td></tr>
                
            <tr><td>Mot de passe :</td>
                <td><input name="password" type="text"></td></tr>
                
            <tr><td>Nom :</td>
                <td><input name="nom_add" type="text"></td></tr>
                
            <tr><td>Prenom :</td>
                <td><input name="prenom_add" type="text"></td></tr>
                
            <tr><td>Statut :</td>
                <td><input type="radio" id ="statutAdmin" name="statut" value="admin">
                <label for="statutAdmin">Administrateur</label>
                    
                <input type="radio" id ="statutUser" name="statut" value="user">
                <label for="statutUser">Utilisateur</label></td></tr>
        </table><br/>
        <input type="submit" name="ajout" value="Valider"/></form>
            
        <h1>Supprimer un membre</h1><br/>
            
        <form action="gerer_membres.php" method="post">
            Login : <input name="login_sup" type="text">
            <input type="submit" name="supression" value="Valider"/>
        </form>
            
            
        </main>
        <?php include('../struct/footer.html'); ?>
    </body>
</html>
