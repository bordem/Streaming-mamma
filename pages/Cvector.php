<?php
	////////////////////////////////////
	//CLASS vector , tableau dynamique//
	////////////////////////////////////
	class vector {
		//private $_arrayList=array();
		//private $_arrayList2=array();
		private $_data=array();
		private $_tailleTableau=0;
	   
		public function add($data,$data2) {
			$this->_data[$this->_tailleTableau]=[$data, $data2];
			$this->_tailleTableau++;
		}
		public function size(){
			return $this->_tailleTableau;
		}
		public function getTab(){
			return $this->_data;
		}
		public function at($i){
			return $this->_data[$i];
		}
		public function at1($i){
			return $this->_data[$i][0];
		}
		public function at2($i){
			return $this->_data[$i][1];
		}
		public function set($i,$data,$data2){
			$this->_data[$i]=[$data,$data2];
		}
		public function sortBy($col){
			$it=0;
			do{ // Tant que le tableau n'est pas trie on continue
				$sortie = true; 
				for( $i=0; $i < $this->_tailleTableau-1-$it ; $i++ )
				{ // on amene le plus petit element à la fin du tableau
					// À chaque tour de boucle, le dernier element est bien place donc on peut ne plus les verifier
					if ( $this->_data[$i][$col] < $this->_data[$i+1][$col] )
					{
						$sortie = false; // le tableau n'est pas trie si on a fait un echange ( c'est une aproximation suffisante)
						/*
						[ $this->_data[$i] , $this->_data[$i+1] ] = [$this->_data[$i+1], $this->_data[$i]];// swap rapide
						*/
						$tmp1=0;
						$tmp2=0;
						$tmp1 = $this->_data[$i];
						$tmp2 = $this->_data[$i+1];
						$this->_data[$i+1] = $tmp1;
						$this->_data[$i] = $tmp2;
						
						
						
					}
				}
			$it = $it + 1 ;
			}while ( !$sortie );
		}
	}
?>
