<?php
/**/
// Utilisateur chez nicolai
$dbuser = "st_mamma";
$dbpasswd = "68badf1397604fd2a2fb66bc6d282c23";
$dbname = "st_mamma";
/*/
// utilisateur de la pi
$dbuser = "pi";
$dbpasswd = "raspberry";
$dbname = "pi";
/**/




$link = mysqli_connect("localhost", $dbuser, $dbpasswd, $dbname);

if ( mysqli_connect_error() ){
	printf("Échec de la connexion : %s\n", mysqli_connect_error());
	die();
}

?>
