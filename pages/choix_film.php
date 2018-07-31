<?php

session_start(); 
include("db_connect.php");

?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Choix du film</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
        <link rel="stylesheet" href="style/style.css" />
		<script src="../scripts/boite_dialogue.js" type="text/javascript"></script>	
    </head>
    
    <body>
        <!-- Haut de page -->
        <?php include('header.php'); ?>
        <main>

        <?php
        	// On refuse l'accès si le visiteur n'est pas connecté -->
            if ($_SESSION['statut'] != "admin" 
            && $_SESSION['statut'] != "user") {
                echo("<div class=\"error\">Vous devez être connecté pour accéder à cette page.</div></main>");
                include('footer.html');
                exit();
            }
         $idpages=$_GET['pages'];
         ?>
        
        <h1>Tous les films</h1> <br/>
        <div id="searchbar">
            <form action="filmRecherche.php" method="post">
            	<input type="text" name="tagCherche" placeholder="Rechercher"/>
                <input type="submit" value="OK" />    
            </form>
        </div>
        
        <?php
        
        
        	$rqt ="SELECT COUNT(*) FROM films";
        	$requete = mysqli_query($link,$rqt);
        	while ($row = mysqli_fetch_assoc($requete)) {
        		$nbTotalFilms=$row['COUNT(*)'];
        		//echo "Nombre de films au total : ".$nbTotalFilms;
        	}
        ?>
        
        
        
        <!-- Tableau des films -->
        <table id="tableauFilms">
            <?php 
            $nbfilmparpages=15;
            $numeropages=0;
            $requete = mysqli_query($link, "SELECT * FROM films LIMIT ".$nbfilmparpages." OFFSET ".$nbfilmparpages*$idpages );
            $i=0;
            
            while ($row = mysqli_fetch_assoc($requete)) {
               	
                if($i%3 == 0)
				    echo "<tr>";
			?>
			    <td>
			    	<a href=<?php echo "lire_film.php?idfilm=".$row['idfilm']; ?>>
						<?php echo $row['titre']; ?></br>
						<img src="<?php echo $row['affiche']; ?>">
					</a><br/>
					<!-- <?php echo $row['anneesortie']; ?><br/>
					<?php echo $row['realisateur']; ?><br/> -->
				</td>
			<?php
			if($i%3==2)
			    echo "</tr>";
			$i=$i+1;
			}
		    ?>
		</table>
		<div class="pagination">
		<?php
		
			$nbPages=$nbTotalFilms/$nbfilmparpages;
			for($i=0;$i<$nbPages;$i++){
				echo "<a href=\"choix_film.php?pages=".$i."\">".$i."</a>";
			}
		?>
		</div>
		
		</main>
		<!-- Bas de page (mentions légales, ...) -->
		<?php include('footer.html'); ?>
    </body>
</html>
