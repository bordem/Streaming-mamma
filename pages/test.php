<?php session_start(); ?>

<!doctype html>
<html>
    
    <head>
        <title>Rafraichissement de la base de données</title>
        <meta charset="utf-8"  />
        <link rel="stylesheet" href="../style.css" />
    </head>
    
    <body>
<?php
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
    	echo $this->_tailleTableau;
    }
    public function getTab(){
    	return $this->_arrayList;
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
		if($value != ".." && $value != '.' && $value != ".Trash-1000"){
			//Enleve le format de la video
			$value=explode(".",$value);
			$value=$value[0];
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


$link = mysqli_connect("localhost","pi","raspberry","site_martin");
$rqtAfficher = mysqli_query($link, "SELECT * FROM films") or die(mysql_error());

$vectorFilmUSB = new vector; 
$vectorFilmBDD = new vector; 

$nbTab=0;
$dir = '../films';
$films = array();
$vectorFilmUSB = showDir($dir,$nbTab,$vectorFilmUSB);

$vectorFilmUSB->size();
print("!");

$films = $vectorFilmUSB->getTab();
print_r($films);
for($i=0;$i<count($films);$i++)
{
	echo " Pute ".$films[$i];
}
print("¡");

while ($row = mysqli_fetch_assoc($rqtAfficher)) {
	$titre=$row["titre"];
	$vectorFilmBDD->add($titre);
	print($titre."\n");
}

?>
    </body>
</html>
