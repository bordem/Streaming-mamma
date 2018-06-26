<?php
session_start(); 
include("db_connect.php");
?>

<!doctype html>
<html>
    
    <head>
        <title>Membres</title>
        <meta charset="utf-8"  />
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
		
		<link rel="stylesheet" href="style/style.css" />
    </head>
    
    <body>
    
        <?php include('header.php'); ?>
        <main class="gestion">
        
        
        <?php
        // On vérifie le statut de l'utilisateur avant d'afficher la page
        
            if($_SESSION['statut'] != "admin") {
                echo ("<p>Désolé, cette page est uniquement accessible aux comptes administrateurs !</p>");
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
            
			$requete = mysqli_prepare($link, "INSERT INTO utilisateurs (login, passwd, statut) VALUES (? ,? ,?)") or die(mysqli_error($link));
			$requete->bind_param("sss",$pseudo,$pass,$stat);
            if (mysqli_execute($requete)) {
                echo "Membre ajouté avec succès.";
            }
            else {
                echo "Erreur dans l'ajout: " . mysqli_error($_SESSION['link'])." Veuillez recommencer.";
            }
        }

        if(isset($_POST['supression'])) {
            $pseudo = $_POST['login_sup'];
            
			$requete2 = mysqli_prepare("DELETE FROM utilisateurs WHERE login = ?") or die(mysqli_error($link));
			$requete2->bind_param($pseudo);
            if (mysqli_execute($requete2)) {
                echo "Membre supprimé avec succès.";
            } else {
                echo "Erreur dans la supression: " . mysqli_error($link)." Veuillez recommencer.";
            }
        }
        ?>


        <h1>Tous les membres</h1><br/>
        <?php

            // TABLEAU DES MEMBRES -----------------------------------------------    
            
            $rqtAfficher = mysqli_query($link, "SELECT * FROM utilisateurs") or die(mysql_error());
            
            echo "<table cellspacing=\"0\" border=\"1\"><tr><th>Pseudo</th><th>Mot de passe</th><th>Statut</th></tr>";
            while ($row = mysqli_fetch_assoc($rqtAfficher)) {
		        echo "<tr><td>".$row["login"]."</td><td>" . $row["passwd"]. "</td><td>".$row["statut"]."</td></tr>";
	        }
	        echo"</table><br/>";
        ?>
        


        <!-- FORMULAIRE---------------------------------------------->
       
        <h1>Ajouter un membre</h1><br/>
            
        <form action="gerer_membres.php" method="post"><table>
            <tr><td>Login :</td>
                <td><input name="login_add" type="text"></td></tr>
                
            <tr><td>Mot de passe :</td>
                <td><input name="password" type="text"></td></tr>
                
            <tr><td>Statut :</td>
                <td><input type="radio" id ="statutAdmin" name="statut" value="admin">
                <label for="statutAdmin">Administrateur</label>
                    
                <input type="radio" id ="statutUser" name="statut" value="user">
                <label for="statutUser">Utilisateur</label></td></tr>
        </table><br/>
        <input type="submit" name="ajout" value="Valider"/></form>
            
        <h1>Supprimer un membre</h1><br/>
            
        <form action="gerer_membres.php" method="post">
            Login : <input name="login_sup" type="text"><br/>
            <input type="submit" name="supression" value="Valider"/>
        </form>
            
            
        </main>
        <?php include('footer.html'); ?>
    </body>
</html>
