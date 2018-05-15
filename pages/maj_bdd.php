<?php session_start(); ?>

<!doctype html>
<html>
    
    <head>
        <title>Màj BDD</title>
        <meta charset="utf-8"  />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="shortcut icon" type="image/x-icon" href="../images/icon.ico" />
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" href="style/style.css" />
    </head>
    
    <body>
        <?php
            include('header.php');
            ////////////////////////////////////
            //CLASS vector , tableau dynamique//
            ////////////////////////////////////
            class vector {
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
                public function at($i){
                	return $this->_arrayList[$i];
                }
            } 

            ///////////////////////////////////////
            //Permet de chercher dans un truc USB//
            ///////////////////////////////////////
            function showDir($dir,$nbTabulation,&$vector)
            {
	            $files1 = scandir($dir);
	            for($j=0;$j<count($files1);$j++){
		            $value = $files1[$j];
		            //echo $value;
		            if($value != ".." && $value != '.' && $value != ".Trash-1000" && $value != "affiche"){
			            /////////////////////////////////////////////////
			            //Enleve le format de la video si besoin
			            //$value=explode(".",$value);
			            //$value=$value[0];
			            ////////////////////////////////////////////////
			
			            //echo $value;
			            /////ECHO LES TABULATIONS POUR FAIRE L'ARBRE
			            /*for($i=0;$i<$nbTab;$i++){
				            echo "	";
			            }*/
			            //echo $value."\n";
			            if(is_dir($dir."/".$value)){
				            //echo $dir."/".$value;
				            showDir($dir."/".$value,$nbTabulation+1,$vector);
			            }
			            else{
				            $vector->add($value);
			            }
			            //echo $value;
		            }
	            }
	            return $vector;
            }

            //MAIN
            //Connexion a la base de données et récupération de la base de donnée
            $link = mysqli_connect("localhost","pi","raspberry","site_martin");
            $rqtAfficher = mysqli_query($link, "SELECT * FROM films") or die(mysql_error());

            //Initialisation de mes variables
            $vectorFilmUSB = new vector; 
            $vectorFilmBDD = new vector; 
            $nbTab=0;
            $dir = '../Films';
            $dirAffiche = '../Films/affiche';
            $films = array();

            //vectorFilmUSB est rempli par le contenu du fichier contenu dasn le disque
            $vectorFilmUSB = showDir($dir,$nbTab,$vectorFilmUSB);


            //Affichage sur la page !
            print("</br>Film sur le disque :");
            $films = $vectorFilmUSB->getTab();
            for($i=0;$i<count($films);$i++)
            {
	            echo "</br>".$films[$i];
            }
            echo "\n";
            print("</br>Film dans la base de donnée :");
            while ($row = mysqli_fetch_assoc($rqtAfficher)) {
	            $titre=$row["titre"];
	            $vectorFilmBDD->add($titre);
	            print(",".$titre);
            }
            //FIN Affichage sur la page !

            //Insertion dasn la base de donnée si le film n'existe pas '
            for($i=0;$i<$vectorFilmUSB->size();$i++){
	            $existeDeja=false;
	            $nomFilm=explode(".",$vectorFilmUSB->at($i));
	            $nomFilm=$nomFilm[0];
	            for($j=0;$j<$vectorFilmBDD->size();$j++){
		            if($nomFilm==$vectorFilmBDD->at($j)){
			            $existeDeja = true;
			            echo "</br> Ce film existe deja : ".$nomFilm;
		            }
	            }
	            if($existeDeja == false){
		            $rqtInsertion = mysqli_query($link,"INSERT INTO `films`(`chemin`,`affiche`,`titre`) VALUES (\"".$dir."/".$vectorFilmUSB->at($i)."\",\"".$dirAffiche."/".$nomFilm.".jpg\",\"".$nomFilm."\")") or die(mysql_error());
		            echo "</br> Ajout de : ".$nomFilm;
	            }
            }
        ?>
        
        <h1>Rafraichissement de la base de données</h1>

       <?php include('footer.html'); ?> 
    </body>
</html>
