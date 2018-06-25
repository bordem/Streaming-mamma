<?php session_start(); ?>

<!doctype html>


<html>
    <head>
        <meta charset="utf-8" />
        <title>Choix du film</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
        <link rel="stylesheet" href="style/style.css" />
    </head>
    
    <body>
        <!-- Haut de page -->
        <?php include('header.php'); ?>
        <main>



        <!-- On refuse l'accès si le visiteur n'est pas connecté -->
        <?php
            if ($_SESSION['statut'] != "admin" 
            && $_SESSION['statut'] != "user") {
                echo("<p>Vous devez être connecté pour accéder à cette page.</p>");
                include('footer.html');
                exit();
            }
         ?>



        
        <h1>Tous les films</h1> <br/>
        <div id="searchbar">
            <form action="filmRecherche.php" method="post">
            	<input type="text" name="tagCherche" placeholder="Rechercher"/>
                <input type="submit" value="OK" />    
            </form>
        </div>
        
        <!-- On affiche un tableau des films -->
        <table id="tableauFilms">
            <?php 
            $link1 = $_SESSION['link1'];
            $link2 = $_SESSION['link2'];
            $link3 = $_SESSION['link3'];
            
            $link = mysqli_connect("localhost",$link1,$link2,$link3);
            
            $requete = mysqli_query($link, "SELECT * FROM films");
            $i=0;
            while ($row = mysqli_fetch_assoc($requete)) {
                if($i%3 == 0)
				    echo "<tr>";
			?>
				    
            <p>
			    <td>
			    	<a href=<?php echo "lire_film.php?idfilm=".$row['idfilm']; ?>>
						<?php echo $row['titre']; ?></br>
						<img src="<?php echo $row['affiche']; ?>">
					</a><br/>
					<!-- <?php echo $row['anneesortie']; ?><br/>
					<?php echo $row['realisateur']; ?><br/> -->
				</td>
			</p>
			
			<?php
			if($i%3==2)
			    echo "</tr>";
			$i=$i+1;
			}
		    ?>
		</table>
		
		</main>
		<!-- Bas de page (mentions légales, ...) -->
		<?php include('footer.html'); ?>
    </body>
</htlm>
