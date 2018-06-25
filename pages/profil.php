<?php session_start(); ?>

<!doctype html>

<html>
<head>
    <meta charset="utf-8" />
        <title>Mon profil</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
        <link rel="stylesheet" href="style/style.css" />
</head>
<body>
    <?php include('header.php'); ?>
    
    <main>
    <?php 
    
    	/*class vector {
                private $_arrayList=array();
               	private $_tailleTableau=0;
               
                public function add($data) {
                    $this->_arrayList[$this->_tailleTableau]=$data;
                    $this->_tailleTableau++;
                }
                public function size(){
                	return $this->_tailleTableau;
                }
                public function getTab(){
                	return $this->_arrayList;
                }
                public function at1($i){
                	return $this->_arrayList[$i];
                }
            } 
    	function verification($id,&$tab){
        	for($i=0;$i<$tab->size();$i++){
		    	if($id == $tab[$i]){
		    		return "false";
		    		echo "echo le film y est deja";
		    	}
		    }
        	return "true";
        	echo "Le film n'y est pas";
        }*/
        
        // On refuse l'accès si le visiteur n'est pas connecté
            if ($_SESSION['statut'] != "admin" 
            && $_SESSION['statut'] != "user") {
                echo("<p>Vous devez être connecté pour accéder à cette page.</p>");
                include('footer.html');
                exit();
            }
            
            $link1 = $_SESSION['link1'];
            $link2 = $_SESSION['link2'];
            $link3 = $_SESSION['link3'];
            $link = mysqli_connect("localhost",$link1,$link2,$link3);
                
            // On récupère l'id de l'utilisateur
            $rqt2 = "SELECT idusr FROM utilisateurs WHERE login='".$_SESSION['login']."'";
            $requete_id = mysqli_query($link, $rqt2) or die(mysql_error());
            while ($row = mysqli_fetch_assoc($requete_id)) {                       
                $idusr = $row['idusr'];
            }
         ?>
             
        <h1>Mon profil</h1>
        <p>
        	<?php 
        	$rqt = "SELECT `nom`,`prenom` FROM `utilisateurs` WHERE `idusr`=".$idusr."";
            $requete_nomPrenom = mysqli_query($link, $rqt) or die(mysql_error());
            while ($row = mysqli_fetch_assoc($requete_nomPrenom)) {                       
                $nom = $row['nom'];
                $prenom = $row['prenom'];
            }
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
            </form>
        </div>
                
            <?php 
                if(isset($_POST['suppr_hist'])){
                    $requete_suppr = mysqli_query($link, "DELETE FROM historiqueFilms WHERE idusr=".$idusr);
                    echo "Historique supprimé !";
                }
                    
                // On récupère les films regardés par cet utisateur
                $rqt1="SELECT `idfilm`, `date` FROM `historiqueFilms` WHERE `idusr`=".$idusr." ORDER BY `date` DESC ";
                $requete_films = mysqli_query($link, $rqt1) or die(mysql_error());
            ?>
            
            <!-- Affichage -->
            <table id="historique">
                <tr>
                    <?php
                    $i = 0;
                    while ($row = mysqli_fetch_assoc($requete_films) ) {                       
                        $idfilm = $row['idfilm'];
                        $date = $row['date'];
                        
                        // On récupère le titre et l'affiche du film
                        $requete_afficher = mysqli_query($link, "SELECT idfilm, titre, affiche FROM films WHERE idfilm=".$idfilm) or die(mysql_error());
                        while ($row = mysqli_fetch_assoc($requete_afficher)) {
                            // On affiche les 5 derniers films disctincts
		                    if ($i<=4) {
		                            echo "<td>
					        	    <a href=lire_film.php?idfilm=".$row['idfilm'].">".
								    $row['titre']."</br>
								    <img src=\"".$row['affiche']."\">
							        </a><br/>
						            </td>";
						            $i = $i+1;
						        }
						    }
                     	}
                    ?>
                </tr>
            </table>
            
            <h1>Films proposés</h1>
            
        
    </main>
    <?php include('footer.html'); ?>
</body>
</html>
