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
		//	$this->_arrayList[$this->_tailleTableau]=$data;
		//	$this->_arrayList2[$this->_tailleTableau]=$data2;
			$this->_data[$this->_tailleTableau]=[$data, $data2];
			$this->_tailleTableau++;
		}
		public function size(){
			return $this->_tailleTableau;
		}
		public function getTab(){
			return $this->_data;
		}
		public function at1($i){
			return $this->_data[$i][0];
		}
		public function at2($i){
			return $this->_data[$i][1];
		}
		public function set($i,$data,$data2){
		//	$this->_arrayList[$i]=$data;
		//	$this->_arrayList2[$i]=$data2;
			$this->_data[$i]=[$data,$data2];
		}
		public function sortBy($col){
			for ($i=$this->_tailleTableau-1; $i>0; $i--){
				echo "i=$i</br>";
				for ($j=$this->_tailleTableau-1; $j>1; $j--){
					echo "j=$j</br>";
					if ($this->_data[$j][$col] > $this_data[$j-1][$col]){
						[$this->_data[$j], $this->_data[$j-1]] = [$this->_data[$j-1], $this->_data[$j]];
					}
				}
			}
		}
	}
?>
