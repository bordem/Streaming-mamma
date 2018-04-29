<?php session_start(); ?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Menu</title>
        <link rel="stylesheet" href="../style.css" />
    </head>
    
    <body>
        <!-- Haut de page -->
        <?php include('header.php'); ?>
        
        
        
        <!-- On vérifie le statut de l'utilisateur avant d'afficher la page -->
        <?php
            if($_SESSION['statut'] != "admin") {
                echo ("<p>Désolé, cette page est uniquement accessible aux comptes administrateurs !</p>");
                include('footer.html');
                exit();
            }
        ?>
        
        
        
        <!-- Corps de la page -->
        <h1>Menu administrateur</h1><br/>
        
        <p>
            - <a href="gerer_membres.php">Gérer les membres</a><br/>
            - <a href="gerer_films.php">Gérer les films</a><br/>
            - <a href="choix_film.php">Regarder des films</a><br/>
        </p>
        
        
        
        <!-- Bas de page (mentions légales, ...) -->
        <?php include('footer.html'); ?>
    </body>
</htlm>
