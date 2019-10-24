<?php
session_start();
$_SESSION['login'] = "visiteur";
$_SESSION['statut'] = "deconnecte";

header("Location: ../struct/connexion.php");

?>
